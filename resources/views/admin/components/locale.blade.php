@if(isset($tab))

    <div class="locale-container-menu">
        <ul>

            @foreach ($localizations as $localization)
                <li class="locale-item {{ $loop->first ? 'locale-active':'' }}" data-tab="{{$tab}}" data-localetab="{{$localization->alias}}">
                    {{$localization->name}}
                </li>    
            @endforeach

        </ul>
    </div>

    {{$slot}}

@endif


