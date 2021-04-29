<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Jenssegers\Agent\Agent;
use App\Http\Requests\Admin\FaqRequest;
use App\Models\DB\Faq;

class FaqController extends Controller
{
    protected $faq;

    function __construct(Faq $faq, Agent $agent)
    {
        $this->faq = $faq;
        $this->agent = $agent;
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
        $faq = $this->faq->updateOrCreate([
            'id' => request('id')],[
            'title' => request('title'),
            'description' => request('description'),
            'category_id' => request('category_id'),
            'active' => 1,
        ]);

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
       

        if($this->agent->isMobile()){
            $view = View::make('admin.faqs.index')
            ->with('faq', $faq)
            ->with('faqs', $this->faq->where('active', 1)->orderBy('created_at', 'desc')->paginate(10));        
        }
        
        if($this->agent->isDesktop()){
            $view = View::make('admin.faqs.index')
            ->with('faq', $faq)
            ->with('faqs', $this->faq->where('active', 1)->orderBy('created_at', 'desc')->paginate(6));        
        }
        
        if(request()->ajax()) {

            $sections = $view->renderSections(); 
    
            return response()->json([
                'form' => $sections['form'],
                
            ]); 
        }
        
        
        return $view;
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
