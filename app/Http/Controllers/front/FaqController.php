<?php

namespace App\Http\Controllers\front;

//use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
//use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use App\Http\Requests\Admin\FaqRequest;
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

        $view = View::make('front.faqs.index')
                ->with('faq', $this->faq)
                ->with('faqs', $this->faq->get());

        if(request()->ajax()) {

            $sections = $view->renderSections(); 
    
            return response()->json([
                'table' => $sections['table'],
                'form' => $sections['form'],
            ]); 
        }

        return $view;
    }
};
/*
    public function indexJson()
    {
        if (! Auth::guard('web')->user()->canAtLeast(['faqs'])){
            return Auth::guard('web')->user()->redirectPermittedSection();
        }

        $query = $this->faq
        ->with('category')
        ->select('t_faq.*');

        return $this->datatables->of($query)->toJson();   
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
            'active' => 1,
        ]);

        $view = View::make('admin.faqs.index')
        ->with('faqs', $this->faq->get())
        ->with('faq', $faq)
        ->renderSections();        

        return response()->json([
            'table' => $view['table'],
            'form' => $view['form'],
            'id' => $faq->id,
        ]);
    }

    public function show(Faq $faq)
    {
        Debugbar::info($faq);

        $view = View::make('admin.faqs.index')
        ->with('faq', $faq)
        ->with('faqs', $this->faq->where('active', 1)->get());   
        
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

        $view = View::make('admin.faqs.index')
            ->with('faq', $this->faq)
            ->with('faqs', $this->faq->where('active', 1)->get())
            ->renderSections();
        
        return response()->json([
            'table' => $view['table'],
            'form' => $view['form']
        ]);
    }
}
*/