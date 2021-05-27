<?php

namespace App\Models\DB;

use App\Vendor\Locale\Models\Locale;
use App\Vendor\Locale\Models\LocaleSlugSeo;
use App\Vendor\Image\Models\ImageResized;
use App;

class Product extends DBModel
{

    protected $table = 't_products';

    public function mobiles()
    {
        return $this->hasMany(Mobile::class, 'mobile_id');
    }
   

}