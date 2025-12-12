<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Interfaces\UserInterface;
use App\Interfaces\OrderInterface;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Address;
use App\Models\Cart;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use PharIo\Manifest\Url;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\OtpMail;
use DB;
use App\Interfaces\CartInterface;



class UserController extends Controller
{
    public function __construct(UserInterface $userRepository, OrderInterface $orderRepository,CartInterface $cartRepository)
    {
        $this->userRepository = $userRepository;
        $this->orderRepository = $orderRepository;
        $this->cartRepository = $cartRepository;
    }

    public function login(Request $request)
    {
        $back_url = url()->previous();
        $recommendedProducts = $this->userRepository->recommendedProducts();
        return view('front.auth.login', compact('recommendedProducts','back_url'));
    }

    // public function register(Request $request)
    // {
    //     $recommendedProducts = $this->userRepository->recommendedProducts();
    //     return view('front.auth.register', compact('recommendedProducts'));
    // }
    public function showRegistrationForm(Request $request){
        $recommendedProducts = $this->userRepository->recommendedProducts();
        return view('front.auth.register', compact('recommendedProducts'));
    }

public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'phone' => 'required|string|max:15|unique:users',
        'password' => 'required|string|min:8',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'password' => Hash::make($request->password),
        'email_otp' => rand(100000, 999999),
        'phone_otp' => rand(100000, 999999),
    ]);
	

    // Send OTP to email
    Mail::to($user->email)->send(new OtpMail($user->email_otp));

    // Send OTP to phone via Twilio
    $sid = config('services.twilio.sid');
    $token = config('services.twilio.token');
    $twilio = new Client($sid, $token);
    $twilio->messages->create($user->phone, [
        'from' => config('services.twilio.from'),
        'body' => 'Your OTP code is ' . $user->phone_otp
    ]);

    return redirect()->route('verify.otp')->with('user', $user);
}


    // public function create(Request $request)
    // {
    //     $request->validate([
    //         'fname' => 'required|string',
    //         'lname' => 'required|string',
    //         'email' => 'required|email|unique:users,email',
    //         'mobile' => 'required|integer|digits:10|unique:users,mobile',
    //         'password' => 'required|string|min:2|max:100',
    //     ]);

    //     $storeData = $this->userRepository->create($request->except('_token'));

    //     if ($storeData) {
    //         // $credentials = $request->only('email', 'password');

    //         // if (Auth::attempt($credentials)) {
    //         //     // return redirect()->intended('home');
    //         //     return redirect()->url('home');
    //         // }

    //         return redirect()->route('front.user.login')->with('success', 'Account created successfully');
    //     } else {
    //         return redirect()->route('front.user.register')->withInput($request->all())->with('failure', 'Something happened');
    //     }
    // }

    
// ...

