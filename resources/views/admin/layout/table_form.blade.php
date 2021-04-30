@extends('admin.layout.master')

@section('content')

    <div class="form" id="form">
        @yield('form')    
    </div>

    <div class="table-container active" id="table">

        @yield('table')
    </div>
    
@endsection