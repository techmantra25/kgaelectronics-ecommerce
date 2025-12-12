@extends('front.profile.layouts.app')

@section('profile-content')
<style>
    .coupon-card.expired > .coupon-head {
        color: #c1080a40;
    }
    .coupon-card.expired > .coupon-content {
        color: #828487;
    }
</style>

<div class="col-lg-9 col-md-8 col-12">
    <div class="profile-card">
        <h3>Coupon</h3>
        <div class="row">
            @foreach ($data as $couponKey => $couponValue)
            <div class="col-lg-6 col-md-8 col-sm-7 col-12 mb-3">
            <div class="coupon-card {{ ($couponValue->end_date < Carbon\Carbon::now()) ? 'expired' : '' }}">
                <div class="coupon-head">
                    &#8377; {{$couponValue->amount}}<br/>OFF
                </div>
                <div class="coupon-content">
                    <h5>{{$couponValue->name}}</h5>
                    <h4>Code: {{$couponValue->coupon_code}}</h4>
                    <h5>Expiry: <strong>{{date('j F Y', strtotime($couponValue->end_date))}}</strong></h5>
                </div>
            </div>
            </div>
            @endforeach
        </div>
    </div>

</div>
@endsection