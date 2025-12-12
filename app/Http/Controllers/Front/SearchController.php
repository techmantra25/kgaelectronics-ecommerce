<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Interfaces\SearchInterface;
use Illuminate\Http\Request;
use App\Models\Product;
// use Illuminate\Http\Response;

class SearchController extends Controller
{
    public function __construct(SearchInterface $searchRepository) 
    {
        $this->searchRepository = $searchRepository;
    }

    public function index(Request $request) 
    {
        $params = $request->except('_token');

        $data = $this->searchRepository->index($params);

        return view('front.search.index', compact('data', 'request'));
    }

    public function product(Request $request)
    {
        # ajax...

        $search = !empty($request->search)?$request->search:'';
        $data = array();
        if(!empty($search)){
            $data = Product::where(function($query) use ($search){
                $query->where('name', 'LIKE','%'.$search.'%')->orWhere('slug','LIKE','%'.$search.'%')->orWhere('style_no', 'LIKE', '%'.$search.'%')->orWhere('short_desc', 'LIKE', '%'.$search.'%')->orWhere('desc', 'LIKE', '%'.$search.'%');
            })->where('status', 1)->get()->toarray();
        }

        return $data;
    }
}
