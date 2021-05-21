<?php

namespace App\Http\Controllers\front;

use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Jenssegers\Agent\Agent;
use App\Vendor\Locale\Locale;
use App\Models\DB\Faq;
use App;

class FaqController extends Controller
{
    protected $agent;
    protected $faq;
    protected $locale;

    function __construct(Faq $faq, Locale $locale, Agent $agent)
    {
        $this->agent = $agent;
        $this->faq = $faq;
        $this->locale = $locale;
        
        $this->locale->setParent('faqs');
        $this->locale->setLanguage(App::getLocale());
    }

    public function index()
    {        
        
        if($this->agent->isDesktop()){
            $faqs = $this->faq->with('image_featured_desktop')->where('active', 1)->get();
            
        }
        
        elseif($this->agent->isMobile()){
            $faqs = $this->faq->with('image_featured_mobile')->where('active', 1)->get();
        }

        $faqs = $faqs->each(function($faq){  
            
            $faq['locale'] = $faq->locale->pluck('value','tag');
            
            return $faq;
        });

        $view = View::make('front.pages.faqs.index')->with('faqs', $faqs );

        return $view;
    }

}
