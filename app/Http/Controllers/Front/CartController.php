<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Interfaces\CartInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Cart;
use Auth;
class CartController extends Controller
{
    public function __construct(CartInterface $cartRepository) 
    {
        $this->cartRepository = $cartRepository;
    }

    public function couponCheck(Request $request)
    {
        $couponData = $this->cartRepository->couponCheck($request->code);
        return $couponData;
    }

    public function couponRemove(Request $request)
    {
        $couponData = $this->cartRepository->couponRemove();
        return $couponData;
    }

    public function add(Request $request) 
    {
        // dd($request->all());

        $request->validate([
            "product_id" => "required|string|max:255",
            "qty" => "required|integer",
        ]);

        $params = $request->except('_token');

        $cartStore = $this->cartRepository->addToCart($params);

        if ($cartStore) {
           // return response()->json(['status' => 200, 'message' => 'Product added to cart', 'response' => $cartStore]);
             return redirect()->route('front.cart.index')->with('success', 'Product added to cart');
        } else {
           // return response()->json(['status' => 400, 'message' => 'Product cannot be added to cart']);
             return redirect()->back()->with('failure', 'Something happened');
        }
    }

    public function viewByIp(Request $request)
    {
        if(Auth::guard('web')->user()){
            $data = $this->cartRepository->viewByIp();

            if ($data) {
                return view('front.cart.index', compact('data'));
            } else {
                return view('front.404');
            }
        }else{
            return redirect()->route('front.user.login');
        }
    }

    public function delete(Request $request, $id)
    {
        $data = $this->cartRepository->delete($id);

        if ($data) {
            return redirect()->route('front.cart.index')->with('success', 'Product removed from cart');
        } else {
            return redirect()->route('front.cart.index')->with('failure', 'Something happened');
        }
    }

    public function qtyUpdate(Request $request, $id, $type)
    {
        $data = $this->cartRepository->qtyUpdate($id, $type);

        if ($data) {
            return redirect()->route('front.cart.index')->with('success', $data);
        } else {
            return redirect()->route('front.cart.index')->with('failure', 'Something happened');
        }
    }
}
