<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTemp extends Model
{
    protected $table = 'product_temp';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'product_id',
        'route_master_id',
        'station_name_id',
        'distance',
        'location_id',
        'position',
        'status'
    ];

    public function route()
    {
        return $this->hasOne('App\Models\RouteMaster', 'id','route_master_id');
    }
    public function station()
    {
        return $this->hasOne('App\Models\StationNameMaster', 'id','station_name_id');
    }
    public function location()
    {
        return $this->hasOne('App\Models\Location', 'id','location_id');
    }
}
