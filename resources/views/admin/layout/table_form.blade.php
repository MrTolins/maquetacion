@extends('admin.layout.master')

@section('content')

    <div class="table">

        <div class="table-title">
            <h1>Table</h1>
        </div>

        <div class="table-container" id="table">

            @yield('table')
        </div>
    </div>

    <div class="form" id="form-container">
        @yield('form')    
    </div>

@endsection