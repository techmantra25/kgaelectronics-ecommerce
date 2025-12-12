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
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\CouponUsage;
use Illuminate\Support\Facades\Session;
class CartController extends Controller
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
        # add or remove items to cart...
        $validator = Validator::make($request->all(),[
            'product_id' => 'required|exists:products,id',
            'qty' => 'required|integer'
        ]);

        if(!$validator->fails()){

            $params = $request->except('_token');
            $product_id = $params['product_id'];
            $qty = $params['qty'];
            $user_id = $this->user_id;

            $check_exist_cart = Cart::where('user_id',$user_id)->where('product_id',$product_id)->first();

            if(empty($check_exist_cart)){
                # Insert
                if($qty != 0){
                    Cart::insert([
                        'user_id' => $user_id,
                        'product_id' => $product_id,
                        'qty' => $qty,
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                }
                
            } else {
                # Update
                if($qty == 0){
                    Cart::where('user_id',$user_id)->where('product_id',$product_id)->delete();
                } else {
                    Cart::where('user_id',$user_id)->where('product_id',$product_id)->update(['qty'=>$qty,'updated_at' => date('Y-m-d H:i:s')]);
                }
            }

            $my_cart = Cart::select('product_id','qty')->where('user_id',$user_id)->get();

            return Response::json([
                'status' => true, 
                'message' => "Saved" , 
                'data' => array(
                    'my_cart' => $my_cart
                ) 
            ],200);

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
        Cart::where('user_id',$user_id)->delete();

        return Response::json([
            'status' => true, 
            'message' => "Cart deleted successfully" , 
            'data' => array() 
        ],200);
    }
//cart list
   //cart list
    public function index(Request $request)
    {
        #  My Cart List Data...
        $user_id = $this->user_id;
        $subTotal = $grandTotal = $couponCodeDiscount = $shippingCharges = $taxPercent = 0;
        $cart= Cart::where('user_id',$user_id)->with('product')->get();
        $couponCode=$cart[0]->couponDetails->coupon_code ?? '';
        // coupon check
        if (!empty($cart[0]->coupon_code_id)) {
            $coupon_code_id = $cart[0]->coupon_code_id;
            $coupon_code_end_date = $cart[0]->couponDetails->end_date;
            $coupon_code_status = $cart[0]->couponDetails->status;
            $coupon_code_max_usage_for_one = $cart[0]->couponDetails->max_time_one_can_use;

            // coupon code validity check
            if ($coupon_code_end_date < \Carbon\Carbon::now() || $coupon_code_status == 0) {
                Cart::where('user_id', $this->user_id)->update(['coupon_code_id' => null]);
            }

            // coupon code usage check
            if ($user_id) {
                $couponUsageCount = CouponUsage::where('coupon_code_id', $coupon_code_id)
                ->where('user_id', $user_id)
                // ->orWhere('email', Auth::guard('web')->user()->email)
                ->count();
            } else {
                $couponUsageCount = CouponUsage::where('coupon_code_id', $coupon_code_id)->where('user_id', $this->user_id)->count();
            }

            if ($couponUsageCount == $coupon_code_max_usage_for_one || $couponUsageCount > $coupon_code_max_usage_for_one) {
                Cart::where('user_id', $this->user_id)->update(['coupon_code_id' => null]);
            }
        }
        foreach($cart as $cartValue){
             // subtotal calculation
             $subTotal += (int) $cartValue->product->offer_price * $cartValue->qty;

             // coupon code calculation
             if (!empty($cart[0]->coupon_code_id)) {
                 // 1 is coupon, else voucher
                 if (($cart[0]->couponDetails->is_coupon == 1)) {
                     if($cart[0]->couponDetails->type == 1){
                         $couponCodeDiscount = (int) ($subTotal * ($cart[0]->couponDetails->amount / 100));
                     }else{
                         $couponCodeDiscount = (int) $cart[0]->couponDetails->amount;
                     }
                 } else {
                     if($cart[0]->couponDetails->type == 1){
                         $couponCodeDiscount = (int) ($subTotal * ($cart[0]->couponDetails->amount / 100));
                     }else{
                         $couponCodeDiscount = (int) $cart[0]->couponDetails->amount;
                     }   
                 }
             }

             // grand total calculation
             $grandTotalWithoutCoupon = $subTotal;
             $grandTotal = ($subTotal + $shippingCharges) - $couponCodeDiscount;
             if($grandTotal < 0){
                 $grandTotal = 0;
             }
        }
        return Response::json([
            'status' => true, 
            'message' => "Cart list fetched successfully" , 
            'data' => array('cart'=>$cart,'total'=>$subTotal,'shipping_charges'=>$shippingCharges,'grandtotal'=>$grandTotal,'couponDiscount'=>$couponCodeDiscount,'couponCode'=>$couponCode)
        ],200);
    }
    
    //coupon check
    
    public function couponCheck(Request $request)
    {
        $user_id = $this->user_id;
        // check coupon/ voucher code is valid or not
        $couponData = Coupon::where('coupon_code', $request->coupon_code)->first();
        //dd($couponData);
        if($couponData) {
            if ($user_id) {
                $couponUsageCount = CouponUsage::where('coupon_code_id', $couponData->id)
                ->where('user_id', $user_id)
                ->count();
                // dd($couponData->id, $couponUsageCount);
            } else {
                $couponUsageCount = CouponUsage::where('coupon_code_id', $couponData->id)->where('user_id', $user_id)->count();
            }

            $is_coupon = ($couponData->is_coupon == 1) ? 'coupon' : 'voucher';

            // check code status & expiry date
            if ($couponData->end_date < \Carbon\Carbon::now() || $couponData->status == 0) {
                return response()->json(['status' => false, 'type' => 'warning', 'message' => $is_coupon.' expired']);
            }
            // check use usage & code usage
            elseif (
                ($couponUsageCount == $couponData->max_time_one_can_use) || 
                ($couponUsageCount > $couponData->max_time_one_can_use)
            ) {
                return response()->json(['status' => false, 'type' => 'warning', 'message' => 'You cannot use this '.$is_coupon.' anymore']);
            } else {
                $totalCartAmount = 0; 
                $cartData = Cart::where('user_id', $user_id)->get();
                foreach ($cartData as $value) {
                    $totalCartAmount += ($value->product->offer_price * $value->qty);
                }
                
                // if($couponData->type == 2 && $couponData->amount > $totalCartAmount){
                //     return response()->json(['resp' => 200, 'type' => 'warning', 'message' => 'Please place a minimum order of Rs.'.($couponData->amount+1).', to use this coupon']);
                // }else{
                    // applied coupon, update in cart
                $cartData = Cart::where('user_id', $user_id)->update(['coupon_code_id' => $couponData->id]);
                Session::put('couponCodeId', $couponData->id);
                // Session::get('couponCodeId');
                // $is_coupon = ($couponData->is_coupon == 1) ? 'coupon' : 'voucher';
                return response()->json(['status' => true, 'type' => 'success',  'message' => $is_coupon.' applied', 'id' => $couponData->id, 'coupon_type' => $couponData->type, 'amount' => $couponData->amount, 'coupon_discount' => $couponData->amount, 'is_coupon' => $is_coupon]);
                // }
            }
        }

        return response()->json(['status' => false, 'type' => 'error', 'message' => 'Invalid code']);
    }
    
    //coupon remove
    public function couponRemove()
    {
        $user_id = $this->user_id;
        $cartData = Cart::where('user_id', $user_id)->update(['coupon_code_id' => null]);
        return response()->json(['status' => true, 'type' => 'success', 'message' => 'Coupon removed']);
    }

}
