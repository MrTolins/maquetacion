@extends('front.layout.master')

@section('title')@lang('front/seo.web-name') | {{$mobile->seo->title}} @stop
@section('description'){{$mobile->seo->description != null? $mobile->seo->description : $mobile->seo->locale_seo->description}} @stop
@section('keywords'){{$mobile->seo->keywords != null ? $mobile->seo->keywords : $mobile->seo->locale_seo->keywords}} @stop
@section('facebook-url'){{URL::asset('/mobiles/' . $mobile->seo->slug)}} @stop
@section('facebook-title'){{$mobile->seo->title}} @stop
@section('facebook-description'){{$mobile->seo->description != null ? $mobile->seo->description : $mobile->seo->locale_seo->description}} @stop

@section("content")
    @if($agent->isDesktop())
        <div class="page-section">
            @include("front.pages.mobiles.desktop.mobile")
        </div>
    @endif

    @if($agent->isMobile())
        <div class="page-section">
            @include("front.pages.mobiles.mobile.mobile")
        </div>
    @endif
@endsection
        
        