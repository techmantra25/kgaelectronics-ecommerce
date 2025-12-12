<?php

namespace App\Repositories;

use App\Interfaces\CategoryInterface;
use App\Models\Product;
use App\Models\Category;
use App\Models\Size;
use App\Models\Color;
use App\Traits\UploadAble;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use DB;
use Illuminate\Database\Eloquent\Model;

class CategoryRepository implements CategoryInterface
{
    use UploadAble;

    public function getAllCategories()
    {
        return Category::orderBy('position', 'asc')->get();
    }

    public function getSearchCategories(string $term)
    {
        return Category::where([['name', 'LIKE', '%' . $term . '%']])->get();
    }

    public function getAllSizes()
    {
        return Size::all();
    }

    public function getAllColors()
    {
        return Color::all();
    }

    public function getCategoryById($categoryId)
    {
        return Category::findOrFail($categoryId);
    }

    public function getCategoryBySlug($slug)
    {
        return Category::where('slug', $slug)->with('ProductDetails')->first();
    }

    public function deleteCategory($categoryId)
    {

        Category::destroy($categoryId);
    }

    public function createCategory(array $categoryDetails)
    {
        $upload_path = "uploads/category/";
        $collection = collect($categoryDetails);

        $category = new Category;
        $category->name = $collection['name'];
        // $category->parent = $collection['parent'];
        $category->description = $collection['description'];

        // generate slug
        $slug = Str::slug($collection['name'], '-');
        $slugExistCount = Category::where('slug', $slug)->count();
        if ($slugExistCount > 0) $slug = $slug . '-' . ($slugExistCount + 1);
        $category->slug = $slug;
        
        // icon image
        if (isset($collection['icon_path'])) {
            $image = $collection['icon_path'];
            $extension = $image->getClientOriginalExtension();
            $imageName = time() . '_icon.' . $extension;
            $image->move($upload_path, $imageName);
            $category->icon_path = $upload_path . $imageName;
        }

        // sketch icon
        if (isset($collection['sketch_icon'])) {
            $image = $collection['sketch_icon'];
            $extension = $image->getClientOriginalExtension();
            $imageName = time() . '_sketch_icon.' . $extension;
            $image->move($upload_path, $imageName);
            $category->sketch_icon = $upload_path . $imageName;
        }

        // thumb image
        if (isset($collection['image_path'])) {
            $image = $collection['image_path'];
            $extension = $image->getClientOriginalExtension();
            $imageName = time() . '_image_path.' . $extension;
            $image->move($upload_path, $imageName);
            $category->image_path = $upload_path . $imageName;
        }

        // banner image
        if (isset($collection['banner_image'])) {
            $bannerImage = $collection['banner_image'];
            $extension = $bannerImage->getClientOriginalExtension();
            $imageName = time() . 'banner_image.' . $extension;
            $bannerImage->move($upload_path, $bannerImageName);
            $category->banner_image = $upload_path . $bannerImageName;
        }
		$category->save();

		$multipleSpecificationData = [];
		 if (isset($collection['bannername']) || isset($collection['icon'])|| isset($collection['bannerdesc'])|| isset($collection['bannerlink'])){
			if (isset($collection['bannername'])) {
				foreach ($collection['bannername'] as $nameKey => $nameValue) {

					 if (is_null($collection['bannername'][$nameKey])) {
						  continue;
					 }

					$multipleSpecificationData[] = [
						'cat_id' => $category->id,
						'name' => $nameValue,
					];

				}
			}
			if (isset($collection['bannerdesc'])) {
				foreach ($collection['bannerdesc'] as $descriptionKey => $descriptionValue) {

					if (is_null($collection['bannerdesc'][$descriptionKey])) {

						 continue;

					}
				   $multipleSpecificationData[$descriptionKey]['description'] = $descriptionValue;

				}
			}
			 if (isset($collection['bannerlink'])) {
				 foreach ($collection['bannerlink'] as $linkKey => $linkValue) {
					if (is_null($collection['bannerlink'][$linkKey])) {

						 continue;

					}

				   $multipleSpecificationData[$linkKey]['link'] = $linkValue;

				}
			 }
			 if (isset($collection['icon'])) {
            foreach ($collection['icon'] as $iconKey => $iconValue) {
				
				 if (is_null($collection['icon'][$iconKey])) {
                      continue;
                }
                $upload_path = "public/uploads/category/";
                $image = $iconValue;
                $imageName = time() . "." . $image->getClientOriginalName();
                $image->move($upload_path, $imageName);
                $uploadedImage = $imageName;
                $multipleSpecificationData[$iconKey]['icon'] = $upload_path . $uploadedImage;
				
            }
			 }

              

            if (count($multipleSpecificationData) > 0)
				
				DB::table('category_banners')->insert($multipleSpecificationData);
			
        }
        

        return $category;
    }

