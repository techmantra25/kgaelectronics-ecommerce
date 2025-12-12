<?php

namespace App\Http\Controllers\Admin;

use App\Interfaces\SettingsInterface;
use App\Models\Settings;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class SettingsController extends Controller
{
    public function __construct(SettingsInterface $settingsRepository)
    {
        $this->settingsRepository = $settingsRepository;
    }

    public function index(Request $request)
    {
        if (!empty($request->term)) {
            $data = $this->settingsRepository->getSearchSettings($request->term);
        } else {
            $data = $this->settingsRepository->listAll();
        }
        return view('admin.settings.index', compact('data'));
    }

    public function show(Request $request, $id)
    {
        $data = $this->settingsRepository->listById($id);
        return view('admin.settings.detail', compact('data'));
    }

   
    public function update(Request $request, $id)
    {   
        // dd($request->all());
        
        try {
            // Uncomment if you want to validate the request
            // $validator = Validator::make($request->all(), [
            //     "content" => "required|string",
            //     'about_image_1' => 'nullable|mimes:jpg,jpeg,png,gif',
            //     'about_image_2' => 'nullable|mimes:jpg,jpeg,png,gif',
            //     'about_company_info_title' => 'required|string',
            //     'about_company_info_desc' => 'required|string',
            //     'blog_image' => 'nullable|mimes:jpg,jpeg,png,gif'
            // ]);
            //
            // if ($validator->fails()) {
            //     return redirect()->back()->withErrors($validator)->withInput();
            // }
                
            $params = $request->except('_token');
            $storeData = $this->settingsRepository->update($id, $params);
    
            if ($storeData) {
                return redirect()->route('admin.settings.index');
            } else {
                return redirect()->route('admin.settings.update')->withInput($request->all());
            }
        } catch (\Exception $e) {
            // Handle the exception here
            // For example, you can log the exception and cache it for later retrieval
            // Cache::put('update_exception_' . $id, $e->getMessage(), 3600); // Cache the exception message for 1 hour
            // dd($e->getMessage());
            // Redirect back with a flash message informing about the error
            return redirect()->back()->with('error', 'An error occurred while updating. Please try again later.');
        }
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
                    Settings::where('id', $delete_id)->delete();
                }

                return redirect()->route('admin.settings.index')->with('success', 'Selected items deleted');
            } else {
                return redirect()->route('admin.settings.index')->with('failure', 'Please select an action')->withInput($request->all());
            }
        } else {
            return redirect()->route('admin.settings.index')->with('failure', $validator->errors()->first())->withInput($request->all());
        }
    }
}