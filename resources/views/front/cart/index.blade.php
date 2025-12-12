@extends('layouts.app')

@section('page', 'Cart')

@section('content')
<style>
/* .cart-item.item-qty .qty-box a {
    width: 20px;
    height: 20px;
    border: none;
    background: #101010;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    -webkit-box-pack: center;
    -ms-flex-pack: center;
    justify-content: center;
    padding: 3px;
} */
/* .cart-item.item-qty .qty-box a:hover {
    background: #c10909;
}
.cart-item.item-qty .qty-box a svg {
    width: 14px;
    height: 14px;
} */
.cart-summary-list li .coupon-block .coupon-text {
    width: 250px
}
</style>

@if(count($data) > 0)
<section class="cart-header mt-3 mb-3 mb-sm-5">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <h4>Shopping Cart</h4>

                <ul class="bread-list">
                    <li><a href="">Home</a></li>
                    <li>Cart</li>
                </ul>

            </div>
            {{-- <div class="col-sm-9">
                <ul class="cart-flow">
                    <li class="active"><a href="javascript: void(0)"><span>Cart</span></a></li>
                    <li><a href="javascript: void(0)"><span>Checkout</span></a></li>
                    <li><a href="javascript: void(0)"><span>Shipping</span></a></li>
                    <li><a href="javascript: void(0)"><span>Payment</span></a></li>
                </ul>
            </div> --}}
        </div>
    </div>
</section>

