<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Jenssegers\Agent\Agent;
use App\Http\Requests\Admin\MobileRequest;
use App\Vendor\Locale\Locale;
use App\Vendor\Locale\LocaleSlugSeo;
use App\Vendor\Image\Image;
use App\Vendor\Product\Product;
use App\Models\DB\Mobile;
use Debugbar;

class MobileController extends Controller
{
    protected $agent;
    protected $mobile;
    protected $locale;
    protected $locale_slug_seo;
    protected $image;
    protected $product;

    function __construct(Mobile $mobile, Agent $agent, Locale $locale, LocaleSlugSeo $locale_slug_seo, Image $image, Product $product)
    {
        $this->mobile = $mobile;
        $this->agent = $agent;
        $this->locale = $locale;
        $this->locale_slug_seo = $locale_slug_seo;
        $this->image = $image;
        $this->product = $product;

        if ($this->agent->isMobile()) {
            $this->paginate = 10;
        }

        if ($this->agent->isDesktop()) {
            $this->paginate = 6;
        }

        $this->product->setParent('mobiles');
        $this->locale->setParent('mobiles');
        //lo que vas a guardar de locale slug seo va a faqs(rel_parent en base de datos)
        $this->locale_slug_seo->setParent('mobiles');
        $this->image->setEntity('mobiles');
    }

    public function index()
    {

        if($this->agent->isMobile()){
            $view = View::make('admin.mobiles.index')
            ->with('mobile', $this->mobile)
            ->with('mobiles', $this->mobile->where('active', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(10));
        }

        if($this->agent->isDesktop()){
            $view = View::make('admin.mobiles.index')
            ->with('mobile', $this->mobile)
            ->with('mobiles', $this->mobile->where('active', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(6));
        }

        if(request()->ajax()) {

            $sections = $view->renderSections(); 
    
            return response()->json([
                'table' => $sections['table'],
                'form' => $sections['form'],
            ]); 
        }

        return $view;
    }

    public function create()
    {

        $view = View::make('admin.mobiles.index')
        ->with('mobile', $this->mobile)
        ->renderSections();

        return response()->json([
            'form' => $view['form']
        ]);
    }

    public function store(MobileRequest $request)
    {          

        $mobile = $this->mobile->updateOrCreate([
            'id' => request('id')],[
            'brand' => request('brand'),
            'model' => request('model'),
            'inches' => request('inches'),
            'height' => request('height'),
            'width' => request('width'),
            'active' => 1,
        ]);

        //le pasas los resultados de seo y la id de faq, mas front_faqs
        if(request('product')){
            $product = $this->product->store(request("product"), $mobile->id);
        }
        
        if(request('seo')){
            $seo = $this->locale_slug_seo->store(request("seo"), $mobile->id, 'front_mobile');
        }

        if(request('locale')){
            $locale = $this->locale->store(request('locale'), $mobile->id);
        }

        if(request('images')){
            $images = $this->image->store(request('images'), $mobile->id);
        }

        if (request('id')){
            $message = \Lang::get('admin/mobiles.mobile-update');
        }else{
            $message = \Lang::get('admin/mobile.mobile-create');
        }

        $view = View::make('admin.mobiles.index')
        ->with('mobiles', $this->mobile->paginate(5))
        ->with('mobile', $mobile)
        ->renderSections();        

        return response()->json([
            'table' => $view['table'],
            'form' => $view['form'],
            'id' => $mobile->id,
            'message' => $message
        ]);
    }

    public function show(Mobile $mobile)
    {
        $locale = $this->locale->show($mobile->id);
        $seo = $this->locale_slug_seo->show($mobile->id);
        $product = $this->product->show($mobile->id);

        $view = View::make('admin.mobiles.index')
        ->with('locale', $locale)
        ->with('seo', $seo)
        ->with('product', $product)
        ->with('mobile', $mobile)
        ->with('mobiles', $this->mobile->where('active', 1)->orderBy('created_at', 'desc')->paginate($this->paginate))
        ->renderSections();        

        return response()->json([
            'table' => $view['table'],
            'form' => $view['form'],
        ]);
    }

    public function destroy(Mobile $mobile)
    {

        $this->locale->delete($mobile->id);
        $this->locale_slug_seo->delete($mobile->id);
        $mobile->active = 0;
        $mobile->save();

        $mobile->delete();

        $message = \Lang::get('admin/mobiles.mobile-delete');

        if($this->agent->isMobile()){
            $view = View::make('admin.mobiles.index')
            ->with('mobile', $this->mobile)
            ->with('mobiles', $this->mobile->where('active', 1)->orderBy('created_at', 'desc')->paginate(10))
            ->renderSections();        
        }

        if($this->agent->isDesktop()){
            $view = View::make('admin.mobiles.index')
            ->with('mobile', $this->mobile)
            ->with('mobiles', $this->mobile->where('active', 1)->orderBy('created_at', 'desc')->paginate(6))
            ->renderSections();        
        }
        
        return response()->json([
            'table' => $view['table'],
            'form' => $view['form'],
            'message' => $message
        ]);
    }

    public function filter(Request $request, $filters = null){

        //Convierte a json la variable filters

        $filters = json_decode($request->input('filters'));

        $query = $this->mobile->query();

        if($filters != null){

        
            $query->when($filters->search, function ($q, $search) {

                if($search == null){
                    return $q;
                }
                else {
                    return $q->where('title', 'like', "%$search%");
                }
            });

            $query->when($filters->date, function ($q, $date) {

                if($date == null){
                    return $q;
                }
                else {
                    return $q->whereDate('created_at', '>=', $date);
                }
            });

            $query->when($filters->datesince, function ($q, $datesince) {

                if($datesince == null){
                    return $q;
                }
                else {
                    return $q->whereDate('created_at', '<=', $datesince);
                }
            });

            $query->when($filters->order, function ($q, $order) use ($filters) {

                $q->orderBy($order, $filters->direction);
            });
        
        }

        if($this->agent->isMobile()){
            $mobiles = $query->where('t_mobiles.active', 1)
                    ->orderBy('t_mobiles.created_at', 'desc')
                    ->paginate(10)
                    ->appends(['filters' => json_encode($filters)]);  
        }

        if($this->agent->isDesktop()){
            $mobiles = $query->where('t_mobiles.active', 1)
                    ->orderBy('t_mobiles.created_at', 'desc')
                    ->paginate(6)
                    ->appends(['filters' => json_encode($filters)]);   
        }

        $view = View::make('admin.mobiles.index')
            ->with('mobiles', $mobiles)
            ->renderSections();

        return response()->json([
            'table' => $view['table'],
        ]);
    }

    
}
