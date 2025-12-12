<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Interfaces\CheckoutInterface;
use App\Interfaces\CartInterface;
use App\Interfaces\UserInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Models\Order;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Cart;
use App\Models\OrderProduct;
use App\Models\Address;
use App\Models\Transaction;
use Illuminate\Support\Facades\URL;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Mail;




class CheckoutController extends Controller
{
    public function __construct(CheckoutInterface $checkoutRepository, CartInterface $cartRepository,UserInterface $userRepository) 
    {
        $this->checkoutRepository = $checkoutRepository;
        $this->cartRepository = $cartRepository;
        $this->userRepository = $userRepository;
    }
    
   
    public function index(Request $request)
    {
        $data = $this->cartRepository->viewByIp();

        if (count($data) > 0) {
            $cartData = $this->checkoutRepository->viewCart();

            if (Auth::guard('web')->user()) {
                $addressData = $this->checkoutRepository->addressData();
            } else {
                $addressData = null;
            }

            if ($cartData) {
                return view('front.checkout.index', compact('cartData', 'addressData'));
            } else {
                return redirect()->route('front.cart.index');
            }
        } else {
            return redirect()->route('front.cart.index');
        }
    }

    public function coupon(Request $request)
    {
        $couponData = $this->checkoutRepository->couponCheck($request->code);
        return $couponData;
    }

