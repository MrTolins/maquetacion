@php
    $route = 'menus';
@endphp

@extends('admin.layout.table_form')

@section('table')

    @isset($menus)

        <div class="table" id="table-container">
            @foreach($menus as $menu_element)
                <div class="table-row swipe-element">
                    <div class="table-field-container swipe-front">
                        <div class="table-field"><p><span>Nombre:</span> {{$menu_element->name}}</p></div>
                    </div>

                    <div class="table-icons-container swipe-back">
                        <div class="table-icons edit-button right-swipe" data-url="{{route('menus_edit', ['menu' => $menu_element->id])}}">
                            <svg viewBox="0 0 24 24">
                                <path d="M20.71,7.04C21.1,6.65 21.1,6 20.71,5.63L18.37,3.29C18,2.9 17.35,2.9 16.96,3.29L15.12,5.12L18.87,8.87M3,17.25V21H6.75L17.81,9.93L14.06,6.18L3,17.25Z" />
                            </svg>
                        </div> 
                        
                        <div class="table-icons delete-button left-swipe" data-url="{{route('menus_destroy', ['menu' => $menu_element->id])}}">
                            <svg viewBox="0 0 24 24">
                                <path d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z" />
                            </svg>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        @include('admin.components.table_pagination', ['items' => $menus])

    @endisset

@endsection

@section('form')

    @isset($menu)

        <div class="form-container">
            <form class="admin-form" id="menus-form" action="{{route("menus_store")}}" autocomplete="off">
                
                {{ csrf_field() }}

                <input autocomplete="false" name="hidden" type="text" style="display:none;">
                <input type="hidden" name="id" value="{{isset($menu->id) ? $menu->id : ''}}">

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
                            <div id="clear-button" data-url="{{route('menus_create')}}">
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
                    <div class="one-column">
                        <div class="form-group">
                            <div class="form-label">
                                <label for="name" class="label-highlight">Nombre</label>
                            </div>
                            <div class="form-input">
                                <input type="text" name="name" value="{{isset($menu->name) ? $menu->name : ''}}"  class="input-highlight"  />
                            </div>
                        </div>
                    </div>
                </div>

            </form>

            @isset($menu->name)
                <div id="menu-item-form-container">
                    @include('admin.menu_items.index', ['menu' => $menu])
                </div>
            @endisset

        </div>

    @endisset

@endsection