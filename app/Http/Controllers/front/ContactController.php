<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Jenssegers\Agent\Agent;
use App\Vendor\Locale\LocaleSlugSeo;
use App\Models\DB\ContactLog;

class ContactController extends Controller
{
    protected $agent;
    protected $contact;
    protected $locale_slug_seo;

    function __construct(Agent $agent, ContactLog $contact_log, LocaleSlugSeo $locale_slug_seo)
    {
        $this->agent = $agent;
        $this->contact_log = $contact_log;
        $this->locale_slug_seo = $locale_slug_seo;

        $this->locale_slug_seo->setLanguage(app()->getLocale()); 
        $this->locale_slug_seo->setParent('contact');      
    }

    public function index()
    {        
        $seo = $this->locale_slug_seo->getByKey(Route::currentRouteName());

        $view = View::make('front.pages.contact.index')->with('seo', $seo );
        
        return $view;
    }

}
