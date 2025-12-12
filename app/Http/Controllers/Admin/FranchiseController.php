<?php

namespace App\Http\Controllers\Admin;

use App\Models\FranchisePartner;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Models\Requisite;
use App\Models\OurStore;
use App\Models\Marketing;


class FranchiseController extends Controller
{
    public function index(Request $request)
    {
        $data = DB::table('franchise_partners')->orderBy('id', 'desc')->get();
        return view('admin.franchise.index', compact('data'));
    }

    public function details(Request $request,$id)
    {
        $data = DB::table('franchise_partners')->where('id',$id)->first();
        return view('admin.franchise.details', compact('data'));
    }

    public function comment(Request $request)
    {
        // dd($request->all());
        if ($request->comment != null) $type = "remarksExists";
        if ($request->comment == null) $type = "noRemarks";

        $comment = FranchisePartner::findOrFail($request->id);
        $comment->remarks = $request->comment;
        $comment->save();

        return response()->json(['status' => 200, 'type' => $type, 'message' => 'remarks added successfully']);
    }


    public function RequisiteIndex(){
        $requisite_data = Requisite::all();
        return view('admin.requisite.index',compact('requisite_data'));        
    }

    public function RequisiteStore(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|file|mimes:jpg,jpeg,png,gif,avif' 
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }
      
             $requisite_data = new Requisite();
        $requisite_data->title = $request->title ?? '';
        $requisite_data->description = $request->description ?? '';

        if($request->hasfile('image')){
            $file = $request->file('image');
            $fileName = time().rand(10000,99999).'.'.$file->getClientOriginalExtension();
            $imgPath = public_path("uploads/requisite");
            $file->move($imgPath,$fileName);
            $requisite_data->image = "uploads/requisite/".$fileName;
        }
        $requisite_data_store = $requisite_data->save();

        if($requisite_data_store){
            return redirect()->back()->with('success','Requisite things are successfully added');;
        }
       
    }

    public function RequisiteView($id){
        // return $id;
        $requisite_view = Requisite::findOrFail($id);
        return view('admin.requisite.details',compact('requisite_view'));
    }

    public function RequisiteUpdate(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'nullable|file|mimes:jpg,jpeg,png,gif,avif' 
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput(); 
        }

        $data = Requisite::findOrFail($request->id);
        $data->title = $request->title ?? '';
        $data->description = $request->description ?? '';

        if($request->hasfile('image')){
            $file = $request->file('image');
            $fileName = time().rand(10000,99999).'.'.$file->getClientOriginalExtension();
            $imgPath = public_path("uploads/requisite");
            $file->move($imgPath,$fileName);
            $data->image = "uploads/requisite/".$fileName;
        }

        $data->save();
        return redirect()->route('admin.franchise.requisite.index')->with('success','Requisite things are successfully updated');;

    }


    public function RequisiteStatus($id){
        $data = Requisite::findOrFail($id);
        $data->status = ($data->status == 1)? 0 : 1;
        $data->save();
        return redirect()->route('admin.franchise.requisite.index');
    }


    public function RequisiteDelete($id){
        $data = Requisite::findOrFail($id);
        $imgPath = public_path($data->image);
        if(file_exists($imgPath)){
            unlink($imgPath);
        }        
        $data->delete();
        return redirect()->route('admin.franchise.requisite.index')->with('success','Requisite things are successfully deleted');
    }

    //Our Stores

    public function StoresIndex(){
        $data = OurStore::all();
        return view('admin.our_store.index',compact('data'));
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(),[
            'title'=>'required|string',
            'image'=>'required|file|mimes:jpg,jpeg,png,gif,avif,webp'
        ]);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = new OurStore();
        $data->title = $request->title ?? '';
        if($request->hasfile('image')){
            $file = $request->file('image');
            $fileName = time().rand(10000,99999).'.'.$file->getClientOriginalExtension();
            $imgPath = public_path("uploads/our_store");
            $file->move($imgPath,$fileName);
            $data->image = "uploads/our_store/".$fileName;
        }

        $data->save();
        return redirect()->back()->with('success','Our Store Created successfully');
    }

    public function show($id){
        $data = OurStore::findOrFail($id);
        return view('admin.our_store.view',compact('data'));
    }

    public function update(Request $request){
        // dd($request->all());
        $data = OurStore::findOrFail($request->id);
        $data->title = $request->title ?? '';
        if($request->hasfile('image')){
            $file = $request->file('image');
            $fileName = time().rand(10000,99999).'.'.$file->getClientOriginalExtension();
            $imgPath = public_path("uploads/our_store");
            $file->move($imgPath,$fileName);
            $data->image = "uploads/our_store/".$fileName;
        }

        $data->save();
        return redirect()->route('admin.franchise.our_stores.index')->with('success','Our Store Updated successfully');

    }

    public function status($id){
        $data =  OurStore::findOrFail($id);
        $data->status = ($data->status == 1)? 0 : 1;
        $data->save();
        return redirect()->back();
        
    }

    public function delete($id){
        $data = OurStore::findOrFail($id);
        $imgPath = public_path($data->image);
        if(file_exists($imgPath)){
            unlink($imgPath);
        }
        $data->delete();
        return redirect()->back()->with('success','Our Store deleted successfully');
    }

    public function MarketingIndex(){
        $data = Marketing::all();
        return view('admin.marketing.index',compact('data'));
    }

    public function MarketingStore(Request $request){
        // dd($request->all());
        $validator = Validator::make($request->all(), [
            'title' => 'required|string',
            'description' => 'required|string',
            'image' => 'required|file|mimes:jpg,jpeg,png,gif,avif' 
        ]);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $data = new Marketing();
        $data->title = $request->title ?? '';
        $data->description = $request->description ?? '';
        if($request->hasfile('image')){
            $file = $request->file('image');
            $fileName = time().rand(10000,99999).'.'.$file->getClientOriginalExtension();
            $imgPath = public_path("uploads/marketing");
            $file->move($imgPath,$fileName);
            $data->image = "uploads/marketing/".$fileName;
        }

        $data->save();
        return redirect()->back()->with('success','Marketing and sales promotion created successfully');

    }

    public function MarketingShow($id){
        $data = Marketing::findOrFail($id);
        return view('admin.marketing.view',compact('data'));
    }

    public function MarketingUpdate(Request $request){
        // dd($request->all());
        $data = Marketing::findOrFail($request->id);
        $data->title = $request->title ?? '';
        $data->description = $request->description ?? '';
        if($request->hasfile('image')){
            $file = $request->file('image');
            $fileName = time().rand(10000,99999).'.'.$file->getClientOriginalExtension();
            $imgPath = public_path("uploads/marketing");
            $file->move($imgPath,$fileName);
            $data->image = "uploads/marketing/".$fileName;
        }

        $data->save();
        return redirect()->route('admin.franchise.marketing.index')->with('success','Marketing and sales promotion updated successfully');
        
    }

    public function MarketingStatus($id){
        $data =  Marketing::findOrFail($id);
        $data->status = ($data->status == 1)? 0 : 1;
        $data->save();
        return redirect()->back();
        
    }

    public function MarketingDelete($id){
        $data = Marketing::findOrFail($id);
        $imgPath = public_path($data->image);
        if(file_exists($imgPath)){
            unlink($imgPath);
        }
        $data->delete();
        return redirect()->back()->with('success','Marketing and sales promotion deleted successfully');
    }

}
