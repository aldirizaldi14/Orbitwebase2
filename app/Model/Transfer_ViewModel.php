<?php
namespace App\Model;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Transfer_viewModel extends Model
{
    use Notifiable, SoftDeletes;

    protected $table = 'transfer_view';
    protected $primaryKey = 'transfer_id';
    protected $fillable = [
        'product_code',
        'transfer_id',
        'transfer_code',
        'transfer_time',
        'transferdet_product_id',
        'transferdet_qty',
        'transfer_deleted_at',
        'transfer_sent_at',


    ];
    protected $hidden = [];
    const CREATED_AT = 'transfer_created_at';
    const UPDATED_AT = 'transfer_updated_at';
    const DELETED_AT = 'transfer_deleted_at';
}
