<?php
namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Product_ViewModel extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = 'product_view';
    protected $primaryKey = 'product_id';
    protected $fillable = [
        'product_code',
        'product_code_alt',
        'product_description',
        'product_created_at',
        'product_created_by',
        'product_updated_at',
        'product_updated_by',
        'product_deleted_at',
        'product_location_alt',
        'QTY',

    ];
    protected $hidden = [];
    const CREATED_AT = 'product_created_at';
    const UPDATED_AT = 'product_updated_at';
    const DELETED_AT = 'product_deleted_at';
}
