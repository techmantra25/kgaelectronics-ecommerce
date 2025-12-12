<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Wishlist;

class ProductController extends Controller
{
    //
    private $user_id;
    public function __construct(Request $request)
    {
        # pass bearer token in Authorizations key...
        if (! empty($request->header('Authorizations'))) {
            $bearer_token = $request->header('Authorizations');
            $token = str_replace("Bearer ","",$bearer_token);            
            try {
                $this->user_id = Crypt::decrypt($token);
                $user = User::find($this->user_id);           
            } catch (DecryptException $e) {
                response()->json(["status"=>false,"message"=>"Mismatched token"],400)->send();
                exit();
            }
        }
    }
    public function list(Request $request)
    {
        # code...
        // echo $this->user_id; die;
        $search = !empty($request->search)?$request->search:'';
        
        $data = Product::select('*');
        
        if(!empty($search)){
            $data = $data->where('name', 'LIKE', '%'.$search.'%');
        }        

        $data = $data->get();

        if(!empty($data)){
            foreach($data as $item){
                $countCart = 0;
                if(!empty($this->user_id)){
                    $check_user_cart = Cart::where('user_id',$this->user_id)->where('product_id',$item->id)->first();
                    if(!empty($check_user_cart)){
                        $countCart = $check_user_cart->qty;
                    }
                }
                $isWishlist = false;
                if(!empty($this->user_id)){
                    $check_user_wishlist = Wishlist::where('user_id',$this->user_id)->where('product_id',$item->id)->first();
                   // dd($check_user_wishlist);
                    if(!empty($check_user_wishlist)){
                        $isWishlist = true;
                    }
                }
                $reviewCount = 0;
               // if(!empty($this->user_id)){
                    $reviewCount = getReviewDetails($item->id)['average_star_count'];
                    $totalPersonReview=getReviewDetails($item->id)['total_person_reviewed'];
                   
               // }
                $review = DB::select("SELECT u.name AS name,r.review AS review,r.rating AS rating FROM reviews AS r INNER JOIN users AS u ON u.id = r.user_id WHERE  r.product_id = '$item->id'");
                $item->countCart = $countCart;
                $item->isWishlist = $isWishlist;
                $item->reviewCount = $reviewCount;
                $item->totalPersonReview =$totalPersonReview;
                $item->review =$review;
            }
        }

        return Response::json([
            'status'=>true,
            'message'=>"Product List",
            'data'=> (object)[
                'products' => $data
            ] 
        ],200);

    }
   
}
