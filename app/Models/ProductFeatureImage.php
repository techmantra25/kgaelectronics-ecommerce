<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductFeatureImage extends Model
{
    
    /**
     * Get the user that owns the Wishlist
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    
    public function productDetails() {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }
}
