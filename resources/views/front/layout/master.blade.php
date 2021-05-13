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

        <title>Front</title>

        @include("front.layout.partials.styles")

      
    </head>
    <header>
        <nav>   
            <ul>   
                <li class="sub-menu-parent" tab-index="0">
                    <a href="#">Menu 1</a>              
                </li>
                <li class="sub-menu-parent" tab-index="0">
                    <a href="#">Menu 2</a>
                </li>
                <li class="sub-menu-parent" tab-index="0">
                    <a href="#">Menu 3</a>
            </ul>
        </nav>
    </header>
    <body>
        <div class="main">
            @yield('content')
        </div>
        
        @include("front.layout.partials.js")  
    </body>
</html>