public function create(Request $request)
{

    $request->validate([
        'fname' => 'required|string',
        'lname' => 'required|string',
        'email' => 'required|email|unique:users,email',
        'mobile' => 'required|integer|digits:10|unique:users,mobile',
        'password' => 'required|string|min:8',
    ]);

    //$otp = Str::random(6); // Generate a 6-character OTP
	$otp = mt_rand(100000, 999999);
    $user = User::create([
        //'name' => $request->name,
        'fname' => $request->fname,
        'lname' => $request->lname,
        'email' => $request->email,
        'mobile' => $request->mobile,
        'password' => Hash::make($request->password),
        'otp' => $otp, // Save the OTP to the user record
    ]);
	$productData = session()->only(['productId', 'productName', 'qty']);
	
    //if ($productData) {
    //    $user_id = $user->id;
     //   $this->cartRepository->addCart ($productData, $user_id);

     //   session()->forget(['productId', 'productName', 'qty']);
       
   // }
	
	 if (session()->has('product_data')) {
            $productData = session('product_data');

            if ($productData) {
                $userId =$user->id;
                $this->cartRepository->addCart($productData, $userId);

                // Clear the session data after adding to the cart
                session()->forget('product_data');

                // Redirect to the cart page
              //  return redirect()->route('front.cart.index');
            }
        }
	$query_calling_number = "6291117317";
                
        $sms_entity_id = "1701159671476365690";
        $sms_template_id = "1707172130660470733";
        

        $myMessage = urlencode('Your OTP for KGA Electronics login is '.$otp.' Please enter this code on the website to proceed Thank you The KGA Electronics Team AMMRTL ');


        $sms_url = 'https://sms.bluwaves.in/sendsms/bulk.php?username=ammrllp&password=123456789&type=TEXT&sender=AMMRTL&mobile='.$user->mobile.'&message='.$myMessage.'&entityId='.$sms_entity_id.'&templateId='.$sms_template_id;

        // // echo $myMessage; die;

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $sms_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        // echo '<pre>'; echo $response;
	
	
	
    // Ensure email is correctly retrieved
    $email = $request->email;

    // Prepare the data for the email
    $data = ['otp' => $otp];

    // Send the email with the OTP
    Mail::send("emails.otp", $data, function ($message) use ($email) {
        $message->to($email)
                ->subject('Your OTP Code')
                ->from('info@kgaelectronics.com');
    });
session(['email' => $request->email]);
	  //$back_url = $request->input('back_url', route('front.home'));
    //return redirect()->route('front.user.otp')->with('success', 'User registered successfully. Please check your email or phone for the OTP.');
	  return redirect()->route('front.user.otp')->with('success', 'User registered successfully. Please check your email or phone for the OTP.');
}

	public function showVerifyForm(Request $request)
	{
		return view('front.auth.otp-verify');
	}
