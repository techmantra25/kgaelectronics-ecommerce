<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Product extends Model
{
    protected $fillable = ['cat_id', 'sub_cat_id', 'collection_id', 'name', 'short_desc', 'desc', 'price', 'offer_price', 'slug', 'meta_title', 'meta_desc', 'meta_keyword', 'style_no', 'image'];

    public function category() {
        return $this->belongsTo('App\Models\Category', 'cat_id', 'id');
    }

    public function subCategory() {
        return $this->belongsTo('App\Models\SubCategory', 'sub_cat_id', 'id');
    }

    public function collection() {
        return $this->belongsTo('App\Models\Collection', 'collection_id', 'id');
    }
public function colorSize() {
        \DB::statement("SET SQL_MODE=''");
        return $this->hasMany('App\Models\ProductColorSize', 'product_id', 'id')->groupBy('color')->orderBy('position')->orderBy('id');
    }
   public function color() {
        
        return $this->belongsTo('App\Models\Color', 'color_id', 'id');
    }

    public function saleDetails() {
        return $this->hasOne('App\Models\Sale', 'product_id', 'id');
    }
    
        public static function insertData($data, $count, $successArr, $failureArr) {

        // dd($data['title']);
        $value = DB::table('products')->where('name', $data['name'])->get();
        //dd($value);
        if($value->count() == 0) {
         DB::table('products')->insert($data);
         array_push($successArr, $data['name']);
         $count++;
        } else {
            array_push($failureArr, $data['name']);
        }
        $resp = [
            "count" => $count,
            "successArr" => $successArr,
            "failureArr" => $failureArr
        ];

        return $resp;
        
    }
}
