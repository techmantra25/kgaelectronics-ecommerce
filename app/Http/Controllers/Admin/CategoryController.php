<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\CategoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
// use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\CategoryBanner;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    // private CategoryInterface $categoryRepository;

    public function __construct(CategoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index(Request $request)
    {
        if (!empty($request->term)) {
            $data = $this->categoryRepository->getSearchCategories($request->term);
        } /* elseif (!empty($request->status)) {
            $data = $this->categoryRepository->getAllCategories($request->status);
        } */ else {
            $data = $this->categoryRepository->getAllCategories();
        }

        return view('admin.category.index', compact('data'));
    }

    public function store(Request $request)
    {
		

        $validator = Validator::make($request->all(),[
            "name" => "required|string|max:255",
            "description" => "nullable|string"
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
        $params = $request->except('_token');
		
        $categoryStore = $this->categoryRepository->createCategory($params);
		
        if ($categoryStore) {
            return redirect()->route('admin.category.index');
        } else {
            return redirect()->route('admin.category.create')->withInput($request->all());
        }
	  }
    }

    public function show(Request $request, $id)
    {
        $data = $this->categoryRepository->getCategoryById($id);
		 $banner = CategoryBanner::where('cat_id',$id)->get();
        return view('admin.category.detail', compact('data','banner'));
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());

        $validator = Validator::make($request->all(),[
            "name" => "required|string|max:255",
            //"parent" => "required|string|max:255",
            "description" => "nullable|string",
            "icon_path" => "nullable",
            "sketch_icon" => "nullable",
            "image_path" => "nullable",
            "banner_image" => "nullable"
        ]);

        $params = $request->except('_token');

        $categoryStore = $this->categoryRepository->updateCategory($id, $params);

        if ($categoryStore) {
            return redirect()->route('admin.category.index');
        } else {
            return redirect()->route('admin.category.create')->withInput($request->all());
        }
    }

    public function status(Request $request, $id)
    {
        $categoryStat = $this->categoryRepository->toggleStatus($id);

        if ($categoryStat) {
            return redirect()->route('admin.category.index');
        } else {
            return redirect()->route('admin.category.create')->withInput($request->all());
        }
    }

    public function destroy($categoryId)
    {
        $this->categoryRepository->deleteCategory($categoryId);

        return redirect()->route('admin.category.index');
    }

    public function bulkDestroy(Request $request)
    {
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
                    Category::where('id', $delete_id)->delete();
                }
    
                return redirect()->route('admin.category.index')->with('success', 'Selected items deleted');
            } else {
                return redirect()->route('admin.category.index')->with('failure', 'Please select an action')->withInput($request->all());
            }
        } else {
            return redirect()->route('admin.category.index')->with('failure', $validator->errors()->first())->withInput($request->all());
        }

    }
	
	
	public function bannerAdd(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'cat_id' => 'required',
            'bannername' => 'required',
        ]);

        if (!$validator->fails()) {
			
                $upload_path = "public/uploads/category/";
                $productImage = new CategoryBanner();
                $productImage->cat_id = $request->cat_id;
                $productImage->name = $request->bannername;
                $productImage->description = $request->bannerdesc;
			    $productImage->link = $request->bannerlink;
                if (isset($request['bannerimage'])) {
					
                    $image = $request->bannerimage;
                    $imageName = time() . "." . mt_rand() . "." . $image->getClientOriginalName();
                    $image->move($upload_path, $imageName);
                    $uploadedImage = $imageName;
                    $productImage->icon = $upload_path . $uploadedImage;
					
                }
			   
                $productImage->save();
			
            if($productImage){
				
                return redirect()->back()->with('success', 'Banner added successfully');
            } else {
                return redirect()->back()->with('failure', 'Something wrong.')->withInput($request->all());
            }
        } else {
            return redirect()->back()->with('failure', $validator->errors()->first())->withInput($request->all());
        }

    }
	

    

    public function bannerEdit(Request $request,$id)
    {
		//dd($request->all());
        $upload_path = "public/uploads/category/";
                $productImage =CategoryBanner::findOrfail($id);
                $productImage->cat_id = $request->cat_id;
                $productImage->name = $request->bannername;
                $productImage->description = $request->bannerdesc;
		        $productImage->link = $request->bannerlink;
                if (isset($request->bannerimage)) {
                    $image = $request->bannerimage;
                    $imageName = time() . "." . mt_rand() . "." . $image->getClientOriginalName();
                    $image->move($upload_path, $imageName);
                    $uploadedImage = $imageName;
                    $productImage->icon = $upload_path . $uploadedImage;
                }
                $productImage->save();
        return redirect()->back()->with('success', 'Banner updated');
    }
	
	public function bannerDestroy(Request $request, $id)
    {
        // dd($id);
        CategoryBanner::destroy($id);
        return redirect()->back()->with('success', 'Banner deleted successfully');
    }
	

}