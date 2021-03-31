@extends('front.layout.front')

@section('form')
<div class="form-title">
    <h1>FAQs</h1>
</div>

<div class="form-container">
    <form class="admin-form" id="form-faqs" action="" autocomplete="off">
        
        @foreach($faqs as $faq_element)
            <button class="accordion">{{$faq_element->title}}</button>
            <div class="panel">
                <p>{{$faq_element->description}}</p>
            </div>
        @endforeach 
    
    </form> 
</div>
@endsection
