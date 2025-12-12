@extends('layouts.app')

@section('page', 'Order Complete')

@section('content')
<section class="cart-header mb-3 mb-sm-5"></section>
<section class="cart-wrapper">
    <div class="container">
        <!-- <div class="complele-box">
            <figure>
                <img src="{{asset('img/404-image.png')}}" height="100">
            </figure>
            <figcaption>
                <h2>Looks like you are lost</h2>
                <p>You can stay here or get back to home.</p>
                <a href="{{route('front.home')}}">Back to Home</a>
            </figcaption>
        </div> -->

        <div class="wrong-page-wrap">
            <div class="row align-items-center">
                <div class="col-lg-6 order-first order-lg-1">
                    <div class="image-wrap">
                        <img src="{{asset('img/404-image.png')}}" >
                    </div>
                </div>
                <div class="col-lg-6 text-change">
                <span class="title-highlighter highlighter-secondary"> <i class="fal fa-exclamation-circle"></i> Oops! Somthing's missing.</span>
                    <h2>Looks like you are lost</h2>
                    <p>It seems like we dont find what you searched. The page you were looking for doesn't exist, isn't available loading incorrectly.</p>
                    <a href="{{route('front.home')}}">Back to Home</a>
                </div>
            </div>
        </div>


    </div>
</section>
@endsection