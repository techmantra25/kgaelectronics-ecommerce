<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\News;

class NewsController extends Controller{
    public function index(){
        $news = News::all();
        return view('admin.news.index',compact('news'));
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
        }
        else{
            $news = new News();
            $news->title = $request->title;
            $news->slug = slugGenerate($request->title,'news');
            $news->content = $request->content;

            if($request->image){
                $file = $request->file('image');
                $fileName = time().rand(10000,99999).'.'.$file->getClientOriginalExtension();
                $imgPath = public_path('uploads/news');
                $file->move($imgPath,$fileName);
                $news->image = "uploads/news/".$fileName;
            }

            $newsStore = $news->save();
        }

        if($newsStore){
            return redirect()->route('admin.news.index');
        }
    }

    public function show($id){
        $news = News::findOrFail($id);
        // dd($news);
        return view('admin.news.details',compact('news'));
    }

    public function update(Request $request,$id){
        // dd($request->all());
        $validator = Validator::make($request->all(),[
            "image" => "nullable | mimes:jpg,jpeg,png,svg,gif",
            "title"=>'required | string',
            "content"=>'required | string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        else{
            $news = News::findOrfail($request->id);
            $news->title = $request->title;
            $news->slug = slugGenerateUpdate($request->title,'news',$request->id);
            $news->content = $request->content;

            if($request->image){
                $file = $request->file('image');
                $fileName = time().rand(10000,99999).'.'.$file->getClientOriginalExtension();
                $imgPath = public_path('uploads/news');
                $file->move($imgPath,$fileName);
                $news->image = "uploads/news/".$fileName;
            }

           $newsUpdate =  $news->save();

        }
        if($newsUpdate){
            return redirect()->route('admin.news.index');
        }
       
    }

    public function status(Request $request, $id){
        $news = News::findOrFail($id);
        $news->status = ($news->status == 1)? 0 : 1;
        $news->update();
        return redirect()->route('admin.news.index');

    }

    public function destroy($id){
        $news = News::findOrFail($id);
        $imagePath = public_path($news->image);
        if(file_exists($imagePath)){
            unlink($imagePath);
        }

        $news->delete();
        return redirect()->route('admin.news.index');
    }

}
