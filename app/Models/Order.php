<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory;
    use SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
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
        return $this->hasOne(Transaction::class, 'order_id', 'id');
    }

    public function shipment() {
        return $this->hasOne(Shipment::class, 'order_id');
    }
}
