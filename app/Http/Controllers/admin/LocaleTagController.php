<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Http\Request;
use Jenssegers\Agent\Agent;
use App\Vendor\Locale\Manager;
use App\Http\Controllers\Controller;
use App\Vendor\Locale\Models\LocaleLanguage;
use App\Vendor\Locale\Models\LocaleTag;
use Debugbar;

class LocaleTagController extends Controller
{
    protected $agent;
    protected $localeTag;
    protected $language;
    protected $manager;

    function __construct(Agent $agent, LocaleTag $localeTag, LocaleLanguage $language, Manager $manager)
    {
        $this->agent = $agent;
        $this->localeTag = $localeTag;
        $this->language = $language;
        $this->manager = $manager;

        if ($this->agent->isMobile()) {
            $this->paginate = 10;
        }

        if ($this->agent->isDesktop()) {
            $this->paginate = 6;
        }
    }

    public function index()
    {
        $tags =  $this->localeTag
        ->select('group','key')
        ->groupBy('group','key')
        ->where('group', 'not like', 'admin/%')
        ->where('group', 'not like', 'front/seo')
        ->paginate($this->paginate);

        $view = View::make('admin.localeTags.index')
            ->with('localeTag', $this->localeTag)
            ->with('localeTags', $tags);

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

    }

    public function store(Request $request)
    {            
        //a localeTag llega tanto el castellano como el inglés
        //accedemos tanto a la clave(rel_anchor) como al valor(value)
        foreach (request('localeTag') as $rel_anchor => $value){
            //sustituye rayas por puntos
            //el explode separa por puntos
            //lanuguage coge el ultimo valor end()
            //index, localization=>alias
            $rel_anchor = str_replace(['-', '_'], ".", $rel_anchor); 
            $explode_rel_anchor = explode('.', $rel_anchor);
            $language = end($explode_rel_anchor);

            $localeTag = $this->localeTag::updateOrCreate([
                'language' => $language,
                'group' => request('group'),
                'key' => request('key')],[
                'language' => $language,
                'group' => request('group'),
                'key' => request('key'),
                'value' => $value,
                'active' => 1
            ]);
        }

        $localeTags =  $this->localeTag
        ->select('group','key')
        ->groupBy('group','key')
        //que group no traiga todo lo que hay en admin ni en front/seo
        ->where('group', 'not like', 'admin/%')
        ->where('group', 'not like', 'front/seo')
        ->paginate(5);

        if (request('id')){
            $message = \Lang::get('admin/localeTag.localeTag-update');
        }else{
            $message = \Lang::get('admin/localeTag.localeTag-create');
        }

        $view = View::make('admin.localeTags.index')
        ->with('localeTags', $localeTags)
        ->with('localeTag', $localeTag)
        ->renderSections();        

        return response()->json([
            'table' => $view['table'],
            'form' => $view['form'],
            'message' => $message
        ]);
    }

    //busca group y key
    public function edit($group, $key)
    {
        //trae todos los que tinen key y group
        //reemplaza las barras por guiones porque si no la barra confundiria a la URL, pensando que le pasa 3 parametros en lugar de 2
        $localeTags = $this->localeTag->where('key', $key)->where('group', str_replace('-', '/' , $group))->paginate($this->paginate); 
        //coge los primeros que son group y key
        $localeTag = $localeTags->first();

        //coge todos los idiomas
        $languages = $this->language->get();

        //bucle con los idiomas
        //filter devolverá una respuesta, recorrerá todos los valores que tenga tags
        //item es cada uno de ellos
        //si item->language es igual al idioma language->alias (idioma actual)
        foreach($languages as $language){
            $locale = $localeTags->filter(function($item) use($language) {
                return $item->language == $language->alias;
            })->first();

            //le pinta el valor, si no coincide no pintaría el valor
            //si cambio value por otro (o agregas otro nuevo), agregará el atributo al vuelo sin pasar por la base de datos
            $localeTag['value.'. $language->alias] = empty($locale->value) ? '': $locale->value; 
        }
        
        //titulo descpcion keywords url
        $view = View::make('admin.localeTags.index')
        ->with('localeTags', $localeTags)
        ->with('localeTag', $localeTag);
        
        if(request()->ajax()) {
            $sections = $view->renderSections(); 
    
            return response()->json([
                'table' => $sections['table'],
                'form' => $sections['form'],
            ]); 
        }
                
        return $view;
    }

    public function destroy(LocaleTag $localeTag)
    {

    }

    public function filter(Request $request, $filters = null){

       
        $filters = json_decode($request->input('filters'));

        $query = $this->localeTag->query();

        if($filters != null){

            $query->when($filters->parent, function ($q, $parent) {

                if($parent == 'all'){
                    return $q;
                }
                else{
                    return $q->where('group', $parent);
                }
            });
    
            $query->when($filters->order, function ($q, $order) use ($filters) {
    
                $q->orderBy($order, $filters->direction);
            });
        }
    
        $localeTags = $query->select('group', 'key')
                ->groupBy('group', 'key')
                ->where('group', 'not like', 'admin/%')
                ->where('group', 'not like', 'front/seo')
                ->paginate($this->paginate)
                ->appends(['filters' => json_encode($filters)]);  

        $view = View::make('admin.localeTags.index')
            ->with('localeTags', $localeTags)
            ->renderSections();

        return response()->json([
            'table' => $view['table'],
        ]);
    }

    public function importTags()
    {
        $this->manager->importTranslations();  
        $message =  \Lang::get('admin/localeTags.localeTag-import');

        $localeTags = $this->localeTag
        ->select('group', 'key')
        ->groupBy('group', 'key')
        ->where('group', 'not like', 'admin/%')
        ->where('group', 'not like', 'front/seo')
        ->paginate($this->paginate);  

        $view = View::make('admin.localeTags.index')
            ->with('localeTags', $localeTags)
            ->with('localeTag', $this->localeTag);

        if(request()->ajax()) {

            $sections = $view->renderSections(); 
    
            return response()->json([
                'table' => $sections['table'],
                'message' => $message,
            ]); 
        }
    }


    
}
