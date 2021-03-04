<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'status_code',
        'status_message',
        'transaction_time',
        'transaction_status',
        'fraud_status',
        'pdf_url',
    ];


    public function order() {
        return $this->hasMany(Order::class, 'transaction_id');
    }

    public function shipment() {
        return $this->hasMany(Shipment::class, 'transaction_id');
    }

    public function payment() {
        return $this->hasOne(Payment::class, 'transaction_id');
    }
}
