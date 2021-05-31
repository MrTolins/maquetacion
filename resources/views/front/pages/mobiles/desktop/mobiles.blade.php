<div class="mobiles">

    <div class="mobiles-title">
        <h3>@lang('front/mobiles.title')</h3>
    </div>
    
    @foreach ($mobiles as $mobile)
        <div class="mobile" data-content="{{$loop->iteration}}">
            <div class="mobile-title-container">
                <div class="mobile-title">
                    <h3>{{isset($mobile->seo->title) ? $mobile->seo->title : ""}}</h3>
                </div>

                <div class="mobile-plus-button" data-button="{{$loop->iteration}}"></div>
            </div>
            <div class="mobile-description">
                <div class="mobile-description-text">
                    {!!isset($mobile->locale['description']) ? $mobile->locale['description'] : "" !!}
                </div>

                <div class="mobile-description-image">
                    @isset($mobile->image_featured_desktop->path)
                        <div class="mobile-description-image-featured">
                            <img src="{{Storage::url($mobile->image_featured_desktop->path)}}" alt="{{$mobile->image_featured_desktop->alt}}" title="{{$mobile->image_featured_desktop->title}}" />
                        </div>
                    @endif

                    @isset($mobile->image_grid_desktop)
                        <div class="mobile-description-image-grid">
                            @foreach ($mobile->image_grid_desktop as $image)
                                <div class="mobile-description-image-grid-item">
                                    <img src="{{Storage::url($image->path)}}" alt="{{$image->alt}}" title="{{$image->title}}" />
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>                
            </div>
        </div>
    @endforeach
    
</div>
