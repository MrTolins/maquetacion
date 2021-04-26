<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Fjalla+One&display=swap" rel="stylesheet">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Lato&family=Poppins:wght@600&family=Recursive:wght@300;900&display=swap" rel="stylesheet">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Maquetacion</title>

        @include("admin.layout.partials.styles")

      
    </head>

    <body>

        <div class="wrapper" id="app">
            @include('admin.components.messages')
            @include('admin.components.modal_delete')
            @include("admin.layout.partials.sidebar")

            @if(isset($filters))
                @include('admin.components.table_filters', $filters)
            @endif


            <div class="master-title">
                <h3 id="lang-faqs">@lang('admin/faqs.parent_section')</h3>
            </div>
            <div class="main" id="main">
            

                @yield('content')
            </div>
        </div>  
        @include("admin.layout.partials.js")  
    </body>
</html>
    