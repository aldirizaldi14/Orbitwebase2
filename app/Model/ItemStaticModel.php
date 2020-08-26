<?php
namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class ItemStaticModel extends Model
{
    use Notifiable /*, SoftDeletes*/;

    protected $table = 'orc_item_static';
    protected $primaryKey = 'count_id';
    protected $fillable = [
        'item_code',
        'item_desc',
        'uom',
        'status',
        'item_type',
        'spq',
        'moq',
        'terms_carrier',
		'ex_work_lt',
        'fob_lt',
        'trading_lt',
        'logistic_lt',
        'customs_lt',
        'yield',
        'safety_time',
        'unit_cost',
        'poq',
        'safety_stock',
        'creation_date',
        'last_update',
    ];
    protected $hidden = [];
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_update';

    public function scopeSearch($query, $search){
        if ($search){
            return $query->whereRaw("(
                lower(item_code) like '%". strtolower($search) ."%'
                OR lower(item_desc) like '%". strtolower($search) ."%'
                OR lower(spq) like '%". strtolower($search) ."%'
            )");
        }
    }
}
