<?php

namespace App\Http\Controllers\front;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Jenssegers\Agent\Agent;
use App\Vendor\Locale\Locale;
use App\Vendor\Locale\LocaleSlugSeo;
use App\Models\DB\Mobile;
use App;
use Debugbar;

class MobileController extends Controller
{
    protected $agent;
    protected $mobile;
    protected $locale;
    protected $locale_slug_seo;

    function __construct(Mobile $mobile, Locale $locale, LocaleSlugSeo $locale_slug_seo, Agent $agent)
    {
        $this->agent = $agent;
        $this->mobile = $mobile;
        $this->locale = $locale;
        $this->locale_slug_seo = $locale_slug_seo;
        
        $this->locale->setParent('mobiles');
        $this->locale->setLanguage(App::getLocale());
        $this->locale_slug_seo->setLanguage(app()->getLocale()); 
        $this->locale_slug_seo->setParent('mobiles');  
    }

    public function index()
    {        
        //coge el nombre de la ruta (en el caso de español coge front_faqs)
        //devuelve el name de la ruta (routes.php)
        $seo = $this->locale_slug_seo->getByKey(Route::currentRouteName());
        
        if($this->agent->isDesktop()){
            $mobiles = $this->mobile->with('image_featured_desktop')->where('active', 1)->get();
            
        }
        
        elseif($this->agent->isMobile()){
            $mobiles = $this->mobile->with('image_featured_mobile')->where('active', 1)->get();
        }

        $mobiles = $mobiles->each(function($mobile){  
            
            $mobile['locale'] = $mobile->locale->pluck('value','tag');
            
            return $mobile;
        });

        $view = View::make('front.pages.mobiles.index')
            ->with('mobiles', $mobiles)
            ->with('seo', $seo);

        return $view;
    }

    public function show($slug)
    {      
        $seo = $this->locale_slug_seo->getIdByLanguage($slug);

        if(isset($seo->key)){

            if($this->agent->isDesktop()){
                $mobile = $this->mobile
                    ->with('image_featured_desktop')
                    ->with('image_grid_desktop')
                    ->where('active', 1)
                
                    ->find($seo->key);
            }
            
            elseif($this->agent->isMobile()){
                $mobile = $this->mobile
                    ->with('image_featured_mobile')
                    ->with('image_grid_mobile')
                    ->where('active', 1)
                  
                    ->find($seo->key);
            }

            $mobile['locale'] = $mobile->locale->pluck('value','tag');

            $view = View::make('front.pages.mobiles.single')->with('mobile', $mobile);

            return $view;

        }else{
            return response()->view('errors.404', [], 404);
        }
    }

}
