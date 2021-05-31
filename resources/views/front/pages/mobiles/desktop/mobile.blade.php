<div class="mobile">

    <div class="mobile-title">
        <h3>{{isset($mobile->seo->title) ? $mobile->seo->title : ""}}</h3>
    </div>
    
    <div class="mobile">
        <div class="mobile-description">
            <div class="mobile-description-text">
                {!!isset($mobile->locale['description']) ? $mobile->locale['description'] : "" !!}
            </div>

            @isset($mobile->image_featured_desktop->path)
                <div class="mobile-description-image">
                    <img src="{{Storage::url($mobile->image_featured_desktop->path)}}" alt="{{$mobile->image_featured_desktop->alt}}" title="{{$mobile->image_featured_desktop->title}}" />
                </div>
            @endif
        </div>
    </div>
    
</div>
