@extends('layouts.app')

@section('page', 'FAQ')

@section('content')

<style type="text/css">
 .blog_banner figure {
        margin: 0;
        position: relative;
    }
    .blog_banner_caption {
        width: 100%;
        max-width: 600px;
        position: absolute;
        top: 50%;
        left: 60%;
        transform: translateY(-50%);
        z-index: 9;
        padding: 0 15px;
    }
    .blog_banner figure img {
        width: 100%;
        height: 100%;
        aspect-ratio: 3/1;
        object-fit: cover;
    }
    .cms_context h1 {
        font-size: 30px;
        line-height: 1.5;
    }
    .cms_context figure img {
        max-width: 100%;
    }
    .news_meta {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }
    .news_date {
        display: block;
        background: #f0f0f0;
        color: #898989;
        padding: 0 5px;
        height: 20px;
        line-height: 20px;
        font-weight: 500;
        margin-right: 10px;
    }
    .news_magazine {
        font-weight: 500;
        color: #898989;
    }
    @media(max-width: 575px) {
       
        .blog_banner_caption {
            width: 100%;
            padding: 20px;
            left: 0;
            right: 0;
            top: 0;
            transform: none;
            text-align: center;
            position: relative;
        }
    }
</style>

<section class="blog_banner p-0">
    <div class="container-fluid p-0">
        <figure>
            <div class="blog_banner_caption">
                <h2>Single Blogs</h2>
            </div>
            <!-- <div class="stroke_text">KGA Electronics</div> -->
            {{-- <!-- <img src="{{asset('/img/332077637_141046705527514_4967098247875274444_n.jpg')}}"> --> --}}
            <img src="{{asset($settings[20]->blog_image)}}">
        </figure>
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
                            <li><a href="{{route('front.content.corporate')}}">Corporate</a></li>
                            <li><a href="{{route('front.content.news')}}">News</a></li>
                            <li class="{{ request()->is('blog*') ? 'active' : '' }}"><a href="{{route('front.content.blog')}}">Blogs</a></li>
                            <li><a href="{{route('front.content.global')}}">Global</a></li>
                            <li><a href="{{route('front.content.contact')}}">Contact</a></li>
                            <!-- <li><a href="{{route('front.content.career')}}">Career</a></li> -->
                        </ul>
                    </li>
                </ul>
            </div>

            <div class="col-sm-9">
                <div class="cms_context">
                    <h1>{{$data->title}}</h1>
                    <div class="news_meta">
                        <div class="news_date">{{date('d F Y', strtotime($data->created_at))}}</div><div class="news_magazine">0 Comment</div>
                    </div>

                    <figure>
                        <img src="{{asset($data->image)}}">
                    </figure>

                    <figcaption>
                        {!!$data->content!!}
                    </figcaption>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
