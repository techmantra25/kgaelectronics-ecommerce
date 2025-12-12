<?php

namespace App\Repositories;

use App\Interfaces\ProductInterface;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\SubCategory;
use App\Models\Collection;
use App\Models\Color;
use App\Models\ProductSpecification;
use App\Models\ProductFeature;
use App\Models\Sale;
use App\Models\ProductColor;
use App\Models\ProductColorSize;
use App\Models\Wishlist;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Auth;
class ProductRepository implements ProductInterface
{
    use UploadAble;

    public function listAll()
    {
        return Product::all();
    }

    public function categoryList()
    {
        return Category::all();
    }
    public function getSearchProducts(string $term)
    {
        return Product::where('name', 'LIKE', '%' . $term . '%')
            ->orWhere('offer_price', 'LIKE', '%' . $term . '%')
            ->orWhere('style_no', 'LIKE', '%' . $term . '%')
            ->orWhere('price', 'LIKE', '%' . $term . '%')
            ->get();
    }

    public function filteredProducts(string $catagoryfilter = '', string $rangefilter = '', string $term = '')
    {
        $data = Product::orderby('id','desc');

        if ($catagoryfilter != '')
            $data =  $data->where('cat_id', $catagoryfilter);

        if ($rangefilter != '')
            $data = $data->where('collection_id', $rangefilter);

        // dd($data->get());

        if ($term != '')
            $data = $data->where('name', 'LIKE', '%' . $term . '%')->orWhere('offer_price', 'LIKE', '%' . $term . '%')->orWhere('style_no', 'LIKE', '%' . $term . '%')->orWhere('price', 'LIKE', '%' . $term . '%');

        return $data->get();
    }


    public function subCategoryList()
    {
        return SubCategory::all();
    }

    public function collectionList()
    {
        return Collection::all();
    }

    public function colorList()
    {
        return Color::all();
    }

    public function colorListByName()
    {
        return Color::orderBy('name', 'asc')->get();
    }

    public function sizeList()
    {
        return Size::all();
    }

    public function listById($id)
    {
        return Product::findOrFail($id);
    }

    public function listBySlug($slug)
    {
        return Product::where('slug', $slug)->with('category', 'subCategory', 'collection', 'colorSize')->first();
    }

    public function relatedProducts($id)
    {
        $product = Product::findOrFail($id);
        $cat_id = $product->cat_id;
        return Product::where('cat_id', $cat_id)->where('id', '!=', $id)->where('status',1)->with('category', 'subCategory', 'collection', 'colorSize')->get();
    }

    public function listImagesById($id)
    {
        return ProductImage::where('product_id', $id)->latest('id')->get();
    }

