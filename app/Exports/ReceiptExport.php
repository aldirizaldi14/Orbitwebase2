<?php

namespace App\Exports;

use App\Model\Receipt_ViewModel;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReceiptExport implements FromCollection
{
    public function collection()
    {
        $date= date('Y-m-d',(strtotime ( '-2 day' , strtotime ( date('Y-m-d')) ) ));
        return Receipt_ViewModel::where('receipt_time','>=' ,$date)
                                 ->get(['product_code','receiptdet_qty','receipt_time']);
    }
}
