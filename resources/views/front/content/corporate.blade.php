@extends('layouts.app')

@section('page', 'FAQ')

@section('content')

<style type="text/css">
    .cms_context ul.global_list {
        margin: 0 0 20px;
        padding: 0;
        list-style-type: none;
        column-gap: 20px;
        column-count: 4;
    }
    .global_list li {
        color: #333333;
        font-weight: 500;
        padding-left: 30px;
        background: url('{{asset('/img/map_global_pin.png')}}') left center no-repeat;
        background-size: 24px auto;
        line-height: 30px;
    }
    a.global {
        color: #c10909;
    }
    .management_profile h4 {
        margin-bottom: 5px;
    }
    .management_profile content {
        display: none;
    }
    .management_more {
        color: #c10909;
        font-size: 14px;
        font-weight: 500;  
    }
    @media(max-width:  1024px) {
        .cms_context ul.global_list {
            column-count: 3;
        }
    }
    @media(max-width:  575px) {
        .cms_context ul.global_list {
            column-count: 2;
        }
    }
</style>
<section class="cart-header mb-3 mb-sm-5 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4>Corporate</h4>
            </div>
        </div>
    </div>
</section>

<section class="cart-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <ul class="account-list mt-0">
                    <li>
                        <span><strong>Quick Links</strong></span>
                        <ul>
                            <!-- <li><a href="{{route('front.content.about')}}">About</a></li> -->
                            <li class="{{ request()->is('corporate') ? 'active' : '' }}"><a href="{{route('front.content.corporate')}}">Corporate</a></li>
                            <li><a href="{{route('front.content.news')}}">News</a></li>
                            <li><a href="{{route('front.content.blog')}}">Blogs</a></li>
                            <li><a href="{{route('front.content.global')}}">Global</a></li>
                            <li><a href="{{route('front.content.contact')}}">Contact</a></li>
                            <!-- <li><a href="{{route('front.content.career')}}">Career</a></li> -->
                        </ul>
                    </li>
                </ul>
            </div>

            <div class="col-sm-9">
                <div class="cms_context">
                    

                </div>
            </div>

        </div>
    </div>
</section>
@endsection
