@extends('admin.layout.table_form')

@section('table')

    <table class="table">
        <tr class="table-titles">
            <th>ID</th>
            <th>Title</th>
            <th>Description</th>
            <th>Category ID</th>
            <th></th>
            <th></th>
        </tr>
        
        @foreach($faqs as $faq_element)
            <tr class="table-data">
                <td>{{$faq_element->id}}</td>
                <td>{{$faq_element->title}}</td>
                <td>{{$faq_element->description}}</td>
                <td>{{$faq_element->category_id}}</td>
                <td class="table-edit" data-url="{{route('faqs_show', ['faq' => $faq_element->id])}}"> 
                    <svg viewBox="0 0 24 24">
                        <path fill="currentColor" d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z" />
                    </svg>
                </td>
                <td class="table-delete" data-url="{{route('faqs_destroy', ['faq' => $faq_element->id])}}"> 
                    <svg viewBox="0 0 24 24">
                        <path fill="currentColor" d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z" />
                    </svg>
                </td>
            </tr>
        @endforeach
    </table>

@endsection

@section('form')

    <div class="form-title">
        <h1>FAQs</h1>
    </div>

    <div class="form-container">
        <form class="admin-form" id="form-faqs" action="{{route("faqs_store")}}" autocomplete="off">

            <input autocomplete="false" name="hidden" type="text" style="display:none;">
            <input type="hidden" name="id" value="{{isset($faq->id) ? $faq->id : ''}}">

            {{ csrf_field() }}
            
            <div class="form-group">
                <div class="form-label">
                    <label for="pregunta" class="label">Title</label>
                </div>
                <div class="form-input">
                    <input type="text" class="input" name="title" value="{{isset($faq->title) ? $faq->title : ''}}" placeholder="Add a title">  
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

            <div class="form-submit">
                <input type="submit" value="Enviar" id="send-button">
            </div>
        </form>   
    </div>

@endsection