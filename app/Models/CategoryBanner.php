<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryBanner extends Model
{
    protected $table='category_banners';
	protected $fillable = ['cat_id', 'name','description','icon','created_at','updated_at'];
}
