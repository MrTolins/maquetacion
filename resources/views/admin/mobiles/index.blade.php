@php
    $route = 'mobiles';
    $filters = ['search' => true, 'date' => true, 'datesince' => true];
    $order = ['fecha de creación' => 't_mobiles.created_at', 'marca' => 't_mobiles.brand'];
@endphp

@extends('admin.layout.table_form')

@section('table')

    @isset($mobiles)

        <div class="table" id="table-container">

            <div class="table-title">
                <h1>Table</h1>
            </div>

            @foreach($mobiles as $mobile_element)
                <div class="table-row swipe-element">
                    <div class="table-field-container swipe-front" data-swipe="{{$mobile_element->id}}">
                            <div class="table-field"><p><span>Marca:</span> {{$mobile_element->brand}}</p></div>
                            <div class="table-field"><p><span>Modelo:</span> {{$mobile_element->model}}</p></div>
                            <div class="table-field"><p><span>Date:</span> {{$mobile_element->created_at}}</p></div>
                    </div>

                    <div class="table-icons-container swipe-back">
                        <div class="table-icons edit-button right-swipe" data-url="{{route('mobiles_show', ['mobile' => $mobile_element->id])}}" data-swipe="{{$mobile_element->id}}">
                            <svg viewBox="0 0 24 24">
                                <path d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z" />
                            </svg>
                        </div> 
                        
                        <div class="table-icons delete-button left-swipe" data-url="{{route('mobiles_destroy', ['mobile' => $mobile_element->id])}}" data-swipe="{{$mobile_element->id}}">
                            <svg viewBox="0 0 24 24">
                                <path d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z" />
                            </svg>
                        </div>
                    </div>
                </div> 
            @endforeach 

            
            @include('admin.components.table_pagination', ['items' => $mobiles])
          

        </div>
    @endif

@endsection

@section('form')

