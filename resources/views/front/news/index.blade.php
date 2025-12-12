@extends('layouts.app')

@section('page', 'FAQ')

@section('content')

<style>
   /* .news_list li figure img {
    position: absolute;
    top: 0;
    width: 100%;
    height: 100%;
    object-fit: cover;
} */
    .news_banner figure {
        margin: 0;
        position: relative;
    }
    .news_banner_caption {
        width: 100%;
        max-width: 600px;
        position: absolute;
        top: 50%;
        left: 60%;
        transform: translateY(-50%);
        z-index: 9;
        padding: 0 15px;
    }
    .news_banner figure img {
        width: 100%;
        height: 100%;
        aspect-ratio: 3/1;
        object-fit: cover;
    }
    .news_list {
        display: flex;
        flex-wrap: wrap;
        width: 100%;
    }
    .news_list li {
        -webkit-box-flex: 0;
        -ms-flex: 0 0 50%;
        flex: 0 0 50%;
        max-width: 50%;
        padding: 0 15px;
        margin-bottom: 30px;
    }
    .news_list li:nth-child(2n -1) {
        border-right: 1px solid #eee;
    }
    .news_list li h4 {
        margin-bottom: 10px;
    }
    .news_list li h4 a:hover {
        color: #141b4b;
        box-shadow: inset 0 -1px 0 0 #c10909;
    }
    .news_meta {
        display: flex;
        align-items: center;
        margin-bottom: 10px;
    }
    .news_date {
        display: block;
        background: #c10909;
        color: #fff;
        padding: 0 5px;
        height: 20px;
        line-height: 20px;
        font-weight: 500;
        margin-right: 10px;
    }
    .news_magazine {
        font-weight: 500;
    }
    @media(max-width: 575px) {
        .news_list li {
            -webkit-box-flex: 0;
            -ms-flex: 0 0 100%;
            flex: 0 0 100%;
            max-width: 100%;
        }
        .news_banner_caption {
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

<section class="news_banner p-0">
    <div class="container-fluid p-0">
        <figure>
            <div class="news_banner_caption">
                <h2>All News</h2>
            </div>
            <!-- <div class="stroke_text">KGA Electronics</div> -->
            {{-- <!-- <img src="{{asset('/img/332077637_141046705527514_4967098247875274444_n.jpg')}}"> --> --}}
            <img src="{{asset($settings[21]->blog_image)}}">
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
                            <li class="{{ request()->is('news*') ? 'active' : '' }}"><a href="{{route('front.content.news')}}">News</a></li>
                            <li><a href="{{route('front.content.blog')}}">Blogs</a></li>
                            <li><a href="{{route('front.content.global')}}">Global</a></li>
                            <li><a href="{{route('front.content.contact')}}">Contact</a></li>
                            <!-- <li><a href="{{route('front.content.career')}}">Career</a></li> -->
                        </ul>
                    </li>
                </ul>
            </div>

            <div class="col-sm-9 col-lg-9">
                <div class="row">
                    <ul class="news_list">
                        @php
                            $news = \DB::table('news')->latest('id')->get();
                        @endphp

                        @foreach ($news as $singleNews)
                        <li>
                            @if($singleNews->image)
                            <a href="{{route('front.content.news.detail', $singleNews->slug)}}">
                                <figure>
                                    <img src="{{asset($singleNews->image)}}" width="509px" height="285px">
                                </figure>
                            </a>
                            @endif
                            <figcaption>
                                <div class="news_meta">
                                    <div class="news_date">{{date('d F Y', strtotime($singleNews->created_at))}}</div>
                                    {{-- <div class="news_magazine">{{$singleNews->link_text}}</div> --}}
                                </div>
                                <h4><a href="{{ route('front.content.news.detail', $singleNews->slug) }}">{{$singleNews->title}}</a></h4>
                                {{-- <h4><a href="{{ route('front.content.news.detail', $singleNews->slug) }}">{{$singleNews->title}}</a></h4> --}}
                                {{-- <div class="news_comments">0 Comments</div> --}}
                            </figcaption>
                        </li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
    </div>
</section>
@endsection
