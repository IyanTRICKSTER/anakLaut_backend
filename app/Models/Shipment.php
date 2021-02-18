<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shipment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'order_id',
        'shipment_address',
        'shipment_date',
        'note',
        'shipment_contact'
    ];

    // Relasi Invers ke Model Order
    public function order() {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
