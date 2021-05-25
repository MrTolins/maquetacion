@php
    $route = 'seo';
@endphp

@extends('admin.layout.table_form')

@section('table')

    @isset($seos)

        <div id="table-container" class="table-seo">
            @foreach($seos as $seo_element)
                <div class="table-row swipe-element">
                    <div class="table-field-container swipe-front">
                        <div class="table-field"><p><span>Clave:</span> {{$seo_element->key}}</p></div>
                    </div>

                    <div class="table-icons-container swipe-back">
                        <div class="table-icons edit-button right-swipe" data-url="{{route('seo_edit', ['key' => $seo_element->key])}}">
                            <svg viewBox="0 0 24 24" style="height: 35px; width: 35px;">
                                <path d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z" />
                            </svg>
                        </div> 
                    </div>
                </div>
            @endforeach
        </div>

        @include('admin.components.table_pagination', ['items' => $seos])
        
    @endisset

@endsection

@section('form')

    @isset($seo)

        <div class="form-container">

            <form class="admin-form" id="seo-form" action="{{route("seo_store")}}" autocomplete="off">
            
                {{ csrf_field() }}
        
                <input autocomplete="false" name="hidden" type="text" style="display:none;">

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
    
                            <div class="import-button" data-url="{{route('seo_import')}}" id="import-seo">
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

                            <input type="hidden" name="seo[key.{{$localization->alias}}]" value="{{$seo["key.$localization->alias"]}}">
                            <input type="hidden" name="seo[group.{{$localization->alias}}]" value="{{$seo["group.$localization->alias"]}}">
                            <input type="hidden" name="seo[old_url.{{$localization->alias}}]" value="{{isset($seo["url.$localization->alias"]) ? $seo["url.$localization->alias"] : ''}}" class="input-highlight block-parameters"  data-regex="/\{.*?\}/g" > 

                            <div class="locale-panel {{ $loop->first ? 'locale-active':'' }}" data-tab="content" data-localetab="{{$localization->alias}}">

                                <div class="one-column">
                                    <div class="form-group">
                                        <div class="form-label">
                                            <label for="seo[url.{{$localization->alias}}]" class="label-highlight">Url</label>
                                        </div>
                                        <div class="form-input">
                                            <input type="text" name="seo[url.{{$localization->alias}}]" value="{{isset($seo["url.$localization->alias"]) ? $seo["url.$localization->alias"] : ''}}" class="input-highlight block-parameters">
                                        </div>
                                    </div>
                                </div>

                                <div class="one-column">
                                    <div class="form-group">
                                        <div class="form-label">
                                            <label for="seo[title.{{$localization->alias}}]" class="label-highlight">Título</label>
                                        </div>
                                        <div class="form-input">
                                            <input type="text" name="seo[title.{{$localization->alias}}]" value="{{isset($seo["title.$localization->alias"]) ? $seo["title.$localization->alias"] : ''}}" class="input-highlight">
                                        </div>
                                    </div>
                                </div>

                                <div class="one-column">
                                    <div class="form-group">
                                        <div class="form-label">
                                            <label for="seo[description.{{$localization->alias}}]" class="label-highlight">Descripción</label>
                                        </div>
                                        <div class="form-input">
                                            <input type="text" name="seo[description.{{$localization->alias}}]" value="{{isset($seo["description.$localization->alias"]) ? $seo["description.$localization->alias"] : ''}}" class="input-highlight">
                                        </div>
                                    </div>
                                </div>

                                <div class="one-column">
                                    <div class="form-group">
                                        <div class="form-label">
                                            <label for="name" class="label-highlight">Keywords</label>
                                        </div>
                                        <div class="form-input">
                                            <input type="text" name="seo[keywords.{{$localization->alias}}]" value="{{isset($seo["keywords.$localization->alias"]) ? $seo["keywords.$localization->alias"] : ''}}" class="input-highlight">
                                        </div>
                                    </div>
                                </div>

                            </div>

                        @endforeach
                
                    @endcomponent
                    
                </div>

            </form>

        </div>
    
    @else

        <div class="form-container">
            <div class="tabs-container">
                <div class="tabs-container-menu">
                    <ul>
                        <li class="tab-item tab-active" data-tab="content">
                            Contenido
                        </li>      
                    </ul>
                </div>
            </div>

            <div class="tab-panel tab-active" data-tab="content">
                <div class="one-column">
                    <div class="form-group">
                        <div class="form-label">

                            <div id="import-seo" data-url="{{route('seo_import')}}">
                                <label class="import-label">Importar enlaces</label>
                            </div>
                     
                        </div>
                    </div>
                </div>

                <div class="one-column">
                    <div class="form-group">
                        <div class="form-label">

                            <div id="ping-google" data-url="{{route('ping_google')}}">
                                <label class="import-label">Call Google</label>
                            </div>
                
                        </div>
                    </div>
                </div>

                <div class="one-column">
                    <div class="form-group">
                        <div class="form-label">
            
                            <div id="create-sitemap" data-url="{{route('create_sitemap')}}">
                                <label class="import-label">Crear Sitemap</label>
                            </div>

                            <div class="form-input">
                                <textarea id="sitemap" class="simple"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endisset

@endsection