@extends('front.layout.front')

@section('form')
<div class="form-title">
    <h1>FAQs</h1>
</div>
      
        @foreach($faqs as $faq_element)
            <button class="accordion" data-button="">{{$faq_element->title}}</button>
            <div class="panel">
                <p>{{$faq_element->description}}</p>
            </div>
        @endforeach
</div> 

@endsection
