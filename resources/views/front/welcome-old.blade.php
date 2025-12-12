@extends('layouts.app')
@section('page', 'Home')
@section('content')
<style>
    .color_holder {
        height: 20px;
        width: 20px;
        border-radius: 50%
    }
    .product__color {
        display: flex;
        flex-wrap: wrap;
        padding: 0 20px 20px;
        align-items: center;
        justify-content: center;
    }
    .color-holder {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        flex: 0 0 20px;
        margin-right: 7px;
        box-shadow: 0px 5px 10px rgb(0 0 0 / 10%);
    }
    @media(max-width: 575px) {
        .color-holder {
            width: 15px;
            height: 15px;
            flex: 0 0 15px;
        }
        .product__color {
            justify-content: center;
        }
    }
</style>
<!-- <section id="home" class="home-banner p-0">
    <div class="home-banner__slider swiper-container">
        <div class="slider swiper-wrapper">
			@foreach ($banner as $item)
                @php
                    $banImgVal = str_replace('public/','',$item->file_path);
                @endphp
                <div class="home-banner__slider-single swiper-slide">
                    
                        @if ($item->type == 'video')
                        <div class="video__wrapper">
                            <video id="onn-video" width="320" height="240" autoplay muted loop playsinline>
                                <source src="{{ asset($banImgVal) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                        @else
                        <div class="video__wrapper">
                            <a href="#">
                                <img src="{{ asset($banImgVal) }}" />
                            </a>
                        </div>
                        @endif
                    
                </div>
            @endforeach            
        </div>
        <div class="swiper-pagination"></div>
    </div>
</section> -->
<section class="cat_section">
    <div class="container">
        <div class="swiper category_slide">
            <div class="swiper-wrapper">
				@foreach($category as $item)
                <div onclick="window.location.href='{{ route('front.category.detail', $item['slug']) }}';" class="swiper-slide">
                    <div class="category_thumbnail">
                        <figure>
                            {{--<img src="{{asset('img/icon/led-tv.png')}}">--}}
							<img src="{{asset($item->icon_path)}}">
                        </figure>
                        <p>{{$item->name}}</p>
                    </div>
                </div>
				@endforeach
                {{--<div class="swiper-slide">
                    <div class="category_thumbnail">
                        <figure>
                            <img src="{{asset('img/icon/airpods.png')}}">
                        </figure>
                        <p>Bluetooth Earbuds</p>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="category_thumbnail">
                        <figure>
                            <img src="{{asset('img/icon/blender.png')}}">
                        </figure>
                        <p>Mixer Grinder</p>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="category_thumbnail">
                        <figure>
                            <img src="{{asset('img/icon/ceiling-fan.png')}}">
                        </figure>
                        <p>ceiling Fans</p>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="category_thumbnail">
                        <figure>
                            <img src="{{asset('img/icon/computer-hardware.png')}}">
                        </figure>
                        <p>Optical Mouse</p>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="category_thumbnail">
                        <figure>
                            <img src="{{asset('img/icon/frying-pan.png')}}">
                        </figure>
                        <p>Non-stick Cookware</p>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="category_thumbnail">
                        <figure>
                            <img src="{{asset('img/icon/headphones.png')}}">
                        </figure>
                        <p>Earphones</p>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="category_thumbnail">
                        <figure>
                            <img src="{{asset('img/icon/reusable-bottle.png')}}">
                        </figure>
                        <p>Sports Bottle</p>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="category_thumbnail">
                        <figure>
                            <img src="{{asset('img/icon/sandwitch-maker.png')}}">
                        </figure>
                        <p>Sandwitch Maker</p>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="category_thumbnail">
                        <figure>
                            <img src="{{asset('img/icon/speaker.png')}}">
                        </figure>
                        <p>Bluetooth Speaker</p>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="category_thumbnail">
                        <figure>
                            <img src="{{asset('img/icon/toaster.png')}}">
                        </figure>
                        <p>Toaster</p>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="category_thumbnail">
                        <figure>
                            <img src="{{asset('img/chimney.png')}}">
                        </figure>
                        <p>Chimney</p>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="category_thumbnail">
                        <figure>
                            <img src="{{asset('img/hairdryer.png')}}">
                        </figure>
                        <p>Hair Dryer</p>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="category_thumbnail">
                        <figure>
                            <img src="{{asset('img/induction-stove.png')}}">
                        </figure>
                        <p>Induction Cooktop</p>
                    </div>
                </div>--}}
            </div>
            <div class="swiper-button-next next_btn"></div>
            <div class="swiper-button-prev prev_btn"></div>
        </div>
    </div>
</section>

<section class="home-banner-section pt-0 px-0">
    <div class="container">
        <div class="swiper tv_slider">
            <div class="swiper-wrapper">
				@foreach($tvproducts as $product)
				@php
				  $feature=\App\Models\ProductFeature::where('product_id',$product->id)->get();
				  $spec=\App\Models\ProductSpecification::where('product_id',$product->id)->get();
				@endphp
                <div class="swiper-slide">
                    <div class="home-section mb-2 mb-sm-4">
                        <div class="row align-items-stretch">
                            <div class="col-12">
                                <div class="product-image text-center">
                                    <h1>{{$product->name}}</h1>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="image-description">
                                    <ul class="feature_list">
										@foreach($feature as $item)
                                        <li><img src="{{asset($item->icon)}}"><p>{{$item->name}}</p></li>
										@endforeach
                                        {{--<li><img src="{{asset('img/aspect-ratio.png')}}"><p>Aspect Ratio</p></li>
                                        <li><img src="{{asset('img/usb.png')}}"><p>USB</p></li>
                                        <li><img src="{{asset('img/av_cable.png')}}"><p>AV</p></li>
                                        <li><img src="{{asset('img/speaker.png')}}"><p>Loud Bass</p></li>
                                        <li><img src="{{asset('img/signal-tower.png')}}"><p>RF</p></li>--}}
                                    </ul>
                                    {!!$product->short_content!!}
                                    <h4>Starting <span class="price">₹ {{$product->offer_price}}*</span></h4>
									 @if(Auth::guard('web')->check())
									   <form method="POST" class="mt-auto" action="{{route('front.cart.add')}}" >@csrf
										   <input type="hidden" name="product_id" value="{{$product->id}}">
                                		   <input type="hidden" name="product_name" value="{{$product->name}}">
										   <input type="hidden" name="qty" value="1">
									   	  <button type="submit" class="latest-btm mt-auto">Order Now</button>
									  </form>
									  
									@else
                                       <a href="{{route('front.user.login')}}" class="latest-btm mt-auto">Order Now</a>
									@endif
                                </div>
                            </div>
							
                            <div class="col-md-6">
                                <div class="product-image text-center">
                                    <figure>
										@if(!file_exists($product->image))
                                        <img src="{{asset('img/electric-appliance.png')}}" />
										@else
										<img src="{{ asset($product->image) }}">
										@endif
                                    </figure>
                                    
                                </div>
                            </div>
                            <div class="col-md-3">
                                <ul class="speci-list">
									@foreach($spec as $row)
									<li>
                                        <figure>
                                            <img src="{{asset($row->icon)}}">
                                        </figure>
                                        <figcaption>
                                            <h5>{{$row->name}}</h5>
                                            <p>{{$row->description}}</p>
                                        </figcaption>
                                    </li>
                                    {{-- <li>
                                        <figure>
                                            <img src="{{asset('img/material.svg')}}">
                                        </figure>
                                        <figcaption>
                                            <h5>Material</h5>
                                            <p>ABS Plastic</p>
                                        </figcaption>
                                    </li>--}}
									@endforeach
                                   {{-- <li>
                                        <figure>
                                            <img src="{{asset('img/voltage.svg')}}">
                                        </figure>
                                        <figcaption>
                                        <h5>Voltage</h5>
                                            <p>240 Volts</p>
                                        </figcaption>
                                    </li>
                                    <li>
                                        <figure>
                                            <img src="{{asset('img/speed.svg')}}">
                                        </figure>
                                        <figcaption>
                                            <h5>Number of Speeds</h5>
                                            <p>3</p>
                                        </figcaption>
                                    </li>
                                    <li>
                                        <figure>
                                            <img src="{{asset('img/wattage.svg')}}">
                                        </figure>
                                        <figcaption>
                                        <h5>Wattage</h5>
                                            <p>550 Watts</p>
                                        </figcaption>
                                    </li>--}}
                                </ul>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-sm-3">
                                
                                <div class="scroller">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0" viewBox="0 0 91 91" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M45.33 90a1.5 1.5 0 0 1-1.5-1.5V68.2a1.5 1.5 0 0 1 3 0v20.26a1.5 1.5 0 0 1-1.5 1.54z" fill="#000000" data-original="#000000"></path><path d="M45.33 90a1.5 1.5 0 0 1-1-.38l-9-7.88a1.5 1.5 0 1 1 2-2.25l9 7.88a1.49 1.49 0 0 1 .15 2.11 1.52 1.52 0 0 1-1.15.52z" fill="#000000" data-original="#000000"></path><path d="M45.33 90a1.5 1.5 0 0 1-1-2.63l9-7.88a1.5 1.5 0 1 1 2 2.25l-9 7.88a1.47 1.47 0 0 1-1 .38zM50.86 60.73H39.79a15.13 15.13 0 0 1-15.11-15.11v-29A15.13 15.13 0 0 1 39.79 1.46h11.07A15.12 15.12 0 0 1 66 16.57v29.05a15.12 15.12 0 0 1-15.14 15.11zM39.79 4.46a12.12 12.12 0 0 0-12.11 12.11v29.05a12.13 12.13 0 0 0 12.11 12.11h11.07A12.12 12.12 0 0 0 63 45.62v-29A12.12 12.12 0 0 0 50.86 4.46z" fill="#000000" data-original="#000000"></path><path d="M45.33 26.37a1.5 1.5 0 0 1-1.5-1.5v-7.53a1.5 1.5 0 0 1 3 0v7.53a1.5 1.5 0 0 1-1.5 1.5z" fill="#000000" data-original="#000000"></path></g></svg>
                                    <span>Scroll Down</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <p>{!!$product->long_content!!}</p>
                            </div>
                            <div class="col-sm-3 text-center text-sm-right">
                                <a href="{{route('front.category.detail',$product->category->slug)}}" class="text-btm-new">
                                    Discover More
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0" viewBox="0 0 512.009 512.009" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M508.625 247.801 392.262 131.437c-4.18-4.881-11.526-5.45-16.407-1.269-4.881 4.18-5.45 11.526-1.269 16.407.39.455.814.88 1.269 1.269l96.465 96.582H11.636C5.21 244.426 0 249.636 0 256.063s5.21 11.636 11.636 11.636H472.32l-96.465 96.465c-4.881 4.18-5.45 11.526-1.269 16.407s11.526 5.45 16.407 1.269c.455-.39.88-.814 1.269-1.269l116.364-116.364c4.511-4.537 4.511-11.867-.001-16.406z" fill="#000000" data-original="#000000" class=""></path></g></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
				@endforeach
                {{--<div class="swiper-slide">
                    <div class="home-section">
                        <div class="row align-items-stretch">
                            <div class="col-12">
                                <div class="product-image text-center">
                                    <h1>43" FHD LED TV</h1>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="image-description">
                                    <ul>
                                        <li><img src="{{asset('img/hdmi-port.png')}}"><p>HDMI</p></li>
                                        <li><img src="{{asset('img/aspect-ratio.png')}}"><p>Aspect Ratio</p></li>
                                        <li><img src="{{asset('img/usb.png')}}"><p>USB</p></li>
                                        <li><img src="{{asset('img/av_cable.png')}}"><p>AV</p></li>
                                        <li><img src="{{asset('img/speaker.png')}}"><p>Loud Bass</p></li>
                                        <li><img src="{{asset('img/signal-tower.png')}}"><p>RF</p></li>
                                    </ul>
                                    <p>Full HD 1080p Smart TV with AMD FreeSync, Apple AirPlay and Chromecast Built-in, Alexa Compatibility, D40f-J09, 2022 Model</p>
                                    <h4>Starting <span class="price">₹ 13,000*</span></h4>
                                    <a href="#" class="latest-btm mt-auto">Order Now</a>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="product-image text-center">
                                    <figure>
                                        <img src="{{asset('img/kga_tv.png')}}">
                                    </figure>
                                    
                                </div>
                            </div>
                            <div class="col-md-3">
                                <ul class="speci-list">
                                    <li>
                                        <figure>
                                            <img src="{{asset('img/material.svg')}}">
                                        </figure>
                                        <figcaption>
                                            <h5>Material</h5>
                                            <p>ABS Plastic</p>
                                        </figcaption>
                                    </li>
                                    <li>
                                        <figure>
                                            <img src="{{asset('img/voltage.svg')}}">
                                        </figure>
                                        <figcaption>
                                        <h5>Voltage</h5>
                                            <p>240 Volts</p>
                                        </figcaption>
                                    </li>
                                    <li>
                                        <figure>
                                            <img src="{{asset('img/speed.svg')}}">
                                        </figure>
                                        <figcaption>
                                            <h5>Number of Speeds</h5>
                                            <p>3</p>
                                        </figcaption>
                                    </li>
                                    <li>
                                        <figure>
                                            <img src="{{asset('img/wattage.svg')}}">
                                        </figure>
                                        <figcaption>
                                        <h5>Wattage</h5>
                                            <p>550 Watts</p>
                                        </figcaption>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-sm-3">
                               
                                <div class="scroller">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0" viewBox="0 0 91 91" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M45.33 90a1.5 1.5 0 0 1-1.5-1.5V68.2a1.5 1.5 0 0 1 3 0v20.26a1.5 1.5 0 0 1-1.5 1.54z" fill="#000000" data-original="#000000"></path><path d="M45.33 90a1.5 1.5 0 0 1-1-.38l-9-7.88a1.5 1.5 0 1 1 2-2.25l9 7.88a1.49 1.49 0 0 1 .15 2.11 1.52 1.52 0 0 1-1.15.52z" fill="#000000" data-original="#000000"></path><path d="M45.33 90a1.5 1.5 0 0 1-1-2.63l9-7.88a1.5 1.5 0 1 1 2 2.25l-9 7.88a1.47 1.47 0 0 1-1 .38zM50.86 60.73H39.79a15.13 15.13 0 0 1-15.11-15.11v-29A15.13 15.13 0 0 1 39.79 1.46h11.07A15.12 15.12 0 0 1 66 16.57v29.05a15.12 15.12 0 0 1-15.14 15.11zM39.79 4.46a12.12 12.12 0 0 0-12.11 12.11v29.05a12.13 12.13 0 0 0 12.11 12.11h11.07A12.12 12.12 0 0 0 63 45.62v-29A12.12 12.12 0 0 0 50.86 4.46z" fill="#000000" data-original="#000000"></path><path d="M45.33 26.37a1.5 1.5 0 0 1-1.5-1.5v-7.53a1.5 1.5 0 0 1 3 0v7.53a1.5 1.5 0 0 1-1.5 1.5z" fill="#000000" data-original="#000000"></path></g></svg>
                                    <span>Scroll Down</span>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <p>Versatility and performance collide with the new D-Series FHD Smart TV that comes loaded with a full array backlight for better contrast and uniformity, brilliant 1080p Full HD resolution and an ultra-fast VIZIO IQ processor with support for immersive audio pass-through for Dolby Atmos and DTS:X.</p>
                            </div>
                            <div class="col-sm-3 text-center text-sm-right">
                                <a href="{{route('front.category.detail',$product->cat->slug)}}" class="text-btm-new">
                                    Discover More
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0" viewBox="0 0 512.009 512.009" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M508.625 247.801 392.262 131.437c-4.18-4.881-11.526-5.45-16.407-1.269-4.881 4.18-5.45 11.526-1.269 16.407.39.455.814.88 1.269 1.269l96.465 96.582H11.636C5.21 244.426 0 249.636 0 256.063s5.21 11.636 11.636 11.636H472.32l-96.465 96.465c-4.881 4.18-5.45 11.526-1.269 16.407s11.526 5.45 16.407 1.269c.455-.39.88-.814 1.269-1.269l116.364-116.364c4.511-4.537 4.511-11.867-.001-16.406z" fill="#000000" data-original="#000000" class=""></path></g></svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>--}}
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next tv-next"></div>
            <div class="swiper-button-prev tv-prev"></div>
        </div>
    </div>
