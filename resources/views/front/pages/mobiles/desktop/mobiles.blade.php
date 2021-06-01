<div class="mobiles">

    <div class="mobiles-title">
        <h3>@lang('front/mobiles.title')</h3>
    </div>
    <div class="wrapper-mobiles">
        @foreach ($mobiles as $mobile)


            
                <div class="box-mobiles">
                    <div class="product-mobiles"><img src="{{Storage::url($mobile->image_featured_desktop->path)}}" alt="{{$mobile->image_featured_desktop->alt}}" title="{{$mobile->image_featured_desktop->title}}" />
                    <span class="name-mobiles"><h3>{{isset($mobile->seo->title) ? $mobile->seo->title : ""}}</h3></span>
                    <span class="description-mobiles">  {!!isset($mobile->locale['description']) ? $mobile->locale['description'] : "" !!}</span>
                    </div>
                </div>
            

            
        @endforeach
    </div>
    
</div>
