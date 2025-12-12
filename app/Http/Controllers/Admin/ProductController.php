<?php

namespace App\Http\Controllers\Admin;

use App\Interfaces\ProductInterface;
use App\Models\Product;
use App\Models\ProductSpecification;
use App\Models\ProductFeature;
use App\Models\Collection;
use App\Models\Color;
use App\Models\Category;
use App\Models\ProductColorSize;
use App\Models\SubCategory;
use App\Models\ProductReviewVideo;
use App\Models\ProductFeatureImage;
use App\Models\ProductImage;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Session as FacadesSession;

class ProductController extends Controller
{
    // private ProductInterface $productRepository;

    public function __construct(ProductInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }
    // public function update_image_path()
    // {
    //     $upload_path = public_path('uploads/product/') . '/'; // absolute path
    //     $db_path_prefix = "uploads/product/";

    //     $images = ProductFeatureImage::where('status_update', 0)->limit(210)->get();

    //     foreach ($images as $img) {
    //         $oldPath = public_path($img->image); // absolute path
            
    //         if (!empty($img->image) && file_exists($oldPath)) {
    //             $extension = pathinfo($img->image, PATHINFO_EXTENSION);
    //             $newFileName = time() . '_' . uniqid() . '.' . $extension;
    //             $newFullPath = $upload_path . $newFileName; // absolute path
               
    //             // Rename/move the file
    //             rename($oldPath, $newFullPath);
    //             // Update DB path without "public/"
    //             $img->image = $db_path_prefix . $newFileName;
    //             $img->status_update = 1;
    //             $img->save();
    //         }
    //     }
        
    //     return "All image/video paths updated successfully!";
    // }
    public function index(Request $request)
    {
        $catagory = !empty($request->category) ? $request->category : '';
        $range = !empty($request->range) ? $request->range : '';
        $term = !empty($request->term) ? $request->term : '';

        if (!empty($request->term) || !empty($request->category) || !empty($request->range)) {
            $data = $this->productRepository->filteredProducts($catagory, $range, $term);
        } else {
            $data = $this->productRepository->listAll();
        }

        $catagories = Product::select('cat_id')->groupBy('cat_id')->with('category')->get();
        $ranges = Product::select('collection_id')->groupBy('collection_id')->with('collection')->get();

        if ($request->ajax()) {
            $cid = $request->collection_id;
            $cc = Product::where('collection_id', $cid)->groupBy('cat_id')->select('cat_id')->with('category')->get();
            return json_encode($cc);
        }

        return view('admin.product.index', compact('data', 'catagories', 'ranges'));
    }

    public function create(Request $request)
    {
        $categories = $this->productRepository->categoryList();
        $sub_categories = $this->productRepository->subCategoryList();
        $collections = $this->productRepository->collectionList();
         $colors = $this->productRepository->colorList();
        return view('admin.product.create', compact('categories', 'sub_categories', 'collections','colors'));
    }

