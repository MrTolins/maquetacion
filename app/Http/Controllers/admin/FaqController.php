<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Jenssegers\Agent\Agent;
use App\Http\Requests\Admin\FaqRequest;
use App\Vendor\Locale\Locale;
use App\Vendor\Image\Image;
use App\Models\DB\Faq;
use Debugbar;

class FaqController extends Controller
{
    protected $agent;
    protected $faq;
    protected $locale;
    protected $image;

    function __construct(Faq $faq, Agent $agent, Locale $locale, Image $image)
    {
        $this->faq = $faq;
        $this->agent = $agent;
        $this->locale = $locale;
        $this->image = $image;

        if ($this->agent->isMobile()) {
            $this->paginate = 10;
        }

        if ($this->agent->isDesktop()) {
            $this->paginate = 6;
        }

        $this->locale->setParent('faqs');
        $this->image->setEntity('faqs');
    }

    public function index()
    {

        if($this->agent->isMobile()){
            $view = View::make('admin.faqs.index')
            ->with('faq', $this->faq)
            ->with('faqs', $this->faq->where('active', 1)
            ->orderBy('created_at', 'desc')
            ->paginate(10));
        }

        if($this->agent->isDesktop()){
            $view = View::make('admin.faqs.index')
            ->with('faq', $this->faq)
            ->with('faqs', $this->faq->where('active', 1)
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

        $view = View::make('admin.faqs.index')
        ->with('faq', $this->faq)
        ->renderSections();

        return response()->json([
            'form' => $view['form']
        ]);
    }

    public function store(FaqRequest $request)
    {          
        Debugbar::info(request('images'));

        $faq = $this->faq->updateOrCreate([
            'id' => request('id')],[
            'name' => request('name'),
            'category_id' => request('category_id'),
            'active' => 1,
        ]);

        if(request('locale')){
            $locale = $this->locale->store(request('locale'), $faq->id);
        }

         if(request('images')){
            $images = $this->image->storeRequest(request('images'), 'webp', $faq->id);
        }

        if (request('id')){
            $message = \Lang::get('admin/faqs.faq-update');
        }else{
            $message = \Lang::get('admin/faqs.faq-create');
        }

        $view = View::make('admin.faqs.index')
        ->with('faqs', $this->faq->paginate(5))
        ->with('faq', $faq)
        ->renderSections();        

        return response()->json([
            'table' => $view['table'],
            'form' => $view['form'],
            'id' => $faq->id,
            'message' => $message
        ]);
    }

    public function show(Faq $faq)
    {
        $locale = $this->locale->show($faq->id);

        $view = View::make('admin.faqs.index')
        ->with('locale', $locale)
        ->with('faq', $faq)
        ->with('faqs', $this->faq->where('active', 1)->orderBy('created_at', 'desc')->paginate($this->paginate))
        ->renderSections();        

        return response()->json([
            'table' => $view['table'],
            'form' => $view['form'],
        ]);
    }

    public function destroy(Faq $faq)
    {
        $faq->active = 0;
        $faq->save();

        $faq->delete();

        $message = \Lang::get('admin/faqs.faq-delete');

        if($this->agent->isMobile()){
            $view = View::make('admin.faqs.index')
            ->with('faq', $this->faq)
            ->with('faqs', $this->faq->where('active', 1)->orderBy('created_at', 'desc')->paginate(10))
            ->renderSections();        
        }

        if($this->agent->isDesktop()){
            $view = View::make('admin.faqs.index')
            ->with('faq', $this->faq)
            ->with('faqs', $this->faq->where('active', 1)->orderBy('created_at', 'desc')->paginate(6))
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

        $query = $this->faq->query();

        if($filters != null){

            $query->when($filters->category_id, function ($q, $category_id) {

                if($category_id == 'all'){
                    return $q;
                }
                else {
                    return $q->where('category_id', $category_id);
                }
            });

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
            $faqs = $query->where('t_faqs.active', 1)
                    ->orderBy('t_faqs.created_at', 'desc')
                    ->paginate(10)
                    ->appends(['filters' => json_encode($filters)]);  
        }

        if($this->agent->isDesktop()){
            $faqs = $query->where('t_faqs.active', 1)
                    ->orderBy('t_faqs.created_at', 'desc')
                    ->paginate(6)
                    ->appends(['filters' => json_encode($filters)]);   
        }

        $view = View::make('admin.faqs.index')
            ->with('faqs', $faqs)
            ->renderSections();

        return response()->json([
            'table' => $view['table'],
        ]);
    }

    
}
