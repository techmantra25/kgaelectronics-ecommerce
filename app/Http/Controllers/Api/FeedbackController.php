<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Models\Review;

class FeedbackController extends Controller
{
    //

    private $user_id;
    public function __construct(Request $request)
    {
        # pass bearer token in Authorizations key...
        if (! $request->hasHeader('Authorizations')) {
            response()->json(["status"=>false,"message"=>"Unauthorized"],401)->send();
            exit();
        } else {
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

    public function save(Request $request)
    {
        # Save Item To Wishlist...
        $validator = Validator::make($request->all(),[
            'product_id' => 'required|exists:products,id',
            'rating' => 'required',
            'review' => 'required',
        ]);

        if(!$validator->fails()){
            $params = $request->except('_token');
            $product_id = $params['product_id'];
            $user_id = $this->user_id;

            Review::insert([
                'user_id' => $user_id,
                'product_id' => $product_id,
                'rating' => $params['rating'],
                'review' => $params['review'],
                'created_at' => date('Y-m-d H:i:s')
            ]);
            return Response::json([
                'status' => true, 
                'message' => "Feedback Added",
            ],200);
        } else {
            return Response::json([
                'status' => false, 
                'message' => $validator->errors()->first() , 
                'data' => array( $validator->errors() ) 
            ],400);
        }


    }

}