   public function store(Request $request)
    {

        $request->validate([
            'email' => 'required|email|max:255',
            'mobile' => 'required|integer|digits:10',
            'fname' => 'required|string|max:255',
            'lname' => 'required|string|max:255',
            //  'address_id' => 'required',
            'shipping_country' => 'nullable|string|max:255',
            'shipping_address' => 'nullable|string|max:255',
            //'shipping_landmark' => 'nullable|string|max:255',
            'shipping_city' => 'nullable|string|max:255',
            'shipping_state' => 'nullable|string|max:255',
            'shipping_pin' => 'nullable|integer|digits:6',
        ], [
            'mobile.*' => 'Please enter valid 10 digit mobile number',
   
            //  'address_id.*' => 'Please enter shipping address',
        ]);
       // $order_no = $this->checkoutRepository->create($request->except('_token'));
        // 1 order
        // if(empty($request->address_id)){
            $nextYear = 24; 
            $curYear = date('y');
            $order_no = "KGA".$curYear . (($curYear != $nextYear) ? '-' . $nextYear : '').'/'.mt_rand();
            $newEntry = new Order;
            $newEntry->order_no = $order_no;
            $newEntry->user_id = Auth::guard('web')->user()->id ?? NULL;
            //$newEntry->ip = $this->ip;
            $userDetails=User::where('id',Auth::guard('web')->user()->id)->first();
            $newEntry->email = $userDetails->email;
            $newEntry->mobile = $userDetails->mobile;
            $newEntry->fname = $userDetails->fname;
            $newEntry->lname = $userDetails->lname;
             //$address = Address::where('id',$request->address_id)->first();
            // $newEntry->shipping_country = $address->country;
             //$newEntry->shipping_address = $address->address;
             //$newEntry->shipping_landmark = $address->landmark;
            // $newEntry->shipping_city = $address->city;
            // $newEntry->shipping_state = $address->state;
            // $newEntry->shipping_pin = $address->pin;
            $newEntry->payment_method = $request->payment_method;
            // dd($newEntry);
            // fetch cart details
            $cartData = Cart::where('user_id', Auth::guard('web')->user()->id)->get();
            $subtotal = 0;
            foreach($cartData as $cartValue) {
                $subtotal += $cartValue->product->offer_price * $cartValue->qty;
            }
            $coupon_code_id = $cartData[0]->coupon_code_id ?? 0;
            $newEntry->coupon_code_id = $coupon_code_id;
            $newEntry->amount = $subtotal;
            $newEntry->shipping_charges = 0;
            $newEntry->tax_amount = 0;
            // $newEntry->discount_amount = 0;
            // $newEntry->coupon_code_id = 0;
            $total = (int) $subtotal;
            if (!empty($coupon_code_id) || $coupon_code_id != 0) {
                // check for voucher/ coupon
                if ($cartData[0]->couponDetails->is_coupon == 0) {
                    $newEntry->coupon_code_type = 'voucher';
                    
                    if($cartData[0]->couponDetails->type == 1){
                        $newEntry->discount_amount = $cartData[0]->couponDetails->amount;

                        $couponCodeDiscount = (int) ($total * ($cartData[0]->couponDetails->amount / 100));

                        $newEntry->coupon_code_discount_type = 'Percentage';
                        $newEntry->final_amount = ceil($total - $couponCodeDiscount);
                    }else{
                        $newEntry->discount_amount = $cartData[0]->couponDetails->amount;

                        $couponCodeDiscount = $cartData[0]->couponDetails->amount;

                        $newEntry->coupon_code_discount_type = 'Flat';
                        $newEntry->final_amount = ceil($total - $couponCodeDiscount) > 0  ? ceil($total - $couponCodeDiscount) : 0;
                    }

                    $newEntry->save();

                    
                } else {
                    $newEntry->coupon_code_type = 'coupon';
                    if($cartData[0]->couponDetails->type == 1){
                        $newEntry->discount_amount = $cartData[0]->couponDetails->amount;

                        $couponCodeDiscount = (int) ($total * ($cartData[0]->couponDetails->amount / 100));

                        $newEntry->coupon_code_discount_type = 'Percentage';
                        $newEntry->final_amount = ceil($total - $couponCodeDiscount);
                    }else{
                        $newEntry->discount_amount = $cartData[0]->couponDetails->amount;

                        $couponCodeDiscount = $cartData[0]->couponDetails->amount;

                        $newEntry->coupon_code_discount_type = 'Flat';
                        $newEntry->final_amount = ceil($total - $couponCodeDiscount) > 0  ? ceil($total - $couponCodeDiscount) : 0;
                    }
                    $newEntry->save();
                }
            } else {
                $newEntry->coupon_code_type = '';
                $newEntry->discount_amount = 0;
                $newEntry->final_amount = $total;
                $newEntry->save();
                //dd($newEntry);
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
                $newCouponUsageEntry->user_id = Auth::guard('web')->user()->id ?? 0;
                $newCouponUsageEntry->email = $request['email'];
                $newCouponUsageEntry->order_id = $newEntry->id;
                $newCouponUsageEntry->usage_time = date('Y-m-d H:i:s');
                $newCouponUsageEntry->save();
            }
            // 2 insert cart data into order products
            $orderProducts = [];
            foreach($cartData as $cartValue) {
                $orderProducts[] = [
                    'order_id' => $newEntry->id,
                    'product_id' => $cartValue->product_id,
                    'product_name' => $cartValue->product->name,
                    'product_image' => $cartValue->product->image,
                    'product_slug' => $cartValue->product->slug,
                    'product_variation_id' => $cartValue->product_variation_id,
                    'price' => $cartValue->product->price,
                    'offer_price' => $cartValue->product->offer_price,
                    'qty' => $cartValue->qty,
                ];
            }
            $orderProductsNewEntry = OrderProduct::insert($orderProducts);

            // 4 remove cart data
            $emptyCart = Cart::where('user_id', Auth::guard('web')->user()->id)->delete();
            $orderEntry   = Order::findOrFail($newEntry->id);
			//dd($orderEntry);
            $order_no=$orderEntry->order_no;
            $orderPro=OrderProduct::where('order_id',$orderEntry->id)->get();
            $orderProducts = [];
			$totalQuantity = 0;
            foreach($orderPro as $cartValue) {
                $orderProducts[] = [
                    'order_id' => $orderEntry->id,
                    'product_id' => $cartValue->product_id,
                    'product_name' => $cartValue->product_name,
                    'product_image' => $cartValue->product_image,
                    'product_slug' => $cartValue->product_slug,
                    'product_variation_id' => $cartValue->product_variation_id,
                    'price' => $cartValue->price,
                    'offer_price' => $cartValue->offer_price,
                    'qty' => $cartValue->qty,
                ];
				$totalQuantity += $cartValue->qty; 
            }
            // 3 send product details mail
            $email_data = [
                'name' => $orderEntry->fname.' '.$orderEntry->lname,
                'subject' => 'KGA - New Order',
                'email' => $orderEntry->email,
                'orderId' => $orderEntry->id,
                'orderNo' => $order_no,
                'orderAmount' => $orderEntry->final_amount,
                'orderProducts' => $orderProducts,
                'blade_file' => 'front/mail/order-confirm',
				'totalQuantity' => $totalQuantity,
            ];
	   //dd($email_data);
            // if ($settings[23]->content == "1") SendMail($email_data);
			Mail::send($email_data['blade_file'], $email_data, function ($message) use ($email_data) {
				$message->to($email_data['email'])
						->subject($email_data['subject'])
						->from('info@kgaelectronics.com');
			});
            // send invoice mail starts
            $invoice_email_data = [
                'name' => $orderEntry->fname.' '.$orderEntry->lname,
                'subject' => 'KGA - Order Invoice',
                'email' => $orderEntry->email,
                'orderId' => $orderEntry->id,
                'payment_method' => $orderEntry->payment_method,
                'orderNo' => $order_no,
                'orderAmount' => $orderEntry->final_amount,
                // 'orderProducts' => $orderProducts,
                'blade_file' => 'front/mail/invoice',
            ];
	    	//Mail::send($invoice_email_data['blade_file'], $invoice_email_data, function ($message) use ($invoice_email_data) {
			//	$message->to($invoice_email_data['email'])
			//			->subject($invoice_email_data['subject'])
			//			->from('info@kgaelectronics.com');
			//});
           // if ($settings[23]->content == "1") SendMail($invoice_email_data);
            // 5 online payment
	  // dd($newEntry->payment_method);
            if ($newEntry->payment_method == 'online_payment') {
                // fetch order details
                $userDetails=User::where('id',Auth::guard('web')->user()->id)->first();
                // Razorpay auto capture code
                $amm = $orderEntry->final_amount;
				//dd($amm);
                $url = "https://api.cashfree.com/pg/orders";
                $link = ''.URL::to('/').'/'.'checkout/complete?order_id={order_id}&order_token={order_token}';

                //$data_string = 'amount='.$amm.',order_id=order_id1,';
                $data_string = json_encode([
                    'order_amount' => $amm,
                    'order_id' => "$orderEntry->id",
                    "order_currency" => 'INR',
                   
                    'customer_details' => [
                    'customer_id' => 'KGA-'.Auth::guard('web')->user()->id,
                    'customer_name' => $userDetails->name,
                    'customer_email' => $userDetails->email,
                    'customer_phone' => $userDetails->mobile
                    ],
                    'order_meta' =>[
                    "return_url" => $link,
                    'notify_url' => 'https://test.cashfree.com'
                    ],
                    'order_note' =>'some order note here'
                    
                ]);
				
                $headers = array(
					'Content-Type: application/json',
					'x-client-id: ' . env('CASHFREE_CLIENT_ID'),
					'x-client-secret: ' . env('CASHFREE_CLIENT_SECRET'),
					'x-api-version: ' . env('CASHFREE_API_VERSION'),
					'x-request-id: ' . env('CASHFREE_REQUEST_ID')
				);


                // Open connection
                $ch = curl_init();
                // Set the url, number of POST vars, POST data
                $ch = curl_init($url);
                curl_setopt($ch, CURLOPT_URL, $url);
                //curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST"); 
                curl_setopt($ch, CURLOPT_POST, true);                                                                  
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                // Disabling SSL Certificate support temporarly
                //curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                //curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                // Execute post
                $result = curl_exec($ch);
				
                $item = json_decode($result);
               // dd($item);
                echo $result;
                //pr($result);
                curl_close($ch);

                // dd($item);

                // dd($item->payment_link);

            return redirect()->to($item->payment_link);
            }else{
                // dd("here");
				//return redirect()->route('front.user.address.add');
				return redirect()->route('front.user.order.show.address', ['id' => $orderEntry->id])->with('success', 'Please choose address for placed your order');
               // return redirect()->route('front.user.order.address');
                // return redirect()->back()->with('success', 'Please choose shipping address');
            }
            // $order_id = Order::where('order_no',$order_no)->first('id');
            // if ($order_no) {
            //     return redirect()->route('front.checkout.payment',$order_id)->with('success', 'Please complete your payment');
            // } else {
                
            //     return redirect()->back()->with('failure', 'Something happened. Try again.')->withInput($request->all());
        // }else{
        return view('front.checkout.complete', compact('orderEntry'))->with('success', 'Thank you for you order');
        // }
    }

