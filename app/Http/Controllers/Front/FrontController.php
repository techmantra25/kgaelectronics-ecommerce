<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubscriptionMail;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\Gallery;
use App\Models\Banner;
use App\Models\FeatureBanner;
use App\Models\Poster;
use App\Models\PromotionalImage;
use App\Models\ProductVideo;
use App\Models\ProductReview;
use Illuminate\Support\Facades\Validator;

class FrontController extends Controller
{
    public function index(Request $request)
    {
        // dd('Hi');
         $category = Category::where('status',1)->latest('id')->get();
		
        // $collections = Collection::latest('id')->get();
        $products = Product::where('is_trending', 1)->latest('view_count', 'id')->get();
        $tvproducts = Product::where('cat_id', 64)->where('status', 1)->latest('id')->get();
		$nonstickproducts = Product::selectRaw('products.*')->join('sales', 'products.id', 'sales.product_id')->where('products.cat_id', 35)->where('products.status', 1)->latest('products.id')->get();
		//dd($nonstickproducts);
		$chimneyproducts = Product::where('cat_id', 89)->where('status', 1)->latest('id')->get();
		$cooktopproducts = Product::where('cat_id', 163)->where('status', 1)->latest('id')->get();
		$nonsticktrandingproducts = Product::where('cat_id', 35)->where('status', 1)->where('is_trending', 1)->latest('id')->get();
		$mouseproducts = Product::where('cat_id', 76)->where('status', 1)->latest('id')->with('color')->limit(2)->get();
		$earphoneproducts = Product::where('cat_id', 77)->where('status', 1)->latest('id')->with('color')->limit(2)->get();
		$earbudproducts = Product::where('cat_id', 71)->where('status', 1)->latest('id')->get();
        $coolerproducts = Product::where('cat_id',162)->where('status',1)->latest('id')->get();
		$sandwichproducts = Product::where('cat_id', 86)->where('status', 1)->latest('id')->first();
		$toasterproducts = Product::where('cat_id', 88)->where('status', 1)->latest('id')->first();
		$inductionproducts = Product::where('cat_id', 84)->where('status', 1)->latest('id')->get();
		$hairdryerproducts = Product::where('cat_id', 85)->where('status', 1)->latest('id')->first();
		$mixerproducts = Product::where('cat_id', 82)->where('status', 1)->latest('id')->get();
		$fanproducts = Product::where('cat_id', 70)->where('status', 1)->latest('id')->with('color')->get();
		$bottleproducts = Product::where('cat_id', 75)->where('status', 1)->latest('id')->get();
		$speakerproducts = Product::where('cat_id', 73)->where('status', 1)->latest('id')->with('color')->get();
        $galleries = Gallery::latest('id')->get();
        $banner = Banner::where('status', 1)->orderBy('position')->get();
		$featureBanner = FeatureBanner::where('status', 1)->orderBy('position')->get();
		$poster = Poster::where('status', 1)->latest('id')->take(1)->get();
		$promotion = PromotionalImage::where('status', 1)->latest('id')->take(2)->get();
		$productVideo = ProductVideo::where('status', 1)->latest('id')->take(2)->get();
		$productReview = ProductReview::where('is_featured', 1)->latest('id')->get();
        return view('front.welcome', compact('products', 'galleries', 'banner','featureBanner','poster','promotion','productVideo','category','tvproducts','nonstickproducts','chimneyproducts','nonsticktrandingproducts','mouseproducts','earphoneproducts','earbudproducts','sandwichproducts','toasterproducts','inductionproducts','mixerproducts','fanproducts','speakerproducts','bottleproducts','productReview','hairdryerproducts','coolerproducts','cooktopproducts'));
    }

    public function mailSubscribe(Request $request)
    {
        $rules = [
            'email' => 'required|email'
        ];

        $validator = Validator::make($request->all(), $rules);

        if (!$validator->fails()) {
            $mailExists = SubscriptionMail::where('email', $request->email)->first();
            if (empty($mailExists)) {
                $mail = new SubscriptionMail();
                $mail->email = $request->email;
                $mail->save();

                return response()->json(['resp' => 200, 'message' => 'Mail subscribed successfully']);
            } else {
                $mailExists->count += 1;
                $mailExists->save();

                return response()->json(['resp' => 200, 'message' => 'Thank you for showing your interest']);
            }
        } else {
            return response()->json(['resp' => 400, 'message' => $validator->errors()->first()]);
        }
    }
}
