<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Interfaces\ProductInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Product;
use App\Models\ProductColorSize;
use App\Models\ProductImage;
use DB;
class ProductController extends Controller
{
    public function __construct(ProductInterface $productRepository) 
    {
        $this->productRepository = $productRepository;
    }

    public function detail(Request $request, $slug)
    {
		
        $data = $this->productRepository->listBySlug($slug);
		
        $images = $this->productRepository->listImagesById($data->id);
        $relatedProducts = $this->productRepository->relatedProducts($data->id);
		//dd($relatedProducts);
        $wishlistCheck = $this->productRepository->wishlistCheck($data->id);
       
        $reviewCount = getReviewDetails($data->id)['average_star_count'];
        $totalPersonReview=getReviewDetails($data->id)['total_person_reviewed'];
        $review = DB::select("SELECT u.name AS name,r.review AS review,r.rating AS rating FROM reviews AS r INNER JOIN users AS u ON u.id = r.user_id WHERE  r.product_id = '$data->id'");
        if ($data) {
            return view('front.product.detail', compact('data', 'images', 'relatedProducts', 'wishlistCheck', 'reviewCount','totalPersonReview','review'));
        } else {
            return view('front.404');
        }
    }

    public function size(Request $request)
    {
        $productId = $request->productId;
        $colorId = $request->colorId;

        $data = ProductColorSize::where('product_id', $productId)->where('color', $colorId)->orderBy('size')->get();
        $dataImage = ProductImage::where('product_id', $productId)->where('color_id', $colorId)->orderBy('id')->get();

        $resp = [];

        foreach ($data as $dataKey => $dataValue) {
            if ($dataValue->size != 0) {
                $resp[] = [
                    'variationId' => $dataValue->id,
                    'sizeId' => $dataValue->size,
                    'sizeName' => $dataValue->sizeDetails->name,
                    'price' => $dataValue->price,
                    'offerPrice' => $dataValue->offer_price,
                ];
            }
        }

        $respImage = [];

        if ($dataImage->count() > 0) {
            foreach ($dataImage as $dataKey => $dataValue) {
                $respImage[] = [
                    'image' => asset($dataValue->image),
                ];
            }
        } else {
            $mainImage = Product::select('image')->where('id', $productId)->first();
            $respImage[] = [
                'image' => asset($mainImage->image)
            ];
        }

        return response()->json(['error' => false, 'data' => $resp, 'images' => $respImage]);
    }
}
