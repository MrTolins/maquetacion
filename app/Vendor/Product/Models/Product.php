<?php

namespace App\Vendor\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Debugbar;

class Product extends Model
{
    protected $table = 't_product';
    protected $guarded = [];

    public function scopeGetValues($query, $rel_parent, $key){

        return $query->where('key', $key)
            ->where('rel_parent', $rel_parent);
    }

    // public function scopeGetIdByLanguage($query, $rel_parent, $language, $key){
        
    //     return $query->where('key', $key)
    //         ->where('language', $language)
    //         ->where('rel_parent', $rel_parent);
    // }

    // public function scopeGetAllByLanguage($query, $rel_parent, $language){

    //     return $query->where('language', $language)
    //         ->where('rel_parent', $rel_parent);
    // }
}