    public function updateCategory($categoryId, array $newDetails)
    {
        $upload_path = public_path('uploads/category/');
        $db_path_prefix = 'uploads/category/'; // save without "public/"
        $category = Category::findOrFail($categoryId);
        $collection = collect($newDetails);

        $category->name = $collection['name'];
        // $category->parent = $collection['parent'];
        $category->description = $collection['description'];

        // generate slug
        $slug = Str::slug($collection['name'], '-');
        $slugExistCount = Category::where('slug', $slug)
            ->where('id', '!=', $categoryId)
            ->count();
        if ($slugExistCount > 0) {
            $slug = $slug . '-' . ($slugExistCount + 1);
        }
        $category->slug = $slug;

        // ICON IMAGE
        if (isset($newDetails['icon_path'])) {
            // new file uploaded
            $image = $collection['icon_path'];
            $extension = $image->getClientOriginalExtension();
            $imageName = time() . '_' . uniqid() . '.' . $extension;
            $image->move($upload_path, $imageName);
            $category->icon_path = $db_path_prefix . $imageName;
        } elseif (!empty($category->icon_path) && file_exists(public_path($category->icon_path))) {
            // rename existing file
            $extension = pathinfo($category->icon_path, PATHINFO_EXTENSION);
            $newName = $db_path_prefix . time() . '_' . uniqid() . '.' . $extension;
            rename($category->icon_path, $newName);
            $category->icon_path = $newName;
        }

        // SKETCH ICON
        if (isset($newDetails['sketch_icon'])) {
            $image = $collection['sketch_icon'];
            $extension = $image->getClientOriginalExtension();
            $imageName = time() . '_' . uniqid() . '.' . $extension;
            $image->move($upload_path, $imageName);
            $category->sketch_icon = $db_path_prefix . $imageName;
        } elseif (!empty($category->sketch_icon) && file_exists(public_path($category->sketch_icon))) {
            $extension = pathinfo($category->sketch_icon, PATHINFO_EXTENSION);
            $newName = $db_path_prefix . time() . '_' . uniqid() . '.' . $extension;
            rename($category->sketch_icon, $newName);
            $category->sketch_icon = $newName;
        }

        // THUMB IMAGE
        if (isset($newDetails['image_path'])) {
            $image = $collection['image_path'];
            $extension = $image->getClientOriginalExtension();
            $imageName = time() . '_' . uniqid() . '.' . $extension;
            $image->move($upload_path, $imageName);
            $category->image_path = $db_path_prefix . $imageName;
        } elseif (!empty($category->image_path) && file_exists(public_path($category->image_path))) {
            $extension = pathinfo($category->image_path, PATHINFO_EXTENSION);
            $newName = $db_path_prefix . time() . '_' . uniqid() . '.' . $extension;
            rename($category->image_path, $newName);
            $category->image_path = $newName;
        }

        // BANNER IMAGE
        if (isset($newDetails['banner_image'])) {
            $bannerImage = $collection['banner_image'];
            $extension = $bannerImage->getClientOriginalExtension();
            $bannerImageName = time() . '_' . uniqid() . '.' . $extension;
            $bannerImage->move($upload_path, $bannerImageName);
            $category->banner_image = $db_path_prefix . $bannerImageName;
        } elseif (!empty($category->banner_image) && file_exists(public_path($category->banner_image))) {
            $extension = pathinfo($category->banner_image, PATHINFO_EXTENSION);
            $newName = $db_path_prefix . time() . '_' . uniqid() . '.' . $extension;
            rename($category->banner_image, $newName);
            $category->banner_image = $newName;
        }
        $category->save();

        return $category;
    }

    public function toggleStatus($id)
    {
        $category = Category::findOrFail($id);

        $status = ($category->status == 1) ? 0 : 1;
        $category->status = $status;
        $category->save();

        return $category;
    }

