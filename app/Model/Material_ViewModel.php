<?php
namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Material_ViewModel extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = 'material_view';
    protected $primaryKey = 'product_id';
    protected $fillable = [
        'product_code',
        'product_code_alt',
        'product_description',
        'product_location_alt',
        'QTY',
        'product_max_alt',
    ];
    protected $hidden = [];
    const CREATED_AT = 'product_created_at';
    const UPDATED_AT = 'product_updated_at';
    const DELETED_AT = 'product_deleted_at';
}
