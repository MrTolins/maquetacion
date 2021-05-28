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

        foreach ($product as $object => $price){
 

            $product[] = $this->product->updateOrCreate([
                    'product_id' => $product_id,
                    'rel_parent' => $this->rel_parent,
                    'object' => $object],[
                    'rel_parent' => $this->rel_parent,
                    'object' => $object,
                    'price' => $price,
                    'price_without_iva' => $price_without_iva,
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
    

