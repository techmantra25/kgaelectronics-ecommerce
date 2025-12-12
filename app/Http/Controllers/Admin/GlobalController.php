<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use App\Models\Globals;

class GlobalController extends Controller{
    public function index(){
    //    return "hi";
    $global = Globals::all();
    return view('admin.global.index',compact('global'));
  
  }

  public function store(Request $request){
    //   dd($request->all());
      $validator = Validator::make($request->all(),[
         'title'=>'required | string',
         'content'=>'required | string'
      ]);

      if($validator->fails()){
          return redirect()->back()->withErrors($validator)->withinput();
      }
      else{
         $global = new Globals();
         $global->title = $request->title;
         $global->content = $request->content;
        $globalStore =  $global->save();
      }

      if($globalStore){
          return redirect()->route('admin.global.index');
      }

  }

  public function show($id){
    //   return $id;
    $data = Globals::findOrFail($id);
     return view('admin.global.details',compact('data'));
  }

  public function update(Request $request,$id){
     $validator = Validator::make($request->all(),[
         'title'=>'required | string',
         'content'=> 'required | string'
     ]);

     if($validator->fails()){
        return redirect()->back()->withErrors($validator)->withInput();
     }
     else{
           $data = Globals::findOrFail($id);
           $data->title = $request->title;
           $data->content = $request->content;
           $globalUpdate = $data->save();
        }

        if($globalUpdate){
            return redirect()->route('admin.global.index');
        }

    }

    public function status(Request $request, $id){
        $global = Globals::findOrFail($id);
        $global->status = ($global->status == 1)? 0 : 1;
        $global->update();
        return redirect()->route('admin.global.index'); 
    }

    public function delete($id){
        $global = Globals::findOrFail($id);
        $global->delete();
        return redirect()->route('admin.global.index');
    }
      
}

   