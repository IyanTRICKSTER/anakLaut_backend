<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderDetail extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'order_id',
        'product_id',
        'order_quantity'
    ];

    // Relasi Invers ke Model Order
    public function order() {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    // Relasi Invers ke Model Product
    public function product() {
        return $this->hasMany(Product::class, 'product_id');
    }
}
