<?php
namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class BomlistModel extends Model
{
    use Notifiable;

    protected $table = 'orc_bom_list';
    protected $fillable = [
        'p_item',
        'p_item_desc',
        'c_item',
        'c_item_desc',
        'effective_date_to',
    ];
    protected $hidden = [];
    const CREATED_AT = 'effective_date_to';


    public function scopeSearch($query, $search)
    {
        if ($search){
            return $query->whereRaw("(
                lower(p_item) like '%". strtolower($search) ."%' )");
        }
    }
}
