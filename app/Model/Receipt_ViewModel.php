<?php
namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Receipt_ViewModel extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = 'receipt_view';
    protected $primaryKey = 'receipt_id';
    protected $fillable = [
        'receipt_id',
        'product_code',
        'receipt_code',
        'receiptdet_qty',
        'receipt_time',
        'receipt_created_at',
        'receipt_user_id',
        'receipt_deleted_at',
        'receiptdet_receipt_id',
    ];
    protected $hidden = [];
    const CREATED_AT = 'receipt_created_at';
    const UPDATED_AT = 'receipt_updated_at';
    const DELETED_AT = 'receipt_deleted_at';
}
