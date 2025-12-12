<?php

// admin guard
Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware(['guest:admin'])->group(function () {
        Route::view('/login', 'admin.auth.login')->name('login');
        Route::post('/check', 'Admin\AdminController@check')->name('login.check');
    });

    Route::middleware(['auth:admin'])->group(function () {
        // dashboard
        // Route::get('/update-product-image-path', 'Admin\ProductController@update_image_path');
        Route::get('/home', 'Admin\AdminController@home')->name('home');
        Route::post('/logout', 'Admin\AdminController@logout')->name('logout');

        // category
        Route::prefix('category')->name('category.')->group(function () {
            Route::get('/', 'Admin\CategoryController@index')->name('index');
            // Route::get('/active', 'Admin\CategoryController@activeCategory')->name('active');
            // Route::get('/inactive', 'Admin\CategoryController@inactiveCategory')->name('inactive');
            Route::post('/store', 'Admin\CategoryController@store')->name('store');
            Route::get('/{id}/view', 'Admin\CategoryController@show')->name('view');
            Route::post('/{id}/update', 'Admin\CategoryController@update')->name('update');
            Route::get('/{id}/status', 'Admin\CategoryController@status')->name('status');
            Route::get('/{id}/delete', 'Admin\CategoryController@destroy')->name('delete');
            Route::get('/bulkDelete', 'Admin\CategoryController@bulkDestroy')->name('bulkDestroy');
			Route::post('/banner/add', 'Admin\CategoryController@bannerAdd')->name('banner.add');
            Route::post('/banner/edit/{id}', 'Admin\CategoryController@bannerEdit')->name('banner.edit');
            Route::get('/banner/{id}/delete', 'Admin\CategoryController@bannerDestroy')->name('banner.delete');
        });

        // sub-category
        Route::prefix('subcategory')->name('subcategory.')->group(function () {
            Route::get('/', 'Admin\SubCategoryController@index')->name('index');
            Route::post('/store', 'Admin\SubCategoryController@store')->name('store');
            Route::get('/{id}/view', 'Admin\SubCategoryController@show')->name('view');
            Route::post('/{id}/update', 'Admin\SubCategoryController@update')->name('update');
            Route::get('/{id}/status', 'Admin\SubCategoryController@status')->name('status');
            Route::get('/{id}/delete', 'Admin\SubCategoryController@destroy')->name('delete');
            Route::get('/bulkDelete', 'Admin\SubCategoryController@bulkDestroy')->name('bulkDestroy');
        });

        // collection
        Route::prefix('collection')->name('collection.')->group(function () {
            Route::get('/', 'Admin\CollectionController@index')->name('index');
            Route::post('/store', 'Admin\CollectionController@store')->name('store');
            Route::get('/{id}/view', 'Admin\CollectionController@show')->name('view');
            Route::post('/{id}/update', 'Admin\CollectionController@update')->name('update');
            Route::get('/{id}/status', 'Admin\CollectionController@status')->name('status');
            Route::get('/{id}/delete', 'Admin\CollectionController@destroy')->name('delete');
            Route::get('/bulkDelete', 'Admin\CollectionController@bulkDestroy')->name('bulkDestroy');
        });

		// color
        Route::prefix('color')->name('color.')->group(function () {
            Route::get('/', 'Admin\ColorController@index')->name('index');
			Route::get('/create', 'Admin\ColorController@create')->name('create');
            Route::post('/store', 'Admin\ColorController@store')->name('store');
            Route::get('/{id}/view', 'Admin\ColorController@show')->name('view');
			Route::get('/{id}/edit', 'Admin\ColorController@edit')->name('edit');
            Route::post('/{id}/update', 'Admin\ColorController@update')->name('update');
            Route::get('/{id}/status', 'Admin\ColorController@status')->name('status');
        });

		// size
        Route::prefix('size')->name('size.')->group(function () {
            Route::get('/', 'Admin\SizeController@index')->name('index');
			Route::get('/create', 'Admin\SizeController@create')->name('create');
            Route::post('/store', 'Admin\SizeController@store')->name('store');
            Route::get('/{id}/view', 'Admin\SizeController@show')->name('view');
			Route::get('/{id}/edit', 'Admin\SizeController@edit')->name('edit');
            Route::post('/{id}/update', 'Admin\SizeController@update')->name('update');
            Route::get('/{id}/status', 'Admin\SizeController@status')->name('status');
        });

        // coupon
        Route::prefix('coupon')->name('coupon.')->group(function () {
            Route::get('/', 'Admin\CouponController@index')->name('index');
            Route::post('/store', 'Admin\CouponController@store')->name('store');
            Route::get('/{id}/view', 'Admin\CouponController@show')->name('view');
            Route::post('/{id}/update', 'Admin\CouponController@update')->name('update');
            Route::get('/{id}/status', 'Admin\CouponController@status')->name('status');
            Route::get('/{id}/delete', 'Admin\CouponController@destroy')->name('delete');
            Route::get('/bulkDelete', 'Admin\CouponController@bulkDestroy')->name('bulkDestroy');
        });

        // voucher
        Route::prefix('voucher')->name('voucher.')->group(function () {
            Route::get('/', 'Admin\VoucherController@index')->name('index');
            Route::get('/create', 'Admin\VoucherController@create')->name('create');
            Route::get('/csv/export', 'Admin\VoucherController@csvExport')->name('csv.export');
            Route::get('{slug}/csv/export', 'Admin\VoucherController@csvExportSlug')->name('detail.csv.export');
            Route::post('/store', 'Admin\VoucherController@store')->name('store');
            Route::get('/{id}/view', 'Admin\VoucherController@show')->name('view');
            Route::post('/{id}/update', 'Admin\VoucherController@update')->name('update');
            Route::get('/{id}/status', 'Admin\VoucherController@status')->name('status');
            Route::get('/{id}/delete', 'Admin\VoucherController@destroy')->name('delete');
            Route::get('/bulkDelete', 'Admin\VoucherController@bulkDestroy')->name('bulkDestroy');
        });

        // customer
        Route::prefix('customer')->name('customer.')->group(function () {
            Route::get('/', 'Admin\UserController@index')->name('index');
            Route::post('/store', 'Admin\UserController@store')->name('store');
            Route::get('/{id}/view', 'Admin\UserController@show')->name('view');
            Route::post('/{id}/update', 'Admin\UserController@update')->name('update');
            Route::get('/{id}/status', 'Admin\UserController@status')->name('status');
            Route::get('/{id}/delete', 'Admin\UserController@destroy')->name('delete');
            Route::get('/bulkDelete', 'Admin\UserController@bulkDestroy')->name('bulkDestroy');
        });

        // product
        Route::prefix('product')->name('product.')->group(function () {
            Route::get('/list', 'Admin\ProductController@index')->name('index');
            Route::get('/create', 'Admin\ProductController@create')->name('create');
            Route::post('/store', 'Admin\ProductController@store')->name('store');
            Route::get('/{id}/view', 'Admin\ProductController@show')->name('view');
            Route::post('/size', 'Admin\ProductController@size')->name('size');
            Route::get('/{id}/edit', 'Admin\ProductController@edit')->name('edit');
            Route::post('/update', 'Admin\ProductController@update')->name('update');
            Route::get('/{id}/status', 'Admin\ProductController@status')->name('status');
            Route::get('/{id}/sale', 'Admin\ProductController@sale')->name('sale');
            Route::get('/{id}/trending', 'Admin\ProductController@trending')->name('trending');
            Route::get('/{id}/delete', 'Admin\ProductController@destroy')->name('delete');
            Route::get('/{id}/image/delete', 'Admin\ProductController@destroySingleImage')->name('image.delete');
            Route::get('/bulkDelete', 'Admin\ProductController@bulkDestroy')->name('bulkDestroy');
            Route::get('/{id}/sync', 'Admin\UnicommerceController@sync')->name('unicommerce.sync');
            Route::get('/{id}/sync/single', 'Admin\UnicommerceController@syncSingle')->name('unicommerce.sync.single');

            // variation
            Route::post('/specification/add', 'Admin\ProductController@specificationAdd')->name('specification.add');
            Route::post('/specification/edit/{id}', 'Admin\ProductController@specificationEdit')->name('specification.edit');
            Route::get('/specification/{id}/delete', 'Admin\ProductController@specificationDestroy')->name('specification.delete');
            Route::post('/feature/add', 'Admin\ProductController@featureAdd')->name('feature.add');
            Route::post('/feature/edit/{id}', 'Admin\ProductController@featureEdit')->name('feature.edit');
            Route::get('/feature/{id}/remove', 'Admin\ProductController@featureDestroy')->name('feature.delete');
            Route::post('/variation/image/add', 'Admin\ProductController@variationImageUpload')->name('variation.image.add');
            Route::post('/variation/image/remove', 'Admin\ProductController@variationImageDestroy')->name('variation.image.delete');
            Route::post('/csv/upload', 'Admin\ProductController@variationCSVUpload')->name('variation.csv.upload');
            Route::post('/bulk/edit', 'Admin\ProductController@variationBulkEdit')->name('variation.bulk.edit');
            Route::post('/bulk/update', 'Admin\ProductController@variationBulkUpdate')->name('variation.bulk.update');
			
			Route::post('/reviewvideo/add', 'Admin\ProductController@videolinkAdd')->name('videolink.add');
            Route::post('/reviewvideo/edit/{id}', 'Admin\ProductController@videolinkEdit')->name('videolink.edit');
            Route::get('/reviewvideo/{id}/delete', 'Admin\ProductController@videolinkDestroy')->name('videolink.delete');
			
			 Route::post('/featureimage/add', 'Admin\ProductController@featureImageAdd')->name('featureImage.add');
            Route::post('/featureimage/edit/{id}', 'Admin\ProductController@featureImageEdit')->name('featureImage.edit');
            Route::get('/featureimage/{id}/delete', 'Admin\ProductController@featureImageDestroy')->name('featureImage.delete');
            // Route::get('/variation/{id}/image/remove', 'Admin\ProductController@variationImageDestroy')->name('variation.image.delete');
        });

        // address
        Route::prefix('address')->name('address.')->group(function () {
            Route::get('/', 'Admin\AddressController@index')->name('index');
            Route::post('/store', 'Admin\AddressController@store')->name('store');
            Route::get('/{id}/view', 'Admin\AddressController@show')->name('view');
            Route::post('/{id}/update', 'Admin\AddressController@update')->name('update');
            Route::get('/{id}/status', 'Admin\AddressController@status')->name('status');
            Route::get('/{id}/delete', 'Admin\AddressController@destroy')->name('delete');
            Route::get('/bulkDelete', 'Admin\AddressController@bulkDestroy')->name('bulkDestroy');
        });

        // faq
        Route::prefix('faq')->name('faq.')->group(function () {
            Route::get('/', 'Admin\FaqController@index')->name('index');
            Route::post('/store', 'Admin\FaqController@store')->name('store');
            Route::get('/{id}/view', 'Admin\FaqController@show')->name('view');
            Route::post('/{id}/update', 'Admin\FaqController@update')->name('update');
            Route::get('/{id}/status', 'Admin\FaqController@status')->name('status');
            Route::get('/{id}/delete', 'Admin\FaqController@destroy')->name('delete');
        });

		// banner
        Route::prefix('banner')->name('banner.')->group(function () {
            Route::get('/', 'Admin\BannerController@index')->name('index');
            Route::post('/store', 'Admin\BannerController@store')->name('store');
            Route::get('/{id}/view', 'Admin\BannerController@show')->name('view');
            Route::post('/{id}/update', 'Admin\BannerController@update')->name('update');
            Route::get('/{id}/status', 'Admin\BannerController@status')->name('status');
            Route::get('/{id}/delete', 'Admin\BannerController@destroy')->name('delete');
        });
		
		// feature banner
        Route::prefix('feature-banner')->name('feature-banner.')->group(function () {
            Route::get('/', 'Admin\FeatureBannerController@index')->name('index');
            Route::post('/store', 'Admin\FeatureBannerController@store')->name('store');
            Route::get('/{id}/view', 'Admin\FeatureBannerController@show')->name('view');
            Route::post('/{id}/update', 'Admin\FeatureBannerController@update')->name('update');
            Route::get('/{id}/status', 'Admin\FeatureBannerController@status')->name('status');
            Route::get('/{id}/delete', 'Admin\FeatureBannerController@destroy')->name('delete');
        });
		
		// poster
        Route::prefix('poster')->name('poster.')->group(function () {
            Route::get('/', 'Admin\PosterController@index')->name('index');
            Route::post('/store', 'Admin\PosterController@store')->name('store');
            Route::get('/{id}/view', 'Admin\PosterController@show')->name('view');
            Route::post('/{id}/update', 'Admin\PosterController@update')->name('update');
            Route::get('/{id}/status', 'Admin\PosterController@status')->name('status');
            Route::get('/{id}/delete', 'Admin\PosterController@destroy')->name('delete');
        });
		
		// poster
        Route::prefix('promotion-image')->name('promotion-image.')->group(function () {
            Route::get('/', 'Admin\PromotionalController@index')->name('index');
            Route::post('/store', 'Admin\PromotionalController@store')->name('store');
            Route::get('/{id}/view', 'Admin\PromotionalController@show')->name('view');
            Route::post('/{id}/update', 'Admin\PromotionalController@update')->name('update');
            Route::get('/{id}/status', 'Admin\PromotionalController@status')->name('status');
            Route::get('/{id}/delete', 'Admin\PromotionalController@destroy')->name('delete');
        });

        // product-review
        Route::prefix('product-review')->name('product-review.')->group(function () {
            Route::get('/', 'Admin\ReviewController@index')->name('index');
            Route::post('/store', 'Admin\ReviewController@store')->name('store');
            Route::get('/{id}/view', 'Admin\ReviewController@show')->name('view');
            Route::post('/{id}/update', 'Admin\ReviewController@update')->name('update');
            Route::get('/{id}/status', 'Admin\ReviewController@status')->name('status');
            Route::get('/{id}/delete', 'Admin\ReviewController@destroy')->name('delete');
			Route::get('/{id}/trending', 'Admin\ReviewController@trending')->name('trending');
        });

        // product-video
        Route::prefix('product-video')->name('product-video.')->group(function () {
            Route::get('/', 'Admin\VideoController@index')->name('index');
            Route::post('/store', 'Admin\VideoController@store')->name('store');
            Route::get('/{id}/view', 'Admin\VideoController@show')->name('view');
            Route::post('/{id}/update', 'Admin\VideoController@update')->name('update');
            Route::get('/{id}/status', 'Admin\VideoController@status')->name('status');
            Route::get('/{id}/delete', 'Admin\VideoController@destroy')->name('delete');
        });
        // settings
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', 'Admin\SettingsController@index')->name('index');
            Route::post('/store', 'Admin\SettingsController@store')->name('store');
            Route::get('/{id}/view', 'Admin\SettingsController@show')->name('view');
            Route::post('/{id}/update', 'Admin\SettingsController@update')->name('update');
            Route::get('/{id}/status', 'Admin\SettingsController@status')->name('status');
            Route::get('/{id}/delete', 'Admin\SettingsController@destroy')->name('delete');
            Route::get('/bulkDelete', 'Admin\SettingsController@bulkDestroy')->name('bulkDestroy');
        });

        // order
        Route::prefix('order')->name('order.')->group(function () {
            Route::get('/', 'Admin\OrderController@index')->name('index');
            Route::post('/store', 'Admin\OrderController@store')->name('store');
            Route::get('/{id}/view', 'Admin\OrderController@show')->name('view');
            Route::get('/{id}/invoice', 'Admin\OrderController@invoice')->name('invoice');
            Route::post('/{id}/update', 'Admin\OrderController@update')->name('update');
            Route::get('/{id}/status/{status}', 'Admin\OrderController@status')->name('status');
            Route::post('/status', 'Admin\OrderController@statusPost')->name('status');
        });

        // transaction
        Route::prefix('transaction')->name('transaction.')->group(function () {
            Route::get('/', 'Admin\TransactionController@index')->name('index');
            Route::get('/{id}/view', 'Admin\TransactionController@show')->name('view');
        });

        // gallery
        Route::prefix('gallery')->name('gallery.')->group(function () {
            Route::get('/', 'Admin\GalleryController@index')->name('index');
            Route::post('/store', 'Admin\GalleryController@store')->name('store');
            Route::get('/{id}/view', 'Admin\GalleryController@show')->name('view');
            Route::post('/{id}/update', 'Admin\GalleryController@update')->name('update');
            Route::get('/{id}/status', 'Admin\GalleryController@status')->name('status');
            Route::get('/{id}/delete', 'Admin\GalleryController@destroy')->name('delete');
        });

        Route::prefix('blog')->name('blog.')->group(function () {
            Route::get('/', 'Admin\BlogController@index')->name('index');
            Route::post('/store', 'Admin\BlogController@store')->name('store');
            Route::get('/{id}/view', 'Admin\BlogController@show')->name('view');
            Route::post('{id}/update', 'Admin\BlogController@update')->name('update');
            Route::get('/{id}/status', 'Admin\BlogController@status')->name('status');
            Route::get('/{id}/delete', 'Admin\BlogController@destroy')->name('delete');
        });
        
        Route::prefix('news')->name('news.')->group(function () {
            Route::get('/', 'Admin\NewsController@index')->name('index');
            Route::post('/store', 'Admin\NewsController@store')->name('store');
            Route::get('/{id}/view', 'Admin\NewsController@show')->name('view');
            Route::post('{id}/update', 'Admin\NewsController@update')->name('update');
            Route::get('/{id}/status', 'Admin\NewsController@status')->name('status');
            Route::get('/{id}/delete', 'Admin\NewsController@destroy')->name('delete');
        });

        Route::prefix('global')->name('global.')->group(function(){
            Route::get('/','Admin\GlobalController@index')->name('index');
            Route::post('/store','Admin\GlobalController@store')->name('store');
            Route::get('/{id}/view','Admin\GlobalController@show')->name('view');
            Route::post('/{id}/update','Admin\GlobalController@update')->name('update');
            Route::get('/{id}/status','Admin\GlobalController@status')->name('status');
            Route::get('/{id}/delete','Admin\GlobalController@delete')->name('delete');
        });

        // mail
        Route::prefix('subscription/mail')->name('subscription.mail.')->group(function () {
            Route::get('/', 'Admin\SubscriptionMailController@index')->name('index');
            Route::post('/comment/add', 'Admin\SubscriptionMailController@comment')->name('comment.add');
        });

        // franchise
        Route::prefix('franchise')->name('franchise.')->group(function () {
            Route::get('/', 'Admin\FranchiseController@index')->name('index');
            Route::get('/{id}/details', 'Admin\FranchiseController@details')->name('details');
            Route::post('/comment/add', 'Admin\FranchiseController@comment')->name('comment.add');

          Route::prefix('requisite')->name('requisite.')->group(function(){
               Route::get('/','Admin\FranchiseController@RequisiteIndex')->name('index');
               Route::post('/store','Admin\FranchiseController@RequisiteStore')->name('store');
               Route::get('/view/{id}','Admin\FranchiseController@RequisiteView')->name('show');
               Route::post('/update','Admin\FranchiseController@RequisiteUpdate')->name('update');
               Route::get('/status/{id}','Admin\FranchiseController@RequisiteStatus')->name('status');
               Route::get('/delete/{id}','Admin\FranchiseController@RequisiteDelete')->name('delete');
          });
          Route::prefix('our_stores')->name('our_stores.')->group(function(){
               Route::get('/','Admin\FranchiseController@StoresIndex')->name('index');
               Route::post('/store','Admin\FranchiseController@store')->name('store');
               Route::get('/view/{id}','Admin\FranchiseController@show')->name('show');
               Route::post('/update','Admin\FranchiseController@update')->name('update');
               Route::get('/status/{id}','Admin\FranchiseController@status')->name('status');
               Route::get('/delete/{id}','Admin\FranchiseController@delete')->name('delete');
          });
          Route::prefix('marketing')->name('marketing.')->group(function(){
               Route::get('/','Admin\FranchiseController@MarketingIndex')->name('index');
               Route::post('/store','Admin\FranchiseController@MarketingStore')->name('store');
               Route::get('/view/{id}','Admin\FranchiseController@MarketingShow')->name('show');
               Route::post('/update','Admin\FranchiseController@MarketingUpdate')->name('update');
               Route::get('/status/{id}','Admin\FranchiseController@MarketingStatus')->name('status');
               Route::get('/delete/{id}','Admin\FranchiseController@MarketingDelete')->name('delete');
          });


        });

        // Promotions
        Route::prefix('promotions')->name('promotion.')->group(function(){
            Route::get('/', 'Admin\PromotionController@index')->name('index');
        });
    });
});