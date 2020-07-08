<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CityMaster extends Model
{
    protected $table = 'city_master';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'title',
        'region_master_id',
        'position',
        'status'
    ];
}