</section>




<section class="utensils_section">
    <div class="utensils_right">

        <div class="swiper utensils_slider">
            <div class="swiper-wrapper">
				@foreach($nonstickproducts as $nonstickproduct)
				
				@php
				  $nonstickfeature=\App\Models\ProductFeature::where('product_id',$nonstickproduct->id)->get();
				  
				  $nonstickspec=\App\Models\ProductSpecification::where('product_id',$nonstickproduct->id)->get();
				@endphp
                <div class="swiper-slide">

                    <div class="utensils_content_right">
                        <h6>KGA</h6>
                        <h2>{{$nonstickproduct->name}}</h2>
                        <h6>premium Quality</h6>
                        <ul>
							@foreach($nonstickfeature as $nonstickfeatures)
                            <li>{{$nonstickfeatures->name}}</li>
							@endforeach
                            {{--<li>5 layer Non-stick Coating</li>
                            <li>Induction base</li>
                            <li>Granite finish</li>--}}
                        </ul>
						 @if(Auth::guard('web')->check())
							<form method="POST" action="{{route('front.cart.add')}}" >@csrf
								<input type="hidden" name="product_id" value="{{$nonstickproduct->id}}">
								<input type="hidden" name="product_name" value="{{$nonstickproduct->name}}">
								<input type="hidden" name="qty" value="1">
 									<button type="submit"  class="latest-btm">Order Now</button>
							</form>
                       
						@else
						<a href="{{route('front.user.login')}}"  class="latest-btm">Order Now</a>
						@endif
                    </div>

                    <img src="{{asset($nonstickproduct->image)}}">

                    <div class="utensils_content_left">
                        <ul>
							@foreach($nonstickspec as $nonstickspecs)
                            <li><img src="{{asset($nonstickspecs->icon)}}"> {{$nonstickspecs->name}}</li>
							@endforeach
                           {{-- <li><img src="{{asset('img/electric.png')}}"> Electric Stove</li>
                            <li><img src="{{asset('img/induction.png')}}"> Induction Cooktops</li>
                            <li><img src="{{asset('img/hobs.png')}}"> Hobs</li>--}}
                        </ul>
                    </div>
                </div>
               
				@endforeach
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next swiper-next"></div>
            <div class="swiper-button-prev swiper-prev"></div>
        </div>
    </div>
    <div class="utensils_left">
        <div class="utensils_content">
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><circle cx="72" cy="128" r="16" fill="" data-original="" class=""></circle><circle cx="128" cy="72" r="16" fill="" data-original="" class=""></circle><path d="m509.463 153.017-1.874-3.747a23.959 23.959 0 0 0-31.331-11.146l-119.581 54.6.1.226a27.985 27.985 0 0 0-19.18 36.37l-2.353 1.569c-31.391-15.7-107.523-3.043-178.655 21.7q-6.269 2.18-12.5 4.494c-7.861-29.123 12.482-50.32 13.589-51.443l-11.334-11.292a77.3 77.3 0 0 0-16.979 29.271 66.627 66.627 0 0 0-.321 39.26c-12.8 5.111-25.1 10.514-36.739 16.129-6.455-23.962-7.028-48.686-6.149-66.552A27.095 27.095 0 1 0 32 211.1v56.58a4.329 4.329 0 0 1-4.325 4.32 20.319 20.319 0 0 0-20.326 20.44 128.959 128.959 0 0 0 6.861 38.122C1.969 343.667-2.409 355.546 1.2 365.925c13.439 38.638 44.317 68.513 86.945 84.121a189.98 189.98 0 0 0 65.354 11.3 217.867 217.867 0 0 0 71.424-12.3c46.141-16.049 84.453-45.914 107.877-84.093 23.741-38.693 29.414-81.281 15.975-119.919a21.522 21.522 0 0 0-.9-2.16A27.9 27.9 0 0 0 371.409 247l.095.194 1.195-.582a27.91 27.91 0 0 0 6.851-3.337l118.842-57.891a24 24 0 0 0 11.072-32.365zM16.313 360.668c-1.107-3.181.725-8.033 4.992-13.727a76.744 76.744 0 0 0 18.988 23.382 77.6 77.6 0 0 1-10.448-1.7c-7.577-1.838-12.381-4.661-13.529-7.951v-.005zm286.642-87.738c-1.686 14.34-4.494 17.294-4.612 17.413l.155.155c-6.623 4.51-13.887 9.008-21.7 13.447A103.433 103.433 0 0 0 287 271a8.092 8.092 0 0 1 8.009-7 8 8 0 0 1 7.948 8.931zm-157.1 20.191 12.292-10.243a80.666 80.666 0 0 1-7.8-11.057 658.658 658.658 0 0 1 11.5-4.124c43.75-15.217 86.4-24.871 120.082-27.181 15.673-1.074 28.884-.448 38.2 1.813 7.581 1.838 12.386 4.664 13.531 7.957s-.87 8.49-5.672 14.636a83.255 83.255 0 0 1-9.129 9.693 24.035 24.035 0 0 0-47.719-5.764c-4.064 29.911-21.746 47.342-26.678 51.682a605.259 605.259 0 0 1-56.335 22.724q-12.242 4.258-24.316 7.922c-31.607-6.1-53.955-25.2-66.469-56.848 11.932-5.82 24.64-11.416 37.883-16.7a95.974 95.974 0 0 0 10.629 15.491zM24.6 289.278A4.3 4.3 0 0 1 27.675 288 20.348 20.348 0 0 0 48 267.675V211.1A11.107 11.107 0 0 1 59.1 200a11.1 11.1 0 0 1 11.08 11.665c-1.144 23.243.045 57.437 12.207 88.342 7.005 17.8 16.913 32.448 29.447 43.533a96.061 96.061 0 0 0 23.838 15.428 432.359 432.359 0 0 1-54.3 10.217c-2.843.33-8.055-1.076-8.055-1.076-17.868-2.978-31.438-14.267-40.334-33.552a111.486 111.486 0 0 1-9.632-42.217 4.275 4.275 0 0 1 1.249-3.062zm337.963-57.372 1.874-1.249a8 8 0 1 0-8.875-13.312l-3.548 2.365a11.994 11.994 0 1 1 19.317 9.77l-4.4 2.145a11.374 11.374 0 0 1-4.365.282z" fill="" data-original="" class=""></path><path d="M104 160h16v16h-16zM96 232h16v16H96zM144 304h16v16h-16zM16 152h16v16H16zM83.563 366.656l8.875-13.312C72.886 340.309 72.023 328.3 72 327.795c.007.135 0 .205 0 .205H56c0 2.076.773 20.8 27.563 38.656zM152 152c0-8.158 3.627-17.948 10.489-28.311a101.832 101.832 0 0 1 11.175-14.039L168 104l-5.657-5.657C161.268 99.419 136 125 136 152z" fill="" data-original="" class=""></path></g></svg>
            <h3>Non-Stick Cookware</h3>
            <p>{{$nonstickproducts->count()}} Collection</p>
        </div>
    </div>
</section>



