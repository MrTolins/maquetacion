@extends('front.layout.front')

@section('form')
<div class="form-title">
    <h1>Login</h1>
</div>

<form class="admin-form" id="form-faqs" method="POST" action="{{route('front_login_submit')}}" autocomplete="off">

    {{ csrf_field() }}

    <div class="form-container">
        <div class="admin-form" data-content="" id="form-faqs" autocomplete="off">
            <div class="form-group">
                <div class="form-label">
                    <label for="email" class="label">Email</label>
                </div>
                <div class="form-input">
                    <input type="email" class="input" value="{{ old('email') }}" name="email">  
                </div>
            </div>
            <div class="form-group">
                <div class="form-label">
                    <label for="password" class="label">Password</label>
                </div>
                <div class="form-input">
                    <input type="password" class="input" name="password">
                </div>
            </div>
            <div class="form-group login-submit">
                <button type="submit">
                    @lang('front/checkout.checkout-continue')
                </button>
            </div>
        </div>
    </div>
</form>


@endsection