    public function create(array $data)
    {
		//dd($data);
        DB::beginTransaction();

        try {
            $collectedData = collect($data);
			//dd($collectedData);
            $upload_path = "public/uploads/product/";
            $db_path_prefix = "uploads/product/";
            $newEntry = new Product;
			
            $newEntry->cat_id = !empty($collectedData['cat_id'])?$collectedData['cat_id']:NULL;
            //$newEntry->sub_cat_id = !empty($collectedData['sub_cat_id'])?$collectedData['sub_cat_id']:NULL;
            // $newEntry->collection_id = $collectedData['collection_id'];
            $newEntry->name = $collectedData['product_name']??'';
			$newEntry->sub_heading = $collectedData['sub_heading']??'';
			$newEntry->color_id = $collectedData['color_id']??'';
            $newEntry->short_desc = $collectedData['short_desc']??'';
            $newEntry->desc = $collectedData['desc']??'';
			$newEntry->short_content = $collectedData['short_content']??'';
			$newEntry->long_content = $collectedData['long_content']??'';
            $newEntry->price = $collectedData['price']??'';
            $newEntry->offer_price = $collectedData['offer_price']??'';
            $newEntry->meta_title = $collectedData['meta_title']??'';
            $newEntry->meta_desc = $collectedData['meta_desc']??'';
            $newEntry->meta_keyword = $collectedData['meta_keyword']??'';
            $newEntry->pack = $collectedData['pack']??'';
			
            // slug generate
            $slug = \Str::slug($collectedData['product_name'], '-');
            $slugExistCount = Product::where('slug', $slug)->count();
            if ($slugExistCount > 0) $slug = $slug . '-' . ($slugExistCount + 1);
            $newEntry->slug = $slug;
			
            // === MAIN IMAGE ===
            if (isset($collectedData['image'])) {
                $image = $collectedData['image'];
                $extension = $image->getClientOriginalExtension();
                $imageName = time() . '_' . uniqid() . '.' . $extension;
                $image->move($upload_path, $imageName);
                $newEntry->image = $db_path_prefix . $imageName;
            }

            // === BANNER IMAGE ===
            if (isset($collectedData['banner_image'])) {
                $image = $collectedData['banner_image'];
                $extension = $image->getClientOriginalExtension();
                $imageName = time() . '_' . uniqid() . '.' . $extension;
                $image->move($upload_path, $imageName);
                $newEntry->banner_image = $db_path_prefix . $imageName;
            }

            // === THUMBNAIL IMAGE ===
            if (isset($collectedData['thumbnail_image'])) {
                $image = $collectedData['thumbnail_image'];
                $extension = $image->getClientOriginalExtension();
                $imageName = time() . '_' . uniqid() . '.' . $extension;
                $image->move($upload_path, $imageName);
                $newEntry->thumbnail_image = $db_path_prefix . $imageName;
            }

			$newEntry->save();
			
            // multiple image upload handling
            if (isset($collectedData['images'])) {
                $multipleImageData = [];
                 foreach ($collectedData['images'] as $imagevalue) {
                    $extension = $imagevalue->getClientOriginalExtension();
                    $imageName = time() . '_' . uniqid() . '.' . $extension;
                    $imagevalue->move($upload_path, $imageName);
                    $multipleImageData[] = [
                        'product_id' => $id,
                        'image' => $db_path_prefix . $imageName,
                        'type' => 'image',
                    ];
                }
			
            if (count($multipleImageData) > 0) ProductImage::insert($multipleImageData);
            }
			
			 if (isset($collectedData['product_images'])) {
				 
					$multipleVideoData = [];
                    foreach ($collectedData['product_images'] as $imagevalue) {
                        $extension = $imagevalue->getClientOriginalExtension();
                        $imageName = time() . '_' . uniqid() . '.' . $extension;
                        $imagevalue->move($upload_path, $imageName);
                        $multipleVideoData[] = [
                            'product_id' => $id,
                            'image' => $db_path_prefix . $imageName,
                            'type' => 'video',
                        ];
                    }
				
				if (count($multipleVideoData) > 0) ProductImage::insert($multipleVideoData);
			 }
			
            $multipleFeatureData = [];
		if (isset($collectedData['featurename']) || isset($collectedData['icon'])) {
			if (isset($collectedData['featurename'])) {
				foreach ($collectedData['featurename'] as $nameKey => $nameValue) {

					 if (is_null($collectedData['featurename'][$nameKey])) {

						  continue;
					 }
					$multipleFeatureData[] = [
						'product_id' => $newEntry->id,
						'name' => $nameValue,
					];
				}
			}
			//dd($multipleFeatureData);
			 if (isset($collectedData['icon'])) {
                foreach ($collectedData['icon'] as $key => $iconValue) {
                    if (is_null($iconValue)) continue;
                    $extension = $iconValue->getClientOriginalExtension();
                    $imageName = time() . '_' . uniqid() . '.' . $extension;
                    $iconValue->move($upload_path, $imageName);
                    $multipleFeatureData[$key]['icon'] = $db_path_prefix . $imageName;
                }
            }

            ProductFeature::insert($multipleFeatureData);
        }

        $multipleSpecificationData = [];
		 if (isset($collectedData['specname']) || isset($collectedData['specicon'])|| isset($collectedData['specdescription'])) {
			if (isset($collectedData['specname'])) {
				foreach ($collectedData['specname'] as $nameKey => $nameValue) {
					 if (is_null($collectedData['specname'][$nameKey])) {
						  continue;
					 }
					$multipleSpecificationData[] = [
						'product_id' => $newEntry->id,
						'name' => $nameValue,
					];
				}
			}
			 if (isset($collectedData['specdescription'])) {
				foreach ($collectedData['specdescription'] as $descriptionKey => $descriptionValue) {
					if (is_null($collectedData['specdescription'][$descriptionKey])) {
						 continue;
					}
				   $multipleSpecificationData[$descriptionKey]['description'] = $descriptionValue;
				}
			 }
			 if(isset($collectedData['specicon'])){
				foreach ($collectedData['specicon'] as $iconKey => $iconValue) {
					 if (is_null($collectedData['specicon'][$iconKey])) {
						  continue;
					 }
					$upload_path = "public/uploads/product/";
					$image = $iconValue;
					$imageName = time() . "." . $image->getClientOriginalName();
					$image->move($upload_path, $imageName);
					$uploadedImage = $imageName;
					$multipleSpecificationData[$iconKey]['icon'] = $upload_path . $uploadedImage;

				}
			 }

            // dd($multipleSpecificationData);

            if (count($multipleSpecificationData) > 0) ProductSpecification::insert($multipleSpecificationData); 
        }
			
				//product video link
			 if (isset($collectedData['product_video_link'])) {
				 
					$multipleVideoLinkData = [];
                    foreach ($collectedData['product_video_link'] as $videolinkkey => $videolinkvalue) {
                     if (is_null($collectedData['product_video_link'][$videolinkkey])) {
                      continue;
                 }
                $multipleVideoLinkData[] = [
                    'product_id' => $newEntry->id,
                    'link' => $videolinkvalue,
                ];
				}
				
				if (count($multipleVideoLinkData) > 0) ProductReviewVideo::insert($multipleVideoLinkData);
			 }
			
			//product feature image 
			 if (!empty($collectedData['product_feature_image'])) {
				 //dd('hi');
					$multipleFeatureImageLinkData = [];
                    foreach ($collectedData['product_feature_image'] as $imagelinkkey => $imagelinkvalue) {
                     if (is_null($collectedData['product_feature_image'][$imagelinkkey])) {
                      continue;
                 }
                $multipleFeatureImageLinkData[] = [
                    'product_id' => $newEntry->id,
                    'image' => $imagelinkvalue,
                ];
				}
				
				if (count($multipleFeatureImageLinkData) > 0) ProductFeatureImage::insert($multipleFeatureImageLinkData);
			 }
			
			
			
		 if (!empty($collectedData['review_title']) || !empty($collectedData['review_content'])|| !empty($collectedData['review_created_by'])) {
			 
			$multipleReviewData = [];
			 if(!empty($collectedData['review_title'])){
				 
				foreach ($collectedData['review_title'] as $nameKey => $nameValue) {
					
					 if (is_null($collectedData['review_title'][$nameKey])) {
						  continue;
					 }
					$multipleReviewData[] = [
						'product_id' => $newEntry->id,
						'title' => $nameValue,
					];
					
				}
			 }
			 if(!empty($collectedData['review_content'])){
				foreach ($collectedData['review_content'] as $descriptionKey => $descriptionValue) {
					if (is_null($collectedData['review_content'][$descriptionKey])) {
						 continue;
					}
				   $multipleReviewData[$descriptionKey]['description'] = $descriptionValue;
					
				}
			 }
			 if(!empty($collectedData['review_created_by'])){
				 
				foreach ($collectedData['review_created_by'] as $iconKey => $iconValue) {
					
					 if (is_null($collectedData['review_created_by'][$iconKey])) {
						  continue;
					 }
					$multipleReviewData[$iconKey]['created_by'] = $iconValue;
					
				}
			 }
           //dd($multipleReviewData);
            if (count($multipleReviewData)>0) {
				
				ProductReview::insert($multipleReviewData); 
				
			}
			
			
          }

            DB::commit();
			//dd($newEntry);
            return $newEntry;
        } catch (\Throwable $th) {
            // throw $th;
            DB::rollback();
        }
    }