    public function complete(Request $request)
    {
        if (auth()->guard('web')->check()) {
            $order_no = Order::where('id',$request->order_id)->first();
            $url = 'https://api.cashfree.com/pg/orders/'.$request->order_id.'/payments';
                 $headers = array(
					'Content-Type: application/json',
					'x-client-id: ' . env('CASHFREE_CLIENT_ID'),
					'x-client-secret: ' . env('CASHFREE_CLIENT_SECRET'),
					'x-api-version: ' . env('CASHFREE_API_VERSION'),
					'x-request-id: ' . env('CASHFREE_REQUEST_ID')
				);
   
                   // Open connection
                   $ch = curl_init();                        
                   // Set the url, number of POST vars, POST data
                  curl_setopt($ch, CURLOPT_URL, $url);
                   curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                
                   $result = curl_exec($ch);
                   $item = json_decode($result);
			
                   curl_close($ch);
                //    $order_status = $item->order_status;
                   
                //    $data = collect();

                   if($item[0]->payment_status=='SUCCESS'){
					  $url = 'https://api.cashfree.com/pg/orders/' . $request->order_id . '/settlements';

					// Set headers with client ID and client secret
					$headers = array(
						'Content-Type: application/json',
						'x-client-id: ' . env('CASHFREE_CLIENT_ID'),
						'x-client-secret: ' . env('CASHFREE_CLIENT_SECRET'),
						'x-api-version: ' . env('CASHFREE_API_VERSION')
					);

					// Open connection
					$ch = curl_init();

					// Set the URL and other options
					curl_setopt($ch, CURLOPT_URL, $url);
					curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

					// Execute the request
					$result = curl_exec($ch);

					// Check for errors
					if (curl_errno($ch)) {
						echo 'Error:' . curl_error($ch);
					}

					// Decode the response
					json_decode($result, true); // Use true to get an associative array

					// Close connection
					curl_close($ch);
					   $txnData = new Transaction();
					   $txnData->user_id = $userDetails->id ?? 0;
					   $txnData->order_id = $request->order_id;
					   $txnData->transaction = $item[0]->cf_payment_id;
					   $txnData->amount = $item[0]->payment_amount;
					   $txnData->currency = "INR";
					   $txnData->method = "";
					   $txnData->description = "";
					   $txnData->bank = "";
					   $txnData->upi = "";
					   $txnData->save();
                   $data = $this->userRepository->addressById(Auth::guard('web')->user()->id);
					 return redirect()->route('front.user.order.show.address', ['id' => $request->order_id])->with('success', 'Please choose address for placed your order!');
                    //return view('front.profile.address', compact('order_no','data'))->with('success', 'Your order has been placed successfully ! Please choose address');
                    // return redirect()->route('front.user.address.add');
                    // return view('front.checkout.complete', compact('order_no'))->with('success', 'Transaction Successful','Thank you for you order');
                   }else{
                    return view('front.checkout.complete', compact('order_no'))->with('success', 'Transaction Failed','Thank you for you order');
                   }
        } else {
            return redirect()->back()->with('failure', 'Something happened. Try again.');
            
        }
           
       
    }

}
