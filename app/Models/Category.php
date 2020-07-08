<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'name',
        'status',
        'position',
        'icon'
    ];

    public function language()
    {
        return $this->hasOne('App\Models\Language','id', 'category_id');
    }

}