@isset($mobile)

    <div class="form-title">
        <h1>Form</h1>
    </div>

    <div class="form-container">
        <form class="admin-form" id="form-faqs" action="{{route("mobiles_store")}}" autocomplete="off">

            <input autocomplete="false" name="hidden" type="text" style="display:none;">
            <input type="hidden" name="id" value="{{isset($mobile->id) ? $mobile->id : ''}}">

            {{ csrf_field() }}
            
            <div class="tabs-container">
                <div class="tabs-container-menu">
                    <ul>
                        <li class="tab-item tab-active" data-tab="content">
                            Contenido
                        </li>  
                        <li class="tab-item" data-tab="images">
                            Imágenes
                        </li>  
                        <li class="tab-item" data-tab="seo">
                            Seo
                        </li>  
                        <li class="tab-item" data-tab="price">
                            Price
                        </li> 
                    </ul>
                </div>
                
                <div class="tabs-container-buttons">
                   
                    <div class="sub-menu-buttons">
                        <div id="clear-button" data-url="{{route('mobiles_create')}}">
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
            
            <div class="tab-panel tab-active" data-tab="content">
                <div class="two-columns">

                    <div class="form-group">
                        <div class="form-label">
                            <label for="brand" class="label-highlight">Marca</label>
                        </div>

                        <div class="form-input">
                            <input type="text" name="brand" value="{{isset($mobile->brand) ? $mobile->brand : ''}}"  class="input-highlight"  />
                        </div>

                        <div class="form-label">
                            <label for="model" class="label-highlight">Modelo</label>
                        </div>

                        <div class="form-input">
                            <input type="text" name="model" value="{{isset($mobile->model) ? $mobile->model : ''}}"  class="input-highlight"  />
                        </div>

                        <div class="form-label">
                            <label for="inches" class="label-highlight">Pulgadas</label>
                        </div>

                        <div class="form-input">
                            <input type="number" name="inches" value="{{isset($mobile->inches) ? $mobile->inches : ''}}"  class="input-highlight"  />
                        </div>

                    </div>

    

                    <div class="form-group">
            
                        <div class="form-label">
                            <label for="height" class="label-highlight">Altura</label>
                        </div>

                        <div class="form-input">
                            <input type="number" name="height" value="{{isset($mobile->height) ? $mobile->height : ''}}"  class="input-highlight"  />
                        </div>

                        <div class="form-label">
                            <label for="width" class="label-highlight">Ancho</label>
                        </div>

                        <div class="form-input">
                            <input type="number" name="width" value="{{isset($mobile->width) ? $mobile->width : ''}}"  class="input-highlight"  />
                        </div>
                    </div>
                </div>

                @component('admin.components.locale', ['tab' => 'content'])

                    @foreach ($localizations as $localization)
            
                        <div class="locale-panel {{ $loop->first ? 'locale-active':'' }}" data-tab="content" data-localetab="{{$localization->alias}}">
                            <div class="one-column">
                    
                                <div class="form-group">
                                    <div class="form-label">
                                        <label for="name" class="label-highlight">Título</label>
                                    </div>
                                    <div class="form-input">
                                        <input type="text" name="seo[title.{{$localization->alias}}]" value="{{isset($seo["title.$localization->alias"]) ? $seo["title.$localization->alias"] : ''}}"  class="input-highlight"/>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="one-column">
                                <div class="form-group">
                                    <div class="form-label">
                                        <label for="description" class="label-highlight">Descripción</label>
                                    </div>
                                    <div class="form-input">
                                        <textarea class="ckeditor input-highlight" name="locale[description.{{$localization->alias}}]">{{isset($locale["description.$localization->alias"]) ? $locale["description.$localization->alias"] : ''}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @endforeach

                @endcomponent
            </div>

            <div class="tab-panel" data-tab="images">
                
                @component('admin.components.locale', ['tab' => 'images'])

                    
                    @foreach ($localizations as $localization)

                        <div class="locale-panel {{ $loop->first ? 'locale-active':'' }}" data-tab="images" data-localetab="{{$localization->alias}}">

                            <div class="one-column">
                                <div class="form-group">
                                    <div class="form-label">
                                        <label for="name" class="label-highlight">Foto destacada</label>
                                    </div>
                                    <div class="form-input">
                                        @include('admin.components.upload_image', [
                                            'entity' => 'mobiles',
                                            'type' => 'single', 
                                            'content' => 'featured', 
                                            'alias' => $localization->alias,
                                            'files' => $mobile->images_featured_preview
                                        ])
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="form-label">
                                        <label for="name" class="label-highlight">Galería</label>
                                    </div>
                                    <div class="form-input">
                                        @include('admin.components.upload_image', [
                                            'entity' => 'mobiles',
                                            'type' => 'collection', 
                                            'content' => 'grid', 
                                            'alias' => $localization->alias,
                                            'files' => $mobile->images_grid_preview
                                        ])
                                    </div>
                                </div>
                            </div>


                        </div>

                    @endforeach

                    

                @endcomponent
                
            </div>

            <div class="tab-panel" data-tab="seo">

                @component('admin.components.locale', ['tab' => 'seo'])

                    @foreach ($localizations as $localization)

                        <div class="locale-panel {{ $loop->first ? 'locale-active':'' }}" data-tab="seo" data-localetab="{{$localization->alias}}">

                            <div class="one-column">
                                <div class="form-group">
                                    <div class="form-label">
                                        <label for="keywords" class="label-highlight">
                                            Keywords 
                                        </label>
                                    </div>
                                    <div class="form-input">
                                        <input type="text" name="seo[keywords.{{$localization->alias}}]" value='{{isset($seo["keywords.$localization->alias"]) ? $seo["keywords.$localization->alias"] : ''}}' class="input-highlight">
                                    </div>
                                </div>
                            </div>

                            <div class="one-column">
                                <div class="form-group">
                                    <div class="form-label">
                                        <label for="description" class="label-highlight">
                                            Descripción. 
                                        </label>
                                    </div>

                                    <div class="form-input">
                                        <textarea maxlength='160' class="input-highlight input-counter" name="seo[description.{{$localization->alias}}]">{{isset($seo["description.$localization->alias"]) ? $seo["description.$localization->alias"] : '' }}</textarea>
                                        <p>Has escrito <span>0</span> caracteres de los 160 recomendados.</p>
                                    </div>
                                </div>
                            </div>
                                                           
                        </div>

                    @endforeach
            
                @endcomponent

            </div>

            <div class="tab-panel" data-tab="price">

                <div class="one-column">
                    <div class="form-group">
                        <div class="form-label">
                            <label for="price_without_iva" class="label-highlight">
                                Precio sin IVA 
                            </label>
                        </div>
                        <div class="form-input">
                            <input type="number" name="product[price_without_iva]" value='{{isset($price["price_without_iva"]) ? $price["price_without_iva"] : ''}}' class="input-highlight">
                        </div>
                    </div>
                </div>

                <div class="one-column">
                    <div class="form-group">
                        <div class="form-label">
                            <label for="price" class="label-highlight">
                                Precio 
                            </label>
                        </div>

                        <div class="form-input">
                            <input type="number" name="product[price]" value='{{isset($price["price"]) ? $price["price"] : ''}}' class="input-highlight">
                        </div>
                    </div>
                </div>

                <div class="one-column">
                    <div class="form-group">
                        <div class="form-label">
                            <label for="iva" class="label-highlight">
                                IVA 
                            </label>
                        </div>

                        <div class="form-input">
                            <input type="number" name="product[iva]" value='{{isset($price["iva"]) ? $price["iva"] : ''}}' class="input-highlight">
                        </div>
                    </div>
                </div>

            </div>
           
        </form>   
    </div>
@endif

@endsection