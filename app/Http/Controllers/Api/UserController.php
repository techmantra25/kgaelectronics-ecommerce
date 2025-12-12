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
use App\Models\Address;

class UserController extends Controller
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
            'user_id' => 'required',
            'address' => 'required|string',
            'landmark' => 'nullable|string',
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
            $landmark = $params['landmark'];
            $user_id = $this->user_id;
                # Update
                    $my_address= Address::find($id);
                    $my_address->user_id = $user_id;
                    $my_address->address = $params['address'];
                    $my_address->landmark = $params['landmark'];
                    $my_address->state = $params['state'];
                    $my_address->city = $params['city'];
                    $my_address->pin = $params['pin'];
                    $my_address->country = $params['country'];
                    $my_address->type = $params['type'];
                    $my_address->billing = $params['billing'];
                    $my_address->created_at = date('Y-m-d H:i:s');
                    $my_address->updated_at = date('Y-m-d H:i:s');
                    
                
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
        $id=$request->id;
        Address::where('id',$id)->delete();

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
