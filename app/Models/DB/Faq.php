<?php

namespace App\Models\DB;

class Faq extends DBModel
{

    protected $table = 't_faqs';
    protected $with = ['category'];

    public function category()
    {
        return $this->belongsTo(FaqCategory::class);
    }
}
