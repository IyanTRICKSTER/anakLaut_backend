<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'order_id',
        'payment_no',
        'payment_type',
        'rek_num',
        'ewallet_num',
        'amount'
    ];

    // Relasi Invers ke Model Order
    public function order() {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
