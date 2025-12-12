<!DOCTYPE html>
<html>

<head>
	<!-- Google Tag Manager -->
	<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
	new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
	j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
	'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
	})(window,document,'script','dataLayer','GTM-K9F32CJ');</script>
	<!-- End Google Tag Manager --> 

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>KGA | @yield('page')</title>

    <link rel="icon" href="{{asset('img/KGA Favicon.ico')}}" type="image/png" sizes="16x16">
    {{-- <link rel="stylesheet" href="{{ asset('css/plugin.css') }}"> --}}
	<link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/select2.min.css') }}">
    <link rel='stylesheet' href="{{ asset('css/lightbox.min.css') }}">
    <link rel='stylesheet' href="{{ asset('css/jquery.fancybox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/fontawesome.min.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('scss/css/preload.css') }}"> --}}
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <!--<link rel="stylesheet" href="https://unpkg.com/aos@2.3.1/dist/aos.css" />-->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.1/aos.css" />
    <link rel="stylesheet" href="{{ asset('css/themify-icons.css') }}">
    <!--<link rel="stylesheet" href="{{ asset('css/flaticon.css') }}">-->
    <!--<link rel="stylesheet" href="{{ asset('css/flat-ui.min.css') }}">-->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
	<link rel="stylesheet" href="{{ asset('css/responsive.css') }}">
	<!--<link rel="canonical" href="https://onninternational.com/">-->
	<link rel="canonical" href="https://kgaerp.in/kga/">
	

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/swiper-bundle.min.js') }}"></script>
</head>