<section class="fan_section">
    <div class="chimney_banner text-center">
        <div class="swiper chimney_slider">
            <div class="swiper-wrapper">
				@foreach($chimneyproducts as $chimneyproduct)
				@php
				  $chimneyfeature=\App\Models\ProductFeature::where('product_id',$chimneyproduct->id)->get();
				  
				@endphp
                <div class="swiper-slide">
                    <img src="{{asset($chimneyproduct->image)}}">
                    <h2>{{$chimneyproduct->name}}</h2>
                    <ul>
						@foreach($chimneyfeature as $chimneyfeatures)
                        <li>{{$chimneyfeatures->name}}</li>
						@endforeach
                        {{--<li>Baffle Filter<br/>Technology</li>
                        <li>Powerful<br/>Copper Motor</li>
                        <li>Metal<br/>Blower</li>--}}
                    </ul>
					@if(Auth::guard('web')->check())
					<form method="POST" action="{{route('front.cart.add')}}" >@csrf
						<input type="hidden" name="product_id" value="{{$chimneyproduct->id}}">
						<input type="hidden" name="product_name" value="{{$chimneyproduct->name}}">
						<input type="hidden" name="qty" value="1">
                        <button type="submit" class="latest-btm">Order Now</button>
					</form>
					@else
					<a href="{{route('front.user.login')}}" class="latest-btm">Order Now</a>
					@endif
                </div>
				@endforeach
                {{--<div class="swiper-slide">
                    <img src="{{asset('img/chimney_prod_2.png')}}">
                    <h2>PURE FLOW +</h2>
                    <ul>
                        <li>Wave Sensor<br/>Technology</li>
                        <li>Baffle Filter<br/>Technology</li>
                        <li>Powerful<br/>Copper Motor</li>
                        <li>Metal<br/>Blower</li>
                    </ul>
                    <a href="#" class="latest-btm">Order Now</a>
                </div>
                <div class="swiper-slide">
                    <img src="{{asset('img/chimney_prod_3.png')}}">
                    <h2>Imperial Vent</h2>
                    <ul>
                        <li>Wave Sensor<br/>Technology</li>
                        <li>Baffle Filter<br/>Technology</li>
                        <li>Powerful<br/>Copper Motor</li>
                        <li>Metal<br/>Blower</li>
                    </ul>
                    <a href="#" class="latest-btm">Order Now</a>
                </div>--}}
            </div>
            <div class="swiper-pagination"></div>
            <div class="swiper-button-next chimney-next"></div>
            <div class="swiper-button-prev chimney-prev"></div>
        </div>
    </div>
    <div class="fan_area_left">
        <div class="fan_area">
			@foreach($fanproducts as $active =>$fanproduct)
			
            <div class="fan_item" id="{{$fanproduct->color->id}}">               
                <div class="fan_image_shadow">
                    <img src="{{asset($fanproduct->banner_image)}}">
                </div>
                <div class="fan_dotted_bg"></div>
                <div class="fan_image">
                    <img src="{{asset($fanproduct->banner_image)}}">
                </div>
            </div>
			@endforeach
            {{--<div class="fan_item" id="black">
                <div class="fan_image_shadow">
                    <img src="{{asset('img/kga_fan_2.png')}}">
                </div>
                <div class="fan_dotted_bg"></div>
                <div class="fan_image">
                    <img src="{{asset('img/kga_fan_2.png')}}">
                </div>
            </div>
            <div class="fan_item" id="brown">
                <div class="fan_image_shadow">
                    <img src="{{asset('img/kga_fan_3.png')}}">
                </div>
                <div class="fan_dotted_bg"></div>
                <div class="fan_image">
                    <img src="{{asset('img/kga_fan_3.png')}}">
                </div>
            </div>--}}
			@foreach($fanproducts as $active =>$fanproduct)
			@php
			  $fanSpec=\App\Models\ProductSpecification::where('product_id',$fanproduct->id)->get();
			@endphp
            <div class="fan_content">
                <h6>KGA</h6>
				<div id="fan{{$fanproduct->color->id}}" class="fan_data_content {{ ($active == 0) ? 'active' : '' }}">
					<h2>{{$fanproduct->name}}</h2>

					<ul class="fan_spec">
						@foreach($fanSpec as  $fanSpecs)
						<li>
							<img src="{{asset($fanSpecs->icon)}}">
							<div>
								<h5>{{$fanSpecs->title}}</h5>
								<p>{{$fanSpecs->description}}</p>
							</div>
						</li>
						@endforeach
						{{--<li>
							<img src="{{asset('img/metal.png')}}">
							<div>
								<h5>Material</h5>
								<p>Aluminium</p>
							</div>
						</li>
						<li>
							<img src="{{asset('img/volume.png')}}">
							<div>
								<h5>Controller Type</h5>
								<p>Button Control</p>
							</div>
						</li>
						<li>
							<img src="{{asset('img/blade.png')}}">
							<div>
								<h5>Number of Blades</h5>
								<p>3</p>
							</div>
						</li>--}}
					</ul>
						
					@if(Auth::guard('web')->check())
					<form method="POST" action="{{route('front.cart.add')}}" >@csrf
						<input type="hidden" name="product_id" value="{{$fanproduct->id}}">
						<input type="hidden" name="product_name" value="{{$fanproduct->name}}">
						<input type="hidden" name="qty" value="1">
					    <button type="submit" class="latest-btn-white">Order Now</button>
					</form>
					@else
						<a href="{{route('front.user.login')}}" class="latest-btn-white">Order Now</a>
					@endif
				</div>
            </div>
			@endforeach
			<ul class="color_spec fan_list">
				@foreach($fanproducts as $active =>$fanproduct)
						<li data-fan="{{$fanproduct->color->id}}"><span style="background: {{$fanproduct->color->code}};"></span></li>
				@endforeach
						{{--<li data-fan="{{$fanproduct->color->id}}"><span style="background: #000000;"></span></li>
						<li data-fan="brown"><span style="background: #523b35;"></span></li>--}}
					</ul>
        </div>
    </div>
</section>

<section class="first_category">
    <div class="category_block">
        <div class="category_content">
            <div class="swiper bottle_content">
                <div class="swiper-wrapper">
					@foreach($bottleproducts as $bottleproduct)
				
					
                    <div class="swiper-slide">
                        <h2>{{$bottleproduct->name}}</h2>
                        <h4>{{$bottleproduct->sub_heading}}</h4>
                        <span class="price">Starting  ₹ {{$bottleproduct->offer_price}}*</span>
                    </div>
					@endforeach
                    {{--<div class="swiper-slide">
                        <h2>Sports Bottle</h2>
                        <h4>304 stainless steel</h4>
                        <span class="price">Starting  ₹ 499*</span>
                    </div>
                    <div class="swiper-slide">
                        <h2>Sports Bottle</h2>
                        <h4>304 stainless steel</h4>
                        <span class="price">Starting  ₹ 499*</span>
                    </div>--}}
                </div>
            </div>

            <div class="d-block mt-auto">
                <div class="swiper cat_slide">
                    <div class="swiper-wrapper">
						@foreach($bottleproducts as $bottleproduct)
                        <div class="swiper-slide">
                            <figure>
                                <img src="{{asset($bottleproduct->banner_image)}}">
                            </figure>
                        </div>
						@endforeach
                        {{--<div class="swiper-slide">
                            <figure>
                                <img src="{{asset('img/bottle_2.png')}}">
                            </figure>
                        </div>
                        <div class="swiper-slide">
                            <figure>
                                <img src="{{asset('img/bottle_3.png')}}">
                            </figure>
                        </div>--}}
                    </div>
                </div>
            </div>
        </div>

        <div class="category_slider">
            <div class="swiper cat_thumbnail">
                <div class="swiper-wrapper">
					@foreach($bottleproducts as $bottleproduct)
                    <div class="swiper-slide">
                        <figure class="bottle_img">
                            <img src="{{asset($bottleproduct->banner_image)}}">
                        </figure>
                    </div>
					@endforeach
                   {{-- <div class="swiper-slide">
                        <figure class="bottle_img">
                            <img src="{{asset('img/bottle_2.png')}}">
                        </figure>
                    </div>
                    <div class="swiper-slide">
                        <figure class="bottle_img">
                            <img src="{{asset('img/bottle_3.png')}}">
                        </figure>
                    </div>--}}
                </div>
            </div>
        </div>
        
        <div class="category_feture">
            <div class="swiper bottle_feature">
                <div class="swiper-wrapper">
					@foreach($bottleproducts as $bottleproduct)
					@php
					  $bottlefeature=\App\Models\ProductFeature::where('product_id',$bottleproduct->id)->get();
					 
					  $bottlespec=\App\Models\ProductSpecification::where('product_id',$bottleproduct->id)->get();
					@endphp
                    <div class="swiper-slide">
                        <div class="bottle_meta">
                            <ul>
								@foreach($bottlefeature as $bottlefeatures)
                                <li>
                                    <h5>{{$bottlefeatures->name}}</h5>
                                </li>
								@endforeach
                                {{--<li>
                                    <h5>304 Stainless Steel</h5>
                                </li>
                                <li>
                                    <h5>Tough Coating</h5>
                                </li>
                                <li>
                                    <h5>Heavy duty</h5>
                                </li>
                                <li>
                                    <h5>Durable</h5>
                                </li>--}}
                            </ul>
							@if(Auth::guard('web')->check())
							<form method="POST" action="{{route('front.cart.add')}}" >@csrf
							<input type="hidden" name="product_id" value="{{$bottleproduct->id}}">
							<input type="hidden" name="product_name" value="{{$bottleproduct->name}}">
							<input type="hidden" name="qty" value="1">
                            	<button type="submit" class="btn">Add to cart <span><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></span></button>
							</form>
							@else
							  <a href="{{route('front.user.login')}}" class="btn">Add to cart <span><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></span></a>
							@endif
                        </div>
                    </div>
					@endforeach
                    {{--<div class="swiper-slide">
                        <ul>
                            <li>
                                <h5>Leak Proof</h5>
                            </li>
                            <li>
                                <h5>304 Stainless Steel</h5>
                            </li>
                            <li>
                                <h5>Tough Coating</h5>
                            </li>
                            <li>
                                <h5>Heavy duty</h5>
                            </li>
                            <li>
                                <h5>Durable</h5>
                            </li>
                        </ul>
                        <a href="#" class="btn">Add to cart <span><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></span></a>
                    </div>
                    <div class="swiper-slide">
                        <ul>
                            <li>
                                <h5>Leak Proof</h5>
                            </li>
                            <li>
                                <h5>304 Stainless Steel</h5>
                            </li>
                            <li>
                                <h5>Tough Coating</h5>
                            </li>
                            <li>
                                <h5>Heavy duty</h5>
                            </li>
                            <li>
                                <h5>Durable</h5>
                            </li>
                        </ul>
                        <a href="#" class="btn">Add to cart <span><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></span></a>
                    </div>--}}
                </div>
            </div>
        </div>
    </div>

    <div class="small_cat">
        <div class="heading">
            <h2 class="text-center">KGA Portable<br/><span>Bluetooth Speaker</span></h2>
            <h4>New Arrival</h4>
        </div>
        
        <div class="bud_area">
			@foreach($speakerproducts as $active =>$speakerproduct)
			@php
			  $speakerFeature=\App\Models\ProductFeature::where('product_id',$speakerproduct->id)->get();
			   if(Auth::guard('web')->check()){
                   $wishlistCheck =\App\Models\Wishlist::where('product_id', $speakerproduct->id)->where('user_id', Auth::guard('web')->user()->id)->first();
             }else{
                $wishlistCheck = '';
             }
			@endphp
            <div class="image_area speaker{{$speakerproduct->color->id}} {{ ($active == 0) ? 'active' : '' }}">
                <img src="{{asset($speakerproduct->banner_image)}}">

                <ul class="bud_specialist_list">
					@foreach($speakerFeature as $speakerFeatures)
                    <li><img src="{{asset($speakerFeatures->icon)}}"><h5>{{$speakerFeatures->name}}</h5></li>
					@endforeach
                   {{-- <li><img src="{{asset('img/charging.png')}}"><h5>Charging Case</h5></li>
                    <li><img src="{{asset('img/magnet.png')}}"><h5>Magnetic Fixing</h5></li>
                    <li><img src="{{asset('img/lighting.png')}}"><h5>200mAh</h5></li>
                    <li><img src="{{asset('img/skin-protection.png')}}"><h5>Sweat Proof</h5></li>--}}
                </ul>
                <div class="row m-0 align-items-end">
                    <div class="col-6 text-right">
                        <span class="cart_area">
                            <span>₹ {{$speakerproduct->offer_price}}</span><br/>
							@if(Auth::guard('web')->check())
							<form method="POST" action="{{route('front.cart.add')}}" >@csrf
							<input type="hidden" name="product_id" value="{{$speakerproduct->id}}">
							<input type="hidden" name="product_name" value="{{$speakerproduct->name}}">
							<input type="hidden" name="qty" value="1">
                            <button type="submit">Add to cart <span><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></span></button>
							</form>
							@else
								<a href="{{route('front.user.login')}}">Add to cart <span><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></span></a>
							@endif
                        </span>
                    </div>
					
                    <div class="col-6">
						@if(Auth::guard('web')->check())
						 <form method="POST" action="{{route('front.wishlist.add')}}" id="toggleWishlistForm">@csrf
                            <input type="hidden" name="product_id" value="{{$speakerproduct->id}}">
                           <button type="submit" class="withlist_btn {{ ($wishlistCheck) ? 'active' : '' }}">Add to wish list <span style="{{ ($wishlistCheck) ? 'background: #c1080a;' : '' }}"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></span>
                           </button>
						</form>
					@else
					
                        <a href="{{route('front.user.login')}}" class="withlist_btn" id="toggleWishlistForm">Add to wish list <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></span></a>
					@endif
                    </div>
					
                </div>
            </div>
			@endforeach
           {{-- <div class="image_area blue">
                <img src="{{asset('img/blue_tooth_speaker.png')}}">

                <ul class="bud_specialist_list">
                    <li><img src="{{asset('img/music.png')}}"><h5>Noise Reduction</h5></li>
                    <li><img src="{{asset('img/charging.png')}}"><h5>Charging Case</h5></li>
                    <li><img src="{{asset('img/magnet.png')}}"><h5>Magnetic Fixing</h5></li>
                    <li><img src="{{asset('img/lighting.png')}}"><h5>200mAh</h5></li>
                    <li><img src="{{asset('img/skin-protection.png')}}"><h5>Sweat Proof</h5></li>
                </ul>
                <div class="row m-0 align-items-end">
                    <div class="col-6 text-right">
                        <span class="cart_area">
                            <span>₹ 499</span><br/>
                            <a href="#">Add to cart <span><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></span></a>
                        </span>
                    </div>
                    <div class="col-6">
                        <a href="" class="withlist_btn">Add to wish list <span><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg></span></a>
                    </div>
                </div>
            </div>--}}
        </div>

        

        <ul class="bud_list">
			@foreach($speakerproducts as $active =>$speakerproduct)
            <li data_bud="speaker{{$speakerproduct->color->id}}" class="active"><span style="background-color: {{$speakerproduct->color->code}};"></span></li>
			@endforeach
            {{--<li data_bud="blue"><span style="background-color: #00f;"></span></li>--}}
        </ul>

        
    </div>
