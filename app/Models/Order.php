<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'order_name',
        'order_phone',
        'order_address',
        'order_product',
        'order_comment',
        'created_at'
    ];

   
}
