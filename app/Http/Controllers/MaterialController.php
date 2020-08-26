<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Auth;

use App\Model\MaterialModel;
use App\Model\Material_ViewModel;
use Session;
use Storage;
use DB;
use Response;


class MaterialController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
    }
    public function index(Request $request)
    {
        $onhandfoot = DB::table('material_view')->get();
        return view('pages.Material',['onhandfoot'=>$onhandfoot]);
        // $user = Auth::user();
        //var_dump($user->user_side."".$user->user_username);
    }

    public function data(Request $request)
    {
        $draw = $request->get('draw');
        $start = (int) $request->get('start');
        $length = (int) $request->get('length');
        $filter = $request->get('filter');
        $sort = $request->get('sort');
        $dir = $request->get('dir');
        if(! $sort){ $sort = 'product_code'; $dir = 'asc'; }

        $filter = DB::raw("(
            LOWER(product_code) LIKE '%".strtolower($filter)."%'
            OR LOWER(product_code_alt) LIKE '%".strtolower($filter)."%'
            OR LOWER(product_description) LIKE '%".strtolower($filter)."%'
        )");
        $data = Material_ViewModel::orderBy($sort, $dir)->whereRaw($filter)->where('product_side_alt', $request->user()->user_side);
        if ($length) {
            $data->skip($start)->take($length);
        }
        $data = $data->get();
        $count =Material_ViewModel::whereRaw($filter)->count();

        $result = [
            'draw' => $draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'listData' => $data,
        ];
        return $result;
    }

    public function detail(Request $request)
    {
        $draw = $request->get('draw');
        $start = (int) $request->get('start');
        $length = (int) $request->get('length');
        $filter = $request->get('filter');
        $sort = $request->get('sort');
        $dir = $request->get('dir');

        $prod_id = (int)$request->get('product_id');
        $row = DB::table('material')->where('product_id',  $prod_id)->first();
        $data = DB::table('wh_mtl_trans')->leftjoin('orc_beg_stock', 'wh_mtl_trans.SEGMENT1', '=','orc_beg_stock.ITEM_CODE')->where('SEGMENT1','=',$row->product_code)->where('orc_beg_stock.SUBINVENTORY_CODE','=','2I0000')->orderBy('TRANSACTION_DATE', 'ASC')->get();
        if ($length) {
            $data->skip($start)->take($length);
        }
        $count = count($data);
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
            'product_code' => 'required',
            'product_description' => 'required',
        ]);
        $data = new MaterialModel;
        $data->product_created_by = $request->user()->user_username;
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
            'product_code' => 'required',
            'product_description' => 'required',
        ]);
        $data = MaterialModel::find($id);
        if (!$data) {
            return [
                'success' => false,
                'message' => 'Invalid data',
                'status' => 'danger',
                'id' => $id,
            ];
        }
        $data->product_updated_by = $request->user()->user_username;
        $process = $this->save($request, $data);
        if ($process) {
            $response = ['status' => 'success', 'success' => true, 'message' => 'Save success'];
        } else {
            $response = ['status' => 'error', 'success' => false, 'message' => 'Unable to save data'];
        }

        return $response;
    }

    private function save(Request $request, MaterialModel $data)
    {
        $data->product_code = $request->input('product_code');
        $data->product_code_alt = $request->input('product_code_alt');
        $data->product_description = $request->input('product_description');
        $data->product_location_alt = $request->input('product_location_alt');
        $data->product_side_alt='222';
        $process = $data->save();
        return $process;
    }

    public function delete($id, Request $request)
    {
        $data = MaterialModel::find($id);
        if (!$data) {
            return [
                'success' => false,
                'message' => 'Invalid data',
                'status' => 'danger',
                'id' => $id,
            ];
        }
        $data->product_updated_by = $request->user()->user_username;
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
        $mc = 'D';
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $spreadsheet->getActiveSheet()->mergeCells('A1:'.$mc.'1');
        $sheet->getStyle('A1:'.$mc.'1')->applyFromArray($style);
        $sheet->setCellValue('A1', '');

        $spreadsheet->getActiveSheet()->mergeCells('A2:'.$mc.'2');
        $sheet->getStyle('A2:'.$mc.'2')->applyFromArray($style);
        $sheet->setCellValue('A2', 'Product Data');

        $spreadsheet->getActiveSheet()->mergeCells('A3:'.$mc.'3');
        $sheet->setCellValue('A3', '');

        $spreadsheet->getActiveSheet()->mergeCells('A4:'.$mc.'4');
        $sheet->getStyle('A4:'.$mc.'4')->applyFromArray($style);
        $sheet->setCellValue('A4', 'Download Time : '. strftime('%A, %d-%m-%Y %H:%M:%S'));

        $sheet->setCellValue('A5', '#');
        $sheet->setCellValue('B5', 'Code');
        $sheet->setCellValue('C5', 'Alternative Code');
        $sheet->setCellValue('D5', 'Description');
        $sheet->setCellValue('E5', 'Max Onhand');
        $sheet->setCellValue('F5', 'Subinventory Code');
        $sheet->setCellValue('G5', 'Max Onhand');
        $sheet->setCellValue('H5', 'Max Onhand');
        $sheet->setCellValue('I5', 'Max Onhand');
        $sheet->setCellValue('J5', 'Max Onhand');
        $sheet->setCellValue('K5', 'Max Onhand');

        $data = $data['listData'];
        $i = 5;
        foreach ($data as $sub) {
            $no = $i-4;
            $i++;
            $sheet->setCellValue('A'.$i, $no);
            $sheet->setCellValue('B'.$i, $sub->product_code);
            $sheet->setCellValue('C'.$i, $sub->product_code_alt);
            $sheet->setCellValue('D'.$i, $sub->product_description);
            $sheet->setCellValue('E'.$i, $sub->product_max_alt);
            $sheet->setCellValue('F'.$i, $sub->SUBINVENTORY_CODE);
            $sheet->setCellValue('G'.$i, $sub->product_location_alt);
            $sheet->setCellValue('H'.$i, $sub->QTY);
            $sheet->setCellValue('I'.$i, $sub->product_side_alt);
            $sheet->setCellValue('J'.$i, $sub->product_sid_alt);
            $sheet->setCellValue('K'.$i, $sub->product_idt);
        }
         $writer = new Xlsx($spreadsheet);
         $writer->save('product.xlsx');
         $response = ['status' => 'error', 'success' => false, 'message' => 'Download Data Product'];
        return  $response;
    }
}
