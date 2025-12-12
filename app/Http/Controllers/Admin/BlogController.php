<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\Blog;

class BlogController extends Controller{
    public function index(){
           $data = Blog::all();
        return view('admin.blog.index',compact('data'));
    }

    public function store(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(),[
            "image" => "required | mimes:jpg,jpeg,png,svg,gif",
            "title"=>'required | string',
            "content"=>'required | string'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
            $blog = new Blog();
            $blog->title = $request->title;
            $blog->content = $request->content;
            $blog->slug = slugGenerate($request->title,'blogs');
            if($request->image){
                $file = $request->file('image');
                $fileName = time().rand(10000,99999).'.'.$file->getClientOriginalExtension();
                $imgPath = public_path('uploads/blog');
                $file->move($imgPath,$fileName);
                $blog->image = "uploads/blog/". $fileName;
            }
    
           $blogStore =  $blog->save();
        }

       if($blogStore){
           return redirect()->route('admin.blog.index');
        }
      


    }

    public function show($id){
        $data = Blog::findOrFail($id);
        // dd($data);
        return view('admin.blog.details',compact('data'));
    }

   
    public function update(Request $request,$id){
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            "image" => "nullable | mimes:jpg,jpeg,png,svg,gif",
            "title" => 'required | string',
            "content" => 'required | string'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else{
            $blog = Blog::findOrFail($request->id);
            $blog->title = $request->title ;
            $blog->slug = slugGenerateUpdate($request->title,'blogs',$request->id);
            $blog->content = $request->content;
    
            if($request->image){
                $file = $request->file('image');
                $fileName = time().rand(10000,99999).'.'.$file->getClientOriginalExtension();
                $imgPath = public_path('uploads/blog');
                $file->move($imgPath,$fileName);
                $blog->image = 'uploads/blog/'.$fileName;
                
            }
           $blogUpdate =  $blog->save();
        }
       if($blogUpdate){
           return redirect()->route('admin.blog.index');
        }

    }

    public function status($id){
        $blog = Blog::findOrFail($id);
        $blog->status = ($blog->status == 1) ? 0 : 1;
        $blog->save();

        return redirect()->route('admin.blog.index');

    }

    public function destroy($id){
        $blog = Blog::findOrFail($id);
        $imagePath = public_path($blog->image);

        if(file_exists($imagePath)){
            unlink($imagePath);
        }

        $blog->delete();
        return redirect()->route('admin.blog.index');
    }

    
}