</section>


<section class="frying_section">
    <div class="container">
        <div class="row align-items-center">
            <div class="panel_right">
			  @foreach($nonsticktrandingproducts as $active =>$nonsticktrandingproduct)
				@php
				  $multipleImage=\App\Models\ProductImage::where('product_id',$nonsticktrandingproduct->id)->get();
				@endphp
                <div id="pan{{$nonsticktrandingproduct->id}}" class="prod_details {{ ($active == 0) ? 'active' : '' }}">
                    <div class="product_content">
                        <h2>{{$nonsticktrandingproduct->name}}</h2>
                        <h4>{!!$nonsticktrandingproduct->short_desc!!}</h4>
                        <div class="price">₹{{$nonsticktrandingproduct->offer_price}}</div>

                        <div class="thumb_banner">
                            <div class="swiper mySwiperthumb{{$active+1}}">
                                <div class="swiper-wrapper">
									@foreach($multipleImage as $index=>$multipleImages)
                                    <div class="swiper-slide">
                                        <figure>
                                            <img src="{{asset($multipleImages->image)}}">
                                        </figure>
                                    </div>
									@endforeach
                                    {{--<div class="swiper-slide">
                                        <figure>
                                            <img src="{{asset('img/pan2.png')}}">
                                        </figure>
                                    </div>--}}
                                </div>
                            </div>
                        </div>

                        {{--<h6>Available Size</h6>

                        <div class="size_box">
                            <label class="box_item"><input type="radio" name="size"><span>250 mm</span></label>
                            <label class="box_item"><input type="radio" name="size"><span>280 mm</span></label>
                            <label class="box_item"><input type="radio" name="size"><span>305 mm</span></label>
                        </div>--}}
						@if(Auth::guard('web')->check())
							<form method="POST" action="{{route('front.cart.add')}}" >@csrf
								<input type="hidden" name="product_id" value="{{$nonsticktrandingproduct->id}}">
								<input type="hidden" name="product_name" value="{{$nonsticktrandingproduct->name}}">
								<input type="hidden" name="qty" value="1">
								<button type="submit" class="btn">Add to cart <span><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></span></button>
						  </form>
						@else
								<a href="{{route('front.user.login')}}" class="btn">Add to cart <span><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></span></a>
					    @endif
                    </div>
                    <div class="product_thumb">
                        <div class="swiper mySwiper{{$active+1}}">
                            <div class="swiper-wrapper">
								@foreach($multipleImage as $index=>$multipleImages)
                                <div class="swiper-slide">
                                    <figure>
                                        <img src="{{asset($multipleImages->image)}}">
                                    </figure>
                                </div>
								@endforeach
                                {{--<div class="swiper-slide">
                                    <figure>
                                        <img src="{{asset('img/pan2.png')}}">
                                    </figure>
                                </div>--}}
                            </div>
                        </div>
                    </div>
                </div>
				@endforeach
                {{--<div id="pan3" class="prod_details">
                    <div class="product_content">
                        <h2>Non-Stick Cookware<br/>Frying Pan</h2>
                        <h4>With Glass Lid With Induction Base, Long Handle, Virgin Grade Aluminium, PFOA/Heavy Metals Free, 3mm Thickness, Pearl Red 3 Layers Reinforced Non-Stick Coating, 2.75L</h4>
                        <div class="price">₹990</div>

                        <div class="thumb_banner">
                            <div class="swiper mySwiper3">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <figure>
                                            <img src="{{asset('img/pan3.png')}}">
                                        </figure>
                                    </div>
                                    <div class="swiper-slide">
                                        <figure>
                                            <img src="{{asset('img/pan4.png')}}">
                                        </figure>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <h6>Available Size</h6>

                        <div class="size_box">
                            <label class="box_item"><input type="radio" name="size"><span>0.5L</span></label>
                            <label class="box_item"><input type="radio" name="size"><span>1L</span></label>
                            <label class="box_item"><input type="radio" name="size"><span>1.7L</span></label>
                            <label class="box_item"><input type="radio" name="size"><span>2.2L</span></label>
                            <label class="box_item"><input type="radio" name="size"><span>2.8L</span></label>

                        </div>
                        <a href="#" class="btn">Add to cart <span><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></span></a>
                    </div>
                    <div class="product_thumb">
                        <div class="swiper mySwiper4">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <figure>
                                        <img src="{{asset('img/pan3.png')}}">
                                    </figure>
                                </div>
                                <div class="swiper-slide">
                                    <figure>
                                        <img src="{{asset('img/pan4.png')}}">
                                    </figure>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>--}}

            </div>
            <div class="panel_left">
                <ul>
					 @foreach($nonsticktrandingproducts as $active =>$nonsticktrandingproduct)
                    <li data-thumb="pan{{$nonsticktrandingproduct->id}}">
                        <img src="{{asset($nonsticktrandingproduct->image)}}">
                    </li>
					@endforeach
                   {{--<li data-thumb="pan3">
                        <img src="{{asset('img/pan3.png')}}">
                    </li>
                    <li data-thumb="pan5">
                        <img src="{{asset('img/pan5.png')}}">
                    </li>
                    <li data-thumb="pan7">
                        <img src="{{asset('img/pan7.png')}}">
                    </li>
                    <li data-thumb="pan9">
                        <img src="{{asset('img/pan10.png')}}">
                    </li>--}}
                </ul>
            </div>
        </div>
    </div>
</section>





<section class="other_product_section">
    <div class="product_section_right">
        <div class="op_content">
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0" viewBox="0 0 64 64" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M59 33a1 1 0 1 1-1-1 1 1 0 0 1 1 1zm-12.778 6.222a1 1 0 0 0 1.414 1.414 9.009 9.009 0 0 1 12.728 0 1 1 0 0 0 1.414-1.414 11.012 11.012 0 0 0-15.556 0zM2 42V16a5.006 5.006 0 0 1 5-5h47a5.006 5.006 0 0 1 5 5v13a1 1 0 0 1-2 0V16a3 3 0 0 0-3-3H7a3 3 0 0 0-3 3v26a3 3 0 0 0 3 3h39a1 1 0 0 1 0 2H34v2.142l12.152 1.87a1 1 0 1 1-.3 1.976L32.923 51h-4.846l-12.925 1.988a1 1 0 0 1-.3-1.976L27 49.142V47H7a5.006 5.006 0 0 1-5-5zm27 7h3v-2h-3zm29.243-5.242a1 1 0 0 0 .707-1.707 7 7 0 0 0-9.9 0 1 1 0 0 0 1.414 1.414 5 5 0 0 1 7.072 0 1 1 0 0 0 .707.293zM54 50a3 3 0 1 1 3-3 3 3 0 0 1-3 3zm0-2a1 1 0 1 0-1-1 1 1 0 0 0 1 1z" fill="" data-original="" class=""></path></g></svg>
            <h3>FHD LED TV</h3>
            <p>5 COLLECTION</p>
        </div>
    </div>
    <div class="product_section_left">
		@php
			$hairdryerfeature=\App\Models\ProductFeature::where('product_id',$hairdryerproducts->id)->get();
					 
		    
		@endphp
        <img src="{{asset($hairdryerproducts->image)}}">

        <div class="other_content">
            <h2>{{$hairdryerproducts->name}}</h2>
            <ul>
				@foreach($hairdryerfeature as $hairdryerfeatures)
                <li><img src="{{asset($hairdryerfeatures->icon)}}"><h4>{{$hairdryerfeatures->name}}</h4></li>
				@endforeach
                {{--<li><img src="{{asset('img/thermometer.png')}}"><h4>Constant Temperature<br/>Hair Care</h4></li>
                <li><img src="{{asset('img/climate-change.png')}}"><h4>Indepandent<br/>Hot/Cold Air</h4></li>
                <li><img src="{{asset('img/recycling.png')}}"><h4>Energy Saving</h4></li>--}}
            </ul>
			@if(Auth::guard('web')->check())
				<form method="POST" action="{{route('front.cart.add')}}" >@csrf
							<input type="hidden" name="product_id" value="{{$hairdryerproducts->id}}">
							<input type="hidden" name="product_name" value="{{$hairdryerproducts->name}}">
							<input type="hidden" name="qty" value="1">
                           <button type="submit" class="latest-btm">Order Now</button>
			  </form>
			 @else
			<a href="{{route('front.user.login')}}" class="latest-btm">Order Now</a>
			@endif
        </div>
        <img src="{{asset($hairdryerproducts->banner_image)}}" class="dryer_image">
    </div>
</section>


