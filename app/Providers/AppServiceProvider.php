<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Schema;
use App\Models\Category;
use App\Models\CategoryParent;
use App\Models\Collection;
use App\Models\Settings;
use App\Models\Cart;
use App\Models\Wishlist;
use Auth;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view::composer('*', function($view) {
            $ip = $_SERVER['REMOTE_ADDR'];

            // categories
            $categoryExists = Schema::hasTable('categories');
            if ($categoryExists) {
                $categories = Category::with('parentCatDetails')->latest('id')->where('status', 1)->get();
                // $categories = Category::with('parentCatDetails')->orderBy('parent', 'asc')->orderBy('position', 'asc')->where('status', 1)->get();

                // dd($categories);

                $categoryNavList = [];

                foreach ($categories as $catKey => $catValue) {
					// Check if the parent category name is already in the $categoryNavList array
					if($catValue->parentCatDetails!=null){
						if (in_array_r($catValue->parentCatDetails ? $catValue->parentCatDetails->name : '', array_column($categoryNavList, 'parent'))) {
							continue; // Skip this iteration if the parent category is already in the list
						}
					}

					// Fetch child categories for the current parent category
					$childCategories = Category::select('slug', 'name', 'sketch_icon', 'image_path')
						->where('parent', $catValue->parent)
						->orderBy('position', 'asc')
						->where('status', 1)
						->get()
						->toArray();

					// Add the parent category and its child categories to the $categoryNavList array
					$categoryNavList[] = [
						'parent' => $catValue->parentCatDetails ? $catValue->parentCatDetails->name : '',
						'child' => $childCategories
					];
				}

            }

            // dd($categoryNavList);

            // collections
            $collectionExists = Schema::hasTable('collections');
            if ($collectionExists) {
                $collections = Collection::orderBy('position', 'asc')->orderBy('id', 'desc')->where('status', 1)->get();
            }

            // settings
            $settingsExists = Schema::hasTable('settings');
            if ($settingsExists) {
                $settings = Settings::where('status', 1)->get();
            }

            // cart count
            $cartExists = Schema::hasTable('carts');
            if ($cartExists) {
                if (Auth::guard('web')->check()) {
                    $cartCount = Cart::where('user_id', Auth::guard('web')->user()->id)->get();
					
                } else {
                   
                        $cartCount = [];
                    
                }

                $totalCartProducts = 0;
                if(count($cartCount) > 0) {
                    foreach($cartCount as $cartKey => $cartVal) {
                        $totalCartProducts += $cartVal->qty;
                    }
                }
				
            }

            // wishlist count
            $wishlistExists = Schema::hasTable('wishlists');
            
            if ($wishlistExists) {
                if (Auth::guard('web')->check()) {
                    $user_id = Auth::guard('web')->user()->id;
                    $wishlistCount = Wishlist::where('user_id', $user_id)->count();
                } else {
                    $wishlistCount = 0;
                }
            }

            view()->share('categories', $categories);
            view()->share('categoryNavList', $categoryNavList);
            view()->share('collections', $collections);
            view()->share('settings', $settings);
            view()->share('cartCount', $totalCartProducts);
            view()->share('wishlistCount', $wishlistCount);
        });
    }
}