public function verifyOtpbackup(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'otp' => 'required|string|size:6',
    ]);

    $user = User::where('email', $request->email)->where('otp', $request->otp)->first();

    if ($user) {
        // OTP is correct, log the user in
        Auth::login($user);

        // Clear the OTP
        $user->otp = null;
        $user->save();
		$email = $request->email; 
		 $body = "Welcome to KGA Electronics. Thank you for logging in. Explore our latest gadgets and track your orders with ease. Happy shopping!";
            $data = ['body' => $body];
	 	Mail::send("emails.welcome", $data, function ($message) use ($email) {
        	$message->to($email)
				->subject('"Welcome to KGA Electronics')
					 ->from('info@milaapp.in');
    	});
		
		
		$query_calling_number = "6291117317";
                
        $sms_entity_id = "1701159671476365690";
        $sms_template_id = "1707172130671122318";
        

        $myMessage = urlencode('Welcome to KGA Electronics Thank you for logging in. Explore our latest gadgets and track your orders with ease. Happy shopping! AMMRTL');


        $sms_url = 'https://sms.bluwaves.in/sendsms/bulk.php?username=ammrllp&password=123456789&type=TEXT&sender=AMMRTL&mobile='.$user->mobile.'&message='.$myMessage.'&entityId='.$sms_entity_id.'&templateId='.$sms_template_id;

        // // echo $myMessage; die;

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => $sms_url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        ));

        $response = curl_exec($curl);
        curl_close($curl);
		
 $back_url = session('back_url', route('home')); // Retrieve the back_url from session
		
        //return redirect()->session('back_url',route('home'))->with('success', 'Logged in successfully');
		return redirect()->to($back_url)->with('success', 'OTP verified successfully');
    } else {
        return back()->withErrors(['otp' => 'Invalid OTP'])->withInput();
    }
}
	public function verifyOtp(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'otp' => 'required|string|size:6',
    ]);

    $user = User::where('email', $request->email)->where('otp', $request->otp)->first();
    if ($user){
        $cartData = Cart::where('user_id', $user->id)->get();
        if($cartData!=" "){
            Auth::login($user);

            // Clear the OTP
            $user->otp = null;
            $user->save();
            $email = $request->email; 
            $body = "Welcome to KGA Electronics. Thank you for logging in. Explore our latest gadgets and track your orders with ease. Happy shopping!";
                $data = ['body' => $body];
            Mail::send("emails.welcome", $data, function ($message) use ($email) {
                $message->to($email)
                    ->subject('"Welcome to KGA Electronics')
                        ->from('info@kgaelectronics.com');
            });
            
            
            $query_calling_number = "6291117317";
                    
            $sms_entity_id = "1701159671476365690";
            $sms_template_id = "1707172130671122318";
            

            $myMessage = urlencode('Welcome to KGA Electronics Thank you for logging in. Explore our latest gadgets and track your orders with ease. Happy shopping! AMMRTL');


            $sms_url = 'https://sms.bluwaves.in/sendsms/bulk.php?username=ammrllp&password=123456789&type=TEXT&sender=AMMRTL&mobile='.$user->mobile.'&message='.$myMessage.'&entityId='.$sms_entity_id.'&templateId='.$sms_template_id;

            // // echo $myMessage; die;

            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => $sms_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            
            
            return redirect()->route('front.cart.index')->with('success', 'Logged in successfully');
            //return redirect()->route('home')->with('success', 'Logged in successfully'); 
        }
        else {
            // OTP is correct, log the user in
            Auth::login($user);

            // Clear the OTP
            $user->otp = null;
            $user->save();
            $email = $request->email; 
            $body = "Welcome to KGA Electronics. Thank you for logging in. Explore our latest gadgets and track your orders with ease. Happy shopping!";
                $data = ['body' => $body];
            Mail::send("emails.welcome", $data, function ($message) use ($email) {
                $message->to($email)
                    ->subject('"Welcome to KGA Electronics')
                        ->from('info@milaapp.in');
            });
            
            
            $query_calling_number = "6291117317";
                    
            $sms_entity_id = "1701159671476365690";
            $sms_template_id = "1707172130671122318";
            

            $myMessage = urlencode('Welcome to KGA Electronics Thank you for logging in. Explore our latest gadgets and track your orders with ease. Happy shopping! AMMRTL');


            $sms_url = 'https://sms.bluwaves.in/sendsms/bulk.php?username=ammrllp&password=123456789&type=TEXT&sender=AMMRTL&mobile='.$user->mobile.'&message='.$myMessage.'&entityId='.$sms_entity_id.'&templateId='.$sms_template_id;

            // // echo $myMessage; die;

            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => $sms_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $response = curl_exec($curl);
            curl_close($curl);
            
            
            
            return redirect()->route('home')->with('success', 'Logged in successfully');
        }
    } else {
        return back()->withErrors(['otp' => 'Invalid OTP'])->withInput();
    }
}
    public function verifyOtp1(Request $request)
    {
        $user = User::find($request->user_id);
    
        if ($user->email_otp == $request->email_otp && $user->phone_otp == $request->phone_otp) {
            $user->is_verified = true;
            $user->email_otp = null;
            $user->phone_otp = null;
            $user->save();
    
            Auth::login($user);
    
            return redirect()->route('home')->with('status', 'Registration successful');
        } else {
            return redirect()->back()->withErrors('Invalid OTP');
        }
    }
    


   // public function check(Request $request)
   // {
      //  $request->validate([
        //    'email' => 'required|email|exists:users,email',
        //    'password' => 'required|string|min:2|max:100',
       // ]);

       // $credentials = $request->only('email', 'password');

       // if (Auth::attempt($credentials)) {
       //     return redirect()->to($request->back_url)->with('success', 'Login Successful');
            // return redirect()->url('home');
       // } else {
            //return redirect()->route('front.user.login')->withInput($request->all())->with('failure', 'Please enter valid credentials');
       // }
  //  }

	public function check(Request $request)
{
    $request->validate([
        'email' => 'required|email|exists:users,email',
        'password' => 'required|string|min:2|max:100',
    ]);

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        if (session()->has('product_data')) {
            $productData = session('product_data');

            if ($productData) {
                $userId = Auth::user()->id;
                $this->cartRepository->addCart($productData, $userId);

                // Clear the session data after adding to the cart
                session()->forget('product_data');

                // Redirect to the cart page
                return redirect()->route('front.cart.index');
            }
        }

        // Redirect to the intended page or back URL if no product data
        return redirect()->to($request->back_url ?? url()->previous())->with('success', 'Login Successful');
    } else {
        return redirect()->route('front.user.login')
            ->withInput($request->all())
            ->with('failure', 'Please enter valid credentials');
    }
}


	public function forgotPassword(Request $request)
    {
        return view('auth.passwords.email');
    }

    public function order(Request $request)
    {
        $data = $this->userRepository->orderDetails();
        return view('front.profile.order', compact('data'));
    }

    public function coupon(Request $request)
    {
        $data = $this->userRepository->couponList();
        return view('front.profile.coupon', compact('data'));
    }

    public function address(Request $request)
    {
        $data = $this->userRepository->addressById(Auth::guard('web')->user()->id);
        if ($data) {
            return view('front.profile.address', compact('data'));
        } else {
            return view('front.404');
        }
    }

    public function addressCreate(Request $request)
    {
        $request->validate([
            "user_id" => "required|integer",
            "address" => "required|string|max:255",
            //"landmark" => "required|string|max:255",
            "lat" => "nullable",
            "lng" => "nullable",
            //"type" => "required|integer",
            "state" => "required|string",
            "city" => "required|string",
            "country" => "required|string",
            "pin" => "required|integer|digits:6",
            //"type" => "required|integer",
        ], [
          //  "lat.*" => "Please enter Location",
          //  "lng.*" => "Please enter Location"
        ]);

        $params = $request->except('_token');
        $storeData = $this->userRepository->addressCreate($params);

        if ($storeData) {
            return redirect()->route('front.user.address');
        } else {
            return redirect()->route('front.user.address.add')->withInput($request->all());
        }
    }
	 public function addressEdit(Request $request, $id)
    {
        $data = Address::where('id',$id)->first();
        if ($data) {
            return view('front.profile.address-edit', compact('data'));
        } else {
            return redirect()->route('front.user.address')->with('failure', 'Something happened');
        }
    }
    public function addressUpdate(Request $request, $id)
    {
		
		 $request->validate([
            "user_id" => "required|integer",
            "address" => "required|string|max:255",
            //"landmark" => "required|string|max:255",
            "lat" => "nullable",
            "lng" => "nullable",
            //"type" => "required|integer",
            "state" => "required|string",
            "city" => "required|string",
            "country" => "required|string",
            "pin" => "required|integer|digits:6",
           // "type" => "required|integer",
        ], [
          //  "lat.*" => "Please enter Location",
          //  "lng.*" => "Please enter Location"
        ]);
        $params = $request->except('_token');
        $updateData = $this->userRepository->addressUpdate($id,$params);
        if ($updateData) {
            return redirect()->route('front.user.address.edit', ['id' => $id])->with('success', 'Address updated successfully');
            
        } else {
            return redirect()->route('front.user.address')->with('failure', 'Something happened');
        }
    }
    public function addressDelete(Request $request, $id)
    {
        $data = Address::where('id',$id)->delete();

        if ($data) {
            return redirect()->route('front.user.address')->with('success', 'Address removed');
        } else {
            return redirect()->route('front.user.address')->with('failure', 'Something happened');
        }
    }
    public function updateProfile(Request $request)
    {
        $request->validate([
            "fname" => "required|string|max:255",
            "lname" => "required|string|max:255",
            "mobile" => "required|integer|digits:10",
        ], [
            "mobile.*" => "Please enter a valid 10 digit mobile number"
        ]);

        $params = $request->except('_token');
        $storeData = $this->userRepository->updateProfile($params);

        if ($storeData) {
            return redirect()->route('front.user.manage')->with('success', 'Profile updated successfully');
        } else {
            return redirect()->route('front.user.manage')->withInput($request->all())->with('failure', 'Something happened. Try again');
        }
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            "old_password" => "required|string|max:255",
            "new_password" => "required|string|max:255|same:confirm_password",
            "confirm_password" => "required|string|max:255",
        ]);

        $params = $request->except('_token');
        $storeData = $this->userRepository->updatePassword($params);

        if ($storeData) {
            return redirect()->route('front.user.manage')->with('success', 'Password updated successfully');
        } else {
            return redirect()->route('front.user.manage')->withInput($request->all())->with('failure', 'Something happened');
        }
    }

    public function wishlist(Request $request)
    {
        $data = $this->userRepository->wishlist();
        if ($data) {
            return view('front.profile.wishlist', compact('data'));
        } else {
            return view('front.404');
        }
    }

    public function invoice(Request $request, $id)
    {
        $data = $this->orderRepository->listById($id);
		//dd($data);
        $address = $this->orderRepository->addressById($id);
		//dd($dataaddress);
        return view('front.profile.invoice', compact('data','address'));
    }
	 public function orderAddress(Request $request, $id)
    {
        $data = $this->orderRepository->listById($id);
        $dataaddress = $this->orderRepository->addressById($id);
		//dd($data);
        return view('front.profile.order-address', compact('data','dataaddress'));
    }
	public function orderAddressUpdate(Request $request, $id)
{
	 //dd($request->all());
    // Validate the incoming request
    $validatedData = $request->validate([
        'country' => 'required|string|max:255',
        'address' => 'required|string|max:255',
        'landmark' => 'nullable|string|max:255',
        'location' => 'required|string|max:255',
        'city' => 'required|string|max:255',
        'state' => 'required|string|max:255',
        'pin' => 'required|digits:6',
		
        'shipping_country' => 'required|string|max:255',
        'shipping_address' => 'required|string|max:255',
        'shipping_landmark' => 'nullable|string|max:255',
        'shipping_location' => 'required|string|max:255',
        'shipping_city' => 'required|string|max:255',
        'shipping_state' => 'required|string|max:255',
        'shipping_pin' => 'required|digits:6',
    ]);

    DB::beginTransaction();

    try {
        // Fetch the order for the given user and order ID
        $order = Order::where('id', $id)
                      ->where('user_id', Auth::user()->id)
                      ->first();
		//dd($order);
        if ($order) {
            // Check if the shipping address already exists
            $address = Address::where('user_id', Auth::user()->id)
                              ->where('address', $request->shipping_address)
                              ->where('location', $request->shipping_location)
                              ->where('state', $request->shipping_state)
                              ->where('pin', $request->shipping_pin)
                              ->first();

            // If the address doesn't exist, create a new one
            if (!$address) {
                $new_address = new Address;
                $new_address->user_id = Auth::user()->id;
                $new_address->address = $request->shipping_address;
                $new_address->country = $request->shipping_country;
                $new_address->landmark = $request->shipping_landmark;
                $new_address->location = $request->shipping_location;
                $new_address->city = $request->shipping_city;
                $new_address->state = $request->shipping_state;
                $new_address->pin = $request->shipping_pin;
                $new_address->save();
            }

            // Update the order's billing and shipping addresses
            $order->billing_country = $request->country;
            $order->billing_address = $request->address;
            $order->billing_landmark = $request->landmark;
            $order->billing_location = $request->location;
            $order->billing_city = $request->city;
            $order->billing_state = $request->state;
            $order->billing_pin = $request->pin;

            $order->shipping_country = $request->shipping_country;
            $order->shipping_address = $request->shipping_address;
            $order->shipping_landmark = $request->shipping_landmark;
            $order->shipping_location = $request->shipping_location;
            $order->shipping_city = $request->shipping_city;
            $order->shipping_state = $request->shipping_state;
            $order->shipping_pin = $request->shipping_pin;
            $order->status = 1;

            $order->save();

            // Commit the transaction
            DB::commit();
		
            return redirect()->route('front.user.order.show.address', ['id' => $id])
                             ->with('success', 'Address updated successfully! And order has been placed Successfully!');
        } else {
            // If the order was not found, rollback the transaction
            DB::rollBack();
            return redirect()->route('front.user.order.show.address')
                             ->with('failure', 'Something happened! Please contact KGA support');
        }
    } catch (\Exception $e) {
        // Rollback the transaction in case of an exception
        DB::rollBack();
        return redirect()->route('front.user.order.address')
                         ->with('failure', 'An error occurred! Please try again.');
    }
}
	
	public function showOrderAddress($id){
		 $addresses = Address::latest()->where('user_id', Auth::user()->id)->get();
		 $data = $this->orderRepository->listById($id);	
		 $order = Order::where('id', $id)
                  ->where('user_id', Auth::user()->id)
                  ->first();

		

  	  return view('front.profile.order-address', compact('addresses', 'order','data'));
	}
	
