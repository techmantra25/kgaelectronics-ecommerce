<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductVideo;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
class VideoController extends Controller
{
    public function index(Request $request) 
    {
        $data = ProductVideo::latest('id')->get();
        return view('admin.product-video.index', compact('data'));
    }

    public function store(Request $request) 
    {
        $validator = Validator::make($request->all(),[
            "image" => "required|mimes:jpg,jpeg,png,svg,gif,mp4,mp3|max:10000000",
			 "title" => "required",
			 "vieo" => "required",
        ]);
		if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
        $params = $request->except('_token');
        $upload_path = "public/uploads/productvideo/";
        $banner = new ProductVideo;
		$banner->title=$request->title;
        // image
        $image = $params['image'];
        $imageName = time().".".mt_rand().".".$image->getClientOriginalName();
        $image->move($upload_path, $imageName);
        $uploadedImage = $imageName;
        $banner->file_path = $upload_path.$uploadedImage;

        // file type
        $extension = $image->getClientOriginalExtension();
        $imageTypes = array('jpg', 'jpeg', 'png', 'svg', 'gif');
		// video
        $video = $params['video'];
        $imageName = time().".".mt_rand().".".$video->getClientOriginalName();
        $video->move($upload_path, $imageName);
        $uploadedImage = $imageName;
        $banner->video = $upload_path.$uploadedImage;
        /*if (in_array($extension, $imageTypes)) {
            $banner->type = 'img';
        } else {
            $banner->type = 'video';
        }*/

        // position
        //$latestPosition = PromotionalImage::select('position')->orderBy('position', 'desc')->first();
        
        /*if(!empty($latestPosition)) {
        	$banner->position = $latestPosition->position + 1;
        } else {
        	$banner->position = 1;
        }*/

        $banner->save();


        if ($banner) {
            return redirect()->route('admin.product-video.index');
        } else {
            return redirect()->route('admin.product-video.create')->withInput($request->all());
        }
		}
    }

    public function show(Request $request, $id)
    {
        $data = ProductVideo::findOrFail($id);
        return view('admin.product-video.detail', compact('data'));
    }

    public function update(Request $request, $id)
    {
		
       $validator = Validator::make($request->all(),[
            "image" => "nullable|mimes:jpg,jpeg,png,svg,gif,mp4,mp3|max:10000000",
        ]);
		if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
        $params = $request->except('_token');
        $upload_path = "public/uploads/productvideo/";
        $banner = ProductVideo::findOrFail($id);
		$banner->title=$request->title ?? '';
        if (isset($request['image'])) {
            // image
            $image = $request['image'];
            $imageName = time().".".mt_rand().".".$image->getClientOriginalName();
            $image->move($upload_path, $imageName);
            $uploadedImage = $imageName;
            $banner->file_path = $upload_path.$uploadedImage;
		}
            // file type
           // $extension = $image->getClientOriginalExtension();
           // $imageTypes = array('jpg', 'jpeg', 'png', 'svg', 'gif');
		// video
			 if (isset($request['video'])) {
				$image = $request['video'];
				$imageName = time().".".mt_rand().".".$image->getClientOriginalName();
				$image->move($upload_path, $imageName);
				$uploadedImage = $imageName;
				$banner->video = $upload_path.$uploadedImage;
			 }
          /*  if (in_array($extension, $imageTypes)) {
                $banner->type = 'img';
            } else {
                $banner->type = 'video';
            }*/
        

        $banner->save();
        if ($banner) {
            return redirect()->route('admin.product-video.index');
        } else {
            return redirect()->route('admin.product-video.create')->withInput($request->all());
        }
		}
    }

    public function status(Request $request, $id)
    {
        $updatedEntry = ProductVideo::findOrFail($id);

        $status = ( $updatedEntry->status == 1 ) ? 0 : 1;
        $updatedEntry->status = $status;
        $updatedEntry->save();


        if ($updatedEntry) {
            return redirect()->route('admin.product-video.index');
        } else {
            return redirect()->route('admin.product-video.create')->withInput($request->all());
        }
    }

    public function destroy(Request $request, $id) 
    {
        $image=ProductVideo::where('id',$id)->delete();

        return redirect()->route('admin.product-video.index');
    }
}
