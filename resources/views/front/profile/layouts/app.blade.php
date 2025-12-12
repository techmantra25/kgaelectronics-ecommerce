@extends('layouts.app')

@section('page', 'Profile')

@section('content')
<section class="cart-header mt-3 mb-3 mb-sm-5">
    <div class="container">
        <div class="row">
            <div class="col-sm-12">
                <h4>Account Information</h4>
            </div>
        </div>
    </div>
</section>

<section class="cart-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-12 mb-5 mb-md-0">
            <!-- <div class="col-sm-12 col-lg-12 mb-5"> -->
                <div class="left-bar">
                    <div class="name-card">
                        <h4>{{Auth::guard('web')->user()->name}}</h4>
                        <h5>{{Auth::guard('web')->user()->email}}</h5>
                        <h5>{{Auth::guard('web')->user()->mobile}}</h5>
                    </div>

                    <ul class="account-list account-list-top">
                        <li class="{{request()->is('user/profile*') ? 'active' : '' }}">
                            <a href="{{route('front.user.profile')}}"> <i class="fas fa-clipboard-list"></i> Overview</a>
                        </li>
                        <li>
                            <span><i class="fas fa-shopping-basket"></i> Orders</span>
                            <ul class="account-item"><li class="{{(request()->is('user/order*')) ? 'active' : '' }}"><a href="{{route('front.user.order')}}">Orders & Returns</a></li></ul>
                        </li>
                        <li>
                            <span> <i class="fas fa-credit-card"></i> Credits</span>
                            <ul class="account-item">
                                <li class="{{request()->is('user/coupon*') ? 'active' : '' }}"><a href="{{route('front.user.coupon')}}">Coupons</a></li>
                            </ul>
                        </li>
                        <li>
                            <span> <i class="far fa-user-circle"></i> Account</span>
                            <ul class="account-item">
                                <li class="{{request()->is('user/manage*') ? 'active' : '' }}"><a href="{{route('front.user.manage')}}">Profile</a></li>
                                <li class="{{request()->is('user/wishlist*') ? 'active' : '' }}"><a href="{{route('front.user.wishlist')}}">Wishlist</a></li>
                                <li class="{{request()->is('user/address*') ? 'active' : '' }}"><a href="{{route('front.user.address')}}">Address</a></li>
                                <li><a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a></li>
                            </ul>
                        </li>
                        <li>
                            <span><i class="fas fa-balance-scale-right"></i> Legal</span>
                            <ul class="account-item">
                                <li><a href="{{route('front.content.terms')}}">Terms & Conditions</a></li>
                                <li><a href="{{route('front.content.privacy')}}">Privacy Statement</a></li>
                                <li><a href="{{route('front.content.security')}}">Security</a></li>
                                <li><a href="{{route('front.content.disclaimer')}}">Disclaimer</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>

            @yield('profile-content')

        </div>
    </div>
</section>
@endsection

@section('script')

<script>
    $(window).scroll(function() {
    if ($(this).scrollTop() > 150){  
        $('.left-bar').addClass("middle-sticky");
    }
    else{
        $('.left-bar').removeClass("middle-sticky");
    }
    });
</script>


@endsection