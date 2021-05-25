@php
    $route = 'localeTags';
    $filters = ['parent' => $groups]; 
    $order = ['grupo' => 'group' , 'clave' => 'key'];
@endphp

@extends('admin.layout.table_form')

@section('table')

    @isset($localeTags)

        <div class="table" id="table-container">

            <div class="table-title">
                <h1>Table</h1>
            </div>

            @foreach($localeTags as $localeTag_element)
                <div class="table-row swipe-element">
                    <div class="table-field-container swipe-front">
                        <div class="table-field"><p><span>Group:</span> {{$localeTag_element->group}}</p></div>
                        <div class="table-field"><p><span>Key:</span> {{$localeTag_element->key}}</p></div>
                    </div>

                    <div class="table-icons-container swipe-back">
                        <div class="table-icons edit-button right-swipe" data-url="{{route('localeTags_edit', ['group' => str_replace("/", "-", $localeTag_element->group), 'key' => $localeTag_element->key])}}">
                            <svg style="width:35px;height:35px;" viewBox="0 0 24 24">
                                <path d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z" />
                            </svg>
                        </div> 
                    </div>
                </div> 
            @endforeach 

            @if($agent->isDesktop())
                @include('admin.components.table_pagination', ['items' => $localeTags])
            @endif

        </div>
    @endif

@endsection

@section('form')

@isset($localeTag)

    <div class="form-title">
        <h1>Form</h1>
    </div>

    <div class="form-container">
        <form class="admin-form" id="form-tags" action="{{route("localeTags_store")}}" autocomplete="off">

            <input autocomplete="false" name="hidden" type="text" style="display:none;">
            <input type="hidden" name="group" value="{{$localeTag->group}}">
            <input type="hidden" name="key" value="{{$localeTag->key}}">

            {{ csrf_field() }}
            
            <div class="tabs-container">
                <div class="tabs-container-menu">
                    <ul>
                        <li class="tab-item tab-active" data-tab="content">
                            Contenido
                        </li>  
       
                    </ul>
                </div>
                
                <div class="tabs-container-buttons">
                   
                    <div class="sub-menu-buttons">

                        <div class="import-button" data-url="{{route('localeTags_import')}}" id="import-button">
                            <label class="import-label">Importar</label>
                        </div>

                        <div class="form-submit">
                            <input type="submit" value="Enviar" id="send-button">
                        </div>
                    </div>
                    
                    
                </div>
            </div>
            
            <div class="tab-panel tab-active" data-tab="content">

                @component('admin.components.locale', ['tab' => 'content'])

                    @foreach ($localizations as $localization)
            
                        <div class="locale-panel {{ $loop->first ? 'locale-active':'' }}" data-tab="content" data-localetab="{{$localization->alias}}">
                            <div class="one-column">
                                <div class="form-group">
                                    <div class="form-label">
                                        <label for="name" class="label-highlight">Traducción para la clave {{$localeTag->key}} del grupo {{$localeTag->group}}</label>
                                    </div>
                                    <div class="form-input">
                                        <input type="text" name="localeTag[value.{{$localization->alias}}]" value="{{isset($localeTag["value.$localization->alias"]) ? $localeTag["value.$localization->alias"] : ''}}"  class="input-highlight"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endforeach

                @endcomponent
            </div>
           
        </form>   
    </div>
@endif

@endsection