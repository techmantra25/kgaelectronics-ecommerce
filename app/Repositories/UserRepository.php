<?php

namespace App\Repositories;

use App\Interfaces\UserInterface;
use App\User;
use App\Models\Address;
use App\Models\Order;
use App\Models\Product;
use App\Models\Wishlist;
use App\Models\Coupon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserRepository implements UserInterface
{
    public function __construct()
    {
        $this->ip = $_SERVER['REMOTE_ADDR'];
    }

    public function listAll()
    {
        return User::all();
    }

    public function listById($id)
    {
        return User::findOrFail($id);
    }

    public function searchCustomer(string $term)
    {
        return User::where([['fname', 'LIKE', '%' . $term . '%']])
            ->orWhere([['lname', 'LIKE', '%' . $term . '%']])
            ->orWhere([['email', 'LIKE', '%' . $term . '%']])
            ->orWhere([['mobile', 'LIKE', '%' . $term . '%']])
            ->orWhere([['gender', 'LIKE', '%' . $term . '%']])
            ->orWhere([['name', 'LIKE', '%' . $term . '%']])
            ->get();
    }

    // public function create(array $data)
    // {
    //     // DB::beginTransaction();

    //     // try {
    //     $collectedData = collect($data);

    //     $full_name = '';
    //     if (isset($data['fname'])) {
    //         $full_name = $collectedData['fname'] . ' ' . $collectedData['lname'];
    //     }

    //     $newEntry = new User;
    //     $newEntry->fname = $collectedData['fname'] ?? NULL;
    //     $newEntry->lname = $collectedData['lname'] ?? NULL;
    //     $newEntry->name = $full_name;
    //     $newEntry->email = $collectedData['email'];
    //     $newEntry->mobile = $collectedData['mobile'];
    //     $newEntry->gender = $collectedData['gender'] ?? NULL;
    //     $newEntry->password = Hash::make($collectedData['password']);

    //     $newEntry->save();

    //     if ($newEntry) {
    //         $email_data = [
    //             'name' => $full_name,
    //             'subject' => 'Onn - New registration',
    //             'email' => $collectedData['email'],
    //             'password' => $collectedData['password'],
    //             'blade_file' => 'front/mail/register',
    //         ];
    //         SendMail($email_data);
    //     }

    //     DB::commit();

    //     return true;
    //     // } catch (\Throwable $th) {
    //     //     //throw $th;

    //     //     DB::rollback();
    //     //     return false;
    //     // }
    // }
    public function create(array $data)
    {
        // DB::beginTransaction();

        // try {
        $collectedData = collect($data);

        // $full_name = '';
        // if (isset($data['fname'])) {
        //     $full_name = $collectedData['fname'] . ' ' . $collectedData['lname'];
        // }

        $newEntry = new User;
        $newEntry->name = $collectedData['name'] ?? NULL;
        // $newEntry->lname = $collectedData['lname'] ?? NULL;
        // $newEntry->name = $full_name;
        $newEntry->email = $collectedData['email'];
        $newEntry->mobile = $collectedData['mobile'];
        $newEntry->gender = $collectedData['gender'] ?? NULL;
        $newEntry->password = Hash::make($collectedData['password']);

        $newEntry->save();

        if ($newEntry) {
            $email_data = [
                'name' => $full_name,
                'subject' => 'Onn - New registration',
                'email' => $collectedData['email'],
                'password' => $collectedData['password'],
                'blade_file' => 'emails/otp',
            ];
            SendMail($email_data);
        }

        DB::commit();

        return true;
        // } catch (\Throwable $th) {
        //     //throw $th;

        //     DB::rollback();
        //     return false;
        // }
    }

    public function update($id, array $newDetails)
    {
        $updatedEntry = User::findOrFail($id);
        $collectedData = collect($newDetails);
        $updatedEntry->fname = $collectedData['fname'];
        $updatedEntry->lname = $collectedData['lname'];
        $updatedEntry->mobile = $collectedData['mobile'];
        if (!empty($collectedData['gender'])) {
            $updatedEntry->gender = $collectedData['gender'];
        }
        $updatedEntry->save();

        return $updatedEntry;
    }

    public function toggle($id)
    {
        $updatedEntry = User::findOrFail($id);

        $status = ($updatedEntry->status == 1) ? 0 : 1;
        $updatedEntry->status = $status;
        $updatedEntry->save();

        return $updatedEntry;
    }

    public function delete($id)
    {
        User::destroy($id);
    }

    public function addressById($id)
    {
        // dd("JJ"):
        // return true;
        return Address::where('user_id', $id)->get();
    }

    public function addressCreate(array $data)
    {
        $collectedData = collect($data);
        $newEntry = new Address;
        $newEntry->user_id = $collectedData['user_id'];
        $newEntry->address = $collectedData['address'];
        $newEntry->landmark = $collectedData['landmark'];
        $newEntry->lat = $collectedData['lat'];
        $newEntry->lng = $collectedData['lng'];
        $newEntry->state = $collectedData['state'];
        $newEntry->city = $collectedData['city'];
        $newEntry->pin = $collectedData['pin'];
        $newEntry->pin = $collectedData['pin'];
        $newEntry->country = $collectedData['country'];
        $newEntry->location = $collectedData['location'];
       // $newEntry->type = $collectedData['type'];
        $newEntry->save();

        return $newEntry;
    }
    

    public function addressupdate($id,array $data)
    {
        $collectedData = collect($data);
        $newEntry = Address::where('id',$id)->first();
        $newEntry->user_id = $collectedData['user_id'];
        $newEntry->address = $collectedData['address'];
        $newEntry->landmark = $collectedData['landmark'];
        $newEntry->lat = $collectedData['lat'];
        $newEntry->lng = $collectedData['lng'];
        $newEntry->state = $collectedData['state'];
        $newEntry->city = $collectedData['city'];
        $newEntry->pin = $collectedData['pin'];
        $newEntry->pin = $collectedData['pin'];
        $newEntry->country = $collectedData['country'];
        $newEntry->location = $collectedData['location'];
       // $newEntry->type = $collectedData['type'];
        $newEntry->update();

        return $newEntry;
    }
	  public function orderAddressupdate($id,array $data)
    {
        $collectedData = collect($data);
        $newEntry = Order::where('id',$id)->first();
        //$newEntry->user_id = $collectedData['user_id'];
        $newEntry->shipping_address = $collectedData['shipping_address'];
        $newEntry->shipping_landmark = $collectedData['shipping_landmark'];
       // $newEntry->lat = $collectedData['lat'];
       // $newEntry->lng = $collectedData['lng'];
        $newEntry->shipping_state = $collectedData['shipping_state'];
        $newEntry->shipping_city = $collectedData['shipping_city'];
        $newEntry->shipping_pin = $collectedData['shipping_pin'];
        //$newEntry->pin = $collectedData['pin'];
        $newEntry->shipping_country = $collectedData['shipping_country'];
        $newEntry->shipping_location = $collectedData['shipping_location'];
        //$newEntry->type = $collectedData['type'];
        $newEntry->update();

        return $newEntry;
    }
	  public function orderAddressBillingUpdate($id,array $data)
    {
        $collectedData = collect($data);
        $newEntry = Order::where('id',$id)->first();
        //$newEntry->user_id = $collectedData['user_id'];
        $newEntry->billing_address = $collectedData['billingaddress'];
        $newEntry->billing_landmark = $collectedData['billinglandmark'];
       // $newEntry->lat = $collectedData['lat'];
       // $newEntry->lng = $collectedData['lng'];
        $newEntry->billing_state = $collectedData['billingstate'];
        $newEntry->billing_city = $collectedData['billingcity'];
        $newEntry->billing_pin = $collectedData['billingpin'];
        //$newEntry->pin = $collectedData['pin'];
        $newEntry->billing_country = $collectedData['billingcountry'];
        $newEntry->billing_location = $collectedData['billinglocation'];
		  $newEntry->shipping_address = $collectedData['shipping_address'];
        $newEntry->shipping_landmark = $collectedData['shipping_landmark'];
       // $newEntry->lat = $collectedData['lat'];
       // $newEntry->lng = $collectedData['lng'];
        $newEntry->shipping_state = $collectedData['shipping_state'];
        $newEntry->shipping_city = $collectedData['shipping_city'];
        $newEntry->shipping_pin = $collectedData['shipping_pin'];
        //$newEntry->pin = $collectedData['pin'];
        $newEntry->shipping_country = $collectedData['shipping_country'];
        $newEntry->shipping_location = $collectedData['shipping_location'];
        //$newEntry->type = $collectedData['type'];
        $newEntry->update();

        return $newEntry;
    }

    public function updateProfile(array $data)
    {
        $collectedData = collect($data);
        $updateEntry = User::findOrFail(Auth::guard('web')->user()->id);
        $updateEntry->fname = $collectedData['fname'];
        $updateEntry->lname = $collectedData['lname'];
        $updateEntry->name = $collectedData['fname'] . ' ' . $collectedData['lname'];
        $updateEntry->mobile = $collectedData['mobile'];
        $updateEntry->save();

        return $updateEntry;
    }

    public function updatePassword(array $data)
    {
        $collectedData = collect($data);
        $userExists = User::findOrFail(Auth::guard('web')->user()->id);

        if ($userExists) {
            if (Hash::check($collectedData['old_password'], $userExists->password)) {
                $userExists->password = Hash::make($collectedData['new_password']);
                $userExists->save();
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function orderDetails()
    {
        $data = Order::where('email', Auth::guard('web')->user()->email)->latest('id')->get();
        return $data;
    }

    public function recommendedProducts()
    {
        $data = Product::latest('is_best_seller', 'id')->get();
        return $data;
    }

    public function wishlist()
    {
        $data = Wishlist::where('user_id', Auth::guard('web')->user()->id)->get();
        return $data;
    }

    public function couponList()
    {
        $data = Coupon::orderBy('end_date', 'desc')->get();
        return $data;
    }
}