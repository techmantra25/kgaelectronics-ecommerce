<?php

namespace App\Providers;

use Illuminate\Auth\Events\Authenticated;

class CartServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Event::listen(Authenticated::class, function ($event) {
            $user = $event->user;
            $sessionCart = session()->get('cart', []);

            if (!empty($sessionCart)) {
                foreach ($sessionCart as $productId => $details) {
                    // Logic to add the session cart items to the user's cart in the database
                    $cartExists = Cart::where('product_id', $productId)->where('user_id', $user->id)->first();
                    
                    if ($cartExists) {
                        $cartExists->qty += $details['qty'];
                        $cartExists->save();
                    } else {
                        $newEntry = new Cart;
                        $newEntry->product_id = $productId;
                        $newEntry->qty = $details['qty'];
                        $newEntry->user_id = $user->id;
                        $newEntry->save();
                    }
                }
                // Clear the session cart after merging
                session()->forget('cart');
            }
        });
    }
}
