@extends('layouts.app')

@section('page', 'Category')

@section('content')
<style>
select {
    border: none;
    background: transparent;
}
select:focus {
    outline: none;
    box-shadow: none;
}
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
}
.color-holder {
	width: 20px;
    height: 20px;
    border-radius: 50%;
    flex: 0 0 20px;
	margin-right: 7px;
	box-shadow: 0px 5px 10px rgb(0 0 0 / 10%);
}
/*.customCats.active {
    display: block;
    border: 2px solid #c1080a;
}*/
.listing-block .product__single figure h6 {
    display: block;
	background: #fff;
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


@php
  $banner=\App\Models\CategoryBanner::where('cat_id',$data->id)->get();
@endphp

<section class="listing-header">
    <div class="container">
        	<div class="row align-items-center">
            <!-- <div class="col-sm-3 d-none d-sm-block">
                <img src="{{ asset($data->banner_image) }}" class="img-fluid">
            </div> -->
            
				<div class="col col-sm-4">
					<!--<h3>{{ $data->name }}</h3> -->
				</div>
				<div class="col-auto col-sm-8">
					<nav aria-label="breadcrumb">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="{{ route('front.home') }}">Home</a></li>
							<li class="breadcrumb-item active" aria-current="page">{{$data->name}}</li>
						</ol>
					</nav>
				</div>
        	</div>
        <div class="row align-items-center">
            <div class="col-12 d-none d-sm-block">
           		 <div class="swiper inner_banner">
                    <div class="swiper-wrapper">
						@foreach($banner as $banners)
                        <div class="swiper-slide">
                            <figure>
                                <div class="banner_caption">
                                    <h6>KGA</h6>
                                    <h2>{{$banners->name}}</h2>
                                    <ul>
										{!!$banners->description!!}
                                        {{--<li>PurColor & HDR</li>
                                        <li>Adaptive Sound & Q-symphony</li>
                                        <li>Multiple Voice Assistant with One Remote Control</li>--}}
                                    </ul>
                                    <a href="#" class="latest-btm mt-auto">Order Now</a>
                                </div>
                                <img src="{{asset($banners->icon)}}" class="banner_img img-fluid">
                            </figure>
                        </div>
						@endforeach
                        
                    </div>
                    <div class="swiper-pagination"></div>
                  </div>
				</div>
			</div>
           
          
       

        <div class="row align-items-center">
            <div class="col-12 text-center">
                <h1>Browse All {{ $data->name }}<h1>
            </div>
        </div>
    </div>
</section>


<section class="filter_bar">
    <div class="container">
        @if (count($data->ProductDetails) > 0)
        <div class="listing-block__meta">
            {{-- <div class="filter">
                <div class="filter__toggle">
                    Filter
                </div>
                <div class="filter__data"></div>
            </div> --}}
            <div class="products mr-3">
              
            </div>
            <div class="sorting">
                Sort By:
                <select name="orderBy" onclick="productsFetch()">
                    <option value="new_arr">New Arrivals</option>
                    <option value="mst_viw">Most Viewed</option>
                    <option value="prc_low">Price: Low To High</option>
                    <option value="prc_hig">Price: High To Low</option>
                </select>
            </div>
        </div>
    </div>
</section>


<section class="listing-block">
    <div class="container">
        

        <div class="product__wrapper">
            <div class="product__filter d-none">
                <div class="product__filter__bar">
                    <div class="filter__close">
                        <i class="fal fa-times"></i>
                    </div>
                    <div class="row">
                        <div class="col-6 col-sm-12 mb-3 mb-sm-0">
                            <h4>Range</h4>
                            <ul class="product__filter__bar-list">
                                @foreach($collections as $categoryKey => $categoryValue)
                                    <li><label><input type="checkbox" name="collection[]" pro-filter="{{$categoryValue->name}}" value="{{$categoryValue->id}}" onclick="productsFetch()"><i></i> {{$categoryValue->name}}</label></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-6 col-sm-12 mb-3 mb-sm-0">
                            <h4>Sizes</h4>
                            <ul class="product__filter__bar-list">
                                @foreach($sizes as $sizeKey => $sizeValue)
                                    <li><label><input type="checkbox" pro-filter="{{$sizeValue->name}}"><i></i> {{$sizeValue->name}}</label></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-6 col-sm-12 mb-3 mb-sm-0">
                            <h4>Price</h4>
                            <ul class="product__filter__bar-list">
                                <li><label><input type="checkbox" pro-filter="&#8377;339 - &#8377;425"><i></i> &#8377;339 - &#8377;425</label></li>
                                <li><label><input type="checkbox" pro-filter="&#8377;410 - &#8377;450"><i></i> &#8377;410 - &#8377;450</label></li>
                                <li><label><input type="checkbox" pro-filter="&#8377;499 - &#8377;525"><i></i> &#8377;499 - &#8377;525</label></li>
                                <li><label><input type="checkbox" pro-filter="&#8377;575 - &#8377;599"><i></i> &#8377;575 - &#8377;599</label></li>
                                <li><label><input type="checkbox" pro-filter="&#8377;599 - &#8377;625"><i></i> &#8377;599 - &#8377;625</label></li>
                                <li><label><input type="checkbox" pro-filter="&#8377;590 - &#8377;615"><i></i> &#8377;590 - &#8377;615</label></li>
                                <li><label><input type="checkbox" pro-filter="&#8377;450 - &#8377;475"><i></i> &#8377;450 - &#8377;475</label></li>
                                <li><label><input type="checkbox" pro-filter="&#8377;430 - &#8377;450"><i></i> &#8377;430 - &#8377;450</label></li>
                            </ul>
                        </div>
                        <div class="col-12">
                            <h4>Color</h4>
                            <ul class="product__filter__bar-list column-2">
                                @foreach($colors as $colorKey => $colorValue)
                                    <li><label> <input type="checkbox" pro-filter="{{$colorValue->name}}"><i></i> {{ucwords($colorValue->name)}}</label></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="product__holder">
                <div class="row">
                   
                    @forelse($data->ProductDetails as $categoryProductKey => $categoryProductValue)
                   
                    @php if($categoryProductValue->status == 0) {continue;} 
					if(Auth::guard('web')->check()){
						$wishlistCheck = \App\Models\Wishlist::where('product_id', $categoryProductValue->id)->where('user_id', Auth::guard('web')->user()->id)->first();
						}else{
							$wishlistCheck = '';
						}
					@endphp
                    <div class="product__single" data-events data-cat="tshirt">
                        <figure>
                            <a href="{{route('front.product.detail',$categoryProductValue->slug)}}"><img src="{{asset($categoryProductValue->thumbnail_image)}}" /></a>
                        </figure>
                        <figcaption>
							<a href="{{route('front.product.detail',$categoryProductValue->slug)}}"><h4>{{$categoryProductValue->name}} </h4></a>

                            <div class="pro_meta">
                                <div class="pro_price">
                                    <h5>
                                        MRP (Inclusive of all taxes)
                                    
                                        <del>&#8377; {{$categoryProductValue->price}}</del>
                                    
                                    </h5>
                                    <h2>&#8377; {{$categoryProductValue->offer_price}}</h2>
                                </div>
                                @if(Auth::guard('web')->check())
								 <div class="order_block_footer">
									<form method="POST" action="{{route('front.wishlist.add')}}" id="toggleWishlistForm">@csrf
										<input type="hidden" name="product_id" value="{{$categoryProductValue->id}}">
										<button type="submit" class="wishlist_btn {{ ($wishlistCheck) ? 'active' : '' }}" style="width: 60px;{{ ($wishlistCheck) ? 'background: #c1080a;' : '' }}">
									<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
									   </button>
								   </form>
								</div>
								 @else
									<a href="{{route('front.user.login')}}" id="myButton" >
										<input type="hidden" name="product_id" value="{{$data->id}}">

										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-heart"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path></svg>
										
									</a>
								@endif
                            </div>
                            
                            <div class="pro_content">
								{!!$categoryProductValue->short_desc!!}
                                {{--<ul>
                                    <li>No Cost EMI starts from ₹ 2832.50/ month.</li>
                                    <li>PurColor &amp; HDR</li>
                                    <li>Adaptive Sound &amp; Q-symphony</li>
                                </ul>--}}
                            </div>

                            <a href="{{ route('front.product.detail', $categoryProductValue->slug) }}" class="buy_button mb-3">Show More</a>
                           
                        </figcaption>

                       
                    </div>
                    @empty

                    @endforelse
                </div>
            </div>
        </div>
        @else
            <p>Sorry, No products found under {{$data->name}} </p>
        @endif
    </div>
</section>
@endsection

@section('script')
<script>
    function productsFetch() {
        // collection values
        var collectionArr = [];
        $('input[name="collection[]"]:checked').each(function(i){
          collectionArr[i] = $(this).val();
        });

        $.ajax({
            url: '{{route("front.category.filter")}}',
            method: 'POST',
            data: {
                '_token' : '{{ csrf_token() }}',
                'categoryId' : '{{$data->id}}',
                'orderBy' : $('select[name="orderBy"]').val(),
                'collection' : collectionArr,
            },
            beforeSend: function() {
                /* $loadingSwal = Swal.fire({
                    title: 'Please wait...',
                    text: 'We are adjusting the products as per your need!',
                    showConfirmButton: false,
                    allowOutsideClick: false
                    // timer: 1500
                }) */
            },
            success: function(result) {
                if (result.status == 200) {
                    var content = prodText = '';
                    $('#prod_count').text(result.data.length);
                    (result.data.length > 1) ? prodText = 'products' : prodText = 'product';
                    $('#prod_text').text(prodText);
                    $.each(result.data, function(key, value) {
                        var url = '{{ route('front.product.detail', ":slug") }}';
                        url = url.replace(':slug', value.slug);

                        content += `
						
                        <a href="${url}" class="product__single" data-events data-cat="tshirt">
                            <figure>
                                <img src="{{asset('${value.thumbnail_image}')}}" />
                                <h6>${value.styleNo}</h6>
                            </figure>
                            <figcaption>
                                <h4>${value.name}</h4>
								 <h5>
                                        MRP (Inclusive of all taxes)
                                    
                                        <del>&#8377; ${value.price}</del>
                                    
                                    </h5>
                                <h2>${value.displayPrice}</h2>
								 
                            </figcaption>
							
							<div class="pro_content">
								${value.short_desc}
                                
                            </div>
							
                           
                            <div class="color">${value.colorVariation}</div>
                        </a>
                        `;
                    });

                    $('.product__holder .row').html(content);
                    // $loadingSwal.close();
                }
                // console.log(result);
            },
            error: function(result) {
                // $loadingSwal.close()
                console.log(result);
                $errorSwal = Swal.fire({
                    // icon: 'error',
                    // title: 'We cound not find anything',
                    text: 'We cound not find anything. Try again with a different filter!',
                    confirmButtonText: 'Okay'
                })
            },
        });
    }
</script>
@endsection
