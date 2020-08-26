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

use App\Model\MrpOnhandModel;
use Session;
use Storage;
use DB;
use Response;


class MrpOnhandController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
    }
    public function index()
    {
        return view('pages.mrponhand');

    }

    public function data(Request $request)
    {
        $draw = $request->get('draw');
        $start = (int) $request->get('start');
        $length = (int) $request->get('length');
        $filter = $request->get('filter');
        $sort = $request->get('sort');
        $dir = $request->get('dir');
        if(! $sort){ $sort = 'item_code'; $dir = 'asc'; }

        $filter = DB::raw("(
            LOWER(item_code) LIKE '%".strtolower($filter)."%'
            OR  CONVERT(VARCHAR,date_time, 120) LIKE '%".$filter."%'

        )");
        $data = MrpOnhandModel::orderBy($sort, $dir)->whereRaw($filter);

        if ($length) {
            $data->skip($start)->take($length);
        }
        $data = $data->get();
        $count = MrpOnhandModel::whereRaw($filter)->count();

        $result = [
            'draw' => $draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'listData' => $data,
        ];
        return $result;
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