<body>
	<!-- Google Tag Manager (noscript) -->
	<noscript>
        <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-K9F32CJ"
	height="0" width="0" style="display:none;visibility:hidden"></iframe>
	</noscript>
	<!-- End Google Tag Manager (noscript) -->

    <div class="search_wrap">
    	<div class="header-search-wrap">
	        <a href="javascript:void(0)" class="search_close">
	            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
	        </a>
	        <div class="search_form" >
	            <input type="search" name="query" onkeyup="getProducts();"  class="search_box" id="search_box" placeholder="Search Product Here..">
	            <button type="" class="search_btn" onclick="getProducts();">
	                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
	            </button>
            </div>

            <div id="searchContext" style="display:none;">
                <div class="search-result-top">
                    <div class="result-count">
                        <span id="countVal"></span>
                    </div>
                    <a href="#" id="searchAllView">View All</a>
                </div>

                <div class="search-result-bottom">
                </div>
            </div>
	    </div>
    </div>
    
    <header class="header">
        <nav>
            <div class="container container-flex">
                <div class="logo">
                    <a href="{{ route('front.home') }}">
                        <!--<img src="{{ asset('img/KGA Logo.png') }}">-->
                        <img src="{{ asset('img/KGA_Logo.png') }}">
                    </a>
                </div>
                <div class="nav-right">
                    <ul class="header_menu list-unstyled p-0 m-0">
                        <li><a href="{{route('front.content.about')}}">About Us</a></li>
                        <li class="shop-item">
                            <a href="javascript:void(0)"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag">
                                    <path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path>
                                    <line x1="3" y1="6" x2="21" y2="6"></line>
                                    <path d="M16 10a4 4 0 0 1-8 0"></path>
                                </svg> Products</a>
                            <div class="lg-menu">
                                <div class="row">
                                    <div class="col-12 col-br">
                                        <ul class="sub_menu list-unstyled p-0 m-0">
                                            @foreach($categories as $category)
                                            <li>
                                                <a href="{{ route('front.category.detail', $category['slug']) }}">{{ $category->name }}
                                                    <iconify-icon icon="prime:angle-double-right"></iconify-icon></a>
                                                <div class="sub-menu mega-menu">
                                                    <div class="container">
                                                        <div class="menu_slider swiper-container">
                                                            <div class="slider swiper-wrapper">

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <!-- <li><a href="#">Daily Deals</a></li> -->
                        {{--<li><a href="#">Track Your Order</a></li>--}}
                        <li>
                            <div class="" id="search_toggle">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-search">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                            </div>
                        </li>
                        <li><a href="{{route('front.user.wishlist')}}"><svg xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-heart">
                                    <path
                                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                                    </path>
                                </svg><span
                                    class="{{ ($wishlistCount > 0) ? 'd-flex ' : 'd-none' }}">{{$wishlistCount}}</span></a>
                        </li>
                        <li><a href="{{route('front.user.login')}}"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg></a></li>
                        <li><a href="{{route('front.cart.index')}}"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-shopping-cart">
                                    <circle cx="9" cy="21" r="1"></circle>
                                    <circle cx="20" cy="21" r="1"></circle>
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                </svg> <span
                                    class="{{ ($cartCount > 0) ? 'd-flex ' : 'd-none' }}">{{$cartCount}}</span></a></li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <header class="d-block d-md-none">
        <div class="container">
            <div class="row align-items-center justify-content-between">
                <!-- <div class="nav-toggle">
                    <span></span>
                </div> -->
                <div class="col-auto d-block d-sm-none">
                    <nav class="account-nav">
                        <ul>
                            <li class="mobile_menu_toggle">
                                <a href="#"><i class="flaticon-menu-2"></i></a>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="col-auto mr-auto">
                    <a href="{{ route('front.home') }}" class="logo">
                        <!--<img src="{{ asset('img/KGA Logo.png') }}">-->
                        <img src="{{ asset('img/KGA_Logo.png') }}">
                    </a>
                </div>
                <div class="col-auto d-none d-lg-block ml-auto menu_area">
                    <nav class="main-nav">
                        <ul>
                            {{--<li>
                                <a href="{{ route('front.home') }}" class="home">Home</a>
                            </li>--}}
                            @foreach($categories as $category)
                            <li>
                                <a href="{{ route('front.category.detail', $category['slug']) }}">{{ $category->name }}
                                    <i class="far fa-angle-down"></i></a>
                                <div class="sub-menu mega-menu">
                                    <div class="container">
                                        <div class="menu_slider swiper-container">
                                            <div class="slider swiper-wrapper">
                                                @foreach($category->ProductDetails as $categoryProductKey =>
                                                $categoryProductValue)
                                                @php
                                                $imgVal = str_replace('public/','',$categoryProductValue->image);
                                                @endphp
                                                @if($categoryProductValue->status == 0) @continue @endif
                                                <div class="menu_slider-single swiper-slide">
                                                    <a
                                                        href="{{ route('front.product.detail', $categoryProductValue->slug) }}">
                                                        <figure>
                                                            <img src="{{asset($imgVal)}}" height="100">
                                                        </figure>
                                                        <figcaption>
                                                            <h4>{{$categoryProductValue->name}}</h4>
                                                        </figcaption>
                                                    </a>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                            {{--
                            <li>
                                <a href="javascript: void(0)">Shop <i class="far fa-angle-down"></i></a>
                                <div class="sub-menu mega-menu">
                                    <ul>
                                        @foreach ($categoryNavList as $categoryNavKey => $categoryNavValue)
                                        <li>
                                            <h5>{{$categoryNavValue['parent']}}</h5>
                            <ul class="mega-drop-menu">
                                @foreach ($categoryNavValue['child'] as $childCatKey => $childCatValue)
                                <li><a href="{{ route('front.category.detail', $childCatValue['slug']) }}"><img
                                            src="{{asset($childCatValue['sketch_icon'])}}">
                                        {{$childCatValue['name']}}</a></li>
                                @endforeach
                            </ul>
                            </li>
                            @endforeach
                        </ul>
                </div>
                </li>
                <li>
                    <a href="javascript: void(0)">Collection <i class="far fa-angle-down"></i></a>
                    <div class="sub-menu mega-menu">
                        <ul>
                            @foreach($collections as $collectionKey => $collectionValue)
                            <li>
                                <a href="{{ route('front.collection.detail', $collectionValue->slug) }}">
                                    <img src="{{ asset($collectionValue->sketch_icon) }}" />
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </li>
                --}}
                <!-- <li>
                                <a href="{{route('front.sale.index')}}">Sale</a>
                            </li> -->
                </ul>
                </nav>
            </div>
            <div class="col-auto">
                <nav class="account-nav">
                    <ul>
                        <li>
                            <!-- <a href="javascript: void(0)" id="search_toggle">
                                    <i class="flaticon-magnifying-glass"></i>
                                </a> -->
                            <div class="search_box" id="search_toggle">
                                <!--<i class="flaticon-magnifying-glass"></i>-->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-search">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                                <!--<input type="text" name="" placeholder="What are you looking for?">-->
                            </div>
                        </li>
                        <li>
                            <a href="{{route('front.user.wishlist')}}" style="position: relative">
                                <!--<i class="flaticon-heart"></i>-->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-heart">
                                    <path
                                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z">
                                    </path>
                                </svg>
                                <div id="wishlist-count" class="{{ ($wishlistCount > 0) ? 'd-block' : 'd-none' }}"
                                    style="position: absolute;
                                    top: -9px;
                                    right: -9px;
                                    z-index: 9;
                                    width: 20px;
                                    height: 20px;
                                    border-radius: 50%;
                                    background: #c1080a;
                                    color: #fff;
                                    font-size: 10px;
                                    text-align: center;
                                    font-weight: 700;
                                    padding: 4px 0px;">{{$wishlistCount}}</div>
                            </a>
                        </li>
                        <li>
                            <a href="{{route('front.user.login')}}">
                                <!--<i class="flaticon-person"></i>-->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-user">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
                                    <circle cx="12" cy="7" r="4"></circle>
                                </svg>
                            </a>
                        </li>

                        <li>
                            <a href="{{route('front.cart.index')}}" style="position: relative">
                                <!--<i class="flaticon-shopping-cart"></i>-->
                                <!--<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>-->
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" class="feather feather-shopping-cart">
                                    <circle cx="9" cy="21" r="1"></circle>
                                    <circle cx="20" cy="21" r="1"></circle>
                                    <path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path>
                                </svg>
                                <div id="cart-count" class="{{ ($cartCount > 0) ? 'd-block' : 'd-none' }}" style="position: absolute;
                                    top: -9px;
                                    right: -9px;
                                    z-index: 9;
                                    width: 20px;
                                    height: 20px;
                                    border-radius: 50%;
                                    background: #c1080a;
                                    color: #fff;
                                    font-size: 10px;
                                    text-align: center;
                                    font-weight: 700;
                                    padding: 4px 0px;">{{$cartCount}}</div>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>
	{{-- <div class="mobile_menu">
        <div class="mobile_menu_content">
            <ul class="mobile_nav">
                <li><a href="{{route('front.content.about')}}">About Us</a></li>
                <li>
                    <a href="javascript:void(0);" class="parent">Products</a>
                    <ul>
                        @foreach($categories as $category)
                        <li>
                            <a href="javascript:void(0)" menu-target="{{ $category->slug }}">{{ $category->name }} <i class="far fa-angle-down"></i></a>
                        </li>
                        @endforeach
                    </ul>
                </li>
                <li><a href="#">Daily Deals</a></li>
            </ul>
            <div class="menu_content">
                @foreach($categories as $category)
                    <div class="menu_item" id="{{ $category->slug }}">
                    @foreach($category->ProductDetails  as $categoryProductKey => $categoryProductValue)
                        @if($categoryProductValue->status == 0) @continue @endif
                        <div class="menu_slider-single swiper-slide">
                            <a href="{{ route('front.product.detail', $categoryProductValue->slug) }}">
                                <figure>
                                    <img src="{{asset($categoryProductValue->image)}}" height="100">
                                </figure>
                                <figcaption>
                                    <h4>{{$categoryProductValue->name}}</h4>
                                </figcaption>
                            </a>
                        </div>
                    @endforeach
                    </div>
                @endforeach
            </div>
        </div>
    </div> --}}

    <div class="overlay">
        <div class="overlay__close">
            <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" viewBox="0 0 24 24" fill="none"
                stroke="#c10909" stroke-width="0.5" stroke-linecap="round" stroke-linejoin="round"
                class="feather feather-x">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </div>

        <div class="overlay_wrapper">
            <div class="overlay_block">
                <ul class="overlay_menu">
                    @foreach ($categoryNavList as $categoryNavKey => $categoryNavValue)
                    <li>
                        <a href="javascript: void(0)">{{$categoryNavValue['parent']}}</a>
                        <ul class="overlay_submenu">
                            @foreach ($categoryNavValue['child'] as $childCatKey => $childCatValue)
                            <li>
                                <a href="{{ route('front.category.detail', $childCatValue['slug']) }}">
                                    <img src="{{asset($childCatValue['sketch_icon'])}}"> {{$childCatValue['name']}}
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

    </div>
    <main>@yield('content')</main>
    @yield('script')
    <footer class="footer">
        <div class="footer-main">
            <div class="container">
                <div class="row">

                    <div class="col-lg-9 col-12 mb-3 mb-lg-0">
                        <div class="row">
                            <div class="col-lg-3 col-sm-6 col-12 mb-3 mb-lg-0">
                                <div class="footer-block">
                                    <div class="footer-heading">Quick Links</div>
                                    <ul class="footer-block-menu">
                                        @foreach ($categories as $categoryIndex => $categoryValue)
                                        <li>
                                            <a
                                                href="{{route('front.category.detail', $categoryValue->slug)}}">{{$categoryValue->web_name}}</a>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12 mb-3 mb-lg-0">
                                <div class="footer-block mb-2 mb-sm-5">
                                    <div class="footer-heading">Explore More</div>
                                    <ul class="footer-block-menu">
                                        <li><a href="{{route('front.content.about')}}">About</a></li>
                                        <li><a href="{{route('front.content.blog')}}">Blog</a></li>
                                        <li><a href="{{route('front.content.contact')}}">Contact</a></li>
                                        <li><a href="{{route('front.content.news')}}">News</a></li>
                                        <li><a href="{{route('front.content.global')}}">Global</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12 mb-3 mb-lg-0">
                                <div class="footer-block mb-2 mb-sm-5">
                                    <div class="footer-heading">Customer Services</div>
                                    <ul class="footer-block-menu">
                                        <li><a href="{{route('front.faq.index')}}">FAQ</a></li>
                                        <li><a href="{{route('front.user.order')}}">My Shopping</a></li>
                                        <li><a href="{{route('front.content.return')}}">Returns Policy</a></li>
                                        <li><a href="{{route('front.content.refund')}}">Refund & Cancellation Policy</a>
                                        </li>
                                        <li><a href="{{route('front.content.service')}}">Service & Contact</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6 col-12 mb-3 mb-lg-0">
                                <div class="footer-block mb-2 mb-sm-5">
                                    <div class="footer-heading">Explore More</div>
                                    <ul class="footer-block-menu">
                                        <li><a href="{{route('front.content.terms')}}">Terms & Conditions</a></li>
                                        <li><a href="{{route('front.content.privacy')}}">Privacy Statement</a></li>
                                        <li><a href="{{route('front.content.security')}}">Security</a></li>
                                        <li><a href="{{route('front.content.disclaimer')}}">Disclaimer</a></li>
                                    </ul>
                                </div>

                                <div class="footer-block mt-2 mt-sm-5">
                                    <div class="footer-heading">Customer Support</div>
                                    <ul class="footer-block-menu">
                                        <li>
                                            <a href="mailto:kgaservicecentre@gmail.com"><svg
                                                    xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                    viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1.5"
                                                    stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-mail">
                                                    <path
                                                        d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z">
                                                    </path>
                                                    <polyline points="22,6 12,13 2,6"></polyline>
                                                </svg> kgaservicecentre@gmail.com</a>
                                        </li>
                                        <li>
                                            <a href="tel:+6291117317"><svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                    height="20" viewBox="0 0 24 24" fill="none" stroke="#ffffff"
                                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"
                                                    class="feather feather-phone">
                                                    <path
                                                        d="M22 16.92V21a2 2 0 0 1-2.18 2A19.8 19.8 0 0 1 3 5.18 2 2 0 0 1 5 3h4.09a2 2 0 0 1 2 1.72 13.49 13.49 0 0 0 .58 2.7 2 2 0 0 1-.45 2L9.91 10.91a16 16 0 0 0 6.2 6.2l1.49-1.49a2 2 0 0 1 2-.45 13.49 13.49 0 0 0 2.7.58 2 2 0 0 1 1.72 2z">
                                                    </path>
                                                </svg> +91 6291117317</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-12 mb-3 mb-lg-0">
                        <div class="newsletter-form">
                            <form method="POST" action="{{route('front.subscription')}}" id="joinUsForm">@csrf
                                <p>Join us for more updates</p>
                                <div class="footer-form">
                                    <input type="email" name="subsEmail" value=""
                                        placeholder="Enter your email address">
                                    <button type="submit">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" class="feather feather-send">
                                            <line x1="22" y1="2" x2="11" y2="13"></line>
                                            <polygon points="22 2 15 22 11 13 2 9 22 2"></polygon>
                                        </svg>
                                    </button>
                                </div>
                                <p class="mt-3" id="joinUsMailResp"></p>
                            </form>

                            <div class="footer-block mt-2 mt-sm-5">
                                <div class="footer-heading">Quick Links</div>
                                <ul class="social">
                                    <li><a href="{{strip_tags($settings[9]->content)}}" target="_blank"><i
                                                class="fab fa-facebook-f" aria-hidden="true"></i></a></li>
                                    <li><a href="{{strip_tags($settings[10]->content)}}" target="_blank"><i
                                                class="fab fa-twitter" aria-hidden="true"></i></a></li>
                                    <li><a href="{{strip_tags($settings[12]->content)}}" target="_blank"><i
                                                class="fab fa-instagram" aria-hidden="true"></i></a></li>
                                    <li><a href="{{strip_tags($settings[11]->content)}}" target="_blank"><i
                                                class="fab fa-youtube" aria-hidden="true"></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <p class="copy-right mb-0 text-center">
                            KGA &copy; 2021-{{ date('Y') }}. All Rights Reserved.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>

    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.6.0/umd/popper.min.js"></script>-->
    {{-- <script src="{{ asset('js/plugin.js') }}"></script> --}}
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
	<script src="{{ asset('js/fontawesome.min.js') }}"></script>
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
    <script src="{{ asset('js/gsap.min.js') }}"></script>
    <script src="{{ asset('js/ScrollTrigger.min.js') }}"></script>
    <script src="{{ asset('js/jquery.waypoints.min.js') }}"></script>
    <script src="{{ asset('js/jquery.counterup.min.js') }}"></script>
    <script src="{{ asset('js/lightbox.min.js') }}"></script>
    <script src="{{ asset('js/jquery.fancybox.min.js') }}"></script>
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/1.16.0/TweenMax.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.1/aos.js"></script>
    <script src="{{ asset('js/ScrollMagic.min.js') }}"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/ScrollMagic/2.0.3/plugins/animation.gsap.min.js'></script>
    <script src="{{ asset('js/debug.addIndicators.min.js') }}"></script>
    <!--<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>-->
	<script src="{{ asset('js/sweetalert2.min.js') }}"></script>
	<!--<script src="{{ asset('js/flat-ui.min.js') }}"></script>-->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://code.iconify.design/iconify-icon/1.0.2/iconify-icon.min.js"></script>
    {{-- <script src="https://checkout.razorpay.com/v1/checkout.js"></script> --}}
    {{-- <script type="text/javascript" src="lib.js"></script> --}}
    <script src="https://static.elfsight.com/platform/platform.js" data-use-service-core defer></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- Toastr JS CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
        // enable tooltips everywhere
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })

        // sweetalert fires | type = success, error, warning, info, question
        function toastFire(type = 'success', title, body = '') {
            /* Swal.fire({
                icon: type,
                title: title,
                text: body,
                confirmButtonColor: '#c10909',
                timer: 5000
            }) */

			const Toast = Swal.mixin({
				toast: true,
				position: 'top-end',
				showConfirmButton: false,
				timer: 3000,
				// timerProgressBar: true,
                showCloseButton: true,
				didOpen: (toast) => {
					toast.addEventListener('mouseenter', Swal.stopTimer)
					toast.addEventListener('mouseleave', Swal.resumeTimer)
				}
			});

			Toast.fire({
				icon: type,
				title: title
			});
        }

        // on session toast fires
        @if (Session::has('success'))
            toastFire('success', '{{ Session::get('success') }}');
        @elseif (Session::has('failure'))
            toastFire('warning', '{{ Session::get('failure') }}');
        @endif

        // button text changes on form submit
        $('form').on('submit', function(e) {
            $('button').attr('disabled', true).prop('disabled', 'disabled');
        });

        // subscription mail form
        $('#joinUsForm').on('submit', function(e) {
            e.preventDefault();
            $.ajax({
                url : $(this).attr('action'),
                method : $(this).attr('method'),
                data : {_token : '{{csrf_token()}}',email : $('input[name="subsEmail"]').val()},
                beforeSend : function() {
                    $('#joinUsMailResp').html('Please wait <i class="fas fa-spinner fa-pulse"></i>');
                },
                success : function(result) {
                    result.resp == 200 ? $icon = '<i class="fas fa-check"></i> ' : $icon = '<i class="fas fa-info-circle"></i> ';
                    $('#joinUsMailResp').html('<span class="success_message">'+ $icon+result.message + '</span>');
                    $('button').attr('disabled', false);
                }
            });
        });

        $('.mobile_menu_toggle').click(function(){
            $('.mobile_menu').toggleClass('active');
        });
        $('.menu_close').click(function(){
            $('.mobile_menu').removeClass('active');
        });
        $('.parent').click(function(){
            $(this).next().toggle();
        });

        $('.mobile_nav li').first().addClass('active');
        $('.menu_item').first().addClass('active');

        $('.mobile_nav li a').click(function(){
            if (!$(this).parent().hasClass('active')){
                $('.mobile_nav li.active').removeClass('active');
                $(this).parent().addClass('active');
            } else {
                $(this).parent().removeClass('active');
            }
            var inputValue = $(this).attr("menu-target");
            var targetBox = $("#" + inputValue);
            $(".menu_item").not(targetBox).removeClass('active');
            $(targetBox).addClass('active');
        });

        $('.info-trigger').click(function(){
            $(this).parent().next().toggleClass('active');
        })

        // remove applied coupon option
        function removeAppliedCoupon() {
            $.ajax({
                url: '{{ route('front.cart.coupon.remove') }}',
                method: 'POST',
                data: {
                    '_token': '{{ csrf_token() }}'
                },
                beforeSend: function() {
                    $('#applyCouponBtn').text('Checking');
                },
                success: function(result) {
                    if (result.type == 'success') {
                        $('#appliedCouponHolder').html('');
                        $('input[name="couponText"]').val('').attr('disabled', false);
                        $('#applyCouponBtn').text('Apply').css('background', '#141b4b').attr('disabled', false);

                        let grandTotalWithoutCoupon = $('input[name="grandTotalWithoutCoupon"]').val();
                        $('#displayGrandTotal').text(grandTotalWithoutCoupon);

                        toastFire(result.type, result.message);
                    } else {
                        toastFire(result.type, result.message);
                        $('#applyCouponBtn').text('Apply');
                    }
                }
            });
        }

        /* let chekoutAmount = getCookie('checkoutAmount');
        // console.log(chekoutAmount);
        if (chekoutAmount) {
            couponApplied(chekoutAmount);
        }

        // checkout page coupon applied design
        function couponApplied(amount) {
            $('input[name="grandTotal"]').val(amount);
            $('#displayGrandTotal').text(amount);

            let couponContent = `
            <div class="cart-total">
                <div class="cart-total-label">
                    COUPON APPLIED<br/>
                    <a href="javascript:void(0)" onclick="removeAppliedCoupon(${amount})"><small>(Remove this coupon)</small></a>
                </div>
                <div class="cart-total-value">- ${amount}</div>
            </div>
            `;

            $('#appliedCouponHolder').html(couponContent);
        } */

        // let paymentGatewayAmount = chekoutAmount ? parseInt(chekoutAmount) * 100 : document.querySelector('[name="grandTotal"]').value * 100;
        // let paymentGatewayAmount = parseInt($('#displayGrandTotal').text()) * 100;
    </script>

    <script>

    

        function getProducts(){
            
            var search = $('#search_box').val();
            console.log(search);
            if(search.length > 0){
                $.ajax({
                    url: "{{ route('front.search.product') }}",
                    dataType: 'json',
                    type: 'POST',
                    data: {
                        'search': search,
                        "_token": "{{ csrf_token() }}"
                    },
                    success: function( data){
                        console.log(data);
                        var countData = data.length;
                        $('#searchContext').show();
                        $('#countVal').text(countData+' Result Found');
                        var base_url = window.location.origin;
                        
                        console.log(base_url);
                        var imgUrl = base_url+'/~a1627unp/dev/kga/';
                        
                        var productData = ``;
                        for(var i =0; i < data.length; i++){
                            var imgGetUrl = imgUrl+''+data[i].image;
                            productData += `<li>
                                <div class="product-holder">
                                    <figure>
                                        <img src="`+imgGetUrl+`">
                                    </figure>
                                    <figcaption>
                                        <a href="{{ url('/product/`+data[i].slug+`') }}" class="proname">`+data[i].name+`</a>
                                        <span class="pro-price">₹`+data[i].price+`</span>
                                    </figcaption>
                                    <div class="product-cart">
                                        <a href="#" class="cart"><i class="flaticon-shopping-cart"></i></a>
                                        <a href="#" class="cart"><i class="fal fa-heart"></i></a>
                                    </div>
                                </div>
                            </li>`;
                        }                        
                        $('.search-result-bottom ul').html(productData);                        
                    }
                    
                });
                var searchUrl = "{{route('front.search.index')}}?query="+search;
                $('#searchAllView').attr('href', searchUrl);
            } else {
                $('#searchContext').hide();
            }
            
        }

        $('input[type=search]').on('search', function () {
            // search logic here
            // this function will be executed on click of X (clear button)
            console.log("Hello");
            getProducts();
        });
		toastr.options = {
			"closeButton": true, // Show close button
			"debug": false,
			"newestOnTop": true,
			"progressBar": true, // Show progress bar
			"positionClass": "toast-top-right", // Position: top-right, top-left, bottom-right, bottom-left
			"preventDuplicates": true,
			"onclick": null,
			"showDuration": "300", // Animation duration
			"hideDuration": "1000",
			"timeOut": "5000", // How long the toast stays visible
			"extendedTimeOut": "1000",
			"showEasing": "swing",
			"hideEasing": "linear",
			"showMethod": "fadeIn",
			"hideMethod": "fadeOut"
		};
    </script>
	
    @yield('script')
</body>
</html>
