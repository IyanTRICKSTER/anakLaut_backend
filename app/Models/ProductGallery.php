<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductGallery extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'product_id',
        'image',
        'is_default'
    ];

    protected $hidden = [
        'product_id'
    ];

    // Relasi Invers ke Model Product
    public function product() {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function getImageAttribute($value) {
        return url('storage/' . $value);
    }
}
