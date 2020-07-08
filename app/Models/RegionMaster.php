<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegionMaster extends Model
{
    protected $table = 'region_master';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'title',
        'position',
        'status'
    ];

    /**
     * Get the city mster for the blog post.
     */
    public function cityMaster()
    {
        return $this->hasMany('App\Models\CityMaster');
    }
}
