@if(isset($tab))

    <div class="locale-container-menu">
        <ul>
            <li class="locale-item locale-active" data-tab="{{$tab}}" data-localetab="es">
                Castellano
            </li>  
            <li class="locale-item" data-tab="{{$tab}}" data-localetab="en">
                Inglés
            </li>     
        </ul>
    </div>

    {{$slot}}

@endif


