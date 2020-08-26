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
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReceiptExport;

use App\Model\BomlistModel;
use App\Model\BomlistdetModel;
use App\Model\UserModel;
use Session;
use Storage;
use DB;
use Response;

class BomlistController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct()
    {
    }
    public function index()
    {
        return view('pages.bomlist');
    }

    public function data(Request $request)
    {
        $draw = $request->get('draw');
        $start = (int) $request->get('start');
        $length = (int) $request->get('length');
        $filter = $request->get('filter');
        $sort = $request->get('sort');
        $dir = $request->get('dir');
        if(! $sort){ $sort = 'p_item'; $dir = 'asc'; }

        $filter = DB::raw("(
            LOWER(p_item) LIKE '%".strtolower($filter)."%'
            OR LOWER(p_item_desc) LIKE '%".strtolower($filter)."%'
            OR LOWER(c_item) LIKE '%".strtolower($filter)."%')  ");
        $data = BomlistModel::orderBy($sort, $dir)->whereRaw($filter)->where('effective_date_to','>=', date('Y-m-d').' 00:00:00')->orwhere('effective_date_to',null);
        if ($length) {
            $data->skip($start)->take($length);
        }
        $data = $data->get();
        $count = BomlistModel::whereRaw($filter)->count();

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
        if(! $sort){ $sort = 'p_item'; $dir = 'asc'; }

        $filter = DB::raw("(
            LOWER(p_item) LIKE '%".strtolower($filter)."%'
        )");

        $pitem =$request->get('id');
        $bomcur = DB::table('orc_bom_list')->select('p_item')->where('p_item','=',$pitem)->first();
        $data =  DB::table('orc_bom_list')->select('p_item')->where('p_item','=',$pitem)->get();

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
            'receipt_code' => 'required',
            'receipt_warehouse_id' => 'required',
        ]);
        $data = new ReceiptModel;
        $data->receipt_created_by = $request->user()->user_username;
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
            'receipt_code' => 'required',
            'receipt_warehouse_id' => 'required',
        ]);

        $data = ReceiptModel::find($id);
        if (!$data) {
            return [
                'success' => false,
                'message' => 'Invalid data',
                'status' => 'danger',
                'id' => $id,
            ];
        }
        $data->receipt_updated_by = $request->user()->user_username;
        $process = $this->save($request, $data);
        if ($process) {
            $response = ['status' => 'success', 'success' => true, 'message' => 'Save success'];
        } else {
            $response = ['status' => 'error', 'success' => false, 'message' => 'Unable to save data'];
        }
        return $response;
    }
    private function save(Request $request, ReceiptModel $data)
    {
        $data->receipt_code = $request->input('receipt_code');
        $data->receipt_time = $request->input('receipt_time');
        $data->receipt_warehouse_id = $request->input('receipt_warehouse_id');
        $process = $data->save();
        return $process;
    }
    public function delete($id, Request $request)
    {
        $data = ReceiptModel::find($id);
        if (!$data) {
            return [
                'success' => false,
                'message' => 'Invalid data',
                'status' => 'danger',
                'id' => $id,
                  ];
         }
        $data->receipt_updated_by = $request->user()->user_username;
        $data->save();
        $process = $data->delete();
        if ($process) {
            $response =['status' => 'success', 'success' => true, 'message' => 'Data berhasil dihapus'];
        } else {
            $response =['status' => 'error', 'success' => false, 'message' => 'Data gagal dihapus'];
        }
        return $response;
    }
    public function export(Request $request)
    {
        return  Excel::download( new ReceiptExport, 'users_data.xlsx');
    }
    public function tes()
    {
            echo date('Y-m-d',(strtotime ( '-2 day' , strtotime ( date('Y-m-d')) ) ));
    }
	public function import_bom()
	{
				$tab = "\t";

				$file_handle = fopen('ftp://ftpuser:P3sgmfid@137.40.52.36/data/BOM_LIST.txt','r');
				while ( !feof($file_handle) )
					{
					$line=fgets($file_handle,4096);
					$line_of_text = str_getcsv($line,$tab);
					if(isset($line_of_text[0])){
					$data=array(
								'p_item'=>$line_of_text[0],
								'p_item_desc'=>$line_of_text[1],
								'p_uom'=>$line_of_text[2],
								'Alternate'=>$line_of_text[3],
								'inventory'=>$line_of_text[4],
								'c_item'=>$line_of_text[5],
								'c_item_desc'=>$line_of_text[6],
								'c_uom'=>$line_of_text[7],
								'qty_com'=>$line_of_text[8],
								'yield'=>$line_of_text[9],
								'effective_date_from'=>$line_of_text[10],
								'effective_date_to'=>$line_of_text[11],
								'supply_subinventory'=>$line_of_text[12],
								'source_subinventory'=>$line_of_text[13],
								'op_unit'=>$line_of_text[14],
								'org_id'=>$line_of_text[15]
								);
		 }

		DB::table('orc_bom_list')->insert($data);
	   }
	}
}
