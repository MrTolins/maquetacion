@php
    $route = 'faqs';
    $filters = ['category' => $faqs_categories, 'search' => true, 'date' => true, 'datesince' => true];
    $order = ['fecha de creación' => 't_faqs.created_at', 'título' => 't_faqs.title'];
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

            
            @include('admin.components.table_pagination', ['items' => $faqs])
          

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
            
            <div class="tabs-container">
                <div class="tabs-container-menu">
                    <ul>
                        <li class="tab-item tab-active" data-tab="contenido">
                            Contenido
                        </li>  
                        <li class="tab-item" data-tab="imagenes">
                            Imágenes
                        </li>     
                    </ul>
                </div>
                
                <div class="tabs-container-buttons">
                    
                    <div class="sub-menu-buttons">
                        <div id="clear-button" data-url="{{route('faqs_create')}}">
                            <svg style="width:35px;height:35px;" viewBox="0 0 24 24">
                                <path fill="currentColor" d="M12,6V9L16,5L12,1V4A8,8 0 0,0 4,12C4,13.57 4.46,15.03 5.24,16.26L6.7,14.8C6.25,13.97 6,13 6,12A6,6 0 0,1 12,6M18.76,7.74L17.3,9.2C17.74,10.04 18,11 18,12A6,6 0 0,1 12,18V15L8,19L12,23V20A8,8 0 0,0 20,12C20,10.43 19.54,8.97 18.76,7.74Z" />
                            </svg>
                        </div>

                        <div class="form-submit">
                            <input type="submit" value="Enviar" id="send-button">
                        </div>
                    </div>
                    
                </div>
            </div>
            
            <div class="tab-panel tab-active" data-tab="contenido">
                <div class="two-columns">
                    <div class="form-group">
                        <div class="form-label">
                            <label for="category_id" class="label-highlight">
                                Categoría 
                            </label>
                        </div>
                        <div class="form-input">
                            <select name="category_id" data-placeholder="Seleccione una categoría" class="input-highlight" id="category-select">
                                <option></option>
                                @foreach($faqs_categories as $faq_category)
                                    <option value="{{$faq_category->id}}" {{$faq->category_id == $faq_category->id ? 'selected':''}} class="category_id">{{ $faq_category->name }}</option>
                                @endforeach
                            </select>                   
                        </div>
                    </div>
                </div>

                @component('admin.components.locale')
        
                    <div class="locale-panel locale-active" data-tab="castellano">
                        <div class="one-column">
                
                            <div class="form-group">
                                <div class="form-label">
                                    <label for="name" class="label-highlight">Título</label>
                                </div>
                                <div class="form-input">
                                    <input type="text" name="name" value="{{isset($faq->title) ? $faq->title : ''}}"  class="input-highlight"  />
                                </div>
                            </div>
                        </div>
                        
                        <div class="one-column">
                            <div class="form-group">
                                <div class="form-label">
                                    <label for="description" class="label-highlight">Descripción</label>
                                </div>
                                <div class="form-input">
                                    <textarea class="ckeditor" name="description" class="input-highlight">{{isset($faq->description) ? $faq->description : ''}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="locale-panel" data-tab="ingles">

                        <div class="one-column">                
                            <div class="form-group">
                                <div class="form-label">
                                    <label for="name" class="label-highlight">Title</label>
                                </div>
                                <div class="form-input">
                                    <input type="text" name="name" value="{{isset($faq->title) ? $faq->title : ''}}"  class="input-highlight"  />
                                </div>
                            </div>
                        </div>
                        
                        <div class="one-column">
                            <div class="form-group">
                                <div class="form-label">
                                    <label for="description" class="label-highlight">Description</label>
                                </div>
                                <div class="form-input">
                                    <textarea class="ckeditor" name="description" class="input-highlight">{{isset($faq->description) ? $faq->description : ''}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                @endcomponent
            </div>

            <div class="tab-panel" data-tab="imagenes">
                
                @component('admin.components.locale')
        
                    <div class="locale-panel locale-active" data-tab="castellano">
                        
                        <div class="one-column">
                            <div class="drop-zone">
                                <span class="drop-zone__prompt">Arrastra el archivo aquí o haz click para subirlo</span>
                                <input type="file" name="myFile" class="drop-zone__input">
                            </div>            
                        </div>
                    </div>

                    <div class="locale-panel" data-tab="ingles">
                        
                        <div class="one-column">
                            <div class="drop-zone">
                                <span class="drop-zone__prompt">Drop file here or click to upload</span>
                                <input type="file" name="myFile" class="drop-zone__input">
                            </div>            
                        </div>
                    </div>

                @endcomponent
                
            </div>
           
        </form>   
    </div>
@endif

@endsection