   public function update($id, array $newDetails)
    {
        DB::beginTransaction();

        try {
            $updatedEntry = Product::findOrFail($id);
            $styleNoSlug = Str::slug($updatedEntry->style_no, '-');

            $upload_path = public_path('uploads/product/');
            $db_path_prefix = 'uploads/product/'; // save without "public/"

            $collectedData = collect($newDetails);

            if (!empty($collectedData['cat_id'])) $updatedEntry->cat_id = $collectedData['cat_id'];
            $updatedEntry->name = $collectedData['product_name'] ?? '';
            $updatedEntry->sub_heading = $collectedData['sub_heading'] ?? '';
            $updatedEntry->color_id = $collectedData['color_id'] ?? '';
            $updatedEntry->short_desc = $collectedData['short_desc'] ?? '';
            $updatedEntry->desc = $collectedData['desc'] ?? '';
            $updatedEntry->short_content = $collectedData['short_content'] ?? '';
            $updatedEntry->long_content = $collectedData['long_content'] ?? '';
            $updatedEntry->price = $collectedData['price'] ?? '';
            $updatedEntry->offer_price = $collectedData['offer_price'] ?? '';

            // Slug generate
            if ($updatedEntry->name != $collectedData['product_name']) {
                $slug = Str::slug($collectedData['product_name'], '-');
                $slugExistCount = Product::where('slug', $slug)->count();
                if ($slugExistCount > 0) $slug = $slug . '-' . ($slugExistCount + 1);
                $updatedEntry->slug = $slug;
            }

            $updatedEntry->meta_title = $collectedData['meta_title'] ?? '';
            $updatedEntry->meta_desc = $collectedData['meta_desc'] ?? '';
            $updatedEntry->meta_keyword = $collectedData['meta_keyword'] ?? '';
            $updatedEntry->pack = $collectedData['pack'] ?? '';

            /* ======================= PRODUCT IMAGE ======================= */
            if (isset($collectedData['product_image'])) {
                // delete old image
                if (!empty($updatedEntry->image) && file_exists(public_path($updatedEntry->image))) {
                    unlink(public_path($updatedEntry->image));
                }
                // upload new
                $image = $collectedData['product_image'];
                $extension = $image->getClientOriginalExtension();
                $imageName = time() . '_' . uniqid() . '.' . $extension;
                $image->move($upload_path, $imageName);
                $updatedEntry->image = $db_path_prefix . $imageName;
            }
            // elseif (!empty($updatedEntry->image) && file_exists(public_path($updatedEntry->image))) {
            //     $extension = pathinfo($updatedEntry->image, PATHINFO_EXTENSION);
            //     $newName = $db_path_prefix . time() . '_' . uniqid() . '.' . $extension;
            //     rename($updatedEntry->image, $newName);
            //     $updatedEntry->image = $newName;
            // }

            /* ======================= BANNER IMAGE ======================= */
            if (isset($collectedData['banner_image'])) {
                if (!empty($updatedEntry->banner_image) && file_exists(public_path($updatedEntry->banner_image))) {
                    unlink(public_path($updatedEntry->banner_image));
                }
                $image = $collectedData['banner_image'];
                $extension = $image->getClientOriginalExtension();
                $imageName = time() . '_' . uniqid() . '.' . $extension;
                $image->move($upload_path, $imageName);
                $updatedEntry->banner_image = $db_path_prefix . $imageName;
            }
            // elseif (!empty($updatedEntry->banner_image) && file_exists(public_path($updatedEntry->banner_image))) {
            //     $extension = pathinfo($updatedEntry->banner_image, PATHINFO_EXTENSION);
            //     $newName = $db_path_prefix . time() . '_' . uniqid() . '.' . $extension;
            //     rename($updatedEntry->banner_image, $newName);
            //     $updatedEntry->banner_image = $newName;
            // }

            /* ======================= THUMBNAIL IMAGE ======================= */
            if (isset($collectedData['thumbnail_image'])) {
                if (!empty($updatedEntry->thumbnail_image) && file_exists(public_path($updatedEntry->thumbnail_image))) {
                    unlink(public_path($updatedEntry->thumbnail_image));
                }
                $image = $collectedData['thumbnail_image'];
                $extension = $image->getClientOriginalExtension();
                $imageName = time() . '_' . uniqid() . '.' . $extension;
                $image->move($upload_path, $imageName);
                $updatedEntry->thumbnail_image = $db_path_prefix . $imageName;
            } 
            // elseif (!empty($updatedEntry->thumbnail_image) && file_exists(public_path($updatedEntry->thumbnail_image))) {
            //     $extension = pathinfo($updatedEntry->thumbnail_image, PATHINFO_EXTENSION);
            //     $newName = $db_path_prefix . time() . '_' . uniqid() . '.' . $extension;
            //     rename($updatedEntry->thumbnail_image, $newName);
            //     $updatedEntry->thumbnail_image = $newName;
            // }
            /* ======================= SAVE PRODUCT ======================= */
            $updatedEntry->save();

            /* ======================= MULTIPLE IMAGES ======================= */
            if (isset($newDetails['images'])) {
                $multipleImageData = [];
                foreach ($newDetails['images'] as $imagevalue) {
                    $extension = $imagevalue->getClientOriginalExtension();
                    $imageName = time() . '_' . uniqid() . '.' . $extension;
                    $imagevalue->move($upload_path, $imageName);
                    $multipleImageData[] = [
                        'product_id' => $id,
                        'image' => $db_path_prefix . $imageName,
                        'type' => 'image'
                    ];
                }
                if (count($multipleImageData) > 0) {
                    ProductImage::insert($multipleImageData);
                }
            }

            /* ======================= MULTIPLE VIDEOS ======================= */
            if (isset($newDetails['video'])) {
                $multipleVideoData = [];
                foreach ($newDetails['video'] as $videovalue) {
                    $extension = $videovalue->getClientOriginalExtension();
                    $videoName = time() . '_' . uniqid() . '.' . $extension;
                    $videovalue->move($upload_path, $videoName);
                    $multipleVideoData[] = [
                        'product_id' => $id,
                        'image' => $db_path_prefix . $videoName,
                        'type' => 'video'
                    ];
                }
                if (count($multipleVideoData) > 0) {
                    ProductImage::insert($multipleVideoData);
                }
            }

            DB::commit();
            return $updatedEntry;
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error updating product: ' . $e->getMessage());
            return back()->withInput()->with('error', 'Error updating product.');
        }
    }