    public function productsByCategory(int $categoryId, array $filter = null)
    {
        try {
            $productsQuery = Product::where('cat_id', $categoryId)->where('status', 1);

            // collection handling
            if (isset($filter['collection'])) {
                if (count($filter['collection']) == 1) {
                    $products = $productsQuery->where('collection_id', $filter['collection'][0]);
                } else {

                }
            }

            // order handling
            if (isset($filter['orderBy'])) {
                $orderBy = "id";
                $order = "desc";

                if ($filter['orderBy'] == "new_arr") {
                    $orderBy = "id";
                    $order = "desc";
                } elseif ($filter['orderBy'] == "mst_viw") {
                    $orderBy = "view_count";
                    $order = "desc";
                } elseif ($filter['orderBy'] == "prc_low") {
                    $orderBy = "offer_price";
                    $order = "asc";
                } elseif ($filter['orderBy'] == "prc_hig") {
                    $orderBy = "offer_price";
                    $order = "desc";
                }

                $products = $productsQuery->orderBy($orderBy, $order);
            }

            $products = $productsQuery->with('colorSize')->get();
            
            $response = [];
            foreach ($products as $productKey => $productValue) {
                // price check
                if (count($productValue->colorSize) > 0) {
                    $varArray = [];
                    foreach ($productValue->colorSize as $productVariationKey => $productVariationValue) {
                        $varArray[] = $productVariationValue->offer_price;
                    }
                    $bigger = $varArray[0];
                    for ($i = 1; $i < count($varArray); $i++) {
                        if ($bigger < $varArray[$i]) {
                            $bigger = $varArray[$i];
                        }
                    }

                    $smaller = $varArray[0];
                    for ($i = 1; $i < count($varArray); $i++) {
                        if ($smaller > $varArray[$i]) {
                            $smaller = $varArray[$i];
                        }
                    }

                    $displayPrice = '&#8377;'.$smaller . ' - &#8377;' . $bigger;

                    if ($smaller == $bigger) $displayPrice = '&#8377;'.$smaller;
                    $show_price = $displayPrice;
                } else {
                    $show_price = '&#8377;'.$productValue['offer_price'];
                }

                // color check
                if (count($productValue->colorSize) > 0) {
                    $uniqueColors = [];

                    foreach ($productValue->colorSize as $variantKey => $variantValue) {
                        if (in_array_r($variantValue->colorDetails->code, $uniqueColors)) continue;

                        $uniqueColors[] = [
                            'id' => $variantValue->colorDetails->id,
                            'code' => $variantValue->colorDetails->code,
                            'name' => $variantValue->colorDetails->name,
                        ];
                    }

                    $colorVar = '<ul class="product__color">';
                    // echo count($uniqueColors);
                    foreach($uniqueColors as $colorCodeKey => $colorCode) {
                        if ($colorCodeKey == 5) break;
                        if ($colorCode['id'] == 61) {
                            $colorVar .= '<li style="background: -webkit-linear-gradient(left,  rgba(219,2,2,1) 0%,rgba(219,2,2,1) 9%,rgba(219,2,2,1) 10%,rgba(254,191,1,1) 10%,rgba(254,191,1,1) 10%,rgba(254,191,1,1) 20%,rgba(1,52,170,1) 20%,rgba(1,52,170,1) 20%,rgba(1,52,170,1) 30%,rgba(15,0,13,1) 30%,rgba(15,0,13,1) 30%,rgba(15,0,13,1) 40%,rgba(239,77,2,1) 40%,rgba(239,77,2,1) 40%,rgba(239,77,2,1) 50%,rgba(254,191,1,1) 50%,rgba(137,137,137,1) 50%,rgba(137,137,137,1) 60%,rgba(254,191,1,1) 60%,rgba(254,191,1,1) 60%,rgba(254,191,1,1) 70%,rgba(189,232,2,1) 70%,rgba(189,232,2,1) 80%,rgba(209,2,160,1) 80%,rgba(209,2,160,1) 90%,rgba(48,45,0,1) 90%); " class="color-holder" data-bs-toggle="tooltip" data-bs-placement="top" title="Assorted"></li>';
                        } else {
                            $colorVar .= '<li onclick="sizeCheck('.$productValue->id.', '.$colorCode['id'].')" style="background-color: '.$colorCode['code'].'" class="color-holder" data-bs-toggle="tooltip" data-bs-placement="top" title="'.$colorCode['name'].'"></li>';
                        }
                    }
                    if (count($uniqueColors) > 5) $colorVar .= '<li>+ more</li>';
                    $colorVar .= '</ul>';

                    $colorVariation = $colorVar;
                } else {
                    $colorVariation = '';
                }

                $response[] = [
                    'name' => $productValue['name'],
                    'slug' => $productValue['slug'],
                    'image' => $productValue['image'],
					'thumbnail_image' => $productValue['thumbnail_image'],
					'price' => $productValue['price'],
					 'short_desc' => $productValue['short_desc'],
                    'styleNo' => $productValue['style_no'],
                    'displayPrice' => $show_price,
                    'colorVariation' => $colorVariation
                ];
            }

            return $response;
        } catch (\Throwable $th) {
            // throw $th;
            return $th;
        }
    }
}
