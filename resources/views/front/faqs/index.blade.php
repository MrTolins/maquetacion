@extends('front.layout.front')

@section('form')
<div class="form-title">
    <h1>FAQs</h1>
</div>

<div class="form-container">
    <form class="admin-form" id="form-faqs" action="" autocomplete="off">

        
        @foreach($faqs as $faq_element)
            <div class="form-group">
                <div class="form-label">
                    <label for="pregunta" class="label">Título</label>
                </div>
                
                <div class="form-input">
                    <div>{{$faq_element->title}}</div>
                </div>
                <input type="checkbox"  id="spoiler2"> 
                <label for="spoiler2" >
                    <img class="form-input-add" src="https://cdn.icon-icons.com/icons2/692/PNG/512/seo-social-web-network-internet_189_icon-icons.com_61521.png">
                </label>
                <div class="spoiler">
            
                    <div class="form-group">
                        <div class="form-label">
                            <label for="respuesta">Descripción</label>
                        </div>
                        <div class="form-input">
                            <div>{{$faq_element->description}}</div>  
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </form>   
</div>
@endsection