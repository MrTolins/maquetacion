<?php

namespace App\Vendor\Product\Models;

use Illuminate\Database\Eloquent\Model;
use Debugbar;

class Product extends Model
{
    protected $table = 't_products';
    protected $guarded = [];

    public function scopeGetValues($query, $object, $product_id){

        return $query->where('product_id', $product_id)
            ->where('object', $object);
    }

}
