@if($type == "image" )
    <div class="upload">      
        @foreach ($files as $image)
            @if($image->language == $alias)
                <div class="upload-thumb" data-label="{{$image->filename}}" style="background-image: url({{Storage::url($image->path)}})"></div>
            @endif
        @endforeach

        <span class="upload-prompt">@lang('admin/upload.image')</span>
        <input class="upload-input" type="file" name="images[{{$content}}.{{$alias}}]">
    </div>
@endif

@if($type == "images" )
    <div class="images" id="images">      
        @foreach ($files as $image)
            @if($image->language == $alias)
                <div class="images-thumb" data-label="{{$image->filename}}" style="background-image: url({{Storage::url($image->path)}})"></div>
            @endif
        @endforeach

        <span class="images-prompt">@lang('admin/upload.image')</span>
        <input class="images-input images-upload" type="file" name="images[{{$content}}.{{$alias}}]" multiple>
        
    </div>
@endif
