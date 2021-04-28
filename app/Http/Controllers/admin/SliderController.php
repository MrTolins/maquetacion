<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SliderRequest;
use App\Models\DB\Slider;
use Debugbar;

class SliderController extends Controller
{
    protected $slider;

    function __construct(Slider $slider)
    {
        $this->slider = $slider;
    }

    public function index()
    {

        $view = View::make('admin.sliders.index')
            ->with('slider', $this->slider)
            ->with('sliders', $this->slider->where('active', 1)->paginate(5));

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

        $view = View::make('admin.sliders.index')
        ->with('slider', $this->slider)
        ->renderSections();

        return response()->json([
            'form' => $view['form']
        ]);
    }

    public function store(SliderRequest $request)
    {            
        $slider = $this->slider->updateOrCreate([
            'id' => request('id')],[
            'name' => request('name'),
            'entity' => request('entity'),
            'visible' => 1,
            'active' => 1,
        ]);

        if (request('id')){
            $message = \Lang::get('admin/sliders.slider-update');
        }else{
            $message = \Lang::get('admin/sliders.slider-create');
        }

        $view = View::make('admin.sliders.index')
        ->with('sliders', $this->slider->paginate(5))
        ->with('slider', $slider)
        ->renderSections();        

        return response()->json([
            'table' => $view['table'],
            'form' => $view['form'],
            'id' => $slider->id,
            'message' => $message
        ]);
    }

    public function show(Slider $slider)
    {
       

        $view = View::make('admin.sliders.index')
        ->with('slider', $slider)
        ->with('sliders', $this->slider->where('active', 1)->paginate(5));   
        
        if(request()->ajax()) {

            $sections = $view->renderSections(); 
    
            return response()->json([
                'form' => $sections['form'],
                
            ]); 
        }
        
        
        return $view;
    }

    public function destroy(Slider $slider)
    {
        $slider->active = 0;
        $slider->save();

        $slider->delete();

        $message = \Lang::get('admin/sliders.slider-delete');

        $view = View::make('admin.sliders.index')
            ->with('slider', $this->slider)
            ->with('sliders', $this->slider->where('active', 1)->paginate(5))
            ->renderSections();
        
        return response()->json([
            'table' => $view['table'],
            'form' => $view['form'],
            'message' => $message
        ]);
    }

    public function filter(Request $request){

        $query = $this->slider->query();

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

        $sliders = $query->where('active', 1)->paginate(5);


        $view = View::make('admin.sliders.index')
            ->with('slider', $this->slider)
            ->with('sliders', $sliders)
            ->renderSections();
        
        return response()->json([
            'table' => $view['table'],
        ]);
    }

    
}