public function orderAddressBillingUpdate(Request $request, $id)
{
    // Define validation rules
    $rules = [
        "billingaddress" => "required|string|max:255",
        "billingstate" => "required|string",
        "billingcity" => "required|string",
        "billingcountry" => "required|string",
        "billingpin" => "required|integer|digits:6",
        "billinglandmark" => "nullable|string",
        "billinglocation" => "required|string",
    ];

    // Add shipping address validation if 'same_as_billing' is not checked
    if ($request->same_as_billing != 1) {
        $rules = array_merge($rules, [
            "shipping_address" => "required|string|max:255",
            "shipping_state" => "required|string",
            "shipping_city" => "required|string",
            "shipping_country" => "required|string",
            "shipping_pin" => "required|integer|digits:6",
            "shipping_landmark" => "nullable|string",
            "shipping_location" => "required|string",
        ]);
    }

    // Validate request data
    $validatedData = $request->validate($rules);

    // Find the order entry
    $order = Order::find($id);

    // Check if the entry exists
    if (!$order) {
        return redirect()->route('front.user.order.address')->with('failure', 'Order not found');
    }

    // Update billing address details
    $order->billing_address = $validatedData['billingaddress'];
    $order->billing_landmark = $validatedData['billinglandmark'] ?? $order->billing_landmark;
    $order->billing_state = $validatedData['billingstate'];
    $order->billing_city = $validatedData['billingcity'];
    $order->billing_pin = $validatedData['billingpin'];
    $order->billing_country = $validatedData['billingcountry'];
    $order->billing_location = $validatedData['billinglocation'] ?? $order->billing_location;

    // Update shipping address details
    if ($request->same_as_billing == 1) {
        // Copy billing address to shipping address
        $order->shipping_address = $validatedData['billingaddress'];
        $order->shipping_landmark = $validatedData['billinglandmark'] ?? $order->billing_landmark;
        $order->shipping_state = $validatedData['billingstate'];
        $order->shipping_city = $validatedData['billingcity'];
        $order->shipping_pin = $validatedData['billingpin'];
        $order->shipping_country = $validatedData['billingcountry'];
        $order->shipping_location = $validatedData['billinglocation'] ?? $order->billing_location;
    } else {
        // Update shipping address with provided data
        $order->shipping_address = $validatedData['shipping_address'];
        $order->shipping_landmark = $validatedData['shipping_landmark'] ?? $order->shipping_landmark;
        $order->shipping_state = $validatedData['shipping_state'];
        $order->shipping_city = $validatedData['shipping_city'];
        $order->shipping_pin = $validatedData['shipping_pin'];
        $order->shipping_country = $validatedData['shipping_country'];
        $order->shipping_location = $validatedData['shipping_location'] ?? $order->shipping_location;
    }

    // Save the updated entry
    $order->save();

    // Redirect based on success or failure
    return redirect()->route('front.user.order.address', ['id' => $id])->with('success', 'Address updated successfully');
}


    public function orderCancel(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "orderId" => "required | integer",
            "cancellationReason" => "required | string"
        ]);

        if (!$validator->fails()) {
            $order = Order::findOrFail($request->orderId);
            $order->status = 5;
            $order->orderCancelledBy = auth()->guard('web')->user()->id;
            $order->orderCancelledReason = $request->cancellationReason;
            $order->save();

            return redirect()->back()->with('success', 'You have cancelled your order');
        } else {
            return redirect()->back()->with('failure', $validator->errors()->first());
        }
    }
}
