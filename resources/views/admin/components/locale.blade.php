<div class="locale-container-menu">
    <ul>
        <li class="locale-item locale-active" data-tab="castellano">
            Castellano
        </li>  
        <li class="locale-item" data-tab="ingles">
            Inglés
        </li>     
    </ul>
</div>

{{$slot}}
{{-- 

@if(isset($tab))

    
    <div class="locale-container-menu">
        <ul>
            @foreach ($localizations as $localization)
                <li class="locale-item {{ $loop->first ? 'locale-active':'' }}" data-tab="{{$tab}}" data-localetab="{{$localization->alias}}">
                    {{$localization->title}}
                </li>      
            @endforeach
        </ul>
    </div>
  


    {{ $slot }}

@endif --}}