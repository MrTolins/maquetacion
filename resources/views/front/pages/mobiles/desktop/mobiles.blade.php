<div class="mobiles">

    <div class="mobiles-title">
        <h3>@lang('front/mobiles.title')</h3>
    </div>
    <div class="wrapper-mobiles">
        @foreach ($mobiles as $mobile)

            <div class="box-mobiles" id="box-mobiles">
                <div class="product-mobiles" id="product-mobiles">
                    <div class="image-mobiles">
                        <img src="{{Storage::url($mobile->image_featured_desktop->path)}}" alt="{{$mobile->image_featured_desktop->alt}}" title="{{$mobile->image_featured_desktop->title}}" />
                    </div>
                    <span class="name-mobiles"><h4>{{isset($mobile->seo->title) ? $mobile->seo->title : ""}}</h4></span>
                    
                </div>
                <span class="description-mobiles">  {!!isset($mobile->locale['description']) ? $mobile->locale['description'] : "" !!}</span>
            </div>
              
        @endforeach
    </div>
    
</div>