    public function store(Request $request)
    {
         //dd($request->all());

         $validator = Validator::make($request->all(),[
            "cat_id" => "required|integer",
            "sub_cat_id" => "nullable|integer",
            // "collection_id" => "required|integer",
            "product_name" => "required|string|max:255",
            "short_desc" => "nullable",
            "desc" => "nullable",
            "price" => "nullable|integer",
            "offer_price" => "nullable|integer",
            "meta_title" => "nullable",
            "meta_desc" => "nullable",
            "meta_keyword" => "nullable",
            "style_no" => "nullable|unique:products",
            "image" => "required",
            "images" => "nullable|array",
			 "video" => "nullable",
            "pack" => "nullable|string|max:255",
        ]);
       if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
        $params = $request->except('_token');
        
        $storeData = $this->productRepository->create($params);

        if ($storeData) {
            return redirect()->route('admin.product.index')->with('success', 'New Product created');
        } else {
            return redirect()->route('admin.product.create')->withInput($request->all());
        }
	   }
    }

    public function show(Request $request, $id)
    {
        $data = $this->productRepository->listById($id);
        $images = $this->productRepository->listImagesById($id);
        return view('admin.product.detail', compact('data', 'images'));
    }

    public function size(Request $request)
    {
        $productId = $request->productId;
        $colorId = $request->colorId;

        $data = ProductColorSize::where('product_id', $productId)->where('color', $colorId)->get();

        $resp = [];

        foreach ($data as $dataKey => $dataValue) {
            $resp[] = [
                'variationId' => $dataValue->id,
                'sizeId' => $dataValue->size,
                'sizeName' => $dataValue->sizeDetails->name
            ];
        }

        return response()->json(['error' => false, 'data' => $resp]);
    }

    public function edit(Request $request, $id)
    {
        $categories = $this->productRepository->categoryList();
        $sub_categories = $this->productRepository->subCategoryList();
        $collections = $this->productRepository->collectionList();
        $data = $this->productRepository->listById($id);
        $spec = ProductSpecification::where('product_id',$id)->get();
        $feature = ProductFeature::where('product_id',$id)->get();
		$videolink = ProductReviewVideo::where('product_id',$id)->get();
		$featureimage = ProductFeatureImage::where('product_id',$id)->get();
		
        $images = $this->productRepository->listImagesById($id);
 		$colors = $this->productRepository->colorList();
        \DB::statement("SET SQL_MODE=''");
        // $productColorGroup = ProductColorSize::select('id', 'color', 'status')->where('product_id', $id)->groupBy('color')->orderBy('position')->orderBy('id')->get();
        $productColorGroup = ProductColorSize::select('id', 'color', 'status', 'position', 'color_name', 'color_fabric')->where('product_id', $id)->groupBy('color')->orderBy('position')->orderBy('id')->get();

        return view('admin.product.edit', compact('id', 'data', 'categories', 'sub_categories', 'collections', 'images', 'spec', 'feature', 'productColorGroup','colors','videolink','featureimage'));
    }

   public function update(Request $request)
    {
        // dd($request->all());

      $validator = Validator::make($request->all(), [
            "product_id" => "required|integer",
            "cat_id" => "required|integer",
          
            // "collection_id" => "nullable|integer",
            "product_name" => "required|string|max:255",
           
            "product_image" => "nullable"
        ]);
		if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
			
        $params = $request->except('_token');
        $storeData = $this->productRepository->update($request->product_id, $params);
		
			if ($storeData) {
				return redirect()->route('admin.product.index')->with('success', 'Product updated successfully');
			} else {
				return redirect()->route('admin.product.update', $request->product_id)->withInput($request->all());
			}
		}
    }


    public function status(Request $request, $id)
    {
        $storeData = $this->productRepository->toggle($id);

        if ($storeData) {
            return redirect()->route('admin.product.index');
        } else {
            return redirect()->route('admin.product.create')->withInput($request->all());
        }
    }

    public function sale(Request $request, $id)
    {
        $storeData = $this->productRepository->sale($id);

        // if ($storeData) {
        return redirect()->route('admin.product.index');
        // } else {
        //     return redirect()->route('admin.product.create')->withInput($request->all());
        // }
    }

    public function trending(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if ($product->is_trending == 1) {
            $product->is_trending = 0;
        } else {
            $product->is_trending = 1;
        }
        $product->save();

        return redirect()->route('admin.product.index');
    }

    public function destroy(Request $request, $id)
    {
        $this->productRepository->delete($id);

        return redirect()->route('admin.product.index');
    }

    public function destroySingleImage(Request $request, $id)
    {
        $this->productRepository->deleteSingleImage($id);
        return redirect()->back();

        // return redirect()->route('admin.product.index');
    }
    public function bulkDestroy(Request $request)
    {
		//dd($request->all());
        // $request->validate([
        //     'bulk_action' => 'required',
        //     'delete_check' => 'required|array',
        // ]);

        $validator = Validator::make($request->all(), [
            'bulk_action' => 'required',
            'delete_check' => 'required|array',
        ], [
            'delete_check.*' => 'Please select at least one item'
        ]);

        if (!$validator->fails()) {
            if ($request['bulk_action'] == 'delete') {
                foreach ($request->delete_check as $index => $delete_id) {
                    Product::where('id', $delete_id)->delete();
                }

                return redirect()->route('admin.product.index')->with('success', 'Selected items deleted');
            } else {
                return redirect()->route('admin.product.index')->with('failure', 'Please select an action')->withInput($request->all());
            }
        } else {
            return redirect()->route('admin.product.index')->with('failure', $validator->errors()->first())->withInput($request->all());
        }
    }

    public function featureDestroy(Request $request, $id)
    {
        // dd($id);
        ProductFeature::destroy($id);
        return redirect()->back()->with('success', 'Feature deleted successfully');
    }

    public function variationImageDestroy(Request $request)
    {
        // dd($request->all());
        ProductImage::destroy($request->id);
        return response()->json(['status' => 200, 'message' => 'Image deleted successfully']);
        // return redirect()->back();
    }

    public function variationImageUpload(Request $request)
    {
        // dd($request->all());

        $request->validate([
            'product_id' => 'required',
            'color_id' => 'required',
            'image' => 'required|array',
        ]);

        $product_id = $request->product_id;
        $color_id = $request->color_id;

        // dd($request->image);

        foreach ($request->image as $imageKey => $imageValue) {
            // $newName = str_replace(' ', '-', $imageValue->getClientOriginalName());
            $newName = mt_rand() . '_' . time() . '.' . $imageValue->getClientOriginalExtension();
            $imageValue->move('public/uploads/product/product_images/', $newName);

            $productImage = new ProductImage();
            $productImage->product_id = $product_id;
            $productImage->color_id = $color_id;
            $productImage->image = 'public/uploads/product/product_images/' . $newName;
            $productImage->save();
        }

        return redirect()->back();
    }

    public function featureAdd(Request $request)
    {
         //dd($request->all());

        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'featurename' => 'required'
           
        ]);

        if (!$validator->fails()) {
            $upload_path = "public/uploads/product/";
            $productImage = new ProductFeature();
            $productImage->product_id = $request->product_id;
            $productImage->name = $request->featurename;
            if (isset($request['feature_icon'])) {
                $image = $request->feature_icon;
                $imageName = time() . "." . mt_rand() . "." . $image->getClientOriginalName();
                $image->move($upload_path, $imageName);
                $uploadedImage = $imageName;
                $productImage->icon = $upload_path . $uploadedImage;
            }
            $productImage->save();

            // return response()->json(['status' => 200, 'message' => 'Size added successfully']);
            return redirect()->back();
        } else {
            // return response()->json(['status' => 200, 'message' => $validator->errors()->first()]);
            return redirect()->back()->with('failure', $validator->errors()->first())->withInput($request->all());

            // return redirect()->route('admin.product.index')->with('failure', $validator->errors()->first())->withInput($request->all());
        }

        
    }

    public function specificationDestroy(Request $request, $id)
    {
        // dd($productId, $colorId);
        ProductSpecification::where('id', $id)->delete();
        return redirect()->back();
    }
	
	public function videolinkDestroy(Request $request, $id)
    {
        // dd($productId, $colorId);
        ProductReviewVideo::where('id', $id)->delete();
        return redirect()->back();
    }

	public function featureImageDestroy(Request $request, $id)
    {
        // dd($productId, $colorId);
        ProductFeatureImage::where('id', $id)->delete();
        return redirect()->back();
    }


    public function specificationAdd(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'product_id' => 'required',
            'specname' => 'required',
        ]);

        if (!$validator->fails()) {
                $upload_path = "public/uploads/product/";
                $productImage = new ProductSpecification();
                $productImage->product_id = $request->product_id;
                $productImage->name = $request->specname;
                $productImage->description = $request->specdescription;
                if (isset($request->spec_icon)) {
                    $image = $request->spec_icon;
                    $imageName = time() . "." . mt_rand() . "." . $image->getClientOriginalName();
                    $image->move($upload_path, $imageName);
                    $uploadedImage = $imageName;
                    $productImage->icon = $upload_path . $uploadedImage;
                }
                $productImage->save();
            if($productImage){
                return redirect()->back()->with('success', 'Specification added successfully');
            } else {
                return redirect()->back()->with('failure', 'Something wrong.')->withInput($request->all());
            }
        } else {
            return redirect()->back()->with('failure', $validator->errors()->first())->withInput($request->all());
        }

    }
	

    

    public function specificationEdit(Request $request,$id)
    {
		//dd($request->all());
        $upload_path = "public/uploads/product/";
                $productImage =ProductSpecification::findOrfail($id);
                $productImage->product_id = $request->product_id;
                $productImage->name = $request->specname;
                $productImage->description = $request->specdescription;
                if (isset($request->spec_icon)) {
                    $image = $request->spec_icon;
                    $imageName = time() . "." . mt_rand() . "." . $image->getClientOriginalName();
                    $image->move($upload_path, $imageName);
                    $uploadedImage = $imageName;
                    $productImage->icon = $upload_path . $uploadedImage;
                }
                $productImage->save();
        return redirect()->back()->with('success', 'Specification updated');
    }

    public function featureEdit(Request $request,$id)
    {
        // dd($request->all());
        $upload_path = "public/uploads/product/";
        $productImage =ProductFeature::findOrfail($id);
        $productImage->product_id = $request->product_id;
        $productImage->name = $request->featurename;
        if (isset($request['feature_icon'])) {
            $image = $request->feature_icon;
            $imageName = time() . "." . mt_rand() . "." . $image->getClientOriginalName();
            $image->move($upload_path, $imageName);
            $uploadedImage = $imageName;
            $productImage->icon = $upload_path . $uploadedImage;
        }
        $productImage->save();

			return redirect()->back()->with('success', 'Feature updated successfully');
      
    }

    
    //review video add
	public function videolinkAdd(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'product_id' => 'required'
            
        ]);

        if (!$validator->fails()) {
                $productImage = new ProductReviewVideo();
                $productImage->product_id = $request->product_id;
                $productImage->link = $request->link;
               
                $productImage->save();
            if($productImage){
                return redirect()->back()->with('success', 'Review  added successfully');
            } else {
                return redirect()->back()->with('failure', 'Something wrong.')->withInput($request->all());
            }
        } else {
            return redirect()->back()->with('failure', $validator->errors()->first())->withInput($request->all());
        }

    }
	//review video edit
	 public function videolinkEdit(Request $request,$id)
    {
		//dd($request->all());
                $productImage =ProductReviewVideo::findOrfail($id);
                $productImage->product_id = $request->product_id;
                $productImage->link = $request->link;
                
                $productImage->save();
        return redirect()->back()->with('success', 'Review updated');
    }
	
	//feature image
   public function featureImageAdd(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'product_id' => 'required'
            
        ]);
		
        if (!$validator->fails()) {
                $upload_path = "public/uploads/product/";
                $productImage = new ProductFeatureImage();
                $productImage->product_id = $request->product_id;
                
                if (isset($request->feature_image)) {
                    $image = $request->feature_image;
                    $imageName = time() . "." . mt_rand() . "." . $image->getClientOriginalName();
                    $image->move($upload_path, $imageName);
                    $uploadedImage = $imageName;
                    $productImage->image = $upload_path . $uploadedImage;
                }
                $productImage->save();
			
            if($productImage){
                return redirect()->back()->with('success', 'Image added successfully');
            } else {
                return redirect()->back()->with('failure', 'Something wrong.')->withInput($request->all());
            }
        } else {
            return redirect()->back()->with('failure', $validator->errors()->first())->withInput($request->all());
        }

    }

	//feature image edit
	
	public function featureImageEdit(Request $request,$id)
    {
		//dd($request->all());
        $upload_path = "public/uploads/product/";
                $productImage =ProductFeatureImage::findOrfail($id);
                $productImage->product_id = $request->product_id;
                if (isset($request->feature_image)) {
                    $image = $request->feature_image;
                    $imageName = time() . "." . mt_rand() . "." . $image->getClientOriginalName();
                    $image->move($upload_path, $imageName);
                    $uploadedImage = $imageName;
                    $productImage->image = $upload_path . $uploadedImage;
                }
                $productImage->save();
        return redirect()->back()->with('success', 'Image updated');
    }
    public function variationFabricUpload(Request $request)
    {
        // dd($request->all());

        $save_location = 'public/uploads/color/';
        $data = $request->image;
        $image_array_1 = explode(";", $data);
        $image_array_2 = explode(",", $image_array_1[1]);
        $data = base64_decode($image_array_2[1]);
        $imageName = mt_rand().'_'.time().'.png';

        if (file_put_contents($save_location.$imageName, $data)) {
            // $user = Auth::user();
            // $user->image_path = $save_location.$imageName;
            // $user->save();
            // return response()->json(['error' => false, 'message' => 'Image updated', 'image' => asset($save_location.$imageName)]);

            $productVariation = ProductColorSize::where('product_id', $request->product_id)->where('color', $request->color_id)->get();

            foreach($productVariation as $item) {
                $item->color_fabric = $save_location.$imageName;
                $item->save();
            }

            return response()->json(['error' => false, 'message' => 'Image uploaded', 'image' => asset($save_location.$imageName), 'color_id' => $request->color_id]);
        } else {
            return response()->json(['error' => true, 'message' => 'Something went wrong']);
        }
    }

 public function variationCSVUpload(Request $request)
    {
        if (!empty($request->file)) {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName();
            $extension = $file->getClientOriginalExtension();
            $tempPath = $file->getRealPath();
            $fileSize = $file->getSize();
            $mimeType = $file->getMimeType();

            $valid_extension = array("csv");
            $maxFileSize = 50097152;
            if (in_array(strtolower($extension), $valid_extension)) {
                if ($fileSize <= $maxFileSize) {
                    $location = 'public/uploads/csv';
                    $file->move($location, $filename);
                    // $filepath = public_path($location . "/" . $filename);
					$filepath = $location."/".$filename;
					
					// dd($filepath);
					
                    $file = fopen($filepath, "r");
                    $importData_arr = array();
                    $i = 0;
                    while (($filedata = fgetcsv($file, 10000, ",")) !== FALSE) {
                        $num = count($filedata);
                        // Skip first row
                        if ($i == 0) {
                            $i++;
                            continue;
                        }
                        for ($c = 0; $c < $num; $c++) {
                            $importData_arr[$i][] = $filedata[$c];
                        }
                        $i++;
                    }
                    fclose($file);
                        $count = $total = 0;
                        $successArr = $failureArr = [];
                        $commaSeperatedCats = '';

                    foreach ($importData_arr as $importData) {
                            $catExistCheck = Category::where('name', $importData[1])->first();
                            if ($catExistCheck) {
                                $insertDirCatId = $catExistCheck->id;
                                $commaSeperatedCats = $insertDirCatId;
                            } else {
                                $dirCat = new Category();
                                $dirCat->name = $importData[1];
                                $slug = Str::slug($importData[1], '-');
                                $slugExistCount = Category::where('slug', $slug)->count();
                                if ($slugExistCount > 0) $slug = $slug.'-'.($slugExistCount+1);
                                $dirCat->slug = $slug;
                                $dirCat->status = 1;
                                $dirCat->save();
                                $insertDirCatId = $dirCat->id;

                                $commaSeperatedCats = $insertDirCatId;
                            }
                        
                            $subcatExistCheck = SubCategory::where('name', $importData[2])->first();
                            if ($subcatExistCheck) {
                                $insertDirSubCatId = $subcatExistCheck->id;
                                $commaSeperatedSubCats = $insertDirSubCatId;
                            } else {
                                $dirCat = new SubCategory();
                                $dirCat->name = $importData[2];
                                $slug = Str::slug($importData[2], '-');
                                $slugExistCount = SubCategory::where('slug', $slug)->count();
                                if ($slugExistCount > 0) $slug = $slug.'-'.($slugExistCount+1);
                                $dirCat->slug = $slug;
                                $dirCat->status = 1;
                                $dirCat->save();
                                $insertDirSubCatId = $dirCat->id;

                                $commaSeperatedSubCats = $insertDirSubCatId;
                            }
                        
                        $insertData = array(
                            "name" => isset($importData[0]) ? $importData[0] : null,
                            "cat_id" => isset($commaSeperatedCats) ? $commaSeperatedCats : null,
                            "sub_cat_id" => isset($commaSeperatedSubCats) ? $commaSeperatedSubCats : null,
                            "price" => isset($importData[3]) ? $importData[3] : null,
                            "offer_price" => isset($importData[3]) ? $importData[3] : null,
                            "status" => 1,
							"created_at" => now(),
							"updated_at" => now(),
                          
                        );

                        $resp = Product::insertData($insertData, $count,$successArr,$failureArr);
                        $count = $resp['count'];
                        $successArr = $resp['successArr'];
                        $failureArr = $resp['failureArr'];
                        $total++;
                    }

                    if($count==0){
                        FacadesSession::flash('csv', 'Already Uploaded. ');
                    }
                    else{
                         FacadesSession::flash('csv', 'Import Successful. '.$count.' Data Uploaded');
                    }
            } else {
                Session::flash('message', 'File too large. File must be less than 50MB.');
            }
        } else {
            Session::flash('message', 'Invalid File Extension. supported extensions are ' . implode(', ', $valid_extension));
        }
    } else {
        Session::flash('message', 'No file found.');
    }
        return redirect()->back();
    }


    public function variationBulkEdit(Request $request)
    {
        $request->validate([
            "bulkAction" => "required | in:edit",
            "variation_id" => "required | array",
        ]);
        $data = $request->variation_id;

        return view('admin.product.bulk.edit', compact('data', 'request'));
    }

    public function variationBulkUpdate(Request $request)
    {
        // dd($request->all());

        $request->validate([
            "id" => "required|array",
            // "price" => "required|array",
            "offer_price" => "required|array"
        ]);

        // dd('here');

        foreach ($request->id as $key => $value) {
            // $price = $request->price[$key];
            $offer_price = $request->offer_price[$key];

            DB::table('product_color_sizes')
            ->where('id', $value)
            ->update([
                // 'price' => $price,
                'offer_price' => $offer_price
            ]);
        }

        

        return redirect()->route('admin.product.edit', $request->product_id)->with('success', 'Bulk update successfull');
    }
}
