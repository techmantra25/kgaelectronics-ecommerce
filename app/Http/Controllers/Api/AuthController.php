<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Models\Address;
class AuthController extends Controller
{
    

    //

    public function login(Request $request)
    {
        # login...

        $validator = Validator::make($request->all(),[
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);

        if(!$validator->fails()){

            $params = $request->except('_token');
            $email = $params['email'];
            $password = $params['password'];

            $user = User::where('email',$email)->first();

            if(Hash::check($password,$user->password)){
                $token = Crypt::encrypt($user->id);
                return Response::json([
                    'status' => true, 
                    'message' => "Logged in successfully" , 
                    'data' => array(
                        'token' => $token,
                        'user' => $user
                    ) 
                ],200);
            } else {
                return Response::json([
                    'status' => false, 
                    'message' => "Wrong Password" , 
                    'data' => array() 
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

    public function register(Request $request)
    {
        # register user...

        $validator = Validator::make($request->all(),[
            'email' => 'required|email|unique:users,email|max:150',
            'name' => 'required',
            'password' => 'required',
            'confirm_password' => 'required|same:password'
        ]);

        if(!$validator->fails()){
            $params = $request->except('_token');
            unset($params['confirm_password']);
            $name_explode = explode(" ",$params['name']);
            // dd($name_explode);
            $params['fname'] = $name_explode[0];
            $params['lname'] = !empty($name_explode[1])?$name_explode[1]:NULL;
            $params['password'] = Hash::make($params['password']);
            // dd($params);
            $params['created_at'] = date('Y-m-d H:i:s');
            User::insert($params);
            return Response::json([
                'status' => true, 
                'message' => "Registered successfully" , 
                'data' => array(
                    // 'token' => $token,
                    'user' => $params
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

    public function logout(Request $request)
    {
        # logout...
        if (! $request->hasHeader('Authorizations')) {
            response()->json(["status"=>false,"message"=>"Unauthorized"],401)->send();
            exit();
        } else {
            $bearer_token = $request->header('Authorizations');
            $token = str_replace("Bearer ","",$bearer_token);            
            try {
                $user_id = Crypt::decrypt($token);  
                $user = User::find($user_id);
                
                // User::where('id',$user_id)->update([
                //     'mac_address' => null
                // ]);
                return Response::json(['status'=>true,'message'=>"Logged out successfully", 'data' => (object) array()],200);         
            } catch (DecryptException $e) {
                response()->json(["status"=>false,"message"=>"Mismatched token"],400)->send();
            }
        }
    }
    
    
     public function save(Request $request)
    {
        # add or remove items to cart...
        $validator = Validator::make($request->all(),[
            'user_id' => 'required',
            'address' => 'required|string',
            'landmark' => 'required|string',
            'state' => 'required|string',
            'city' => 'required|string',
            'pin' => 'required|numeric|digits:6',
            'country' => 'required|string',
            'type' => 'required|integer',
            'billing' => 'required|integer',
        ]);

        if(!$validator->fails()){

            $params = $request->except('_token');
            $address = $params['address'];
            $landmark = $params['landmark'];
            $user_id = $this->user_id;
                # Insert
                   $my_address= Address::insert([
                        'user_id' => $user_id,
                        'address' => $params['address'],
                        'landmark' => $params['landmark'],
                        'state' => $params['state'],
                        'city' => $params['city'],
                        'pin' => $params['pin'],
                        'country' => $params['country'],
                        'type' => $params['type'],
                        'billing' => $params['billing'],
                        'created_at' => date('Y-m-d H:i:s'),
                        'updated_at' => date('Y-m-d H:i:s')
                    ]);
                
            return Response::json([
                'status' => true, 
                'message' => "Saved" , 
                'data' => array(
                'my_address' => $my_address
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
    //edit
    public function edit(Request $request)
    {
        # add or remove items to cart...
        $validator = Validator::make($request->all(),[
            'id' => 'required',
            'user_id' => 'required',
          
        ]);

        if(!$validator->fails()){

            $params = $request->except('_token');
            $id = $request->id;
            $user_id = $this->user_id;
                # Update
                    $my_address= Address::find($id);
                    $my_address->address = $request->address;
                    $my_address->landmark = $request->landmark;
                    $my_address->state = $request->state;
                    $my_address->city = $request->city;
                    $my_address->pin = $request->pin;
                    $my_address->country = $request->country;
                    $my_address->type = $request->type;
                    $my_address->billing = $request->billing;
                    $my_address->created_at = date('Y-m-d H:i:s');
                    $my_address->updated_at = date('Y-m-d H:i:s');
                    $my_address->save();
                
            return Response::json([
                'status' => true, 
                'message' => "Updated" , 
                'data' => array(
                'my_address' => $my_address
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
        Address::where('id',$request->id)->delete();

        return Response::json([
            'status' => true, 
            'message' => "Address deleted successfully" , 
            'data' => array() 
        ],200);
    }
    //cart list
    public function index(Request $request)
    {
        #  My Address List Data...
        $user_id = $this->user_id;
        $address= Address::where('user_id',$user_id)->with('user')->get();
      
        return Response::json([
            'status' => true, 
            'message' => "Address list fetched successfully" , 
            'data' => array('address'=>$address)
        ],200);
    }
    
     public function view(Request $request)
    {
        #  My Address List Data...
        $user_id = $this->user_id;
        $address= Address::where('id',$d)->get();
      
        return Response::json([
            'status' => true, 
            'message' => "Address list fetched successfully" , 
            'data' => array('address'=>$address)
        ],200);
    }
}