    public function toggle($id)
    {
        $updatedEntry = Product::findOrFail($id);

        $status = ($updatedEntry->status == 1) ? 0 : 1;
        $updatedEntry->status = $status;
        $updatedEntry->save();

        return $updatedEntry;
    }

    public function sale($id)
    {
        $saleExist = Sale::where('product_id', $id)->first();

        if ($saleExist) {
            $resp = Sale::where(['product_id' => $id])->delete();
            return $resp;
        } else {
            $resp = Sale::create(['product_id' => $id]);
            return $resp;
        }
    }

    public function delete($id)
    {
        Product::destroy($id);
    }

    public function deleteSingleImage($id)
    {
        ProductImage::destroy($id);
    }

    public function wishlistCheck($productId)
    {
        $ip = $_SERVER['REMOTE_ADDR'];
        if(Auth::guard('web')->check()){
        $data = Wishlist::where('product_id', $productId)->where('user_id', Auth::guard('web')->user()->id)->first();
        }else{
            $data = '';
        }
        return $data;
    }

    public function primaryColorSizes($productId)
    {
        $primaryColor = ProductColorSize::select('color')->where('product_id', $productId)->groupBy('color')->orderBy('position')->first();

        // dd($primaryColor->color);

        if ($primaryColor) {
            $sizes = ProductColorSize::where('product_id', $productId)->where('color', $primaryColor->color)->orderBy('size')->get();
            // dd($sizes);
            return $sizes;
        }
        return false;
    }
}
