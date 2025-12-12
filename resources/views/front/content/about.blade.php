@extends('layouts.app')

@section('page', 'ABOUT')

@section('content')
<style type="text/css">
    .account-card {
        height: auto;
    }
    .about_header {
        padding: 50px 0 50px;
    }
    .about_header h1 {
        margin: 0;
    }
    .about_header p {
        font-size: 20px;
        line-height: 1.6;
        text-align: justify;
        margin: 0;
        padding-top: 20px;
        margin-top: 20px;
        border-top: 1px solid #eee;
        color: #111;
    }
    .about_header h2 {
        font-size: 30px;
        line-height: 1.4;
    }
    .about_count {
        font-size: 60px;
        font-weight: 600;
        color: #c10909;
    }
    .about_count_content {
        font-size: 18px;
        font-weight: 500;
    }
    .about_badge {
        display: inline-block;
        vertical-align: top;
        padding: 3px 15px;
        background: #c10909;
        color: #fff;
        font-weight: 700;
        border-radius: 30px;
        text-transform: uppercase;   
    }
    .about_banner figure {
        margin: 0;
        position: relative;
    }
    .about_banner_caption {
        width: 100%;
        max-width: 600px;
        position: absolute;
        top: 50%;
        left: 60%;
        transform: translateY(-50%);
        z-index: 9;
        padding: 0 15px;
    }
    .about_banner figure img {
        width: 100%;
        height: 100%;
        aspect-ratio: 3/1;
        object-fit: cover;
    }
    .about_excerpt {
        padding: 50px 0;
    }
    .about_excerpt p {
        font-size: 14px;
        font-weight: 400;
        line-height: 1.6;
        color: #111;
    }
    .about_excerpt h5 {
        margin-bottom: 10px;
    }
    .global_reach_list {
        columns: 4;
        column-gap: 30px;
    }
    .global_reach_list li {
        width: 100%;
        font-size: 14px;
        font-weight: 400;
        margin-bottom: 10px;
    }
    .about_services {
        padding: 50px 0 0;
        background: #f7f7f7;
    }
    .about_services h2 {
        font-size: 38px;
        line-height: 1.4;
        margin-bottom: 50px;
    }
    .about_services_item {
        padding-bottom: 30px;
        margin-bottom: 30px;
        border-bottom: 1px solid #ccc;
    }
    .about_services h5 {
        margin-bottom: 20px;
        font-weight: 500;
    }
    .about_services p {
        font-size: 14px;
        font-weight: 400;
        line-height: 1.6;
        color: #111;
        margin: 0;
    }
    .about_services_item:last-child {
        margin: 0;
        border: none;
    }
    .about_services figure {
        width: 100%;
        padding-bottom: 95%;
        position: relative;
        margin: 0;
    }
    .about_services figure img {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .about_banner figure {
        position: relative;
        overflow: hidden;
    }
    .about_banner .stroke_text {
        position: absolute;
        bottom: -30px;
        left: 0;
        -webkit-text-stroke-width: 3px;
        -webkit-text-stroke-color: #fff;
        color: transparent;
        z-index: 9;
        font-size: 200px;
        font-weight: 900;
        line-height: 1;
        white-space: nowrap;
    }
    .about_gallery {
        display: block;
        padding: 50px 0;
    }
    .about_gallery h2 {
        font-size: 38px;
        line-height: 1.4;
        margin-bottom: 50px;
    }
    .about_gallery img {
        max-width: 100%;
    }
    .media_popop {
        display: inline-block;
        vertical-align: top;
        line-height: 0;
        position: relative;
    }
    .media_popop span {
        position: absolute;
        display: inline-block;
        vertical-align: top;
        padding: 8px;
        border-radius: 50%;
        background-color: rgba(0,0,0,0.3);
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 9;
    }
    @media(max-width: 575px) {
        .about_banner figure img {
            aspect-ratio: 3/2;
            object-position: left center;
        }
        .about_banner_caption {
            width: 100%;
            padding: 20px;
            left: 0;
            right: 0;
            top: 0;
            transform: none;
            text-align: center;
            position: relative;
        }
        .about_banner_caption h2 {
            font-size: 30px;
            margin-bottom: 16px;
        }
        .about_banner_caption h4 {
            font-size: 14px;
            line-height: 1.4;
        }
        .about_header {
            padding: 16px 0;
        }
        .about_header h2 {
            font-size: 20px;
        }
        .about_header p {
            padding-top: 0;
            margin-top: 0;
            font-size: 16px;
        }
        section {
            padding: 16px 0;
        }
        .about_section p {
            font-size: 16px;
        }
        .about_section figure {
            position: relative;
            top: auto;
        }
        .media_popop {
            margin-bottom: 15px;
        }
    }
</style>

<section class="about_banner p-0">
    <div class="container-fluid p-0">
        <figure>
            <div class="about_banner_caption">
                <h6>Company Info</h6>
                <h2>{{$settings[0]->about_company_info_title}}</h2>
                <h4>{!!$settings[0]->about_company_info_desc!!}</h4>
            </div>
            <!-- <div class="stroke_text">KGA Electronics</div> -->
            {{-- <!-- <img src="{{asset('/img/332077637_141046705527514_4967098247875274444_n.jpg')}}"> --> --}}
            <img src="{{asset($settings[0]->about_image_1)}}">
        </figure>
    </div>
</section>

<section class="about_header">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-sm-12">
                <!-- <div class="row">
                    <div class="col-sm-4">
                        <div class="about_count">30</div>
                        <div class="about_count_content">Years<br/>Experience</div>
                    </div>
                    <div class="col-sm-4">
                        <div class="about_count">20k+</div>
                        <div class="about_count_content">Usual<br/>Users</div>
                    </div>
                    <div class="col-sm-4">
                        <div class="about_count">98%</div>
                        <div class="about_count_content">Positive<br/>Feedback</div>
                    </div>
                </div> -->
                <p>Welcome to KGA Electronics &amp; Home Appliances, where KGA stands for Khushboo Gupta Abhinav, named after its founders! </p>
                <p>Founded by two young entrepreneurs - Abhinav Gupta (29yo) &amp; Khushboo Khosla Gupta (29yo), we are a dynamic and innovative brand, recognized as the Times Brand Icon awardee for Emerging Brand in the Consumer Durable Electronics Industry 2022 by Times of India. In 2023, we were honored with the Brand Excellence in Home Appliances &amp; Televisions award by TV9. As the fastest-growing home appliance brand in Eastern India, we are creating a buzz in the industry.</p>
            </div>
        </div>
    </div>
</section>

<section class="about_section">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-12">
                <figure>
                    <img src="{{asset($settings[0]->about_image_2)}}">
                </figure>
            </div>
            <div class="col-md-6 col-12">
                <p>{!!$settings[0]->content!!}</p>

                {{-- <p>With our commitment to quality and innovation, we have successfully reached and served over 200,000 end customers, who have embraced our products for their exceptional performance and reliability. As a homegrown Indian brand founded by two young entrepreneurs in their 20s, we are proud to contribute to the growth and development of the nation's economy.</p>

                <p>Our success has attracted significant investor interest, making us an ideal choice for foreign direct investment (FDI) and foreign funding opportunities. If you are seeking to invest in an exciting Indian startup venture, KGA Electronics &amp; Home Appliances offers a compelling proposition.</p>

                <p>Join us as we continue to make waves in the home appliances industry, providing cutting-edge technology, top-notch products, and unparalleled customer satisfaction. Experience the difference with KGA Electronics &amp; Home Appliances - the perfect blend of innovation and excellence.</p> --}}
            </div>
        </div>
    </div>
</section>

<!-- <section class="about_excerpt">
    <div class="container">
        <div class="row">
            <div class="col-sm-10 offset-sm-1">
            <p>At KGA Electronics & Home Appliances, we pride ourselves on being pioneers in introducing groundbreaking products to the market. We were the first company in India to introduce titanium plate induction cooktops, setting a new standard for efficiency and durability. Our wide range of products includes mixer grinders, induction cookers, LED TVs, 3rd generation auto clean chimneys, toasters, hair dryers, Bluetooth earbuds, Bluetooth speakers, ceiling fans, steam irons, non-stick utensils, and more.</p>

            <p>With our commitment to quality and innovation, we have successfully reached and served over 200,000 end customers, who have embraced our products for their exceptional performance and reliability. As a homegrown Indian brand founded by two young entrepreneurs in their 20s, we are proud to contribute to the growth and development of the nation's economy.</p>

            <p>Our success has attracted significant investor interest, making us an ideal choice for foreign direct investment (FDI) and foreign funding opportunities. If you are seeking to invest in an exciting Indian startup venture, KGA Electronics & Home Appliances offers a compelling proposition.</p>

            <p>Join us as we continue to make waves in the home appliances industry, providing cutting-edge technology, top-notch products, and unparalleled customer satisfaction. Experience the difference with KGA Electronics & Home Appliances – the perfect blend of innovation and excellence.</p>
        </div>
    </div>
</section> -->

<!-- <section class="about_services">
    <div class="container">
        <div class="row">
            <div class="col-sm-5 offset-sm-1">
                <h2>Experience and trust built over the years</h2>
            </div>
        </div>
    </div>

    <div class="container pl-0">
        <div class="row align-items-center">
            <div class="col-sm-5">
                <figure>
                    <img src="{{asset('/img/onn_franchise03.jpg')}}">
                </figure>
            </div>
            <div class="col-sm-5 offset-sm-1">
                <div class="about_services_item">
                    <h5>1914 translation by H. Rackham</h5>
                    <p>A vast range of designs, top notch quality and sensible styling has been presented to meet the standards and aspirations of today’s youth.</p>
                </div>

                <div class="about_services_item">
                    <h5>Vision & Mission</h5>
                    <p>We believe in providing our customers with the products to satisfy their needs of ultimate comfort and style at the same time. As the fashion is changing at rapid pace, we aim to make the products meet the desires and aspirations of the youth.</p>
                </div>

                <div class="about_services_item">
                    <h5>1914 translation by H. Rackham</h5>
                    <p>We are focusing on maintaining and strengthening the brand image in accordance with the brand identity and brand values.</p>
                </div>
            </div>
        </div>
    </div>
</section> -->


<section class="about_gallery">
    <div class="container">
        <div class="row">
            <div class="col-sm-5">
                <h2>Our Videos</h2>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-sm-3">
                <a data-fancybox class="media_popop" href="https://m.media-amazon.com/images/I/E1DXTDY9BsL.mp4">
                    <img src="{{asset('/img/41d5cea9-d696-454b-9055-ea51eb4311d2._CR0,0,750,750_SX3000_.jpg')}}">
                    <span><svg xmlns="http://www.w3.org/2000/svg" width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-play-circle"><circle cx="12" cy="12" r="10"></circle><polygon points="10 8 16 12 10 16 10 8"></polygon></svg></span>
                </a>
            </div>
            <div class="col-sm-3">
                <a data-fancybox class="media_popop" href="https://m.media-amazon.com/images/I/E11F7rl%2BrfL.mp4">
                    <img src="{{asset('/img/0ca88669-5e8b-4f2e-af23-1c1758d6a09a._CR0,0,750,750_SX3000_.jpg')}}">
                    <span><svg xmlns="http://www.w3.org/2000/svg" width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-play-circle"><circle cx="12" cy="12" r="10"></circle><polygon points="10 8 16 12 10 16 10 8"></polygon></svg></span>
                </a>
            </div>
            <div class="col-sm-3">
                <a data-fancybox class="media_popop" href="https://www.youtube.com/watch?v=KDoty3vwFuI">
                    <img src="{{asset('/img/e453d97267d604124e2906c7258a04c8.w1500.h1500._CR0,0,1500,1500_SX750_SY750_.jpg')}}">
                    <span><svg xmlns="http://www.w3.org/2000/svg" width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-play-circle"><circle cx="12" cy="12" r="10"></circle><polygon points="10 8 16 12 10 16 10 8"></polygon></svg></span>
                </a>
            </div>
            <div class="col-sm-3">
                <a data-fancybox class="media_popop" href="https://www.youtube.com/watch?v=a7P7mFXjul0">
                    <img src="{{asset('/img/1d92756a-70bb-48d4-83d5-fab6c59d6c16._CR0,0,1500,1503_SX960_SY960_.jpg')}}">
                    <span><svg xmlns="http://www.w3.org/2000/svg" width="52" height="52" viewBox="0 0 24 24" fill="none" stroke="#ffffff" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-play-circle"><circle cx="12" cy="12" r="10"></circle><polygon points="10 8 16 12 10 16 10 8"></polygon></svg></span>
                </a>
            </div>
        </div>
    </div>
</section>


<!-- <section class="about_services">
    <div class="container">
        <div class="row">
            <div class="col-sm-5">
                <h2>Experience and trust built over the years</h2>
            </div>
        </div>
    </div>

    <div class="container pr-0">
        <div class="row align-items-center">
            <div class="col-sm-5 offset-sm-1">
                <div class="about_services_item">
                    <h5>1914 translation by H. Rackham</h5>
                    <p>A vast range of designs, top notch quality and sensible styling has been presented to meet the standards and aspirations of today’s youth.</p>
                </div>

                <div class="about_services_item">
                    <h5>Vision & Mission</h5>
                    <p>We believe in providing our customers with the products to satisfy their needs of ultimate comfort and style at the same time. As the fashion is changing at rapid pace, we aim to make the products meet the desires and aspirations of the youth.</p>
                </div>

                <div class="about_services_item">
                    <h5>1914 translation by H. Rackham</h5>
                    <p>We are focusing on maintaining and strengthening the brand image in accordance with the brand identity and brand values.</p>
                </div>
            </div>
            <div class="col-sm-5 offset-sm-1">
                <figure>
                    <img src="{{asset('/img/onn_franchise03.jpg')}}">
                </figure>
            </div>
        </div>
    </div>
</section> -->



<!-- <section class="cart-header mb-3 mb-sm-5 mt-5">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4>About us</h4>
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
                            <li><a href="{{route('front.content.about')}}">About</a></li>
                            <li><a href="{{route('front.content.corporate')}}">Corporate</a></li>
                            <li><a href="{{route('front.content.news')}}">News</a></li>
                            <li><a href="{{route('front.content.blog')}}">Blogs</a></li>
                            <li><a href="{{route('front.content.global')}}">Global</a></li>
                            <li><a href="{{route('front.content.contact')}}">Contact</a></li>
                            <li><a href="{{route('front.content.career')}}">Career</a></li>
                        </ul>
                    </li>
                </ul>
            </div>

            <div class="col-sm-7 col-lg-7">
                <div class="row">
                    <div class="col-sm-12 col-lg-6">
                        <a href="{{route('front.content.corporate')}}" class="account-card">
                            <figure>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-coffee"><path d="M18 8h1a4 4 0 0 1 0 8h-1"></path><path d="M2 8h16v9a4 4 0 0 1-4 4H6a4 4 0 0 1-4-4V8z"></path><line x1="6" y1="1" x2="6" y2="4"></line><line x1="10" y1="1" x2="10" y2="4"></line><line x1="14" y1="1" x2="14" y2="4"></line></svg>
                                </span>
                            </figure>
                            <figcaption>
                                <h4>Corporate</h4>
                            </figcaption>
                        </a>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <a href="{{route('front.content.news')}}" class="account-card">
                            <figure>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-file-text"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><polyline points="10 9 9 9 8 9"></polyline></svg>
                                </span>
                            </figure>
                            <figcaption>
                                <h4>News</h4>
                            </figcaption>
                        </a>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <a href="{{route('front.content.career')}}" class="account-card">
                            <figure>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-briefcase"><rect x="2" y="7" width="20" height="14" rx="2" ry="2"></rect><path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"></path></svg>
                                </span>
                            </figure>
                            <figcaption>
                                <h4>Career</h4>
                            </figcaption>
                        </a>
                    </div>
                    <div class="col-sm-12 col-lg-6">
                        <a href="{{route('front.content.global')}}" class="account-card">
                            <figure>
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-globe"><circle cx="12" cy="12" r="10"></circle><line x1="2" y1="12" x2="22" y2="12"></line><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"></path></svg>
                                </span>
                            </figure>
                            <figcaption>
                                <h4>Global</h4>
                            </figcaption>
                        </a>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section> -->

@endsection
