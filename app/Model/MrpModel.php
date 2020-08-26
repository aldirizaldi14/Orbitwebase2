<?php
namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class MrpModel extends Model
{
    use Notifiable;

    protected $table = 'mrp_temp';
    protected $primaryKey = 'count_id';
    protected $fillable =['item_code',
                        'safety_stock',
                        'spq',
                        'moq',
                        'poq',
                        'yield',
                        'ex_work',
                        'log_time',
                        'safety_time',
                        'org_short_qty',
                        'short_qty',
                        'po_qty_spq',
                        'po_qty_release',
                        'po_release_date',
                        'po_etd_date',
                        'po_eta_date',
                        'creation_date',
                        'status_log',
                                      ];
    protected $hidden = [];
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'creation_date';

    public function scopeSearch($query, $search){
        if ($search){
            return $query->whereRaw("(
                lower(item_code) like '%". strtolower($search) ."%'
                OR lower(safety_stock) like '%". strtolower($search) ."%'
                OR lower(creation_date) like '%". strtolower($search) ."%'
            )");
        }
    }
}
