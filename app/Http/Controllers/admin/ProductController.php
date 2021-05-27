<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Jenssegers\Agent\Agent;
use App\Http\Requests\Admin\ProductRequest;
use App\Vendor\Locale\Locale;
use App\Vendor\Locale\LocaleSlugSeo;
use App\Vendor\Image\Image;
use App\Models\DB\Product;
use Debugbar;

class ProductController extends Controller
{
    protected $agent;
    protected $product;
    protected $locale;
    protected $locale_slug_seo;
    protected $image;

    function __construct(Product $product, Agent $agent, Locale $locale, LocaleSlugSeo $locale_slug_seo, Image $image)
    {
        $this->product = $product;
        $this->agent = $agent;
        $this->locale = $locale;
        $this->locale_slug_seo = $locale_slug_seo;
        $this->image = $image;

        if ($this->agent->isMobile()) {
            $this->paginate = 10;
        }

        if ($this->agent->isDesktop()) {
            $this->paginate = 6;
        }

        $this->locale->setParent('products');
        //lo que vas a guardar de locale slug seo va a faqs(rel_parent en base de datos)
        $this->locale_slug_seo->setParent('products');
        $this->image->setEntity('products');
    }

    public function index()
    {

        if($this->agent->isMobile()){
            $view = View::make('admin.products.index')
            ->with('product', $this->product)
            ->with('products', $this->product->where('active', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(10));
        }

        if($this->agent->isDesktop()){
            $view = View::make('admin.products.index')
            ->with('product', $this->product)
            ->with('products', $this->product->where('active', 1)
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

        $view = View::make('admin.products.index')
        ->with('product', $this->product)
        ->renderSections();

        return response()->json([
            'form' => $view['form']
        ]);
    }

    public function store(ProductRequest $request)
    {          
        Debugbar::info(request('seo'));

        $product = $this->product->updateOrCreate([
            'id' => request('id')],[
            'type' => request('type'),
            'key' => request('key'),
            'description' => request('description'),
            'price' => request('price'),
            'mobile_id' => request('mobile_id'),
            'active' => 1,
        ]);

        //le pasas los resultados de seo y la id de faq, mas front_faqs
        if(request('seo')){
            $seo = $this->locale_slug_seo->store(request("seo"), $product->id, 'front_product');
        }

        if(request('locale')){
            $locale = $this->locale->store(request('locale'), $product->id);
        }

        if(request('images')){
            $images = $this->image->store(request('images'), $product->id);
        }

        if (request('id')){
            $message = \Lang::get('admin/products.product-update');
        }else{
            $message = \Lang::get('admin/products.product-create');
        }

        $view = View::make('admin.products.index')
        ->with('products', $this->product->paginate(5))
        ->with('product', $product)
        ->renderSections();        

        return response()->json([
            'table' => $view['table'],
            'form' => $view['form'],
            'id' => $product->id,
            'message' => $message
        ]);
    }

    public function show(Product $product)
    {
        $locale = $this->locale->show($product->id);
        $seo = $this->locale_slug_seo->show($product->id);

        $view = View::make('admin.products.index')
        ->with('locale', $locale)
        ->with('seo', $seo)
        ->with('product', $product)
        ->with('products', $this->product->where('active', 1)->orderBy('created_at', 'desc')->paginate($this->paginate))
        ->renderSections();        

        return response()->json([
            'table' => $view['table'],
            'form' => $view['form'],
        ]);
    }

    public function destroy(Product $product)
    {
        $product->active = 0;
        $product->save();

        $product->delete();

        $message = \Lang::get('admin/products.product-delete');

        if($this->agent->isMobile()){
            $view = View::make('admin.products.index')
            ->with('product', $this->product)
            ->with('products', $this->product->where('active', 1)->orderBy('created_at', 'desc')->paginate(10))
            ->renderSections();        
        }

        if($this->agent->isDesktop()){
            $view = View::make('admin.products.index')
            ->with('product', $this->product)
            ->with('products', $this->product->where('active', 1)->orderBy('created_at', 'desc')->paginate(6))
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

        $query = $this->product->query();

        if($filters != null){

            $query->when($filters->element_id, function ($q, $element_id) {

                if($category_id == 'all'){
                    return $q;
                }
                else {
                    return $q->where('element_id', $element_id);
                }
            });

            $query->when($filters->search, function ($q, $search) {

                if($search == null){
                    return $q;
                }
                else {
                    return $q->where('name', 'like', "%$search%");
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
            $products = $query->where('t_products.active', 1)
                    ->orderBy('t_products.created_at', 'desc')
                    ->paginate(10)
                    ->appends(['filters' => json_encode($filters)]);  
        }

        if($this->agent->isDesktop()){
            $products = $query->where('t_products.active', 1)
                    ->orderBy('t_products.created_at', 'desc')
                    ->paginate(6)
                    ->appends(['filters' => json_encode($filters)]);   
        }

        $view = View::make('admin.products.index')
            ->with('products', $products)
            ->renderSections();

        return response()->json([
            'table' => $view['table'],
        ]);
    }

    
}
