<div class="table-filter" id="table-filter">
    <div class="table-filter-container">
        <form class="filter-form" id="filter-form" action="{{route("faqs_filter")}}" autocomplete="off">             

            {{ csrf_field() }}


            @foreach ($filters as $key => $items)
            
                @if($key == 'parent')
                    <div class="one-column">
                        <div class="form-group">
                            <div class="form-label">
                                <label for="category_id" class="label-highlight">Filtrar por</label>
                            </div>
                            <div class="form-input">
                                <select name="category_id" data-placeholder="Seleccione una categoría" class="input-highlight">
                                    <option value="all"}}>Todas</option>
                                    @foreach($items as $item)
                                        <option value="{{$item->id}}"}}>{{ $item->name }}</option>
                                    @endforeach
                                </select>    
                            </div>
                        </div>
                    </div>    
                @endif

                @if($key == 'category')
                    <div class="one-column">
                        <div class="form-group">
                            <div class="form-label">
                                <label for="category_id" class="label-highlight">Filtrar por categoría</label>
                            </div>
                            <div class="form-input">
                                <select name="category_id" data-placeholder="Seleccione una categoría" class="input-highlight" class="filter-select">
                                    <option value="all"}}>Todas</option>
                                    @foreach($items as $item)
                                        <option value="{{$item->id}}"}}>{{ $item->name }}</option>
                                    @endforeach
                                </select>    
                            </div>
                        </div>
                    </div>    
                @endif

                @if($key == 'search')
                    <div class="one-column">
                        <div class="form-group">
                            <div class="form-label">
                                <label for="search" class="label-highlight">Buscar palabra</label>
                            </div>
                            <div class="form-input" id="search">
                                <input type="text" name="search" class="input-highlight" value="">
                            </div>
                        </div>
                    </div>    
                @endif

                @if($key == 'date')
                    <div class="one-column">
                        <div class="form-group">
                            <div class="form-label">
                                <label for="date" class="label-highlight">Desde</label>
                            </div>
                            <div class="form-input" id="search">
                                <input type="date" name="date" class="input-highlight" value="">
                            </div>
                        </div>
                    </div>    
                @endif

                @if($key == 'datesince')
                    <div class="one-column">
                        <div class="form-group">
                            <div class="form-label">
                                <label for="datesince" class="label-highlight">Hasta</label>
                            </div>
                            <div class="form-input" id="search">
                                <input type="date" name="datesince" class="input-highlight" value="">
                            </div>
                        </div>
                    </div>    
                @endif  
                                         
            @endforeach

            <div class="form-group">
                <div class="form-label">
                    <label for="order" class="label-highlight">Ordenar por</label>
                </div>
                <div class="form-input">
                    <select name="order" data-placeholder="Seleccione una categoría" class="input-highlight">
                        @foreach($order as $key => $item)
                            <option value="{{$item}}">{{ucfirst($key)}}</option>
                        @endforeach
                    </select>                   
                </div>
            </div>
                
            <div class="form-group">
                <div class="form-label">
                    <label for="direction" class="label-highlight hidden">Dirección</label>
                </div>
                <div class="form-input">
                    <select name="direction" class="input-highlight">
                        <option value="asc">Ascendente</option>
                        <option value="desc">Descendente</option>
                    </select>                        
                </div>
            </div>
        </form>
    </div>

    <div class="table-filter-buttons">
        <div class="table-filter-button open-filter button-active" id="open-filter">
            <svg viewBox="0 0 24 24">
                <path d="M11 11L16.76 3.62A1 1 0 0 0 16.59 2.22A1 1 0 0 0 16 2H2A1 1 0 0 0 1.38 2.22A1 1 0 0 0 1.21 3.62L7 11V16.87A1 1 0 0 0 7.29 17.7L9.29 19.7A1 1 0 0 0 10.7 19.7A1 1 0 0 0 11 18.87V11M13 16L18 21L23 16Z" />
            </svg>
        </div>
        <div class="table-filter-button apply-filter" id="apply-filter">
            <svg viewBox="0 0 24 24">
                <path d="M12 12V19.88C12.04 20.18 11.94 20.5 11.71 20.71C11.32 21.1 10.69 21.1 10.3 20.71L8.29 18.7C8.06 18.47 7.96 18.16 8 17.87V12H7.97L2.21 4.62C1.87 4.19 1.95 3.56 2.38 3.22C2.57 3.08 2.78 3 3 3H17C17.22 3 17.43 3.08 17.62 3.22C18.05 3.56 18.13 4.19 17.79 4.62L12.03 12H12M15 17H18V14H20V17H23V19H20V22H18V19H15V17Z" />
            </svg>
        </div>
    </div>
</div>
