<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

use App\Model\WarehouseModel;
use Session;
use Storage;
use DB;
use Response;

class WarehouseController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
    }

    public function index()
    {
        return view('pages.warehouse');
    }

    public function data(Request $request)
    {
        $draw = $request->get('draw');
        $start = (int) $request->get('start');
        $length = (int) $request->get('length');
        $filter = $request->get('filter');
        $sort = $request->get('sort');
        $dir = $request->get('dir');
        if(! $sort){ $sort = 'warehouse_name'; $dir = 'asc'; }

        $filter = DB::raw("(
            LOWER(warehouse_name) LIKE '%".strtolower($filter)."%'
            OR LOWER(warehouse_description) LIKE '%".strtolower($filter)."%'
        )");

        $data = WarehouseModel::orderBy($sort, $dir)
            ->whereRaw($filter);
        if ($length) {  
            $data->skip($start)->take($length); 
        }
        $data = $data->get();
        
        $count = WarehouseModel::whereRaw($filter)
            ->count();

        $result = [
            'draw' => $draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'listData' => $data,
        ];

        return $result;
    }

    public function create(Request $request)
    {
        $this->validate($request, [
            'warehouse_name' => 'required',
            'warehouse_description' => 'required',
        ]);
        $data = new WarehouseModel;
        $data->warehouse_created_by = $request->user()->user_username;
        $process = $this->save($request, $data);
        if ($process) {
            $response = ['status' => 'success', 'success' => true, 'message' => 'Save success'];
        } else {
            $response = ['status' => 'error', 'success' => false, 'message' => 'Unable to save data'];
        }
        return $response;
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'warehouse_name' => 'required',
            'warehouse_description' => 'required',
        ]);

        $data = WarehouseModel::find($id);
        if (!$data) {
            return [
                'success' => false,
                'message' => 'Invalid data',
                'status' => 'danger',
                'id' => $id,
            ];
        }
        $data->warehouse_updated_by = $request->user()->user_username;
        $process = $this->save($request, $data);
        if ($process) {
            $response = ['status' => 'success', 'success' => true, 'message' => 'Save success'];
        } else {
            $response = ['status' => 'error', 'success' => false, 'message' => 'Unable to save data'];
        }

        return $response;
    }

    private function save(Request $request, WarehouseModel $data)
    {
        $data->warehouse_name = $request->input('warehouse_name');
        $data->warehouse_description = $request->input('warehouse_description');
        $process = $data->save();

        return $process;
    }

    public function delete($id, Request $request)
    {
        $data = WarehouseModel::find($id);
        if (!$data) {
            return [
                'success' => false,
                'message' => 'Invalid data',
                'status' => 'danger',
                'id' => $id,
            ];
        }
        $data->warehouse_updated_by = $request->user()->user_username;
        $data->save();
        $process = $data->delete();
        if ($process) {
            $response = ['status' => 'success', 'success' => true, 'message' => 'Data berhasil dihapus'];
        } else {
            $response = ['status' => 'error', 'success' => false, 'message' => 'Data gagal dihapus'];
        }

        return $response;
    }

    public function export(Request $request)
    {
        $data = $this->data($request);

        $tanggal = date('Y-m');
        $tanggal = explode('-', $tanggal);
        $path = '/files/'.$tanggal[0].'/'.$tanggal[1].'/';
        if (!Storage::disk('public')->exists($path)) {
            Storage::disk('public')->makeDirectory($path, $mode = 0744, true, true);
        }

        $style = array(
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
            )
        );

        setlocale(LC_TIME, 'id_utf8', 'Indonesian', 'id_ID.UTF-8', 'Indonesian_indonesia.1252', 'WINDOWS-1252');
        $mc = 'C';
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->mergeCells('A1:'.$mc.'1');
        $sheet->getStyle('A1:'.$mc.'1')->applyFromArray($style);
        $sheet->setCellValue('A1', '');

        $spreadsheet->getActiveSheet()->mergeCells('A2:'.$mc.'2');
        $sheet->getStyle('A2:'.$mc.'2')->applyFromArray($style);
        $sheet->setCellValue('A2', 'Warehouse Data');

        $spreadsheet->getActiveSheet()->mergeCells('A3:'.$mc.'3');
        $sheet->setCellValue('A3', '');

        $spreadsheet->getActiveSheet()->mergeCells('A4:'.$mc.'4');
        $sheet->getStyle('A4:'.$mc.'4')->applyFromArray($style);
        $sheet->setCellValue('A4', 'Download Time : '. strftime('%A, %d-%m-%Y %H:%M:%S'));

        $sheet->setCellValue('A5', '#');
        $sheet->setCellValue('B5', 'Name');
        $sheet->setCellValue('C5', 'Description');
        
        $data = $data['listData'];
        $i = 5;
        foreach ($data as $sub) {
            $no = $i-4;
            $i++;
            $sheet->setCellValue('A'.$i, $no);
            $sheet->setCellValue('B'.$i, $sub->warehouse_name);
            $sheet->setCellValue('C'.$i, $sub->warehouse_description);
        }

        $writer = new Xlsx($spreadsheet);
        $filename = 'warehouse.xlsx';
        $writer->save(storage_path('app/public').$path.$filename);

        return Response::download(storage_path('app/public').$path.$filename);
    }
}
