<?php

namespace App\Http\Controllers\Admin;

use App\Interfaces\ColorInterface;
use App\Models\Color;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ColorController extends Controller
{
    // private ColorInterface $colorRepository;

    public function __construct(ColorInterface $colorRepository)
    {
        $this->colorRepository = $colorRepository;
    }

    public function index(Request $request)
    {
        if (!empty($request->term)) {
            $data = $this->colorRepository->getSearchColor($request->term);
        } else {
            $data = $this->colorRepository->getAllColor();
        }
        return view('admin.color.index', compact('data'));
    }
   public function create(Request $request)
    {
        
        return view('admin.color.create');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            "name" => "required|string|max:255",
            "code" => "nullable|string",
        ]);
		if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
        $params = $request->except('_token');
        $storeData = $this->colorRepository->createColor($params);

        if ($storeData) {
            return redirect()->route('admin.color.index');
        } else {
            return redirect()->route('admin.color.create')->withInput($request->all());
        }
	   }
    }

    public function show(Request $request, $id)
    {
        $data = $this->colorRepository->getColorById($id);
        return view('admin.color.details', compact('data'));
    }
    public function edit(Request $request, $id)
    {
        $data = $this->colorRepository->getColorById($id);
        return view('admin.color.edit', compact('data'));
    }
    public function update(Request $request, $id)
    {
        // dd($request->all());

        $validator = Validator::make($request->all(),[
            "name" => "required|string|max:255",
            "code" => "nullable|string",
        ]);
		if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }else{
        $params = $request->except('_token');
        $storeData = $this->colorRepository->updateColor($id, $params);

        if ($storeData) {
            return redirect()->route('admin.color.index');
        } else {
            return redirect()->route('admin.color.create')->withInput($request->all());
        }
		}
    }

    public function status(Request $request, $id)
    {
        $storeData = $this->colorRepository->toggleStatus($id);

        if ($storeData) {
            return redirect()->route('admin.color.index');
        } else {
            return redirect()->route('admin.color.create')->withInput($request->all());
        }
    }

}