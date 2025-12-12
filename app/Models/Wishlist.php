<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wishlist extends Model
{
    
    /**
     * Get the user that owns the Wishlist
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(App\Models\Product::class, 'product_id', 'id');
    }
    
     public function productDetails() {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }
}
