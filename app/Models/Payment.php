<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $keyType = "string";

    protected $fillable = [
        'transaction_id',
        'payment_type',
        'bank',
        'va_number',
        'gross_amount',
    ];

    //Relasi Invers ke Transaksi Model
    public function transaction() {
        return $this->belongsTo(Transaction::class, 'transaction_id', 'id');
    }
}
