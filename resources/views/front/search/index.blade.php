@extends('layouts.app')

@section('page', app('request')->input('query'))

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
    align-items: center;
	padding: 0 20px 20px;
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

@if (count($data) > 0)
<section class="listing-block mt-5 pt-5">
    <div class="container">
        <div class="listing-block__meta">
            <p>Displaying search result for <b>{{app('request')->input('query')}}</b></p>
        </div>

        <div class="product__wrapper">
            <div class="product__holder">
                <div class="row">
                    @foreach($data as $productKey => $productValue)
                    <a href="{{ route('front.product.detail', $productValue->slug) }}" class="product__single" data-events data-cat="tshirt">
                        <figure>
                            <img src="{{asset($productValue->image)}}" />
                            <h6 class="d-block">{{$productValue->style_no}}</h6>
                        </figure>
                        <figcaption>
                            <h4>{{$productValue->name}}</h4>
                            <h5>
                            @if (count($productValue->colorSize) > 0)
                                @php
                                    $varArray = [];
                                    foreach($productValue->colorSize as $productVariationKey => $productVariationValue) {
                                        $varArray[] = $productVariationValue->offer_price;
                                    }
                                    $bigger = $varArray[0];
                                    for ($i = 1; $i < count($varArray); $i++) {
                                        if ($bigger < $varArray[$i]) {
                                            $bigger = $varArray[$i];
                                        }
                                    }

                                    $smaller = $varArray[0];
                                    for ($i = 1; $i < count($varArray); $i++) {
                                        if ($smaller > $varArray[$i]) {
                                            $smaller = $varArray[$i];
                                        }
                                    }
                                @endphp

								@if($smaller == $bigger)
									&#8377;{{$bigger}}
								@else
									&#8377;{{$smaller}} - &#8377;{{$bigger}}
								@endif
                            @else
                                &#8377;{{$productValue->offer_price}}
                            @endif
                            </h5>
                        </figcaption>

                        {!! variationColors($productValue->id, 5) !!}
							
                        {{-- <div class="color">
							@if (count($productValue->colorSize) > 0)
							@php
							$uniqueColors = [];

							foreach ($productValue->colorSize as $variantKey => $variantValue) {
                                if ($variantValue->status == 1) {
                                    $uniqueColors[] = [
                                        'id' => $variantValue->colorDetails->id,
                                        'code' => $variantValue->colorDetails->code,
                                        'name' => $variantValue->colorDetails->name,
                                        'status' => $variantValue->status,
                                    ];
                                }
							}

							echo '<ul class="product__color">';
							foreach($uniqueColors as $colorCodeKey => $colorCode) {
                                if ($colorCodeKey == 5) {break;}
                                if ($colorCode['id'] == 61) {
                                    echo '<li style="background: -webkit-linear-gradient(left,  rgba(219,2,2,1) 0%,rgba(219,2,2,1) 9%,rgba(219,2,2,1) 10%,rgba(254,191,1,1) 10%,rgba(254,191,1,1) 10%,rgba(254,191,1,1) 20%,rgba(1,52,170,1) 20%,rgba(1,52,170,1) 20%,rgba(1,52,170,1) 30%,rgba(15,0,13,1) 30%,rgba(15,0,13,1) 30%,rgba(15,0,13,1) 40%,rgba(239,77,2,1) 40%,rgba(239,77,2,1) 40%,rgba(239,77,2,1) 50%,rgba(254,191,1,1) 50%,rgba(137,137,137,1) 50%,rgba(137,137,137,1) 60%,rgba(254,191,1,1) 60%,rgba(254,191,1,1) 60%,rgba(254,191,1,1) 70%,rgba(189,232,2,1) 70%,rgba(189,232,2,1) 80%,rgba(209,2,160,1) 80%,rgba(209,2,160,1) 90%,rgba(48,45,0,1) 90%); " class="color-holder" data-bs-toggle="tooltip" data-bs-placement="top" title="Assorted"></li>';
                                } else {
                                    echo '<li onclick="sizeCheck('.$productValue->id.', '.$colorCode['id'].')" style="background-color: '.$colorCode['code'].'" class="color-holder" data-bs-toggle="tooltip" data-bs-placement="top" title="'.$colorCode['name'].'"></li>';
                                }
							}
							if (count($uniqueColors) > 5) {echo '<li>+ more</li>';}
							echo '</ul>';
							@endphp
						    @endif
						</div> --}}
                    </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section> 
@else
<section class="cart-header mb-3 mb-sm-5"></section>
<section class="cart-wrapper">
    <div class="container">
        <div class="complele-box">
            <figure>
                <img src="{{asset('img/close.svg')}}" height="100">
            </figure>
            <figcaption>
                <h2>OOPS ! <b>{{app('request')->input('query')}}</b> returns no result</h2>
                <p>Search new query.</p>
                <a href="{{route('front.home')}}">Back to Home</a>
            </figcaption>
        </div>
    </div>
</section>
@endif
@endsection