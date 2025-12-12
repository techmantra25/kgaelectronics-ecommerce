<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductReview;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
class ReviewController extends Controller
{
    public function index(Request $request) 
    {
        $data = ProductReview::latest('id')->get();
		$product = Product::where('status',1)->orderby('id','desc')->get();
        return view('admin.product-review.index', compact('data','product'));
    }

    public function store(Request $request) 
    {
		//dd($request->all());
       $validator = Validator::make($request->all(),[
			"product_id" => "required",
            "created_by" => "required",
			 "title" => "required",
			 "description" => "required",
			 //"video" => "required",
        ]);
		//dd('hi');
		if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
        $params = $request->except('_token');
        $upload_path = "public/uploads/productreview/";
        $banner = new ProductReview;
		$banner->product_id=$request->product_id;
		$banner->title=$request->title;
		$banner->description=$request->description;
       $banner->created_by=$request->created_by ?? '';
        // file type
       // $extension = $image->getClientOriginalExtension();
       // $imageTypes = array('jpg', 'jpeg', 'png', 'svg', 'gif');
		// video
		
        
        
		$banner->status=1;
        $banner->save();
		//dd($banner);

        if ($banner) {
            return redirect()->route('admin.product-review.index');
        } else {
            return redirect()->route('admin.product-review.create')->withInput($request->all());
        }
		}
    }

    public function show(Request $request, $id)
    {
        $data = ProductReview::findOrFail($id);
		$product = Product::where('status',1)->orderby('id','desc')->get();
        return view('admin.product-review.detail', compact('data','product'));
    }

    public function update(Request $request, $id)
    {
		
        $$validator = Validator::make($request->all(),[
            "thumbnail_imge" => "nullable|mimes:jpg,jpeg,png,svg,gif,mp4,mp3|max:10000000",
        ]);
		if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
        $params = $request->except('_token');
        $upload_path = "public/uploads/productvideo/";
        $banner = ProductReview::findOrFail($id);
		$banner->product_id=$request->product_id;
		$banner->title=$request->title ?? '';
		$banner->description=$request->description ?? '';
        
          
		$banner->created_by=$request->created_by ?? '';
        

        $banner->save();
        if ($banner) {
            return redirect()->route('admin.product-review.index');
        } else {
            return redirect()->route('admin.product-review.create')->withInput($request->all());
        }
		}
    }

    public function status(Request $request, $id)
    {
        $updatedEntry = ProductReview::findOrFail($id);

        $status = ( $updatedEntry->status == 1 ) ? 0 : 1;
        $updatedEntry->status = $status;
        $updatedEntry->save();


        if ($updatedEntry) {
            return redirect()->route('admin.product-review.index');
        } else {
            return redirect()->route('admin.product-review.create')->withInput($request->all());
        }
    }

    public function destroy(Request $request, $id) 
    {
        $image=ProductReview::where('id',$id)->delete();

        return redirect()->route('admin.product-review.index');
    }
	
	
	 public function trending(Request $request, $id)
    {
        $product = ProductReview::findOrFail($id);

        if ($product->is_featured == 1) {
            $product->is_featured = 0;
        } else {
            $product->is_featured = 1;
        }
        $product->save();

        return redirect()->back();
    }
}
