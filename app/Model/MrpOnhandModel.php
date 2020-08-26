<?php
namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class MrpOnhandModel extends Model
{
    use Notifiable;

    protected $table = 'mrp_onhand_cal';
    //protected $primaryKey = 'item_code';
    protected $fillable =['period_name',
                        'item_code',
                        'uom',
                        'beg_stock',
                        'po_out_qty ',
                        'po_rcv_qty ',
                        'date_time ',
                        'last_update',
                        'vt_stock',
                        'vt_onh_remain',
                                      ];
    protected $hidden = [];
    const CREATED_AT = 'date_time';
    const UPDATED_AT = 'last_update';

    public function scopeSearch($query, $search){
        if ($search){
            return $query->whereRaw("(
                lower(item_code) like '%". strtolower($search) ."%'
                OR lower(period_name) like '%". strtolower($search) ."%'
                OR lower(last_update) like '%". strtolower($search) ."%'
            )");
        }
    }
}
