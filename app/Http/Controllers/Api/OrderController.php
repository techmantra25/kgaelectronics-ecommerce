<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\DB;
use Auth;
use App\User;
use App\Models\Cart;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Address;
use App\Models\Settings;
use App\Models\Product;
use App\Models\Transaction;
class OrderController extends Controller
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

    public function place(Request $request)
    {
        # Place Order...

        $validator = Validator::make($request->all(),[
             'address_id' => 'required',
             'final_amount' => 'required',
             'payment_method' => 'required'
        ]);

        if(!$validator->fails()){
            $params = $request->except('_token');
            // $product_id = $params['product_id'];
            $user_id = $this->user_id;
            $shippingCharge=0;
            $check_existing_cart = Cart::where('user_id',$user_id)->get()->toarray();

             if(!empty($check_existing_cart)){
            //     // dd($check_existing_cart);
            //     foreach($check_existing_cart as $items){
            //         //dd($items['product_id']);
            //     }
            // } else {
            //     return Response::json([
            //         'status' => false, 
            //         'message' => "No items found in your cart", 
            //         'data' => array() 
            //     ],200);
            // }

            // 1 order sequence
           // $OrderChk = Order::select('order_sequence_int')->latest('id')->first();
            
            //if($OrderChk->order_sequence_int == 0) $orderSeq = 1;
           // else $orderSeq = (int) $OrderChk->order_sequence_int + 1;

            //$ordNo = "KGA".mt_rand();
            $settings = Settings::all();
			$nextYear = 24; 
            $curYear = date('y');
            $order_no = "KGA".$curYear . (($curYear != $nextYear) ? '-' . $nextYear : '').'/'.mt_rand();
           // $order_no = "OIS".date('y').'/'.$ordNo;

            // 2 order place
            $newEntry = new Order;
            //$newEntry->order_sequence_int = $orderSeq;
            $newEntry->order_no = $order_no;
            $newEntry->user_id = $user_id;
            //$newEntry->ip = $this->ip;
            $userDetails=User::where('id',$user_id)->first();
            $newEntry->email = $userDetails->email;
            $newEntry->mobile = $userDetails->mobile;
            $newEntry->fname = $userDetails->fname;
            $newEntry->lname = $userDetails->lname;
            $address = Address::where('id',$params['address_id'])->first();
            $newEntry->shipping_country = $address->country;
            $newEntry->shipping_address = $address->address;
            $newEntry->shipping_landmark = $address->landmark;
            $newEntry->shipping_city = $address->city;
            $newEntry->shipping_state = $address->state;
            $newEntry->shipping_pin = $address->pin;
            $newEntry->payment_method =$params['payment_method'];
            // fetch cart details
            // $cartData = Cart::where('ip', $this->ip)->get();
            if (!empty($user_id)) {
                $cartData = Cart::where('user_id', $user_id)->get();
            } else {
                if (!empty($_COOKIE['cartToken'])) {
                    $cartData = Cart::where('guest_token', $_COOKIE['cartToken'])->get();
                } else {
                    $cartData = [];
                    return false;
                }
            }

            $subtotal = 0;
            foreach($cartData as $cartValue) {
                $subtotal += $request->final_amount;
            }
            $coupon_code_id = $cartData[0]->coupon_code_id ?? 0;
            $newEntry->coupon_code_id = $coupon_code_id;
            $newEntry->amount = $subtotal;

            $total = (int) $subtotal;

            $newEntry->tax_amount = 0;
            $shippingCharges = 0;
             // if coupon found
            if (!empty($coupon_code_id) || $coupon_code_id != 0) {
                // check for voucher/ coupon
                if ($cartData[0]->couponDetails->is_coupon == 0) {
                    $newEntry->coupon_code_type = 'voucher';
                    
                    if($cartData[0]->couponDetails->type == 1){
                        $newEntry->discount_amount = $cartData[0]->couponDetails->amount;

                        $couponCodeDiscount = (int) ($total * ($cartData[0]->couponDetails->amount / 100));

                        $newEntry->coupon_code_discount_type = 'Percentage';
                        $final_amount = ceil($total - $couponCodeDiscount);

                        // shipping charges
                        //if ((int) $minOrderAmount >= (int) $final_amount ) {
                            //$shippingCharges = $shippingCharge;
                            $final_amount = $final_amount + $shippingCharges;
                        //}
                        $newEntry->shipping_charges = $shippingCharges;

                        $newEntry->final_amount = $final_amount;
                    }else{
                        $newEntry->discount_amount = $cartData[0]->couponDetails->amount;

                        $couponCodeDiscount = $cartData[0]->couponDetails->amount;

                        $newEntry->coupon_code_discount_type = 'Flat';
                        $final_amount = ceil($total - $couponCodeDiscount) > 0  ? ceil($total - $couponCodeDiscount) : 0;

                        // shipping charges
                       // if ((int) $minOrderAmount >= (int) $final_amount ) {
                           // $shippingCharges = $shippingCharge;
                            $final_amount = $final_amount + $shippingCharges;
                       // }
                        $newEntry->shipping_charges = $shippingCharges;

                        $newEntry->final_amount = $final_amount;
                    }

                    $newEntry->save();

                    // dd($newEntry);
                } else {
                    $newEntry->coupon_code_type = 'coupon';
                    if($cartData[0]->couponDetails->type == 1){
                        $newEntry->discount_amount = $cartData[0]->couponDetails->amount;

                        $couponCodeDiscount = (int) ($total * ($cartData[0]->couponDetails->amount / 100));

                        $newEntry->coupon_code_discount_type = 'Percentage';
                        $final_amount = ceil($total - $couponCodeDiscount);

                        // shipping charges
                       // if ((int) $minOrderAmount >= (int) $final_amount ) {
                          //  $shippingCharges = $shippingCharge;
                            $final_amount = $final_amount + $shippingCharges;
                       // }
                        $newEntry->shipping_charges = $shippingCharges;

                        $newEntry->final_amount = $final_amount;
                    }else{
                        $newEntry->discount_amount = $cartData[0]->couponDetails->amount;

                        $couponCodeDiscount = $cartData[0]->couponDetails->amount;

                        $newEntry->coupon_code_discount_type = 'Flat';
                        $final_amount = ceil($total - $couponCodeDiscount) > 0  ? ceil($total - $couponCodeDiscount) : 0;

                        // shipping charges
                       // if ((int) $minOrderAmount >= (int) $final_amount ) {
                         //   $shippingCharges = $shippingCharge;
                            $final_amount = $final_amount + $shippingCharges;
                       // }
                        $newEntry->shipping_charges = $shippingCharges;

                        $newEntry->final_amount = $final_amount;
                    }
                    $newEntry->save();
                }
            } else {

                // shipping charges
               // if ((int) $minOrderAmount >= (int) $total ) {
                  //  $shippingCharges = $shippingCharge;
                    $total = $total + $shippingCharges;
                //}
			    $newEntry->final_amount = $total;
			    $newEntry->save();
            }
			 // coupon code usage handler
            if (!empty($coupon_code_id) || $coupon_code_id != 0) {
                $newEntry->discount_amount = $cartData[0]->couponDetails->amount;
                $newEntry->final_amount = $total - (int) $cartData[0]->couponDetails->amount;

                // update coupon code usage
                $couponDetails = Coupon::findOrFail($coupon_code_id);
                $old_no_of_usage = $couponDetails->no_of_usage;
                $new_no_of_usage = $old_no_of_usage + 1;
                $couponDetails->no_of_usage = $new_no_of_usage;
                if ($new_no_of_usage == $couponDetails->max_time_of_use) $couponDetails->status = 0;
                $couponDetails->save();

                $newCouponUsageEntry = new CouponUsage();
                $newCouponUsageEntry->coupon_code_id = $coupon_code_id;
                $newCouponUsageEntry->coupon_code = $couponDetails->coupon_code;
                $newCouponUsageEntry->discount = $cartData[0]->couponDetails->amount;
                $newCouponUsageEntry->total_checkout_amount = $total;
                $newCouponUsageEntry->final_amount = $total - (int) $cartData[0]->couponDetails->amount;
                $newCouponUsageEntry->user_id = $user_id ?? 0;
                $newCouponUsageEntry->email = $userDetails->email;
                //$newCouponUsageEntry->ip = $this->ip;
                $newCouponUsageEntry->order_id = $newEntry->id;
                $newCouponUsageEntry->usage_time = date('Y-m-d H:i:s');
                $newCouponUsageEntry->save();
            }
            $productDetails=Product::where('id',$cartValue->product_id)->first();
            // 2 insert cart data into order products
            $orderProducts = [];
            foreach($cartData as $cartValue) {
                $orderProducts[] = [
                    'order_id' => $newEntry->id,
                    'product_id' => $cartValue->product_id,
                    'product_name' => $productDetails->name,
                    'product_image' => $productDetails->image,
                    'product_slug' => $productDetails->product_slug,
                    'price' => $productDetails->offer_price,
                    'offer_price' => $productDetails->offer_price,
                    'qty' => $cartValue->qty,
                ];
            }
            $orderProductsNewEntry = OrderProduct::insert($orderProducts);

            // dd($settings[23]->content);

            // 4 remove cart data
            if($newEntry->payment_method=='cash_on_delivery'){
                $emptyCart = Cart::where('user_id', $user_id)->delete();
                if (!empty($user_id)) {
                    $emptyCart = Cart::where('user_id', $user_id)->delete();
                } else {
                    if (!empty($_COOKIE['cartToken'])) {
                        $emptyCart = Cart::where('guest_token', $_COOKIE['cartToken'])->delete();
                    } else {
                        $emptyCart = [];
                        return false;
                    }
                }
            }

            //5 online payment
                // fetch order details
            if($newEntry->payment_method=='online_payment'){
                $ordDetails = Order::findOrFail($newEntry->id);
                 //dd($ordDetails);

                // Razorpay auto capture code
                $amm = $ordDetails->final_amount;
                //$pay_id = $params['cashfree_payment_id'];

                $url = 'https://sandbox.cashfree.com/pg/orders';

                //$data_string = 'amount='.$amm.',order_id=order_id1,';
                $data = array(
                    'order_amount' => $amm,
                    'order_id' => "$ordDetails->id",
                    'order_currency' => 'INR',
                   
                    'customer_details' => array(
                    'customer_id' => 'KGA-'.$user_id,
                    'customer_name' => $userDetails->name,
                    'customer_email' => $userDetails->email,
                    'customer_phone' => $userDetails->mobile
                    ),
                    'order_meta' =>array(
                    'notify_url' => 'https://test.cashfree.com'
                    ),
                    'order_note' =>'some order note here'
                    
                );
                
                $data_string = json_encode($data);
                //dd($data_string);
              //  $cashfree_key_id = $settings[20]->content;
             //   $cashfree_key_secret = $settings[21]->content;

                $headers = array(
                    'Content-Type: application/json',
                    //'Authorization: Basic '. base64_encode("$cashfree_key_id:$cashfree_key_secret"),
                    'x-client-id: TEST379068726ce23f15bbf7a394af860973',
                    'x-client-secret: TESTf0e1fda493174087269b4e4a5d4d68bfd5bd063c',
                    'x-api-version: 2022-09-01',
                    'x-request-id: kga_electronics'
                );

                // Open connection
                $ch = curl_init();
                // Set the url, number of POST vars, POST data
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
                curl_setopt($ch, CURLOPT_POST, true);                                                                  
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                // Disabling SSL Certificate support temporarly
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                //curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                // Execute post
                $result = curl_exec($ch);
                $item = json_decode($result);
               // dd($item);
                //echo $result;
                //pr($result);
                curl_close($ch);

            
            
            return Response::json([
                        'status' => true, 
                        'message' => "Order Placed", 
                        'data' => array("order_id" => $newEntry->id,"cf_order_id" => $item->cf_order_id,"payment_session_id"=>$item->payment_session_id) 
                    ],200);
             }else{
                  return Response::json([
                        'status' => true, 
                        'message' => "Order Placed", 
                        'data' => array("order_id" => $newEntry->id) 
                    ],200);
             }
            }else{
                return Response::json([
                    'status' => false, 
                    'message' => "Cart Empty", 
                     
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

    public function list(Request $request)
    {
        # List My Orders...

        $user_id = $this->user_id;
        $data = Order::where('user_id',$user_id)->orderBy('id','desc')->with('orderProducts')->get();

        return Response::json([
            'status' => true, 
            'message' => "My orders", 
            'data' => array(
                'total' => count($data),
                'orders' => $data
            ) 
        ],200);

    }

    public function details($id)
    {
        # Order Details...
        $order = Order::with('orderProducts')->find($id);

        // $order = !empty($order)?$order: (object) [];
        
        return Response::json([
            'status' => true, 
            'message' => "Order details", 
            'data' => array(
                'order' => $order
            ) 
        ],200);
    }

     //transaction store
    public function transaction(Request $request)
    {
        $validator = Validator::make($request->all(),[
             'transaction_id' => 'required',
        ]);

        if(!$validator->fails()){
            $params = $request->except('_token');
            // $product_id = $params['product_id'];
            $user_id = $this->user_id;
            $txnData = new Transaction();
            $txnData->user_id = $user_id ?? 0;
            $txnData->order_id = $request->order_id;
            $txnData->transaction = $request->transaction_id;
            //$txnData->online_payment_id = $request['razorpay_payment_id'];
            // $txnData->amount = $total;razorpay_amount
            //$txnData->amount = $ordDetails->final_amount;
            $txnData->amount = $request->amount;
            $txnData->currency = "INR";
            $txnData->method = "";
            $txnData->description = "";
            $txnData->bank = "";
            $txnData->upi = "";
            $txnData->save();
            return Response::json([
                'status' => true, 
                'message' => "Transaction Saved", 
                'data' => array() 
            ],200);
    
        } else {
            return Response::json([
                'status' => false, 
                'message' => $validator->errors()->first() , 
                'data' => array( $validator->errors() ) 
            ],400);
        }
    }
    
     public function verify(Request $request)
    {
        # Place Order...

        $validator = Validator::make($request->all(),[
             'order_id' => 'required',
             
        ]);

        if(!$validator->fails()){
            $params = $request->except('_token');
            // $product_id = $params['product_id'];
            $user_id = $this->user_id;
            $order_id = $params['order_id'];
            $order=Order::where('id',$order_id)->first();
            $url = 'https://sandbox.cashfree.com/pg/orders/'.$order_id.'/payments';
             $headers = array(
                    'Content-Type: application/json',
                    //'Authorization: Basic '. base64_encode("$cashfree_key_id:$cashfree_key_secret"),
                    'x-client-id: TEST379068726ce23f15bbf7a394af860973',
                    'x-client-secret: TESTf0e1fda493174087269b4e4a5d4d68bfd5bd063c',
                    'x-api-version: 2022-09-01',
                   // 'x-request-id: kga_electronics'
                );

                // Open connection
                $ch = curl_init();
                // Set the url, number of POST vars, POST data
               curl_setopt($ch, CURLOPT_URL, $url);
               // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET"); 
              //  curl_setopt($ch, CURLOPT_POST, true);                                                                  
               // curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                // Disabling SSL Certificate support temporarly
               // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                //curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                // Execute post
                $result = curl_exec($ch);
                $item = json_decode($result);
                //dd($item[0]->cf_payment_id);
                //echo $result;
                //pr($result);
                curl_close($ch);
                $user_id = $this->user_id;
                $txnData = new Transaction();
                $txnData->user_id = $user_id ?? 0;
                $txnData->order_id = $request->order_id;
                $txnData->transaction = $item[0]->cf_payment_id;
                //$txnData->online_payment_id = $request['razorpay_payment_id'];
                // $txnData->amount = $total;razorpay_amount
                //$txnData->amount = $ordDetails->final_amount;
                $txnData->amount = $item[0]->payment_amount;
                $txnData->currency = "INR";
                $txnData->method = "";
                $txnData->description = "";
                $txnData->bank = "";
                $txnData->upi = "";
                $txnData->save();
                if($item[0]->payment_status=='SUCCESS'){
                    if($order->payment_method=='online_payment'){
                        $emptyCart = Cart::where('user_id', $user_id)->delete();
                    }
                return Response::json([
                            'status' => true, 
                            'message' => "Transaction Successful", 
                            'data' => array("result" => $item) 
                        ],200);
                }else{
                    return Response::json([
                            'status' => false, 
                            'message' => "Transaction Failed", 
                            'data' => array("result" => $item) 
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

}
