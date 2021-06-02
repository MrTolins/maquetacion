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

    public function setParent($object)
    {
        $this->object = $object;
    }

    public function getParent()
    {
        return $this->object;
    }

    public function store($product, $product_id)
    {  

        $product[] = $this->product->updateOrCreate([
                'product_id' => $product_id,
                'object' => $this->object],[
                'object' => $this->object,
                'price' => $product['price'],
                'price_without_iva' => $product['price_without_iva'],
                'iva' => $product['iva']
        ]);

        return $product;
    }

    public function show($product_id)
    {
        return DBProduct::getValues($this->object, $product_id)->first();   
    }

    public function delete($product_id)
    {
        if (DBProduct::getValues($this->object, $product_id)->count() > 0) {

            DBProduct::getValues($this->object, $product_id)->delete();   
        }
    }
}
    

