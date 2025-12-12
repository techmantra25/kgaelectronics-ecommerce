<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpMail;

Route::get('/dev-clear', function()
{
    \Artisan::call('optimize:clear');
    echo 'cache cleared';
});


Route::get('/test-email', function () {
    $otp = '123456';
    Mail::to('test@example.com')->send(new OtpMail($otp));
    return 'Email sent!';
});


Route::get('/home', 'HomeController@index')->name('home');
Route::get('/test-route', 'HomeController@test_route')->name('test_route');

Route::post('/set-session-data', 'HomeController@storeSessionData')->name('set_session_data');

// website
Route::name('front.')->group(function () {
    // home
    Route::get('/', 'Front\FrontController@index')->name('home');
    Route::post('/subscribe', 'Front\FrontController@mailSubscribe')->name('subscription');

    // category detail
    Route::name('category.')->group(function () {
        Route::get('/category/{slug}', 'Front\CategoryController@detail')->name('detail');
        Route::post('/category/filter', 'Front\CategoryController@filter')->name('filter');
    });

    // sale
    Route::name('sale.')->group(function () {
        Route::get('/sale', 'Front\SaleController@index')->name('index');
    });

    // collection detail
    Route::name('collection.')->group(function () {
        Route::get('/collection/{slug}', 'Front\CollectionController@detail')->name('detail');
        Route::post('/collection/filter', 'Front\CollectionController@filter')->name('filter');
    });

    // product detail
    Route::name('product.')->group(function () {
        Route::get('/product/detail/{slug}', 'Front\ProductController@detail')->name('detail');
        Route::post('/size', 'Front\ProductController@size')->name('size');
    });

    // wishlist
    Route::prefix('wishlist')->name('wishlist.')->group(function () {
        // Route::get('/', 'Front\WishlistController@viewByIp')->name('index');
        Route::post('/add', 'Front\WishlistController@add')->name('add');
        Route::post('/remove', 'Front\WishlistController@remove')->name('remove');
        Route::get('/delete/{id}', 'Front\WishlistController@delete')->name('delete');
    });

    // cart
    Route::prefix('cart')->name('cart.')->group(function () {
        Route::get('/', 'Front\CartController@viewByIp')->name('index');
        Route::post('/coupon/check', 'Front\CartController@couponCheck')->name('coupon.check');
        Route::post('/coupon/remove', 'Front\CartController@couponRemove')->name('coupon.remove');
        Route::post('/add', 'Front\CartController@add')->name('add');
        Route::get('/delete/{id}', 'Front\CartController@delete')->name('delete');
        Route::get('/quantity/{id}/{type}', 'Front\CartController@qtyUpdate')->name('quantity');
    });

    // checkout
    Route::prefix('checkout')->name('checkout.')->group(function () {
        Route::get('/', 'Front\CheckoutController@index')->name('index');
        // Route::post('/coupon/check', 'Front\CheckoutController@coupon')->name('coupon.check');
        Route::post('/store', 'Front\CheckoutController@store')->name('store');
        Route::get('/complete', 'Front\CheckoutController@complete')->name('complete');
    });

    // faq
    Route::prefix('faq')->name('faq.')->group(function () {
        Route::get('/', 'Front\FaqController@index')->name('index');
    });

    // offer
    Route::prefix('offer')->name('offer.')->group(function () {
        Route::get('/', 'Front\OfferController@index')->name('index');
    });

    // search
    Route::prefix('search')->name('search.')->group(function () {
        Route::get('/', 'Front\SearchController@index')->name('index');
        Route::post('/product', 'Front\SearchController@product')->name('product');
    });

	// franchise
	Route::prefix('franchise')->name('franchise.')->group(function () {
        Route::get('/', 'Front\FranchiseController@index')->name('index');
        Route::post('/mail', 'Front\FranchiseController@mail')->name('mail');
        Route::post('/partner', 'Front\FranchiseController@partner')->name('partner');
        // Route::get('/thank-you', 'Front\FranchiseController@partner')->name('partner.success');
        Route::view('/thank-you', 'front.franchise.success')->name('partner.success');
    });

    // settings contents
    Route::name('content.')->group(function () {
        Route::get('/terms-and-conditions', 'Front\ContentController@termDetails')->name('terms');
        Route::get('/privacy-statement', 'Front\ContentController@privacyDetails')->name('privacy');
        Route::get('/security', 'Front\ContentController@securityDetails')->name('security');
        Route::get('/disclaimer', 'Front\ContentController@disclaimerDetails')->name('disclaimer');
        Route::get('/shipping-and-delivery', 'Front\ContentController@shippingDetails')->name('shipping');
        Route::get('/payment-voucher-promotion', 'Front\ContentController@paymentDetails')->name('payment');
        Route::get('/return-policy', 'Front\ContentController@returnDetails')->name('return');
        Route::get('/refund-policy', 'Front\ContentController@refundDetails')->name('refund');
        Route::get('/service-and-contact', 'Front\ContentController@serviceDetails')->name('service');

        Route::get('/blog', 'Front\ContentController@blog')->name('blog');
        Route::get('/blog/{slug}', 'Front\ContentController@blogDetail')->name('blog.detail');

		Route::get('/blog-demo', 'Front\ContentController@blog2')->name('blog.dummy');
        Route::get('/blog-demo/{slug}', 'Front\ContentController@blogDetail2')->name('blog.detail.dummy');

        Route::get('/about', 'Front\ContentController@about')->name('about');
        Route::get('/contact', 'Front\ContentController@contact')->name('contact');
        Route::post('/add-contact','Front\ContentController@Addcontact')->name('contact.add');

        Route::get('/corporate', 'Front\ContentController@corporate')->name('corporate');
        Route::get('/news', 'Front\ContentController@news')->name('news');
        Route::get('/news/{slug}', 'Front\ContentController@newsDetail')->name('news.detail');

		Route::get('/news-demo', 'Front\ContentController@news2')->name('news.demo');
        Route::get('/news-demo/{slug}', 'Front\ContentController@newsDetail2')->name('news.detail.demo');

        Route::get('/career', 'Front\ContentController@career')->name('career');
        Route::get('/global', 'Front\ContentController@global')->name('global');
    });

    // user login & registration - guard
    Route::middleware(['guest:web'])->group(function () {
        Route::prefix('user/')->name('user.')->group(function () {
            Route::get('/register', 'Front\UserController@showRegistrationForm')->name('register');
            // Route::get('/register', 'Front\UserController@register')->name('register');
            // Route::get('/verify-otp', 'Front\UserController@showVerificationForm')->name('verify-otp');

            // Route::post('register', [RegisterController::class, 'register']);
            // Route::get('verify-otp', [OtpController::class, 'showVerificationForm'])->name('verify.otp');
            // Route::post('verify-otp', [OtpController::class, 'verifyOtp']);
            




            Route::get('register/email/verification','Front\UserController@sendOTP')->name('register.email.verification');
            // Route::post('/send-otp','Front\OTPController@sendOTP')->name('register.email.sendotp');
            Route::post('/register', 'Front\UserController@create')->name('create');
			Route::get('/otp','Front\UserController@showVerifyForm')->name('otp');
			Route::post('/otp', 'Front\UserController@verifyOtp')->name('otp-verify');
            // Route::post('otp/verify', [UserController::class, 'create'])->name('front.user.create');
            // Route::post('/create', [UserController::class, 'create'])->name('front.user.create');
            // Route::post('/create', [UserController::class, 'create'])->name('front.user.create');

            Route::get('otp/verify','Front\OTPController@showVerifyForm')->name('verify');
            Route::post('otp/verify','Front\OTPController@verify');
            Route::get('/login', 'Front\UserController@login')->name('login');

            Route::post('/send-otp', [OtpController::class, 'sendOtp'])->name('send-otp');
            Route::post('/verify-otp', [OtpController::class, 'verifyOtp'])->name('verify-otp');



            Route::post('/check', 'Front\UserController@check')->name('check');
            Route::get('/forgot-password', 'Front\UserController@forgotPassword')->name('forgot.password');
            Route::post('/forgot-password/check', 'Front\UserController@forgotPasswordCheck')->name('forgot.password.check');
        });
    });

    // profile login & registration - guard
    Route::middleware(['auth:web'])->group(function () {
        Route::prefix('user/')->name('user.')->group(function () {
            Route::view('profile', 'front.profile.index')->name('profile');
            Route::view('manage', 'front.profile.edit')->name('manage');
            Route::post('manage/update', 'Front\UserController@updateProfile')->name('manage.update');
            Route::post('password/update', 'Front\UserController@updatePassword')->name('password.update');
            Route::get('order', 'Front\UserController@order')->name('order');
            Route::post('order/cancel', 'Front\UserController@orderCancel')->name('order.cancel');
            Route::get('order/{id}/invoice', 'Front\UserController@invoice')->name('invoice');
            Route::get('order/{id}/address', 'Front\UserController@orderAddress')->name('order.address');
            Route::post('order/{id}/address', 'Front\UserController@orderAddressUpdate')->name('order.address.update');
			Route::get('order/{id}/address', 'Front\UserController@showOrderAddress')->name('order.show.address');
			Route::get('order/{id}/address/billing', 'Front\UserController@orderAddressBilling')->name('order.address.billing');
            Route::post('order/{id}/address/billing', 'Front\UserController@orderAddressBillingUpdate')->name('order.address.billing.update');
            Route::get('coupon', 'Front\UserController@coupon')->name('coupon');
            Route::get('address', 'Front\UserController@address')->name('address');
            Route::view('address/add', 'front.profile.address-add')->name('address.add');
            Route::post('address/add', 'Front\UserController@addressCreate')->name('address.create');
            Route::get('address/edit/{id}', 'Front\UserController@addressEdit')->name('address.edit');
            Route::post('address/edit/{id}', 'Front\UserController@addressUpdate')->name('address.update');
            Route::get('address/delete/{id}', 'Front\UserController@addressDelete')->name('address.delete');
            Route::get('wishlist', 'Front\UserController@wishlist')->name('wishlist');
        });
    });

	// promotion
    Route::prefix('promotion')->name('promotion.')->group(function () {
        Route::get('/', 'Front\PromotionController@index')->name('index');
        Route::post('/store', 'Front\PromotionController@store')->name('store');
		Route::view('/thank-you', 'front.promotion.success')->name('success');
    });
    // city from state
	Route::get('/state/{name}/detail', 'Front\StateController@detail')->name('state.detail');

    // mail template test
    Route::view('/mail/1', 'front.mail.register');
    Route::view('/mail/2', 'front.mail.order-confirm');
});
Route::get('.well-known/pki-validation/7B72D1854F566533389BC0BD6FB16A16.txt', function () {
    return response()->file(public_path('.well-known/pki-validation/7B72D1854F566533389BC0BD6FB16A16.txt'));
});
Auth::routes();

Route::get('login', 'Front\UserController@login')->name('login');

require 'admin.php';
