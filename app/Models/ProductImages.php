<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImages extends Model
{
    protected $table = 'product_images';
    protected $fillable = [
        'id',
        'path',
        'product_id',
        'status',
        'position'
    ];
}
