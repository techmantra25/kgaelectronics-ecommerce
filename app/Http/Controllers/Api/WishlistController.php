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
use App\Models\Wishlist;
use App\Models\Product;
class WishlistController extends Controller
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
    
    //wishlist list
    public function index(Request $request)
    {
        
        #  My Address List Data...
        $user_id = $this->user_id;
        $item= Wishlist::where('user_id',$user_id)->with('productDetails')->get();
      
        return Response::json([
            'status' => true, 
            'message' => "Wishlist  fetched successfully" , 
            'data' => array('wishlist'=>$item)
        ],200);
    }
    //save
    public function save(Request $request)
    {
        # Save Item To Wishlist...
        $validator = Validator::make($request->all(),[
            'product_id' => 'required|exists:products,id',
        ]);

        if(!$validator->fails()){
            $params = $request->except('_token');
            $product_id = $params['product_id'];
            $user_id = $this->user_id;

            $check_exist_item = Wishlist::where('user_id',$user_id)->where('product_id',$product_id)->first();

            if(!empty($check_exist_item)){
                Wishlist::where('user_id',$user_id)->where('product_id',$product_id)->delete();
                return Response::json([
                'status' => true, 
                'message' => "Wishlist deleted successfully" , 
                'data' => array() 
             ],200);
                
            } else {
             $my_data =   Wishlist::insert([
                    'user_id' => $user_id,
                    'product_id' => $product_id,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]);
                return Response::json([
                'status' => true, 
                'message' => "Saved" , 
                
            ],200);
            }
        } else {
            return Response::json([
                'status' => false, 
                'message' => $validator->errors()->first() , 
                'data' => array( $validator->errors() ) 
            ],400);
        }


    }
    public function delete(Request $request)
    {
        # Delete My Cart Data...
        $user_id = $this->user_id;
        //Wishlist::where('id',$request->id)->delete();
        $newEntry = Wishlist::destroy($request->id);
       // if ($newEntry) {
        return Response::json([
            'status' => true, 
            'message' => "Wishlist deleted successfully" , 
            'data' => array() 
        ],200);
        //}
      //  else{
        //     return Response::json([
        //     'status' => false, 
        //     'message' => "Something happend" , 
        //     'data' => array() 
        // ],500);
        // }
    }

}
