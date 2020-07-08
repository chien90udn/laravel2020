<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FloorPlanMaster extends Model
{
    protected $table = 'floor_plan_master';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'title',
        'position',
        'group_id',
        'status'
    ];
}
