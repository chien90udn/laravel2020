<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StationNameMaster extends Model
{
    protected $table = 'station_name_master';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'title',
        'location_id',
        'route_master_id',
        'position',
        'status'
    ];
}
