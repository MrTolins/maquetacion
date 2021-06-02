<div class="mobile">
    {{-- <nav class="flex-nav">
        <div class="container">
          <div class="grid menu">
            <div class="column-xs-8 column-md-6">
                <h3>{{isset($mobile->seo->title) ? $mobile->seo->title : ""}}</h3>
            </div>
            
          </div>
        </div>
      </nav>
      <main>
        <div class="container">
       
          <div class="grid product">
            <div class="column-xs-12 column-md-7">
              <div class="product-gallery">
                <div class="product-image">
                    <img src="{{Storage::url($mobile->image_featured_desktop->path)}}" alt="{{$mobile->image_featured_desktop->alt}}" title="{{$mobile->image_featured_desktop->title}}" />
                </div>
                <ul class="image-list">
                    @foreach ($mobile->image_grid_desktop as $image)
                            <div class="mobile-description-image-grid-item image-item">
                                <img src="{{Storage::url($image->path)}}" alt="{{$image->alt}}" title="{{$image->title}}" />
                            </div>
                    @endforeach
                </ul>
              </div>
            </div>
            <div class="column-xs-12 column-md-5">
              <h1>{{isset($mobile->seo->title) ? $mobile->seo->title : ""}}</h1>
              <h2>Precio (IVA inc.): {!!isset($mobile->product->price) ? $mobile->product->price : "" !!} €</h2>
              <h3>Especificaciones</h3>
              <h4>Pulgadas: {!!isset($mobile->inches) ? $mobile->inches : "" !!} "</h4>
              <h4>Resolución: {!!isset($mobile->height) ? $mobile->height : "" !!} x {!!isset($mobile->width) ? $mobile->width : "" !!}
              <div class="description">
                {!!isset($mobile->locale['description']) ? $mobile->locale['description'] : "" !!}
               
              </div>
              <div class="add-to-cart">Añadir al carrito</div>
            </div>
          </div>
        
        </div>
      </main>
      <footer>
    
      </footer> --}}







    <section class="product">
        <div class="product__photo">
            <div class="photo-container">
                <div class="photo-main">
                    <div class="controls">
                        <i class="material-icons">share</i>
                        <i class="material-icons">favorite_border</i>
                    </div>
                    <img src="{{Storage::url($mobile->image_featured_desktop->path)}}" alt="{{$mobile->image_featured_desktop->alt}}" title="{{$mobile->image_featured_desktop->title}}" />
                </div>
                <div class="photo-album">
                    <ul>
                        @foreach ($mobile->image_grid_desktop as $image)
                            <div class="mobile-description-image-grid-item image-item">
                                <img src="{{Storage::url($image->path)}}" alt="{{$image->alt}}" title="{{$image->title}}" />
                            </div>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
        <div class="product__info">
            <div class="title">
                <h1>{{isset($mobile->seo->title) ? $mobile->seo->title : ""}}</h1>
            </div>
            <div class="price">
                <h2>Precio (IVA inc.): {!!isset($mobile->product->price) ? $mobile->product->price : "" !!} €</h2>
            </div>
            <div class="description">
                <h3>Especificaciones</h3>
                <ul>
                    <li>{!!isset($mobile->locale['description']) ? $mobile->locale['description'] : "" !!}</li>
                    <li>Pulgadas: {!!isset($mobile->inches) ? $mobile->inches : "" !!} "</li>
                    <li>Apples may be good for bone health</li>
                    <li>Resolución: {!!isset($mobile->height) ? $mobile->height : "" !!} x {!!isset($mobile->width) ? $mobile->width : "" !!}</li>
                </ul>
            </div>
            <button class="buy--btn">ADD TO CART</button>
        </div>
    </section>
    
    <footer>
        
    </footer>

    
</div>
