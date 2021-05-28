<?php

namespace App\Vendor\Product;

use App\Vendor\Product\Models\Product as DBProduct;
use Debugbar;

class Product
{
    protected $rel_parent;

    function __construct(DBProduct $product)
    {
        $this->product = $product;
    }

    public function setParent($rel_parent)
    {
        $this->rel_parent = $rel_parent;
    }

    public function getParent()
    {
        return $this->rel_parent;
    }

    public function store($product, $product_id)
    {  

        foreach ($product as $rel_anchor => $value){

            array_pop($explode_rel_anchor); 
            $tag = implode(".", $explode_rel_anchor); 

            $product[] = $this->product->updateOrCreate([
                    'product_id' => $product_id,
                    'rel_parent' => $this->rel_parent,
                    'rel_anchor' => $rel_anchor],[
                    'rel_parent' => $this->rel_parent,
                    'rel_anchor' => $rel_anchor,
                    'tag' => $tag,
                    'value' => $value,
            ]);
        }

        return $product;
    }

    public function show($product_id)
    {
        return DBProduct::getValues($this->rel_parent, $product_id)->pluck('value','rel_anchor')->all();   
    }

    public function delete($product_id)
    {
        if (DBProduct::getValues($this->rel_parent, $product_id)->count() > 0) {

            DBProduct::getValues($this->rel_parent, $product_id)->delete();   
        }
    }
}
    

