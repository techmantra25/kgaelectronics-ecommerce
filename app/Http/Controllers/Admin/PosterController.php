<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Poster;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;
class PosterController extends Controller
{
    public function index(Request $request) 
    {
        $data = Poster::latest('id')->get();
        return view('admin.poster.index', compact('data'));
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
        $upload_path = "public/uploads/poster/";
        $banner = new Poster;

        // image
        $image = $params['image'];
        $imageName = time().".".mt_rand().".".$image->getClientOriginalName();
        $image->move($upload_path, $imageName);
        $uploadedImage = $imageName;
        $banner->file_path = $upload_path.$uploadedImage;

        // file type
        $extension = $image->getClientOriginalExtension();
        $imageTypes = array('jpg', 'jpeg', 'png', 'svg', 'gif');

       /* if (in_array($extension, $imageTypes)) {
            $banner->type = 'img';
        } else {
            $banner->type = 'video';
        }*/

        // position
        //$latestPosition = Poster::select('position')->orderBy('position', 'desc')->first();
        
       /* if(!empty($latestPosition)) {
        	$banner->position = $latestPosition->position + 1;
        } else {
        	$banner->position = 1;
        }*/

        $banner->save();


        if ($banner) {
            return redirect()->route('admin.poster.index');
        } else {
            return redirect()->route('admin.poster.create')->withInput($request->all());
        }
		}
    }

    public function show(Request $request, $id)
    {
        $data = Poster::findOrFail($id);
        return view('admin.poster.detail', compact('data'));
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
        $upload_path = "public/uploads/poster/";
        $banner = Poster::findOrFail($id);
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

            /*if (in_array($extension, $imageTypes)) {
                $banner->type = 'img';
            } else {
                $banner->type = 'video';
            }*/
        }

        $banner->save();
        if ($banner) {
            return redirect()->route('admin.poster.index');
        } else {
            return redirect()->route('admin.poster.create')->withInput($request->all());
        }
		}
    }

    public function status(Request $request, $id)
    {
        $updatedEntry = Poster::findOrFail($id);

        $status = ( $updatedEntry->status == 1 ) ? 0 : 1;
        $updatedEntry->status = $status;
        $updatedEntry->save();


        if ($updatedEntry) {
            return redirect()->route('admin.poster.index');
        } else {
            return redirect()->route('admin.poster.create')->withInput($request->all());
        }
    }

    public function destroy(Request $request, $id) 
    {
        $poster=Poster::where('id',$id)->delete();

        return redirect()->route('admin.poster.index');
    }
}
