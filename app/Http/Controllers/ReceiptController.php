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

use App\Model\ReceiptModel;
use App\Model\UserModel;
use App\Model\ReceiptdetModel;
use App\Model\Receipt_ViewModel;
use Session;
use Storage;
use DB;
use Response;

class ReceiptController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct()
    {
    }
    public function index()
    {
        return view('pages.receipt');
    }

    public function data(Request $request)
    {
        $draw = $request->get('draw');
        $start = (int) $request->get('start');
        $length = (int) $request->get('length');
        $filter = $request->get('filter');
        $sort = $request->get('sort');
        $dir = $request->get('dir');
        if(! $sort){ $sort = 'receipt_created_at'; $dir = 'asc'; }

        $filter = DB::raw("(
            LOWER(product_code) LIKE '%".strtolower($filter)."%'
            OR  CONVERT(VARCHAR,receipt_created_at, 120) LIKE '%".$filter."%'
        )");

        $data = Receipt_ViewModel::orderBy($sort, $dir)
            ->whereRaw($filter)
            ->join('user', 'user_id', 'receipt_user_id');
        if ($length) {
            $data->skip($start)->take($length);
        }
         $data = $data->get();

        $count = Receipt_ViewModel::whereRaw($filter)
            ->count();

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
        $receipt_id = (int) $request->get('receipt_id');

        $data = ReceiptdetModel::where('receiptdet_receipt_id', $receipt_id)
            ->join('product', 'product_id', 'receiptdet_product_id')
            ->get();
        $count = ReceiptdetModel::where('receiptdet_receipt_id', $receipt_id)
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
}
