<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RouteMaster extends Model
{
    protected $table = 'route_master';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'title',
        'location_id',
        'operating_company_id',
        'position',
        'status'
    ];
}
