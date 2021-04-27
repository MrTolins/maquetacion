<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\FaqRequest;
use App\Models\DB\Faq;
use Debugbar;

class FaqController extends Controller
{
    protected $faq;

    function __construct(Faq $faq)
    {
        $this->faq = $faq;
    }

    public function index()
    {

        $view = View::make('admin.faqs.index')
            ->with('faq', $this->faq)
            ->with('faqs', $this->faq->where('active', 1)->paginate(5));

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
       

        $view = View::make('admin.faqs.index')
        ->with('faq', $faq)
        ->with('faqs', $this->faq->where('active', 1)->paginate(5));   
        
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

        $view = View::make('admin.faqs.index')
            ->with('faq', $this->faq)
            ->with('faqs', $this->faq->where('active', 1)->paginate(5))
            ->renderSections();
        
        return response()->json([
            'table' => $view['table'],
            'form' => $view['form'],
            'message' => $message
        ]);
    }

    public function filter(Request $request){

        $query = $this->faq->query();

        $query->when(request('category_id'), function ($q, $category_id) {

            if($category_id == 'all'){
                return $q;
            }
            else {
                return $q->where('category_id', $category_id);
            }
        });

        $query->when(request('search'), function ($q, $search) {

            if($search == null){
                return $q;
            }
            else {
                return $q->where('title', 'like', "%$search%");
            }
        });

        $query->when(request('date'), function ($q, $date) {

            if($date == null){
                return $q;
            }
            else {
                return $q->whereDate('created_at', '>=', $date);
            }
        });

        $query->when(request('datesince'), function ($q, $datesince) {

            if($datesince == null){
                return $q;
            }
            else {
                return $q->whereDate('created_at', '<=', $datesince);
            }
        });

        $query->when(request('order'), function ($q, $order) use ($request) {

            $q->orderBy($order, $request->direction);
        });

        $faqs = $query->join('t_faqs_categories', 't_faqs.category_id', '=', 't_faqs_categories.id')
        ->where('t_faqs.active', 1)->paginate(5);

        $view = View::make('admin.faqs.index')
            ->with('faqs', $faqs)
            ->renderSections();

        return response()->json([
            'table' => $view['table'],
        ]);
    }

    
}
