<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['ip', 'product_id', 'product_name', 'product_image', 'product_slug', 'product_variation_id', 'price', 'offer_price', 'qty','coupon_code_id'];

    public function cartVariationDetails() {
        return $this->belongsTo('App\Models\ProductColorSize', 'product_variation_id', 'id');
    }

    public function couponDetails() {
        return $this->belongsTo('App\Models\Coupon', 'coupon_code_id', 'id');
    }
    public function product() {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }
}
