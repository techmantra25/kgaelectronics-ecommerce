<?php

namespace App\Repositories;

use App\Interfaces\SearchInterface;
use App\Models\Product;

class SearchRepository implements SearchInterface 
{
    public function __construct() {
        $this->ip = $_SERVER['REMOTE_ADDR'];
    }

    public function index(array $data) 
    {
        $collectedData = collect($data);
        $search = $collectedData['query'];

        $data = Product::where(function($query) use ($search){
            $query->where('name', 'LIKE','%'.$search.'%')->orWhere('slug','LIKE','%'.$search.'%')->orWhere('style_no', 'LIKE', '%'.$search.'%')->orWhere('short_desc', 'LIKE', '%'.$search.'%')->orWhere('desc', 'LIKE', '%'.$search.'%');
        })->where('status', 1)->get();

        return $data;
    }
}