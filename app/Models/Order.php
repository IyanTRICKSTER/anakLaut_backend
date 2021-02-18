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
        'uuid',
        'name',
        'email',
        'phone',
        'address',
        'status'
    ];

    protected $hidden = [

    ];

    //Relasi ke Model Order Detail
    public function order_details() {
        return $this->hasMany(OrderDetail::class, 'order_id');
    }

    // Relasi ke Model Shipment
    public function shipment() {
        return $this->hasOne(Shipment::class, 'order_id', 'id');
    }

    // Relasi ke Model Payment
    public function payment() {
        return $this->hasOne(Payment::class, 'order_id', 'id');
    }
}
