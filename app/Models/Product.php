<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'title',
        'description',
        'price',
        'content',
        'hot',
        'approve',
        'exped_at',
        'category_id',
        'group_floor',
        'ad_user_id',
        'user_id',
        'currency_id',
        'status',
        'created_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
//    public function messages()
//    {
//        return $this->hasMany('App\Model\Message')->whereNull('messages.product_id');
//    }

    public function images()
    {
        return $this->belongsTo('App\Models\ProductImages', 'id','product_id');
    }

    public function locations()
    {
        return $this->hasOne('App\Models\Location','id', 'location_id');
    }

    public function city()
    {
        return $this->hasOne('App\Models\CityMaster','id', 'city_master_id');
    }
    public function category()
    {
        return $this->hasOne('App\Models\Category','id', 'category_id');
    }

    public function currency()
    {
        return $this->hasOne('App\Models\Currency','id', 'currency_id');
    }

    public function user()
    {
        return $this->hasOne('App\Models\User','id', 'user_id');
    }

    public function admin()
    {
        return $this->hasOne('App\Models\Admin','id', 'user_id');
    }

    public function FloorFrom()
    {
        return $this->hasOne('App\Models\FloorPlanMaster','id', 'floor_id_from');
    }
    public function FloorTo()
    {
        return $this->hasOne('App\Models\FloorPlanMaster','id', 'floor_id_to');
    }

}
