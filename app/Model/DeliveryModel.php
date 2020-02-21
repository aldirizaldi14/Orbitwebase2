<?php
namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class DeliveryModel extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = 'delivery';
    protected $primaryKey = 'delivery_id';
    protected $fillable = [
        'delivery_code', 
        'delivery_time', 
        'delivery_expedition', 
        'delivery_destination', 
        'delivery_city', 
        'delivery_user_id', 
        'delivery_created_at',
        'delivery_created_by',
        'delivery_updated_at',
        'delivery_updated_by',
        'delivery_deleted_at',
    ];
    protected $hidden = [];
    const CREATED_AT = 'delivery_created_at';
    const UPDATED_AT = 'delivery_updated_at';
    const DELETED_AT = 'delivery_deleted_at';
}