@extends('admin.layout.table_form')

@section('table')

    <table class="table">

        @foreach($faqs_categories as $faq_category_element)
        <div class="table-row swipe-element" id="categories-table" >
            <div class="table-field-container swipe-front" data-swipe="{{$faq_category_element->id}}">
                    <div class="table-field"><p><span>ID:</span> {{$faq_category_element->id}}</p></div>
                    <div class="table-field"><p><span>Name:</span>{{$faq_category_element->name}}</p></div>
            </div>

            <div class="table-icons-container swipe-back">
                <div class="table-icons edit-button right-swipe" data-url="{{route('faqs_categories_edit', ['faq_category' => $faq_category_element->id])}}" >
                    <svg viewBox="0 0 24 24">
                        <path d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z" />
                    </svg>
                </div> 
                
                <div class="table-icons delete-button left-swipe" data-url="{{route('faqs_categories_destroy', ['faq_category' => $faq_category_element->id])}}">
                    <svg viewBox="0 0 24 24">
                        <path d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z" />
                    </svg>
                </div>
            </div>
        </div>


        {{-- <tr class="table-titles">
            <th>ID</th>
            <th>Name</th>
            <th></th>
            <th></th>
        </tr>
        
        @foreach($faqs_categories as $faq_category_element)
            <tr class="table-data">
                <td>{{$faq_category_element->id}}</td>
                <td>{{$faq_category_element->name}}</td>
                
               <td class="table-edit" data-url="{{route('faqs_categories_edit', ['faq_category' => $faq_category_element->id])}}"> 
                    <svg style="width:24px;height:24px;cursor: pointer;" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z" />
                    </svg>
                </td>
                <td class="table-delete" data-url="{{route('faqs_categories_destroy', ['faq_category' => $faq_category_element->id])}}"> 
                    <svg style="width:24px;height:24px;cursor: pointer;" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z" />
                    </svg>
                </td>
            </tr>
        @endforeach --}}
        @endforeach
    </table>

@endsection

@section('form')

    <div class="form-title">
        <h1>FAQs Categories</h1>
    </div>

    
    <div class="form-container">
        <form class="admin-form" id="form-faqs" action="{{route("faqs_categories_store")}}" autocomplete="off">

            {{ csrf_field() }}

            <input autocomplete="false" name="hidden" type="text" style="display:none;">
            <input type="hidden" name="id" value="{{isset($faq_category->id) ? $faq_category->id : ''}}">
          
            <div class="form-group">
                <div class="form-label">
                    <label for="name" class="label">Name</label>
                </div>
                <div class="form-input">
                    <input type="text" class="input" name="name" value="{{isset($faq_category->name) ? $faq_category->name : ''}}" placeholder="Add a name">  
                </div>
            </div>


            <div class="form-submit">
                <input type="submit" value="Send" id="send-button">
            </div>
        </form>   
    </div>

@endsection





    


