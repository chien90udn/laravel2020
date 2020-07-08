<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperatingCompany extends Model
{
    protected $table = 'operating_company';

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
    public function routeMaster()
    {
        return $this->hasMany('App\Models\RouteMaster');
    }
}
