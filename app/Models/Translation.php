<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    protected $table = 'translations';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */

    protected $fillable = [
        'lang_content',
        'lang_code',
        'post_id',
        'lang_id',
        'lang_type',
        'lang_type_detail'
    ];

    public function getAllTranslationCodes(){
        $translation = static::all();
        $codes = [];
        foreach ($translation as $tran){
            $codes[] = $tran -> lang_code;
        }
        return $codes;
    }


}
