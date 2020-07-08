<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'content',
        'product_id',
        'user_id_from',
        'user_id_from_type',
        'user_id_to',
        'user_id_to_type',
        'status',
        'approve',
        'reply_id',
        'created_at',
    ];
    public function products()
    {
        return $this->belongsTo('App\Models\Product','product_id','id');
    }

    public function users()
    {
        return $this->belongsTo('App\Models\User','user_id_from','id');
    }
    public function user_from()
    {
        return $this->belongsTo('App\Models\User','user_id_from','id');
    }
    public function user_to()
    {
        return $this->belongsTo('App\Models\User','user_id_to','id');
    }

    public function admins()
    {
        return $this->belongsTo('App\Models\Admin','user_id_from','id');
    }

    public function admin_from()
    {
        return $this->belongsTo('App\Models\Admin','user_id_from','id');
    }

    public function admin_to()
    {
        return $this->belongsTo('App\Models\Admin','user_id_to','id');
    }

}
