<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    /**public function __construct()
    {
        $this->middleware('auth');
    }**/

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
	public function test_route(){
		 return view('test_route');
	}
	 public function storeSessionData(Request $request)
    {
        // Store the data in the session
        session([
            'product_data' => [
                'productId' => $request->input('id'),
                'productName' => $request->input('product_name'),
                'qty' => $request->input('quantity'),
            ]
        ]);

        return response()->json(['status' => 'success', 'message' => 'Data stored successfully']);
    }
}
