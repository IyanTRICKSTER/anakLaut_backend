<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'transaction_id',
        'order_from',
        'customer_id',
        'uuid',
        'status'
    ];

    protected $hidden = [

    ];

    //Relasi ke Model Order Detail
    public function order_details() {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    public function transaction() {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }
}