<section class="cart-wrapper">
    <div class="container">
        {{-- @if (Session::get('success'))
        <div class="alert alert-success">{{Session::get('success')}}</div>
        @endif
        @if (Session::get('failure'))
        <div class="alert alert-danger">{{Session::get('failure')}}</div>
        @endif --}}
        
        <div class="row justify-content-between">
            <div class="col-md-7 col-12">
                <div class="cart-holder">
                    <!-- <div class="cart-row cart-row--header">
                        <div class="cart-item item-thumb">Image</div>
                        <div class="cart-item item-title">Name and Style</div>
                        <div class="cart-item item-attr">Size</div>
                        <div class="cart-item item-color">Color</div>
                        <div class="cart-item item-price">Price</div>
                        <div class="cart-item item-qty">Quantity</div>
                        <div class="cart-item item-price">Amount</div>
                        <div class="cart-item item-remove">Action</div>
                    </div> -->

                    @php
                        $subTotal = $grandTotal = $couponCodeDiscount = $shippingCharges = $taxPercent = 0;
                        $minOrderAmount =500;
                    @endphp

                    @foreach($data as $cartKey => $cartValue)
                    <div class="cart-row">
                        <div class="cart-item item-thumb">
                            <figure>
                                <img src="{{$cartValue->product->image}}">
                            </figure>
                        </div>

                        <div class="cart-infor-holder">
                            <div class="cart-item item-title">
                                <h4>{{$cartValue->product->name}}</h4>
                                <!-- <h6>Style # OF {{$cartValue->product_style_no}}</h6> -->
                            </div>
                            {{-- @if ($cartValue->cartVariationDetails)
                                <div class="cart-item item-attr">
                                    <!-- <div class="cart-text">Size</div> -->
                                    <h4>{{$cartValue->cartVariationDetails->sizeDetails->name}}</h4>
                                </div>
                            @endif
                            @if ($cartValue->cartVariationDetails)
                            <div class="cart-item item-color">
                                <!-- <div class="cart-text">Colour</div> -->
                                <h4>{{ucwords($cartValue->cartVariationDetails->colorDetails->name)}}</h4>
                            </div>
                            @endif --}}

                            <div class="cart-item item-qty">
                                <!-- <div class="cart-text">Quantity</div> -->
                                <div class="qty-box">
                                    <a href="{{ route('front.cart.quantity', [$cartValue->id, 'decr']) }}" class="decrement" type="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-minus"><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                    </a>
                                    <input class="counter" readonly type="number" value="{{$cartValue->qty}}">
                                    <a href="{{ route('front.cart.quantity', [$cartValue->id, 'incr']) }}" class="increment" type="button">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                                    </a>
                                </div>
                            </div>

                            <div class="cart-item item-price">
                                <!-- <div class="cart-text"> Amount</div> -->
                                <h3>&#8377;{{$cartValue->product->offer_price * $cartValue->qty}}</h3>
                            </div>
                            <div class="cart-bottom">
                                <div class="cart-item item-price">
                                    <!-- <div class="cart-text">Price</div> -->
                                    <!-- <h4>&#8377;{{$cartValue->product->offer_price}}</h4> -->
                                    <h4><del>&#8377; {{$cartValue->product->price}}</del> &#8377; {{$cartValue->product->offer_price}} </h4>
                                </div>
                                <div class="cart-item item-remove">
                                    <a href="{{route('front.cart.delete', $cartValue->id)}}">Remove</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    @php
                        // subtotal calculation
                        $subTotal += (int) $cartValue->product->offer_price * $cartValue->qty;

                        // coupon code calculation
                        if (!empty($data[0]->coupon_code_id)) {
                            // 1 is coupon, else voucher
                            if (($data[0]->couponDetails->is_coupon == 1)) {
                                if($data[0]->couponDetails->type == 1){
                                    $couponCodeDiscount = (int) ($subTotal * ($data[0]->couponDetails->amount / 100));
                                }else{
                                    $couponCodeDiscount = (int) $data[0]->couponDetails->amount;
                                }
                            } else {
                                if($data[0]->couponDetails->type == 1){
                                    $couponCodeDiscount = (int) ($subTotal * ($data[0]->couponDetails->amount / 100));
                                }else{
                                    $couponCodeDiscount = (int) $data[0]->couponDetails->amount;
                                }   
                            }
                        }

                        // grand total calculation
                        $grandTotalWithoutCoupon = $subTotal;
                        $grandTotal = ($subTotal + $shippingCharges) - $couponCodeDiscount;
                        if($grandTotal < 0){
                            $grandTotal = 0;
                        }
                    @endphp

                    @endforeach
                </div>
            </div>
            <div class="col-md-5 col-12">
                <div class="w-100 position-stick amount-holder">
                    <h2 class="summery-heading">Order Summary</h2>
                    <div class="cart-total">
                        <div class="cart-total-label">
                            Subtotal
                        </div>
                        <div class="cart-total-value">
                            &#8377;<span id="subTotalAmount">{{$subTotal}}</span>
                        </div>
                    </div>
                    <div class="cart-total">
                        <div class="cart-total-label">
                            Shipping Charges
                        </div>
                        <div class="cart-total-value">
                             @if($shippingCharges== 0) Free Delivery @else &#8377; {{$shippingCharges}} @endif
                        </div>
                    </div>

                    {{-- <div class="cart-total">
                        <div class="cart-total-label">
                            Tax and Others - <strong>{{$taxPercent}}%</strong><br/>
                            <small>(Inclusive of all taxes)</small>
                        </div>
                        <div class="cart-total-value"></div>
                    </div> --}}

                    <div id="appliedCouponHolder">
                    @if (!empty($data[0]->coupon_code_id))
                        @if ($data[0]->couponDetails)
                            <div class="cart-total">
                                <div class="cart-total-label">
                                    @php
                                        if (($data[0]->couponDetails->is_coupon == 1)) {
                                            $typeDisplay = 'COUPON';
                                            if ($data[0]->couponDetails->type == 1) {
                                                $amountDisplay = '- '.$data[0]->couponDetails->amount.'%';
                                            }
                                            else {
                                                $amountDisplay = '- &#8377 '.$data[0]->couponDetails->amount;
                                            }
                                        } else {
                                            $typeDisplay = 'VOUCHER';
                                            if ($data[0]->couponDetails->type == 1) {
                                                $amountDisplay = '- '.$data[0]->couponDetails->amount.'%';
                                            }
                                            else {
                                                $amountDisplay = '- &#8377 '.$data[0]->couponDetails->amount;
                                            }
                                        }
                                    @endphp
                                    {{ $typeDisplay }} APPLIED - <strong>{{$data[0]->couponDetails->coupon_code}}</strong><br/>
                                    <a href="javascript:void(0)" onclick="removeAppliedCoupon()"><small>(Remove this {{ ($data[0]->couponDetails->is_coupon == 1) ? 'coupon' : 'voucher' }})</small></a>
                                </div>
                                <div class="cart-total-value">{!! $amountDisplay !!}</div>
                            </div>
                        @endif
                    @endif
                    </div>
                    <div class="cart-total">
                        <div class="cart-total-label">
                            Total
                        </div>
                        <div class="cart-total-value">
                            <input type="hidden" value="{{$grandTotalWithoutCoupon}}" name="grandTotalWithoutCoupon">
                            &#8377;<span id="displayGrandTotal">{{$grandTotal}}</span>
                        </div>
                    </div>
                </div>
            </div>
                    <div class="col-md-6 col-lg-5">
                        <ul class="cart-summary-list">
                             <li>
                                <h5><span>Have</span> a coupon code? enter here</h5>
                               {{-- <img src="img/delivery-truck.png" />
                                {{-- $minOrderAmount = $shippingChargeJSON->min_order;
                                $shippingCharge = $shippingChargeJSON->shipping_charge; --}}
                               {{-- <h5><span>FREE</span> Shipping On order above &#8377;{{$minOrderAmount}}</h5>
                                {{-- <h5><span>FREE</span> Shipping for all orders</h5> --}}
                                {{-- <h5><span>&#8377;60</span> Apply Below order &#8377;499</h5> --}}
                               {{-- <a href="{{route('front.content.shipping')}}">See Shipping charges and policies</a>--}}
                            </li> 
                            <li>
                               
                                <img src="img/coupon.png" />
                                <div class="coupon-block">
                                    <input type="text" class="coupon-text" name="couponText" id="couponText" placeholder="Enter coupon code or voucher here" value="{{ (!empty($data[0]->coupon_code_id)) ? $data[0]->couponDetails->coupon_code : '' }}" {{ (!empty($data[0]->coupon_code_id)) ? 'disabled' : '' }}>
                                    @if (!empty($data[0]->coupon_code_id))
                                        <button id="applyCouponBtn" style="background: #c1080a" disabled="true">Applied</button>
                                    @else
                                        <button id="applyCouponBtn">Apply</button>
                                    @endif
                                </div>
                                @error('lname')<p class="small text-danger mb-0 mt-2">{{$message}}</p>@enderror
                                <div class="w-100">
                                    {{-- <a href="{{route('front.user.coupon')}}" class="d-inline-block mt-2">Get latest coupon from here</a> --}}
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="justify-content-between checkout-proceed-row">
                        <div class="col-12 text-right mt-4">
                            <form action="{{route('front.checkout.index')}}" method="GET">
                                <button type="submit" class="btn checkout-btn">Proceed to checkout</button>
                            </form>
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </div>
    



    <div class="container">
        <section class="service-info-section">
            <ul class="ser-list">
                <li>
                    <div class="box">
                        <figure>
                            <img src="img/service1.png">
                        </figure>
                        <figcaption>
                            <h3>Fast & Secure Delivery</h3>
                            <p>Tell about your service.</p>
                        </figcaption>
                    </div>
                </li>
                <li>
                    <div class="box">
                        <figure>
                            <img src="img/service2.png">
                        </figure>
                        <figcaption>
                            <h3>Money Back Guarantee</h3>
                            <p>Within 10 days.</p>
                        </figcaption>
                    </div>
                </li>
                <li>
                    <div class="box">
                        <figure>
                            <img src="img/service3.png">
                        </figure>
                        <figcaption>
                            <h3>24 Hour Return Policy</h3>
                            <p>No question ask.</p>
                        </figcaption>
                    </div>
                </li>
                <li>
                    <div class="box">
                        <figure>
                            <img src="img/service4.png">
                        </figure>
                        <figcaption>
                            <h3>Pro Quality Support</h3>
                            <p>24/7 Live support.</p>
                        </figcaption>
                    </div>
                </li>
            </ul>
        </section>
    </div>




</section>

@else
<section class="cart-header mb-3 mb-sm-5"></section>
<section class="cart-wrapper">
    <div class="container">
        <div class="complele-box">
            <figure>
                <img src="{{asset('img/empty-cart.png')}}" height="100">
            </figure>
            <figcaption>
                <h2>Your cart is empty</h2>
               
                <a href="{{route('front.home')}}">Back to Home</a>
            </figcaption>
        </div>
    </div>
</section>
@endif

@endsection

@section('script')
    <script>
        // cart page coupon
        $('#applyCouponBtn').on('click', (e) => {
            e.preventDefault()
            let couponCode = $('input[name="couponText"]').val();
            if (couponCode.length > 0) {
                $.ajax({
                    url: '{{ route('front.cart.coupon.check') }}',
                    method: 'POST',
                    data: {
                        '_token': '{{ csrf_token() }}',
                        code: couponCode
                    },
                    beforeSend: function() {
                        $('#applyCouponBtn').text('Checking');
                        // $('#applyCouponBtn').text('Checking').attr('disabled', true);
                    },
                    success: function(result) {
                        // console.log(result);

                        if (result.type == 'success') {
                            // console.log(result);
                            $('#applyCouponBtn').text('APPLIED').css('background', '#c1080a').attr('disabled', true);

                            $('input[name="couponText"]').attr('disabled', true);
                            let beforeCouponValue = parseInt($('#displayGrandTotal').text());
                            let couponDiscount = parseInt(result.amount);
                            // let discountedGrandTotal = beforeCouponValue - couponDiscount;
                            // $('#displayGrandTotal').text(discountedGrandTotal);

                            // coupon/ voucher type
                            let amountToDisplay = '';
                            if (result.is_coupon == 'voucher') {
                                let discountedGrandTotal = 0;
                                if(result.coupon_type == 1){
                                    amountToDisplay = '- '+result.amount+'%';
                                    discountedGrandTotal = Math.ceil(beforeCouponValue * ((100-couponDiscount)/100));
                                }else{
                                    amountToDisplay = '- &#8377; '+result.amount;
                                    discountedGrandTotal = beforeCouponValue - couponDiscount;
                                }
                                
                                if (discountedGrandTotal < 0) {
                                    $('#displayGrandTotal').text(0);
                                }else{
                                    $('#displayGrandTotal').text(discountedGrandTotal);
                                }
                            } else {
                                let discountedGrandTotal = 0;
                                if(result.coupon_type == 1){
                                    amountToDisplay = '- '+result.amount + '%';
                                    discountedGrandTotal = Math.ceil(beforeCouponValue - ((beforeCouponValue * couponDiscount)/100));
                                }else{
                                    amountToDisplay = '- &#8377; '+result.amount;
                                    discountedGrandTotal = beforeCouponValue - couponDiscount;
                                }

                                if (discountedGrandTotal < 0) {
                                    $('#displayGrandTotal').text(0);
                                }else{
                                    $('#displayGrandTotal').text(discountedGrandTotal);
                                }
                            }

                            let couponContent = `
                            <div class="cart-total">
                                <div class="cart-total-label">
                                    ${result.is_coupon} APPLIED - <strong>${couponCode}</strong><br/>
                                    <a href="javascript:void(0)" onclick="removeAppliedCoupon()"><small>(Remove this ${result.is_coupon})</small></a>
                                </div>
                                <div class="cart-total-value">${amountToDisplay}</div>
                            </div>
                            `;

                            $('#appliedCouponHolder').html(couponContent);
                            toastFire(result.type, result.message);
                        } else {
                            toastFire(result.type, result.message);
                            $('#applyCouponBtn').text('Apply');
                        }
                    }
                });
            }
        });
		
		  document.addEventListener('contextmenu', function(e) {
			e.preventDefault();
		  });
    </script>
@endsection