<section class="mixer_section">
    <img src="{{asset('img/mixer_bg.png')}}">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center"><h2>Mixer Grinder</h2></div>
        </div>
        <div class="swiper mixer_slide">
            <div class="swiper-wrapper">
				@foreach($mixerproducts as $mixerproduct)
				@php
				  
				  $mixerspec=\App\Models\ProductSpecification::where('product_id',$mixerproduct->id)->get();
				@endphp
                <div class="swiper-slide">
                    <div class="row align-items-stretch">
                        <div class="col-sm-4 mixer_content">
                            <h3>{{$mixerproduct->name}}</h3>
                            <p>Starting ₹ {{$mixerproduct->price}}</p>
							@if(Auth::guard('web')->check())
							<form method="POST" class="mt-auto" action="{{route('front.cart.add')}}" >@csrf
							<input type="hidden" name="product_id" value="{{$mixerproduct->id}}">
							<input type="hidden" name="product_name" value="{{$mixerproduct->name}}">
							<input type="hidden" name="qty" value="1">
                            <button type="submit" class="btn mt-auto">Add to cart <span><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></span></button>
							</form>
							@else
							<a href="{{route('front.user.login')}}" class="btn mt-auto">Add to cart <span><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></span></a>
							@endif
                        </div>
                        <div class="col-sm-4">
                            <img src="{{asset($mixerproduct->banner_image)}}" class="mixer_img">
                        </div>
                        <div class="col-sm-4">
                            <ul class="mixer_specification">
								@foreach($mixerspec as $pro)
                                <li>
                                    <figure>
                                        <img src="{{asset($pro->icon)}}">
                                    </figure>
                                    <figcaption>
                                        <h5>{{$pro->name}}</h5>
                                        <p>{{$pro->description}}</p>
                                    </figcaption>
                                </li>
								@endforeach
                               {{-- <li>
                                    <figure>
                                        <img src="{{asset('img/voltage.svg')}}">
                                    </figure>
                                    <figcaption>
                                    <h5>Voltage</h5>
                                        <p>240 Volts</p>
                                    </figcaption>
                                </li>
                                <li>
                                    <figure>
                                        <img src="{{asset('img/speed.svg')}}">
                                    </figure>
                                    <figcaption>
                                        <h5>Number of Speeds</h5>
                                        <p>3</p>
                                    </figcaption>
                                </li>
                                <li>
                                    <figure>
                                        <img src="{{asset('img/wattage.svg')}}">
                                    </figure>
                                    <figcaption>
                                    <h5>Wattage</h5>
                                        <p>550 Watts</p>
                                    </figcaption>
                                </li>--}}
                            </ul>

                            <ul class="video_list">
                                <li>
                                    <span class="play_btn">
                                        <img src="{{asset('img/play.png')}}">
                                    </span>
                                    <a href="https://www.youtube.com/watch?v=6rZCmINXBA4">
                                        <img src="https://img.youtube.com/vi/6rZCmINXBA4/0.jpg">
                                    </a>
                                </li>
                                <li>
                                    <span class="play_btn">
                                        <img src="{{asset('img/play.png')}}">
                                    </span>
                                    <a href="https://www.youtube.com/watch?v=a7P7mFXjul0">
                                        <img src="https://img.youtube.com/vi/a7P7mFXjul0/0.jpg">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
				@endforeach
                {{--<div class="swiper-slide">
                    <div class="row align-items-stretch">
                        <div class="col-sm-4 mixer_content">
                            <h3>KGA 2jar Fighter Mixer Grinder</h3>
                            <p>Starting ₹ 2,219</p>
                            <a href="#" class="btn mt-auto">Add to cart <span><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></span></a>
                        </div>
                        <div class="col-sm-4">
                            <img src="{{asset('img/mixer_2.png')}}" class="mixer_img">
                        </div>
                        <div class="col-sm-4">
                            <ul class="mixer_specification">
                                <li>
                                    <figure>
                                        <img src="{{asset('img/material.svg')}}">
                                    </figure>
                                    <figcaption>
                                        <h5>Material</h5>
                                        <p>ABS Plastic</p>
                                    </figcaption>
                                </li>
                                <li>
                                    <figure>
                                        <img src="{{asset('img/voltage.svg')}}">
                                    </figure>
                                    <figcaption>
                                    <h5>Voltage</h5>
                                        <p>240 Volts</p>
                                    </figcaption>
                                </li>
                                <li>
                                    <figure>
                                        <img src="{{asset('img/speed.svg')}}">
                                    </figure>
                                    <figcaption>
                                        <h5>Number of Speeds</h5>
                                        <p>3</p>
                                    </figcaption>
                                </li>
                                <li>
                                    <figure>
                                        <img src="{{asset('img/wattage.svg')}}">
                                    </figure>
                                    <figcaption>
                                    <h5>Wattage</h5>
                                        <p>550 Watts</p>
                                    </figcaption>
                                </li>
                            </ul>

                            <ul class="video_list">
                                <li>
                                    <span class="play_btn">
                                        <img src="{{asset('img/play.png')}}">
                                    </span>
                                    <a href="https://www.youtube.com/watch?v=6rZCmINXBA4">
                                        <img src="https://img.youtube.com/vi/6rZCmINXBA4/0.jpg">
                                    </a>
                                </li>
                                <li>
                                    <span class="play_btn">
                                        <img src="{{asset('img/play.png')}}">
                                    </span>
                                    <a href="https://www.youtube.com/watch?v=a7P7mFXjul0">
                                        <img src="https://img.youtube.com/vi/a7P7mFXjul0/0.jpg">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="row align-items-stretch">
                        <div class="col-sm-4 mixer_content">
                            <h3>KGA Royal Red Mixer Grinder</h3>
                            <p>Starting ₹ 2,219</p>
                            <a href="#" class="btn mt-auto">Add to cart <span><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></span></a>
                        </div>
                        <div class="col-sm-4">
                            <img src="{{asset('img/mixer_3.png')}}" class="mixer_img">
                        </div>
                        <div class="col-sm-4">
                            <ul class="mixer_specification">
                                <li>
                                    <figure>
                                        <img src="{{asset('img/material.svg')}}">
                                    </figure>
                                    <figcaption>
                                        <h5>Material</h5>
                                        <p>ABS Plastic</p>
                                    </figcaption>
                                </li>
                                <li>
                                    <figure>
                                        <img src="{{asset('img/voltage.svg')}}">
                                    </figure>
                                    <figcaption>
                                    <h5>Voltage</h5>
                                        <p>240 Volts</p>
                                    </figcaption>
                                </li>
                                <li>
                                    <figure>
                                        <img src="{{asset('img/speed.svg')}}">
                                    </figure>
                                    <figcaption>
                                        <h5>Number of Speeds</h5>
                                        <p>3</p>
                                    </figcaption>
                                </li>
                                <li>
                                    <figure>
                                        <img src="{{asset('img/wattage.svg')}}">
                                    </figure>
                                    <figcaption>
                                    <h5>Wattage</h5>
                                        <p>550 Watts</p>
                                    </figcaption>
                                </li>
                            </ul>

                            <ul class="video_list">
                                <li>
                                    <span class="play_btn">
                                        <img src="{{asset('img/play.png')}}">
                                    </span>
                                    <a href="https://www.youtube.com/watch?v=6rZCmINXBA4">
                                        <img src="https://img.youtube.com/vi/6rZCmINXBA4/0.jpg">
                                    </a>
                                </li>
                                <li>
                                    <span class="play_btn">
                                        <img src="{{asset('img/play.png')}}">
                                    </span>
                                    <a href="https://www.youtube.com/watch?v=a7P7mFXjul0">
                                        <img src="https://img.youtube.com/vi/a7P7mFXjul0/0.jpg">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>--}}

            </div>
        </div>


        <div class="row justify-content-center">
            <div class="col-sm-6">
                <div class="swiper mixer_thumb">
                    <div class="swiper-wrapper">
						@foreach($mixerproducts as $mixerproduct)
                        <div class="swiper-slide">
                            <figure>
                                <img src="{{asset($mixerproduct->banner_image)}}">
                            </figure>
                        </div>
						@endforeach
                        {{--<div class="swiper-slide">
                            <figure>
                                <img src="{{asset('img/mixer_2.png')}}">
                            </figure>
                        </div>
                        <div class="swiper-slide">
                            <figure>
                                <img src="{{asset('img/mixer_3.png')}}">
                            </figure>
                        </div>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="first_category">
    <div class="sandwitch_block">
		        @php
				  $sandwitchfeature=\App\Models\ProductFeature::where('product_id',$sandwichproducts->id)->get();
				  $sandwitchreviewLink=\App\Models\ProductReviewVideo::where('product_id',$sandwichproducts->id)->first();
		       
				@endphp
        <div class="row flex-column-reverse flex-sm-row">
            <div class="col-sm-7 pl-0">
                <img src="{{asset($sandwichproducts->banner_image)}}" class="img-fluid">
            </div>
            <div class="col-sm-5 text-center text-sm-left">
                <h3>{{$sandwichproducts->name}}</h3>
                <ul class="toaster_list">
					@foreach($sandwitchfeature as $item)
                    <li><img src="{{asset($item->icon)}}"><h6>{{$item->name}}</h6></li>
					@endforeach
                    {{--<li><img src="{{asset('img/flash.png')}}"><h6>800W High Power</h6></li>
                    <li><img src="{{asset('img/air-conditioning.png')}}"><h6>2 Interchangeable Plates</h6></li>
                    <li><img src="{{asset('img/auto_popup.png')}}"><h6>Aluminium Plates</h6></li>
                    <li><img src="{{asset('img/wide.png')}}"><h6>Ultra-Resistant 3-Layer Non-Stick Coating</h6></li>--}}
                </ul>
				@if(Auth::guard('web')->check())
							<form method="POST" action="{{route('front.cart.add')}}" >@csrf
							<input type="hidden" name="product_id" value="{{$sandwichproducts->id}}">
							<input type="hidden" name="product_name" value="{{$sandwichproducts->name}}">
							<input type="hidden" name="qty" value="1">
               			    <button type="submit" class="btn">Add to cart <span><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></span></button>
				</form>
				@else
				<a href="{{route('front.user.login')}}" class="btn">Add to cart <span><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></span></a>
				@endif
				@if(!empty($sandwitchreviewLink))
                <a class="play_btn" target="_blank" href="{{$sandwitchreviewLink->link }}">
                    <img src="{{asset('img/play.png')}}">
                </a>
				@endif
            </div>
        </div>
    </div>
    <div class="toaster_block">
		       @php
				  $toasterfeature=\App\Models\ProductSpecification::where('product_id',$toasterproducts->id)->get();
				 $toasterreviewLink=\App\Models\ProductReviewVideo::where('product_id',$toasterproducts->id)->first();
				@endphp
        <div class="row align-items-center">
            <div class="col-sm-5 text-center text-sm-left">
                <h3>{{$toasterproducts->name}}</h3>
                <ul class="toaster_list">
					@foreach($toasterfeature as $item)
                    <li><img src="{{asset($item->icon)}}"><h6>{{$item->name}}</h6></li>
					@endforeach
                    {{--<li><img src="{{asset('img/air-conditioning.png')}}"><h6>7 Heating Mode</h6></li>
                    <li><img src="{{asset('img/flash.png')}}"><h6>950W High Power</h6></li>
                    <li><img src="{{asset('img/auto_popup.png')}}"><h6>Auto Pop-up</h6></li>
                    <li><img src="{{asset('img/wide.png')}}"><h6>Extra Wide Bread Slop</h6></li>--}}
                </ul>
				 @if(Auth::guard('web')->check())
					<form method="POST" action="{{route('front.cart.add')}}" >@csrf
					<input type="hidden" name="product_id" value="{{$toasterproducts->id}}">
					<input type="hidden" name="product_name" value="{{$toasterproducts->name}}">
					<input type="hidden" name="qty" value="1">
                	<button type="submit" class="btn">Add to cart <span><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></span></button>
				    </form>
				@else
						<a href="{{route('front.user.login')}}" class="btn">Add to cart <span><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right"><polyline points="9 18 15 12 9 6"></polyline></svg></span></a>
				@endif
				@if(!empty($toasterreviewLink))
                <a class="play_btn" target="_blank" href="{{$toasterreviewLink->link }}">
                    <img src="{{asset('img/play.png')}}">
                </a>
				@endif
            </div>
            <div class="col-sm-7">
                <img src="{{asset($toasterproducts->banner_image)}}" class="img-fluid">
            </div>
        </div>
    </div>
</section>



<section class="earphone_section">
    <div class="earphone_left">
        <div class="ear_content">
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M131.15 80.64c-10.48 0-18.98 8.5-18.98 18.98v49.67c0 10.48 8.5 18.98 18.98 18.98s18.98-8.5 18.98-18.98V99.62c-.01-10.48-8.5-18.98-18.98-18.98zM449.17 193.13c-5.63-8.85-17.36-11.45-26.2-5.83l-41.88 26.65c-8.84 5.63-11.45 17.35-5.82 26.19v.01c5.63 8.85 17.36 11.45 26.2 5.83l41.88-26.65c8.84-5.63 11.44-17.36 5.82-26.2z" fill="" data-original="" class=""></path><path d="M275.36 150.32a70.767 70.767 0 0 0-23.11-53.16c-1.43-1.3-3.64-1.2-4.94.23s-1.2 3.64.23 4.94a63.786 63.786 0 0 1 20.82 47.9c-.2 16.27-6.6 31.73-18.04 43.52s-26.68 18.66-42.93 19.33c-11.28.47-22.14-1.94-31.9-7.01 14.29-1.84 27.94-7.67 39.3-16.91 14.69-11.95 23.78-28.31 25.59-46.06 3.27-31.96-5.67-50.78-15.93-68.8-10.56-18.54-26.45-32.96-45.94-41.67l-28.97-12.95c-20.12-8.99-42.54-9.61-63.12-1.74-24.71 9.46-43.51 30.38-50.27 55.97l-1.23 4.66c-8.02 30.35 2.18 63.19 25.99 83.66l34.51 29.66c.02 1.15.04 2.3.04 3.46v147.69c0 9.65 7.85 17.5 17.5 17.5h36.44c9.65 0 17.5-7.85 17.5-17.5V209.18c11.27 7.13 24.46 10.96 37.88 10.96.97 0 1.94-.02 2.91-.06 18.04-.75 34.97-8.36 47.66-21.45 12.68-13.08 19.79-30.24 20.01-48.31zm-99.13-29.21c-1.84-.62-3.82.36-4.44 2.2l-.03.1a222.722 222.722 0 0 0-11.87 71.83v133.91h-28.74c-1.93 0-3.5 1.57-3.5 3.5s1.57 3.5 3.5 3.5h28.74v6.91c0 5.79-4.71 10.5-10.5 10.5h-36.44c-5.79 0-10.5-4.71-10.5-10.5V195.35c0-1.78-.03-3.56-.07-5.34V190a222.79 222.79 0 0 0-11.88-66.71 3.489 3.489 0 0 0-4.44-2.18 3.489 3.489 0 0 0-2.18 4.44 215.665 215.665 0 0 1 11.18 56.8l-29.59-25.43c-21.79-18.73-31.12-48.78-23.78-76.56l1.23-4.66c6.19-23.42 23.39-42.56 46.01-51.22 18.84-7.21 39.35-6.64 57.76 1.59l28.97 12.95c18.12 8.1 32.9 21.5 42.72 38.76 9.67 16.99 18.11 34.72 15.05 64.62-3.22 31.45-32.82 56.68-66.53 57.29v-4.45c0-23.71 3.87-47.12 11.5-69.58l.04-.1c.6-1.85-.38-3.83-2.21-4.45zM470.98 197.49l-.89-1.83a84.745 84.745 0 0 0-43.22-40.93c-18.91-7.98-40.15-8.84-59.82-2.45l-3.05.99a147.129 147.129 0 0 0-65.73 43.63l-25.12 29.03c-2.75.68-5.39 1.76-7.83 3.24-22.79 13.79-36.58 37.9-36.88 64.48-.48 41.66 32.97 76.32 74.58 77.27.59.01 1.17.02 1.76.02 3.52 0 7.05-.24 10.51-.72 13.79-1.9 25.83-9.05 34.14-19.6 3.1.31 6.21.47 9.3.47 20.27 0 40.03-6.57 56.3-18.76v135.75h-28.72c-1.93 0-3.5 1.57-3.5 3.5s1.57 3.5 3.5 3.5h28.72V482c0 5.79-4.71 10.5-10.5 10.5h-36.44c-5.79 0-10.5-4.71-10.5-10.5V364.28c0-1.93-1.57-3.5-3.5-3.5s-3.5 1.57-3.5 3.5V482c0 9.65 7.85 17.5 17.5 17.5h36.44c9.65 0 17.5-7.85 17.5-17.5V326.56l28.77-25.78c28.91-25.91 37.21-68.39 20.18-103.29zm-184.89 156.9a20.73 20.73 0 0 1-7.74 4.26h-.01c-22.01-9.16-38.34-29.37-42.09-53.51a21.24 21.24 0 0 1 3.62-4.07c8.8-7.63 22.16-6.67 29.79 2.12l18.55 21.4c3.7 4.26 5.51 9.71 5.11 15.33s-2.97 10.78-7.23 14.47zm59.15-9.88c-.23.24-.42.5-.57.79-7.23 9.69-17.99 16.27-30.35 17.98-3.67.51-7.42.72-11.15.63a68.33 68.33 0 0 1-15.3-2.1c.97-.65 1.91-1.36 2.81-2.14 5.67-4.92 9.09-11.75 9.63-19.25.53-7.49-1.88-14.74-6.8-20.42l-18.55-21.4c-10.11-11.66-27.79-12.97-39.5-2.96-.01-.64-.03-1.28-.03-1.93.28-24.15 12.81-46.05 33.51-58.58 3.33-2.02 7.16-3.06 11.14-3.06.52 0 1.04.02 1.56.05l1.36.09c40.39 2.84 72.03 36.82 72.03 77.38 0 6.04-.7 12.06-2.08 17.88-1.51 6.33-4.16 12.07-7.71 17.04zm100.87-48.94-29.38 26.33a86.927 86.927 0 0 1-62.82 22.05c2.59-4.54 4.58-9.52 5.84-14.85 1.5-6.35 2.26-12.91 2.26-19.49 0-44.21-34.5-81.27-78.55-84.36l-.46-.03 20.55-23.74a140.159 140.159 0 0 1 62.61-41.55l3.05-.99c18.07-5.88 37.57-5.08 54.93 2.24a77.743 77.743 0 0 1 39.65 37.55l.89 1.83c15.68 32.1 8.03 71.17-18.57 95.01zM278.02 409.57a3.5 3.5 0 0 0-4-2.91 3.5 3.5 0 0 0-2.91 4l4.07 25.72a3.498 3.498 0 0 0 3.45 2.95c.18 0 .37-.01.55-.04a3.5 3.5 0 0 0 2.91-4zM196.8 382.69l-17.91 18.9a3.505 3.505 0 0 0 .13 4.95 3.508 3.508 0 0 0 4.95-.13l17.91-18.9a3.505 3.505 0 0 0-.13-4.95 3.505 3.505 0 0 0-4.95.13zM270.38 61.87a3.492 3.492 0 0 0 4.65-1.69l11.04-23.58a3.498 3.498 0 1 0-6.34-2.96l-11.04 23.58a3.498 3.498 0 0 0 1.69 4.65zM320.14 125.08c.25 0 .5-.03.76-.08l25.43-5.61c1.89-.42 3.08-2.28 2.66-4.17s-2.28-3.08-4.17-2.66l-25.43 5.61a3.492 3.492 0 0 0-2.66 4.17c.35 1.63 1.8 2.74 3.41 2.74z" fill="" data-original="" class=""></path></g></svg>
            <h3>WIRELESS STEREO EARBUDS</h3>
            <p>{{$earbudproducts->count()}} Collection</p>
        </div>
    </div>
    <div class="earphone_right">
        <div class="swiper bud_slider">
            <div class="swiper-wrapper">
				@foreach($earbudproducts as $earbudproduct)
				@php
		            $earbudproductfeatures=\App\Models\ProductFeature::where('product_id',$earbudproduct->id)->get();
		            
	           @endphp
                <div class="swiper-slide">
                    <img src="{{asset($earbudproduct->banner_image)}}">

                    <div class="earphone_content_left">
                        <div class="battery_time">
                            42 <span>Hrs</span><div>Playtime</div>
                        </div>
						@if(Auth::guard('web')->check())
						<form method="POST" action="{{route('front.cart.add')}}" >@csrf
							<input type="hidden" name="product_id" value="{{$earbudproduct->id}}">
							<input type="hidden" name="product_name" value="{{$earbudproduct->name}}">
							<input type="hidden" name="qty" value="1">
                            <button type="submit" class="latest-btm">Order Now</button>
						</form>
						@else
							<a href="{{route('front.user.login')}}" class="latest-btm">Order Now</a>
						@endif
                    </div>
                    <div class="earphone_content_right">
                        <h6>KGA</h6>
                        <h2>{{$earbudproduct->name}}</h2>
                        <h6>{{$earbudproduct->sub_heading}}</h6>
                        <ul>
							@foreach($earbudproductfeatures as $earbudproductfeature)
                            <li>{{$earbudproductfeature->name}}</li>
							@endforeach
                            {{--<li>10M Communication Distance</li>--}}
                        </ul>
                    </div>
                </div>
                @endforeach
               {{-- <div class="swiper-slide">
                    <img src="{{asset('img/bumble_beats.png')}}">

                    <div class="earphone_content_left">
                        <div class="battery_time">
                            50 <span>Hrs</span><div>Playtime</div>
                        </div>
                        <a href="#" class="latest-btm">Order Now</a>
                    </div>
                    <div class="earphone_content_right">
                        <h6>KGA</h6>
                        <h2>Bumble Beats</h2>
                        <h6>Wireless Stereo Earbuds</h6>
                        <ul>
                            <li>Crystal Clear Acoustics</li>
                            <li>50ms Super Low Latency</li>
                            <li>Type C Charging</li>
                        </ul>
                    </div>
                </div>
                <div class="swiper-slide">
                    <img src="{{asset('img/black_panther.png')}}">

                    <div class="earphone_content_left">
                        <div class="battery_time">
                            50 <span>Hrs</span><div>Playtime</div>
                        </div>
                        <a href="#" class="latest-btm">Order Now</a>
                    </div>
                    <div class="earphone_content_right">
                        <h6>KGA</h6>
                        <h2>Black Panther</h2>
                        <h6>Wireless Stereo Earbuds</h6>
                        <ul>
                            <li>Crystal Clear Acoustics</li>
                            <li>50ms Super Low Latency</li>
                            <li>Type C Charging</li>
                        </ul>
                    </div>
                </div>--}}

            </div>

            <div class="swiper-pagination"></div>
            <div class="swiper-button-next bud-next"></div>
            <div class="swiper-button-prev bud-prev"></div>
        </div>
        
    </div>
</section>



<section class="headphone_section">
    <div class="headphone_left">
        
		@php
		   $earphoneproductfeatures=\App\Models\ProductFeature::where('product_id',$earphoneproducts->id)->get();
		   $earphoneCount=\App\Models\Product::where('cat_id',77)->where('status',1)->count();
	    @endphp
        <div class="headphone_content">
            <h6>KGA</h6>
            <h2>{{$earphoneproducts->name}}</h2>
            <ul>
				@foreach($earphoneproductfeatures as $earphoneproductfeature)
                <li>{{$earphoneproductfeature->name}}</li>
				@endforeach
               {{-- <li>High quality Microphone</li>
                <li>Very Comfortable for ears</li>--}}
            </ul>
			@if(Auth::guard('web')->check())
				<form method="POST" action="{{route('front.cart.add')}}" >@csrf
					<input type="hidden" name="product_id" value="{{$earphoneproducts->id}}">
					<input type="hidden" name="product_name" value="{{$earphoneproducts->name}}">
					<input type="hidden" name="qty" value="1">
                   <button type="submit" class="latest-btn-white">Order Now</button>
				</form>
			@else
				 <a href="{{route('front.user.login')}}" class="latest-btn-white">Order Now</a>
			@endif
        </div>

        <img src="{{asset($earphoneproducts->banner_image)}}">
    </div>
    <div class="headphone_right">
        <div class="ear_content">
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="512" height="512" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M131.15 80.64c-10.48 0-18.98 8.5-18.98 18.98v49.67c0 10.48 8.5 18.98 18.98 18.98s18.98-8.5 18.98-18.98V99.62c-.01-10.48-8.5-18.98-18.98-18.98zM449.17 193.13c-5.63-8.85-17.36-11.45-26.2-5.83l-41.88 26.65c-8.84 5.63-11.45 17.35-5.82 26.19v.01c5.63 8.85 17.36 11.45 26.2 5.83l41.88-26.65c8.84-5.63 11.44-17.36 5.82-26.2z" fill="" data-original="" class=""></path><path d="M275.36 150.32a70.767 70.767 0 0 0-23.11-53.16c-1.43-1.3-3.64-1.2-4.94.23s-1.2 3.64.23 4.94a63.786 63.786 0 0 1 20.82 47.9c-.2 16.27-6.6 31.73-18.04 43.52s-26.68 18.66-42.93 19.33c-11.28.47-22.14-1.94-31.9-7.01 14.29-1.84 27.94-7.67 39.3-16.91 14.69-11.95 23.78-28.31 25.59-46.06 3.27-31.96-5.67-50.78-15.93-68.8-10.56-18.54-26.45-32.96-45.94-41.67l-28.97-12.95c-20.12-8.99-42.54-9.61-63.12-1.74-24.71 9.46-43.51 30.38-50.27 55.97l-1.23 4.66c-8.02 30.35 2.18 63.19 25.99 83.66l34.51 29.66c.02 1.15.04 2.3.04 3.46v147.69c0 9.65 7.85 17.5 17.5 17.5h36.44c9.65 0 17.5-7.85 17.5-17.5V209.18c11.27 7.13 24.46 10.96 37.88 10.96.97 0 1.94-.02 2.91-.06 18.04-.75 34.97-8.36 47.66-21.45 12.68-13.08 19.79-30.24 20.01-48.31zm-99.13-29.21c-1.84-.62-3.82.36-4.44 2.2l-.03.1a222.722 222.722 0 0 0-11.87 71.83v133.91h-28.74c-1.93 0-3.5 1.57-3.5 3.5s1.57 3.5 3.5 3.5h28.74v6.91c0 5.79-4.71 10.5-10.5 10.5h-36.44c-5.79 0-10.5-4.71-10.5-10.5V195.35c0-1.78-.03-3.56-.07-5.34V190a222.79 222.79 0 0 0-11.88-66.71 3.489 3.489 0 0 0-4.44-2.18 3.489 3.489 0 0 0-2.18 4.44 215.665 215.665 0 0 1 11.18 56.8l-29.59-25.43c-21.79-18.73-31.12-48.78-23.78-76.56l1.23-4.66c6.19-23.42 23.39-42.56 46.01-51.22 18.84-7.21 39.35-6.64 57.76 1.59l28.97 12.95c18.12 8.1 32.9 21.5 42.72 38.76 9.67 16.99 18.11 34.72 15.05 64.62-3.22 31.45-32.82 56.68-66.53 57.29v-4.45c0-23.71 3.87-47.12 11.5-69.58l.04-.1c.6-1.85-.38-3.83-2.21-4.45zM470.98 197.49l-.89-1.83a84.745 84.745 0 0 0-43.22-40.93c-18.91-7.98-40.15-8.84-59.82-2.45l-3.05.99a147.129 147.129 0 0 0-65.73 43.63l-25.12 29.03c-2.75.68-5.39 1.76-7.83 3.24-22.79 13.79-36.58 37.9-36.88 64.48-.48 41.66 32.97 76.32 74.58 77.27.59.01 1.17.02 1.76.02 3.52 0 7.05-.24 10.51-.72 13.79-1.9 25.83-9.05 34.14-19.6 3.1.31 6.21.47 9.3.47 20.27 0 40.03-6.57 56.3-18.76v135.75h-28.72c-1.93 0-3.5 1.57-3.5 3.5s1.57 3.5 3.5 3.5h28.72V482c0 5.79-4.71 10.5-10.5 10.5h-36.44c-5.79 0-10.5-4.71-10.5-10.5V364.28c0-1.93-1.57-3.5-3.5-3.5s-3.5 1.57-3.5 3.5V482c0 9.65 7.85 17.5 17.5 17.5h36.44c9.65 0 17.5-7.85 17.5-17.5V326.56l28.77-25.78c28.91-25.91 37.21-68.39 20.18-103.29zm-184.89 156.9a20.73 20.73 0 0 1-7.74 4.26h-.01c-22.01-9.16-38.34-29.37-42.09-53.51a21.24 21.24 0 0 1 3.62-4.07c8.8-7.63 22.16-6.67 29.79 2.12l18.55 21.4c3.7 4.26 5.51 9.71 5.11 15.33s-2.97 10.78-7.23 14.47zm59.15-9.88c-.23.24-.42.5-.57.79-7.23 9.69-17.99 16.27-30.35 17.98-3.67.51-7.42.72-11.15.63a68.33 68.33 0 0 1-15.3-2.1c.97-.65 1.91-1.36 2.81-2.14 5.67-4.92 9.09-11.75 9.63-19.25.53-7.49-1.88-14.74-6.8-20.42l-18.55-21.4c-10.11-11.66-27.79-12.97-39.5-2.96-.01-.64-.03-1.28-.03-1.93.28-24.15 12.81-46.05 33.51-58.58 3.33-2.02 7.16-3.06 11.14-3.06.52 0 1.04.02 1.56.05l1.36.09c40.39 2.84 72.03 36.82 72.03 77.38 0 6.04-.7 12.06-2.08 17.88-1.51 6.33-4.16 12.07-7.71 17.04zm100.87-48.94-29.38 26.33a86.927 86.927 0 0 1-62.82 22.05c2.59-4.54 4.58-9.52 5.84-14.85 1.5-6.35 2.26-12.91 2.26-19.49 0-44.21-34.5-81.27-78.55-84.36l-.46-.03 20.55-23.74a140.159 140.159 0 0 1 62.61-41.55l3.05-.99c18.07-5.88 37.57-5.08 54.93 2.24a77.743 77.743 0 0 1 39.65 37.55l.89 1.83c15.68 32.1 8.03 71.17-18.57 95.01zM278.02 409.57a3.5 3.5 0 0 0-4-2.91 3.5 3.5 0 0 0-2.91 4l4.07 25.72a3.498 3.498 0 0 0 3.45 2.95c.18 0 .37-.01.55-.04a3.5 3.5 0 0 0 2.91-4zM196.8 382.69l-17.91 18.9a3.505 3.505 0 0 0 .13 4.95 3.508 3.508 0 0 0 4.95-.13l17.91-18.9a3.505 3.505 0 0 0-.13-4.95 3.505 3.505 0 0 0-4.95.13zM270.38 61.87a3.492 3.492 0 0 0 4.65-1.69l11.04-23.58a3.498 3.498 0 1 0-6.34-2.96l-11.04 23.58a3.498 3.498 0 0 0 1.69 4.65zM320.14 125.08c.25 0 .5-.03.76-.08l25.43-5.61c1.89-.42 3.08-2.28 2.66-4.17s-2.28-3.08-4.17-2.66l-25.43 5.61a3.492 3.492 0 0 0-2.66 4.17c.35 1.63 1.8 2.74 3.41 2.74z" fill="" data-original="" class=""></path></g></svg>
            <h3>Wired Earphones</h3>
            <p>{{$earphoneCount}} Collection</p>
        </div>
    </div>
</section>


<section class="cook_section">
	
	@php
		$mouseproductfeatures=\App\Models\ProductFeature::where('product_id',$mouseproducts->id)->get();
				  
	@endphp
    <div class="mouse_block">
        <img src="{{asset($mouseproducts->banner_image)}}">

        <div class="mouse_content">
            <h6>KGA - {{$mouseproducts->sub_heading}}</h6>
            <h2>{{$mouseproducts->name}}</h2>

            <ul class="mouse_list">
				@foreach($mouseproductfeatures as $mouseproductfeature)
                <li><img src="{{asset($mouseproductfeature->icon)}}"><h6>MAC OS</h6></li>
				@endforeach
                {{--<li><img src="{{asset('img/windows-logo.png')}}"><h6>Windows</h6></li>
                <li><img src="{{asset('img/usb-icon.png')}}"><h6>USB Type</h6></li>
                <li><img src="{{asset('img/cable.png')}}"><h6>1 meter</h6></li>
                <li><img src="{{asset('img/energy.png')}}"><h6>Plug & Play</h6></li>--}}
            </ul>
			@if(Auth::guard('web')->check())
				<form method="POST" action="{{route('front.cart.add')}}" >@csrf
					<input type="hidden" name="product_id" value="{{$mouseproducts->id}}">
					<input type="hidden" name="product_name" value="{{$mouseproducts->name}}">
					<input type="hidden" name="qty" value="1">
            		<button type="submit" class="mt-auto latest-btm">Order Now</button>
			    </form>
			@else
				 <a href="{{route('front.user.login')}}" class="mt-auto latest-btm">Order Now</a>
		   @endif
        </div>
    </div>
   
    <div class="cooker_block">
        <div class="cooker_content">
            <h6>KGA</h6>
			@foreach($inductionproducts as $active => $inductionproduct)
			<div id="cook{{$inductionproduct->id}}" class="cooker_data_content {{ ($active == 0) ? 'active' : '' }}">
				<h2>{{$inductionproduct->name}}</h2>
				<p>{!!$inductionproduct->short_desc!!}</p>
				@if(Auth::guard('web')->check())
				<form method="POST" action="{{route('front.cart.add')}}" >@csrf
					<input type="hidden" name="product_id" value="{{$inductionproduct->id}}">
					<input type="hidden" name="product_name" value="{{$inductionproduct->name}}">
					<input type="hidden" name="qty" value="1">
            		<button type="submit" class="mt-auto latest-btm">Order Now</button>
			    </form>
			@else
				 <a href="{{route('front.user.login')}}" class="mt-auto latest-btm">Order Now</a>
		   @endif
				
			</div>
			@endforeach
			{{--<div id="cookA4161" class="cooker_image">
				<h2>{{$inductionproducts->name}}</h2>
				<p>{!!$inductionproducts->short_desc!!}</p>
				<a href="#" class="mt-auto latest-btm">Order Now</a>
			</div>
			<div id="cookA4161" class="cooker_image">
				<h2>{{$inductionproducts->name}}</h2>
				<p>{!!$inductionproducts->short_desc!!}</p>
				<a href="#" class="mt-auto latest-btm">Order Now</a>
			</div>--}}


            <ul class="cooker_list">
				@foreach($inductionproducts as $active  => $inductionproduct)
                <li data-image="{{$inductionproduct->id}}" class="{{ ($active == 0) ? 'active' : '' }}">
                    <img src="{{asset($inductionproduct->banner_image)}}">
                </li>
				@endforeach
                {{--<li data-image="A4170">
                    <img src="{{asset('img/0W8A4170.png')}}">
                </li>
                <li data-image="A4178">
                    <img src="{{asset('img/0W8A4178.png')}}">
                </li>--}}
            </ul>
        </div>
        <div class="cooker_image">
			@foreach($inductionproducts as $active => $inductionproduct)
            <div id="{{$inductionproduct->id}}" class="cooker_data_image {{ ($active == 0) ? 'active' : '' }}">
                <img src="{{asset($inductionproduct->banner_image)}}">
            </div>
			@endforeach
            {{--<div id="A4170" class="cooker_data_image">
                <img src="{{asset('img/0W8A4170.png')}}">
            </div>
            <div id="A4178" class="cooker_data_image">
                <img src="{{asset('img/0W8A4178.png')}}">
            </div>--}}
        </div>
    </div>
</section>


<section class="review_section">
    <div class="swiper review_slider">
        <div class="swiper-wrapper">
			@foreach($productReview as $productReviews)
            <div class="swiper-slide">
                <div class="review_block">
                    <div class="review_text">
                        <h4>{{$productReviews->title}}</h4>
                        <p>{{$productReviews->description}}</p>
                    </div>
                    
                    <div class="review_meta">
                        <img src="https://ui-avatars.com/api/?name= {{$productReviews->created_by}}">
                        <div class="author_name">
                            {{$productReviews->created_by}}
                        </div>
                    </div>
                </div>
            </div>
			@endforeach
          {{--  <div class="swiper-slide">
                <div class="review_block">
                    <div class="review_text">
                        <h4>Worth for money!! Very nice quality</h4>
                        <p>Great looking and Red color i love it and mixing is good. This grinding machine i bought it in June 8th daily it used for light work twice till now no issues thanks!</p>
                    </div>
                    <div class="review_meta">
                        <img src="https://ui-avatars.com/api/?name=Anil+G">
                        <div class="author_name">
                            Anil G.
                        </div>
                    </div>
                </div>
            </div>
            <div class="swiper-slide">
                <div class="review_block">
                    <div class="review_text">
                        <h4>Good quality! Reasonable price!</h4>
                        <p>Very nice shiny body. Working very well. I made my dosa batter in the grinding jar and I am very happy with the performance. Easy to use & easy to clean. Value for money.</p>
                    </div>
                    <div class="review_meta">
                        <img src="https://ui-avatars.com/api/?name=Naman">
                        <div class="author_name">
                            Naman
                        </div>
                    </div>
                </div>
            </div>--}}
        </div>
        <div class="swiper-button-next review-next"></div>
        <div class="swiper-button-prev review-prev"></div>
    </div>
</section>



<?php /* ?>

<section class="category-section">
    <div class="cat-left">
        <figure>
            <img src="{{asset('img/kadai.svg')}}">
        </figure>
        <figcaption>
            <h3>Deep Kadai</h3>
            <p>Collection</p>
        </figcaption>
    </div>
    <div class="cat-product">
        <div class="product-holder">
            <div class="pro-details-place">
                <p>KGA Utensils are high quality and are a perfect choice for your modern kitchens.</p>
                <div class="proprice">₹1100</div>
                <a href="#" class="add-fav-icon"><i class="flaticon-heart"></i> Add To Favs</a>
            </div>
            <div class="pro-image">
                <img src="{{asset('img/DEEP-KADAI.png')}}">
            </div>
            <div class="Pro-name">
                <h2>Non-Stick Cookware Deep Kadai </h2>
                <a href="#" class="latest-btm">Order Now</a>
            </div>
        </div>
    </div>
</section>


<section class="category-section cat-bottle-color">

    <div class="cat-product">
        <div class="product-holder">
            <div class="pro-details-place">
                <p>KGA Bottle are high quality and are a perfect choice for the world traveller.</p>
                <div class="proprice">₹499</div>
                <a href="#" class="add-fav-icon"><i class="flaticon-heart"></i> Add To Favs</a>
            </div>
            <div class="pro-image">
                <img src="{{asset('img/kga-bottle.png')}}">
            </div>
            <div class="Pro-name">
                <h2>Travel Stainless Steel Sports Water Bottle </h2>
                <a href="#" class="latest-btm">Order Now</a>
            </div>
        </div>
    </div>
    <div class="cat-left">
        <figure>
            <img src="{{asset('img/waterbottle.svg')}}">
        </figure>
        <figcaption>
            <h3>Bottle</h3>
            <p>Collection</p>
        </figcaption>
    </div>
</section>


<section class="quater_banner">
    <div class="container">
        <div class="row m-0 ">
			@foreach ($featureBanner as $item)
                @php
                    $banImgVal = str_replace('public/','',$item->file_path);
                @endphp
			 @if ($item->type == 'video')
                        <div class="col-sm-4 mb-3  mb-sm-0">
                            <video id="onn-video" width="320" height="240" autoplay muted loop playsinline>
                                <source src="{{ asset($banImgVal) }}" type="video/mp4">
                                Your browser does not support the video tag.
                            </video>
                        </div>
                        @else
            <div class="col-sm-4 mb-3  mb-sm-0">
                <a href="#" class="image-style">
                    <img src="{{ asset($banImgVal) }}" />
                </a>
            </div>
			@endif
            {{--<div class="col-sm-4 mb-3  mb-sm-0">
                <a href="#" class="image-style">
                    <img src="img/kga_banner_4.png" />
                </a>
            </div>
            <div class="col-sm-4">
                <a href="#" class="image-style">
                    <img src="img/kga_banner_5.png" />
                </a>
            </div>--}}
			 @endforeach           
        </div>
    </div>
</section>
<section id="tranding" class="home-product">
    <div class="container">
        <div class="row align-items-center m-0 mb-2 mb-sm-4">
            <div class="col-sm-12">
                <h2 class="">Trending Products</h2>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="home-product__holder">
            <!-- <div class="home-product__holder__left">
                <h2 class="home-product__holder__title">Trending <strong>Products</strong></h2>
            </div> -->
    
            <div class="home-product__holder__right">
                <div class="home_product__left">
					@foreach ($poster as $item)
                @php
                    $banImgVal = str_replace('public/','',$item->file_path);
                @endphp
                    <figure>
                        <a href="#" class="image-style">
                            <img src="{{$banImgVal}}">
                        </a>
                    </figure>
					@endforeach
                </div>
                <div class="home-product__slider">
                    @foreach ($products as $productKey => $productValue)
                        @php
                            $imgVal = str_replace('public/','',$productValue->image);
                        @endphp
                        <a href="{{ route('front.product.detail', $productValue->slug) }}" class="home-product__single">
                            <figure>
                                <img src="{{asset($imgVal)}}" />
                            </figure>
                            <figcaption>
                                <h4>{{$productValue->name}}</h4>
                                <!--<h6>Style # OF {{$productValue->style_no}}</h6>-->
                                <h5> <del>&#8377;{{$productValue->price}}</del> &#8377;{{$productValue->offer_price}}</h5>
                                
                            </figcaption>
                            {!! variationColors($productValue->id, 5) !!}
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

<section class="half_banner">
    <div class="container">
        <div class="row m-0">
			@foreach ($promotion as $item)
                @php
                    $banImgVal = str_replace('public/','',$item->file_path);
                @endphp
            <div class="col-sm-6 mb-3 mb-sm-0">
                <a href="#" class="image-style">
                    <!-- <img src="img/kga_banner_1.png" /> -->
                    <img src="{{$banImgVal}}" />
                </a>
            </div>
			@endforeach
            {{--<div class="col-sm-6">
                <a href="#" class="image-style">
                    <!-- <img src="img/kga_banner_2.png" /> -->
                    <img src="img/add-banner21000x1000.jpg" />
                </a>
            </div>--}}
        </div>
    </div>
</section>


<section class="review-section">
    <div class="container">
        <div class="row align-items-center m-0 mb-2 mb-sm-4">
            <div class="col-sm-12">
                <h2 class="">Product Review</h2>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row m-0">
			@foreach ($productReview as $item)
                @php
                    $banImgVal = str_replace('public/','',$item->thumbnail_image);
			       $banvideoVal = str_replace('public/','',$item->video);
                @endphp
            <div class="col-sm-6 mb-3 mb-sm-0">
				@if(!empty($item->video_link))
                <a class="review_thumb" target="_blank" href="{{$item->video_link}}">
					@else
					 <a href="{{$banvideoVal}}" data-fancybox class="video_thumb">
						 @endif
                    <figure>
                        <img src="img/review1.jpg">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) --><path d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z"/></svg>
                    </figure>
                    <figcaption>
                        <h4>{{$item->title}}</h4>
                        <p>{!!$item->description!!}</p>
                    </figcaption>
                </a>
            </div>
			@endforeach
           {{-- <div class="col-sm-6">
                <a class="review_thumb" data-fancybox href="https://www.youtube.com/watch?v=UYldyU6qf38">
                    <figure>
                        <img src="img/review2.jpg">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!-- Font Awesome Pro 5.15.4 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) --><path d="M549.655 124.083c-6.281-23.65-24.787-42.276-48.284-48.597C458.781 64 288 64 288 64S117.22 64 74.629 75.486c-23.497 6.322-42.003 24.947-48.284 48.597-11.412 42.867-11.412 132.305-11.412 132.305s0 89.438 11.412 132.305c6.281 23.65 24.787 41.5 48.284 47.821C117.22 448 288 448 288 448s170.78 0 213.371-11.486c23.497-6.321 42.003-24.171 48.284-47.821 11.412-42.867 11.412-132.305 11.412-132.305s0-89.438-11.412-132.305zm-317.51 213.508V175.185l142.739 81.205-142.739 81.201z"/></svg>
                    </figure>
                    <figcaption>
                        <h4>KGA Family - Customer Feedback Pavit</h4>
                        <p>Pavit, one of our satisfied customers shares her experience with KGA Home Appliances and how she is living a healthy comfortable life by using KGA products.</p>
                    </figcaption>
                </a>
            </div>--}}
        </div>
    </div>
</section>


<section class="video-section">
    <div class="container">
        <div class="row align-items-center m-0 mb-2 mb-sm-4">
            <div class="col-sm-12">
                <h2 class="">Product Videos</h2>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row m-0">
			@foreach ($productVideo as $item)
                @php
                    $banImgVal = str_replace('public/','',$item->file_path);
			       $banvideoVal = str_replace('public/','',$item->video);
                @endphp
            <div class="col-sm-4 mb-3 mb-sm-0">
                <a href="{{$banvideoVal}}" data-fancybox class="video_thumb">
                    <figure>
                        <img src="{{$banImgVal}}">
                    </figure>
                    <figcaption>
                        <h2>{{$item->title}}</h2>
                        <svg width="100" height="100" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50C100 77.6142 77.6142 100 50 100C22.3858 100 0 77.6142 0 50C0 22.3858 22.3858 0 50 0C77.6142 0 100 22.3858 100 50ZM2.5 50C2.5 76.2335 23.7665 97.5 50 97.5C76.2335 97.5 97.5 76.2335 97.5 50C97.5 23.7665 76.2335 2.5 50 2.5C23.7665 2.5 2.5 23.7665 2.5 50Z" fill="#D9D9D9"/>
                            <path d="M37.6506 37.1603C37.6506 33.3113 41.8173 30.9056 45.1506 32.8301L67.6506 45.8205C70.984 47.745 70.984 52.5563 67.6506 54.4808L45.1506 67.4711C41.8173 69.3956 37.6506 66.99 37.6506 63.141L37.6506 37.1603Z" fill="#D9D9D9"/>
                        </svg>
                    </figcaption>
                </a>
            </div>
           {{-- <div class="col-sm-4 mb-3 mb-sm-0">
                <a href="https://www.youtube.com/watch?v=D3Fh-ARfn3w" data-fancybox class="video_thumb">
                    <figure>
                        <img src="img/video2.png">
                    </figure>
                    <figcaption>
                        <h2>KGA<br/>Induction</h2>
                        <svg width="100" height="100" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50C100 77.6142 77.6142 100 50 100C22.3858 100 0 77.6142 0 50C0 22.3858 22.3858 0 50 0C77.6142 0 100 22.3858 100 50ZM2.5 50C2.5 76.2335 23.7665 97.5 50 97.5C76.2335 97.5 97.5 76.2335 97.5 50C97.5 23.7665 76.2335 2.5 50 2.5C23.7665 2.5 2.5 23.7665 2.5 50Z" fill="#D9D9D9"/>
                            <path d="M37.6506 37.1603C37.6506 33.3113 41.8173 30.9056 45.1506 32.8301L67.6506 45.8205C70.984 47.745 70.984 52.5563 67.6506 54.4808L45.1506 67.4711C41.8173 69.3956 37.6506 66.99 37.6506 63.141L37.6506 37.1603Z" fill="#D9D9D9"/>
                        </svg>
                    </figcaption>
                </a>
            </div>
            <div class="col-sm-4">
                <a href="https://www.youtube.com/watch?v=gdEY4C234ow" data-fancybox class="video_thumb">
                    <figure>
                        <img src="img/video3.png">
                    </figure>
                    <figcaption>
                        <h2>KGA<br/>Toaster</h2>
                        <svg width="100" height="100" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M100 50C100 77.6142 77.6142 100 50 100C22.3858 100 0 77.6142 0 50C0 22.3858 22.3858 0 50 0C77.6142 0 100 22.3858 100 50ZM2.5 50C2.5 76.2335 23.7665 97.5 50 97.5C76.2335 97.5 97.5 76.2335 97.5 50C97.5 23.7665 76.2335 2.5 50 2.5C23.7665 2.5 2.5 23.7665 2.5 50Z" fill="#D9D9D9"/>
                            <path d="M37.6506 37.1603C37.6506 33.3113 41.8173 30.9056 45.1506 32.8301L67.6506 45.8205C70.984 47.745 70.984 52.5563 67.6506 54.4808L45.1506 67.4711C41.8173 69.3956 37.6506 66.99 37.6506 63.141L37.6506 37.1603Z" fill="#D9D9D9"/>
                        </svg>
                    </figcaption>
                </a>
            </div>--}}
			@endforeach
        </div>
    </div>
</section>

<?php */ ?>
@endsection
@section('script')
<script>
document.getElementById('submitForm').addEventListener('click', function(e) {
    e.preventDefault(); // Prevent the default behavior of the anchor tag
    document.getElementById('myForm').submit(); // Submit the form
});
	
document.getElementById('NonsticksubmitForm').addEventListener('click', function(e) {
    e.preventDefault(); // Prevent the default behavior of the anchor tag
    document.getElementById('myNonstickForm').submit(); // Submit the form
});
</script>
@endsection