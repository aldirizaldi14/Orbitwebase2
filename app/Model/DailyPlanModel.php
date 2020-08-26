<?php
namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class DailyPlanModel extends Model
{
    use Notifiable /*, SoftDeletes*/;

    protected $table = 'orc_daily_plan';
    protected $primaryKey = 'header_id';
    protected $fillable = ['header_id',
    'item_number',
    'item_type',
    'quantity',
    'production_date',
    'month',
    'year',
    'creation_date',
    'last_update_date',
    'subinventory',
    'organization_id',
    ];
    protected $hidden = [];
    const CREATED_AT = 'creation_date';
    const UPDATED_AT = 'last_update_date';

    public function scopeSearch($query, $search){
        if ($search){
            return $query->whereRaw("(
                lower(item_number) like '%". strtolower($search) ."%'
                OR lower(item_type) like '%". strtolower($search) ."%'
                OR lower(last_update_date) like '%". strtolower($search) ."%'
            )");
        }
    }
}
