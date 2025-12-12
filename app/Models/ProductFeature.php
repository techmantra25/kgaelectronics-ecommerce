<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class ProductFeature extends Model
{
    public function product() {
        return $this->belongsTo('App\Models\Product', 'product_id', 'id');
    }
}
