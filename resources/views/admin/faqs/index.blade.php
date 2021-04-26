@php
    $route = 'faqs';
    $filters = ['category' => $faqs_categories, 'search' => true, 'date' => true, 'datesince' => true];
    $order = ['fecha de creación' => 't_faqs.created_at', 'título' => 't_faqs.title', 'categoria' => 't_faqs_categories.name'];
@endphp

@extends('admin.layout.table_form')

@section('table')

    @isset($faqs)

        <div class="table" id="table-container">

            <div class="table-title">
                <h1>Table</h1>
            </div>

            @foreach($faqs as $faq_element)
                <div class="table-row swipe-element">
                    <div class="table-field-container swipe-front" data-swipe="{{$faq_element->id}}">
                            <div class="table-field"><p><span>Title:</span> {{$faq_element->title}}</p></div>
                            <div class="table-field"><p><span>Category:</span> {{$faq_element->category->name}}</p></div>
                            <div class="table-field"><p><span>Date:</span> {{$faq_element->created_at}}</p></div>
                    </div>

                    <div class="table-icons-container swipe-back">
                        <div class="table-icons edit-button right-swipe" data-url="{{route('faqs_show', ['faq' => $faq_element->id])}}" data-swipe="{{$faq_element->id}}">
                            <svg viewBox="0 0 24 24">
                                <path d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z" />
                            </svg>
                        </div> 
                        
                        <div class="table-icons delete-button left-swipe" data-url="{{route('faqs_destroy', ['faq' => $faq_element->id])}}" data-swipe="{{$faq_element->id}}">
                            <svg viewBox="0 0 24 24">
                                <path d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z" />
                            </svg>
                        </div>
                    </div>
                </div> 
            @endforeach 

            @if($agent->isDesktop())
                @include('admin.components.table_pagination', ['items' => $faqs])
            @endif

        </div>
    @endif

@endsection

@section('form')

@isset($faq)

    <div class="form-title">
        <h1>Form</h1>
    </div>

    <div class="form-container">
        <form class="admin-form" id="form-faqs" action="{{route("faqs_store")}}" autocomplete="off">

            <input autocomplete="false" name="hidden" type="text" style="display:none;">
            <input type="hidden" name="id" value="{{isset($faq->id) ? $faq->id : ''}}">

            {{ csrf_field() }}
            
            <div class="second-menu-form">
                <nav class="second-menu-nav">
                    <ul class="second-menu-ul">
                        <li class="sub-menu-parent active"><a data-toggle="tab" >Home</a></li>
                        <li class="sub-menu-parent"><a data-toggle="tab" >Description</a></li>
                        <li class="sub-menu-parent">
                            <div class="form-submit">
                                <input type="submit" value="Send" id="send-button">
                            </div>
                        </li>
                        <li class="sub-menu-parent">
                            <div id="clear-button" data-url="{{route('faqs_create')}}">
                                <svg style="width:35px;height:35px;cursor: pointer;" viewBox="0 0 24 24">
                                    <path fill="currentColor" d="M12,6V9L16,5L12,1V4A8,8 0 0,0 4,12C4,13.57 4.46,15.03 5.24,16.26L6.7,14.8C6.25,13.97 6,13 6,12A6,6 0 0,1 12,6M18.76,7.74L17.3,9.2C17.74,10.04 18,11 18,12A6,6 0 0,1 12,18V15L8,19L12,23V20A8,8 0 0,0 20,12C20,10.43 19.54,8.97 18.76,7.74Z" />
                                </svg>
                            </div>
                        </li>
                        
                    </ul>
                </nav>
            
                <div class="home active">
                    <div class="form-group">
                        <div class="form-label">
                            <label for="pregunta" class="label">Title</label>
                        </div>
                        <div class="form-input">
                            <input type="text" class="input" name="title" value="{{isset($faq->title) ? $faq->title : ''}}" placeholder="Add a title" >  
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="form-label">
                            <label for="respuesta">Description</label>
                        </div>
                        <div class="form-input">
                            <textarea class="ckeditor input" name="description" value="{{isset($faq->description) ? $faq->description : ''}}">{{isset($faq->description) ? $faq->description : ''}}</textarea>  
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="form-label">
                            <label for="select">Select Category</label>
                        </div>
                        <div class="form-input">
                            <select class="form-select" name="category_id" value="" id="categories">

                                @foreach($faqs_categories as $faq_category)
                                    <option value="{{$faq_category->id}}" {{$faq->category_id == $faq_category->id ? 'selected':''}} class="category_id">{{ $faq_category->name }}</option>                
                                @endforeach

                            </select>
                        </div>
                    </div>

                    {{-- <div class="form-submit">
                        <input type="submit" value="Enviar" id="send-button">
                    </div> --}}
                </div>
                <div class="description">
                    <h3></h3>
                </div>
            </div>
           
        </form>   
    </div>
@endif

@endsection
