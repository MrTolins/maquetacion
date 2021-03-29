@extends('admin.layout.table_form')

@section('table')

    <table class="tabla">
        <tr class="table-titles">
            <th>ID</th>
            <th>Pregunta</th>
            <th>Respuesta</th>
            <th></th>
            <th></th>
        </tr>
        
        @foreach($faqs as $faq_element)
            <tr class="table-data">
                <td>{{$faq_element->id}}</td>
                <td>{{$faq_element->title}}</td>
                <td>{{$faq_element->description}}</td>
                <td class="table-edit" data-url="{{route('faqs_show', ['faq' => $faq_element->id])}}"> 
                    <svg style="width:24px;height:24px;cursor: pointer;" viewBox="0 0 24 24">
                        <path fill="currentColor" d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z" />
                    </svg>
                </td>
                <td class="table-delete" data-url="{{route('faqs_destroy', ['faq' => $faq_element->id])}}"> 
                    <svg style="width:24px;height:24px;cursor: pointer;" viewBox="0 0 24 24">
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
                    <label for="pregunta" class="label">Pregunta</label>
                </div>
                <div class="form-input">
                    <input type="text" class="input" name="title" value="{{isset($faq->title) ? $faq->title : ''}}" placeholder="Añada una pregunta">  
                </div>
            </div>

            <div class="form-group">
                <div class="form-label">
                    <label for="respuesta">Respuesta</label>
                </div>
                <div class="form-input">
                    <input type="text" class="input" name="description" value="{{isset($faq->description) ? $faq->description : ''}}" placeholder="Añada una respuesta">  
                </div>
            </div>

            <div class="form-submit">
                <input type="submit" value="Enviar" id="send-button">
            </div>
        </form>   
    </div>

@endsection