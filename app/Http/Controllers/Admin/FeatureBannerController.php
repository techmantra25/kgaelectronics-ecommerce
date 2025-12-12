<?php

namespace App\Http\Controllers\Admin;

use App\Interfaces\BannerInterface;
use App\Models\FeatureBanner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
class FeatureBannerController extends Controller
{
    public function __construct(BannerInterface $bannerInterface) 
    {
        $this->bannerRepository = $bannerInterface;
    }

    public function index(Request $request) 
    {
        $data = FeatureBanner::orderBy('position')->get();
        return view('admin.feature-banner.index', compact('data'));
    }

    public function store(Request $request) 
    {
        $validator = Validator::make($request->all(),[
            "image" => "required|mimes:jpg,jpeg,png,svg,gif|max:10000000",
        ]);
		if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
        $params = $request->except('_token');
        $upload_path = "public/uploads/feturebanner/";
        $banner = new FeatureBanner;

        // image
        $image = $params['image'];
        $imageName = time().".".mt_rand().".".$image->getClientOriginalName();
        $image->move($upload_path, $imageName);
        $uploadedImage = $imageName;
        $banner->file_path = $upload_path.$uploadedImage;

        // file type
        $extension = $image->getClientOriginalExtension();
        $imageTypes = array('jpg', 'jpeg', 'png', 'svg', 'gif');

        if (in_array($extension, $imageTypes)) {
            $banner->type = 'img';
        } else {
            $banner->type = 'video';
        }

        // position
        $latestPosition = FeatureBanner::select('position')->orderBy('position', 'desc')->first();
        
        if(!empty($latestPosition)) {
        	$banner->position = $latestPosition->position + 1;
        } else {
        	$banner->position = 1;
        }

        $banner->save();


        if ($banner) {
            return redirect()->route('admin.feature-banner.index');
        } else {
            return redirect()->route('admin.feature-banner.create')->withInput($request->all());
        }
		}
    }

    public function show(Request $request, $id)
    {
        $data = FeatureBanner::findOrFail($id);
        return view('admin.feature-banner.detail', compact('data'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(),[
            "image" => "nullable|mimes:jpg,jpeg,png,svg,gif|max:10000000",
        ]);
		if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
        $params = $request->except('_token');
        $upload_path = "public/uploads/featurebanner/";
        $banner = FeatureBanner::findOrFail($id);
        if (isset($params['image'])) {
            // image
            $image = $params['image'];
            $imageName = time().".".mt_rand().".".$image->getClientOriginalName();
            $image->move($upload_path, $imageName);
            $uploadedImage = $imageName;
            $banner->file_path = $upload_path.$uploadedImage;

            // file type
            $extension = $image->getClientOriginalExtension();
            $imageTypes = array('jpg', 'jpeg', 'png', 'svg', 'gif');

            if (in_array($extension, $imageTypes)) {
                $banner->type = 'img';
            } else {
                $banner->type = 'video';
            }
        }

        $banner->save();
        if ($banner) {
            return redirect()->route('admin.feature-banner.index');
        } else {
            return redirect()->route('admin.feature-banner.create')->withInput($request->all());
        }
		}
    }

    public function status(Request $request, $id)
    {
        $updatedEntry = FeatureBanner::findOrFail($id);

        $status = ( $updatedEntry->status == 1 ) ? 0 : 1;
        $updatedEntry->status = $status;
        $updatedEntry->save();


        if ($updatedEntry) {
            return redirect()->route('admin.feature-banner.index');
        } else {
            return redirect()->route('admin.feature-banner.create')->withInput($request->all());
        }
    }

    public function destroy(Request $request, $id) 
    {
        $banner=FeatureBanner::where('id',$id)->delete();
        return redirect()->route('admin.feature-banner.index');
    }
}
