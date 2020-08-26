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

use App\Model\MrpModel;
use Session;
use Storage;
use DB;
use Response;

class MRPController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    public function __construct()
    {

    }
    public function index()
    {
        return view('pages.MRP');
    }
    public function mrp_onhand(Request $request)
    {
        DB::table('mrp_onhand_cal')->update(['vt_stock' => 0,'po_out_qty'=>0,'po_rcv_qty'=>0]); //update null to zero (0)

        $po_rcv = DB::table('orc_po_rcv') //update po receive di table mrp_onhand_cal
                ->select('item_code', DB::raw('SUM(quantity) as qty'))
                ->groupBy('item_code')
                ->get();
                foreach(  $po_rcv  as $row)
                {
                    DB::table('mrp_onhand_cal')->where('item_code',$row->item_code)->update(['po_rcv_qty'=>$row->qty]);
                }
        $po_out = DB::table('orc_po_outstanding') //update po outstanding di table mrp_onhand_cal
                ->select('item_code', DB::raw('SUM(out_qty) as qty'))
                ->groupBy('item_code')
                ->get();
                foreach(  $po_out  as $row)
                {
                    DB::table('mrp_onhand_cal')->where('item_code',$row->item_code)->update(['po_out_qty'=>$row->qty]);
                }
        $vt_stock = DB::table('mrp_onhand_cal') //VT Stock
                ->select('item_code', DB::raw('SUM(po_out_qty+beg_stock+po_rcv_qty) as qty'))
                ->groupBy('item_code')
                ->get();
                foreach(  $vt_stock  as $row)
                {
                     DB::table('mrp_onhand_cal')->where('item_code',$row->item_code)->update(['vt_stock'=>$row->qty]);
                }
            return Response::json('success');
    }
    public function shortage(Request $request)
    {
        //get shortage
       $Mtl = DB::table('mtl_requirement')
       ->select('c_item','production_date','qty_mtl_req')
     ->where('c_item', 'BAND0015X1500')
       ->orderBy('production_date')
       ->get();
       foreach ($Mtl as $row)
        {
        $row->c_item;
        $row->qty_mtl_req;
        $stock = DB::table('mrp_onhand_cal')->select('item_code','vt_stock')->where('item_code', $row->c_item)->get();
            foreach($stock as $rw)
            {
                 $hasil=$rw->vt_stock-$row->qty_mtl_req;
                    if($hasil>=0){
                        //update stock
                        $affected = DB::table('mrp_onhand_cal')->where('item_code', $row->c_item)->update(['vt_stock' => $hasil]);
                    }elseif($hasil<0){
                        //update stock jadi 0 dan simpan shortage material
                        $affected = DB::table('mrp_onhand_cal')->where('item_code', $row->c_item)->update(['vt_stock' => 0]);
                        //get static item to get QTY purchase
                        $static = DB::table('orc_item_static')->select('spq','moq','safety_stock','yield')->where('item_code',$row->c_item)->get();
                          foreach ($static as $rw);
                       // $row->c_item."--".$row->production_date."--".$total."--".$rw->safety_stock.'--'.$spq=ceil(((($total*-1)-(($total*-1)*$rw->yield))+($total*-1)+$rw->safety_stock)/$rw->spq)*$rw->spq."<br>";
                       //get vt_remaining onhan unttuk kalkulasi brp Po yang harus di issue
                          $remain = DB::table('mrp_onhand_cal')->select('vt_onh_remain')->where('item_code',$row->c_item)->get();
                              foreach ( $remain as $raw);
                              $total=$raw->vt_onh_remain-($hasil*-1);
                                if($total<0){
                                    $spq=ceil(((($total*-1)-(($total*-1)*$rw->yield))+($total*-1)+$rw->safety_stock)/$rw->spq)*$rw->spq;
                                    $end=$spq-($total*-1);
                             //save PO QTY PO Release
                                    DB::table('mrp_po_r_qty')->insert(['ITEM_CODE' => $row->c_item, 'PRODUCTION_DATE' =>   $row->production_date,'PO_QTY'=>$spq,'TRANSACTION_DATE'=>date('Y-m-d')]);
                                    DB::table('mrp_onhand_cal')->where('item_code', $row->c_item)->update(['vt_onh_remain' => $end]);
                          }
                     DB::table('mrp_shortage_temp')->insert(['ITEM_CODE' => $row->c_item, 'PRODUCTION_DATE' =>   $row->production_date,'SHORT_QTY'=>$hasil,'TRANSACTION_DATE'=>date('Y-m-d')]);
                    }
            }
        }
    }
    public function get_mtl_req()
    {

    }
    public function save_mrp_cal()
    {
        $data = DB::select("select static_item.item_code,safety_stock,spq,moq,poq,
                    (ex_work_lt+customs_lt+fob_lt+trading_lt+safety_time) as po_lt, convert(varchar(7), production_date, 126) production_date , ex_work_lt, yield,
                    case
                        when sum((PO_QTY)) <= moq then moq
                        when sum((PO_QTY)) >= moq then sum((PO_QTY))
                        end  as PO_QTY_R,(customs_lt+fob_lt+trading_lt) as log_tm,safety_time,
            --   DATEPART(MONTH, DATEADD(DAY, -(ex_work_lt+customs_lt+fob_lt+trading_lt+safety_time), production_date)) month_release,
                DATEPART(YEAR, DATEADD(DAY, -(ex_work_lt+customs_lt+fob_lt+trading_lt+safety_time), production_date)) year_release,
                DATEPART(WK, DATEADD(DAY, -(ex_work_lt+customs_lt+fob_lt+trading_lt+safety_time), production_date)) week_number
                from orc_item_static as static_item, mrp_po_r_qty as temp
                where trim(static_item.item_code)=trim(temp.ITEM_CODE)
                group by safety_stock,DATEPART(week, DATEADD(DAY, -(ex_work_lt+customs_lt+fob_lt+trading_lt+safety_time), production_date)),yield,static_item.item_code,spq,moq,poq,ex_work_lt,(customs_lt+fob_lt+trading_lt),safety_time,
                (ex_work_lt+customs_lt+fob_lt+trading_lt+safety_time),convert(varchar(7), production_date, 126),
                --DATEPART(MONTH, DATEADD(DAY, -(ex_work_lt+customs_lt+fob_lt+trading_lt+safety_time), production_date)),
                DATEPART(YEAR, DATEADD(DAY, -(ex_work_lt+customs_lt+fob_lt+trading_lt+safety_time), production_date))");
        foreach($data as $row)
        {
            if($row->poq==0){
                $poq=1;
            }else
            {
                $poq=$row->poq;
            }
        $release_date = $this->change_date((int)$row->year_release,(int)$row->week_number, (int)$poq);
        $po_release_date= date('Y-m-d', strtotime('-'.(int)$row->safety_time.'days', strtotime(date('Y-m-d',$release_date))));
        $etd=date('Y-m-d', strtotime('+'.(int)$row->ex_work_lt.'days', strtotime($po_release_date)));
        $eta=date('Y-m-d', strtotime('+'.(int)$row->log_tm.'days', strtotime($etd)));
       // echo $row->item_code."--".$row->short_qty."--".$po_release_date."--".$etd."---".$eta."</br>";
      DB::table('mrp_temp')->insert(['item_code'=>$row->item_code,
        'safety_stock'=>$row->safety_stock,
        'spq'=>$row->spq,
        'moq'=>$row->moq,
        'poq'=>(int)$row->poq,
        'yield'=>$row->yield,
        'ex_work'=>(int)$row->ex_work_lt,
        'log_time'=>(int)$row->log_tm,
        'safety_time'=>(int)$row->safety_time,
        'org_short_qty'=>0,
        'short_qty '=>0,
        'po_qty_spq'=>0,
        'po_qty_release'=>$row->PO_QTY_R,
        'po_release_date '=>$po_release_date,
        'po_etd_date'=>$etd,
        'po_eta_date'=>$eta,
        'creation_date'=>date('Y-m-d h:i:sa'),
        'status_log'=>'1']);
        }
    }
    private  function change_date($year,$week_num, $day) {
        $timestamp    = strtotime($year. '-W' . $week_num . '-' . $day);
        return $timestamp;
      }
    private function save(Request $request, ReceiptModel $data)
    {
        $data->receipt_code = $request->input('receipt_code');
        $data->receipt_time = $request->input('receipt_time');
        $data->receipt_warehouse_id = $request->input('receipt_warehouse_id');
        $process = $data->save();
        return $process;
    }
    public function export(Request $request)
    {
        return  Excel::download( new ReceiptExport, 'users_data.xlsx');
    }
    public function mrp_data(Request $request)
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
            OR  CONVERT(VARCHAR,creation_date, 120) LIKE '%".$filter."%'
        )");
        $data = MrpModel::orderBy($sort, $dir)->whereRaw($filter);

        if ($length) {
            $data->skip($start)->take($length);
        }
        $data = $data->get();
        $count = MrpModel::whereRaw($filter)->count();

        $result = [
            'draw' => $draw,
            'recordsTotal' => $count,
            'recordsFiltered' => $count,
            'listData' => $data,
        ];
        return $result;
    }
}
