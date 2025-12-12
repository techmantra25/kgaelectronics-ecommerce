<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\SubscriptionMail;
use App\Models\Requisite;
use App\Models\OurStore;
use App\Models\Marketing;
use App\Models\FranchisePartner;

class FranchiseController extends Controller
{
    public function index(Request $request)
    {
        $data = Requisite::where('status',1)->get();
        $our_store_data = OurStore::where('status',1)->get();
        $marketing_data = Marketing::where('status',1)->get();
        return view('front.franchise.index',compact('data','our_store_data','marketing_data'));
    }

    public function mail(Request $request)
    {
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if (!$validator->fails()) {
            $mailExists = SubscriptionMail::where('email', $request->email)->first();
            if (empty($mailExists)) {
                $mail = new SubscriptionMail();
                $mail->email = $request->email;
                $mail->type = 'franchise_subscription';
                $mail->save();

                return response()->json(['resp' => 200, 'message' => 'Mail subscribed successfully']);
            } else {
                $mailExists->count += 1;
                $mailExists->save();

                return response()->json(['resp' => 200, 'message' => 'Thank you for showing your interest']);
            }
        } else {
            return response()->json(['resp' => 400, 'message' => $validator->errors()->first()]);
        }
    }

   

    public function partner(Request $request){
        // return $request->input();
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'city' => 'required|string|max:255',
            'business_nature' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'property_type' => 'required|string',
            'capital' => 'required|string',
            'source' => 'required|string',
            'comment' => 'nullable|string|max:1000',
        ]);
    
       $data = new FranchisePartner();
       $data->name = $request->name ?? '';
       $data->phone = $request->phone ?? '';
       $data->email = $request->email ?? '';
       $data->city = $request->city ?? '';
       $data->business_nature = $request->business_nature ?? '';
       $data->region = $request->region ?? '';
       $data->property_type = $request->property_type ?? '';
       $data->capital = $request->capital ?? '';
       $data->source = $request->source ?? '';
       $data->comment = $request->comment ?? '';
       $data->save(); 
      return redirect()->route('front.franchise.index')->with('success','Partner data submitted successfully');
    }
}
