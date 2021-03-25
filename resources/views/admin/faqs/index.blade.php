@extends('admin.layout.table_form')

@section('table')
<table class="tabla">
    <tr>
        <th>ID</th>
        <th>Pregunta</th>
        <th>Respuesta</th>
        <th></th>
        <th></th>
    </tr>
    @foreach($faqs as $faq)
    <tr>
        <td>{{$faq->id}}</td>
        <td>{{$faq->title}}</td>
        <td>{{$faq->description}}</td>
        <td> 
            <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                <path fill="currentColor" d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z" />
            </svg>
        </td>
        <td> 
            <svg style="width:24px;height:24px" viewBox="0 0 24 24">
                <path fill="currentColor" d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z" />
            </svg>
        </td>
    </tr>
</table>

@endsection

@section('form')

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
                <input type="text" id="pregunta" class="input" name="pregunta" value="{{isset($faq->title) ? $faq->title : ''}}" placeholder="Añada una pregunta">  
            </div>
        </div>

        <div class="form-group">
            <div class="form-label">
                <label for="respuesta">Respuesta</label>
            </div>
            <div class="form-input">
                <input type="text" id="respuesta" class="input" name="respuesta" value="{{isset($faq->description) ? $faq->description : ''}}" placeholder="Añada una respuesta">  
            </div>
        </div>

        <div class="form-submit">
            <input type="submit" value="Enviar" id="send-button">
        </div>
    </form>   
</div>
@endsection