<?php

namespace App\Repositories;

use App\Interfaces\WishlistInterface;
use App\Models\Wishlist;
use Auth;
class WishlistRepository implements WishlistInterface 
{
    public function __construct() {
        $this->ip = $_SERVER['REMOTE_ADDR'];
    }

    public function addToWishlist(array $data) 
    {
        $collectedData = collect($data);

        $wishlistExists = Wishlist::where('product_id', $collectedData['product_id'])->where('user_id', Auth::guard('web')->user()->id)->first();

        if ($wishlistExists) {
            $newEntry = Wishlist::destroy($wishlistExists->id);
            return "removed";
        } else {
            $newEntry = new Wishlist;
            $newEntry->product_id = $collectedData['product_id'];
            $newEntry->user_id = Auth::guard('web')->user()->id;

            $newEntry->save();
            return "wishlisted";
        }
    }

    // public function viewByIp()
    // {
    //     $data = Wishlist::where('ip', $this->ip)->get();
    //     return $data;
    // }

    // public function delete($id)
    // {
    //     $data = Wishlist::destroy($id);
    //     return $data;
    // }

    // public function empty()
    // {
    //     $data = Wishlist::where('ip', $this->ip)->delete();
    //     return $data;
    // }
}