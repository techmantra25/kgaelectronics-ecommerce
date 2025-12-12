<?php

namespace App\Repositories;

use App\Interfaces\SettingsInterface;
use App\Models\Settings;
use Illuminate\Support\Facades\Hash;

class SettingsRepository implements SettingsInterface
{
    public function listAll()
    {
        return Settings::all();
    }
    public function getSearchSettings(string $term)
    {
        return Settings::where([['page_heading', 'LIKE', '%' . $term . '%']])->get();
    }

    public function listById($id)
    {
        return Settings::findOrFail($id);
    }

    public function update($id, array $newDetails)
    {
        // dd("hi",$newDetails);
        $updatedEntry = Settings::findOrFail($id);
        $collectedData = collect($newDetails);
        // dd($collectedData);
        if($updatedEntry->page_heading == 'about'){
            if(isset($newDetails['about_image_1']) && $newDetails['about_image_1']->isValid()){
                $file = $collectedData['about_image_1'];
                $fileName = time().rand(10000,99999).'.'.$file->getClientOriginalExtension();
                $imgPath = public_path('uploads/about-page');
                $file->move($imgPath,$fileName);
                $updatedEntry->about_image_1 = 'uploads/about-page/'.$fileName;
            }
    
            if(isset($newDetails['about_image_2']) && $newDetails['about_image_2']->isValid()){
                $file = $collectedData['about_image_2'];
                $fileName = time().rand(10000,99999).'.'.$file->getClientOriginalExtension();
                $imgPath = public_path('uploads/about-page');
                $file->move($imgPath,$fileName);
                $updatedEntry->about_image_2 = 'uploads/about-page/'.$fileName;
            }
    
            
            $updatedEntry->about_company_info_title = $collectedData['about_company_info_title'];
            $updatedEntry->about_company_info_desc = $collectedData['about_company_info_desc'];
            $updatedEntry->content = $collectedData['content'];
        }
        
        $updatedEntry->content = $collectedData['content_all'];
        // dd($updatedEntry->content);
        if($updatedEntry->page_heading == 'blog'){
               if(isset($newDetails['blog_image']) && $newDetails['blog_image']->isValid()){
                $file = $collectedData['blog_image'];
                $fileName = time().rand(10000,99999).'.'.$file->getClientOriginalExtension();
                $imgPath = public_path('uploads/blog-page');
                $file->move($imgPath,$fileName);
                $updatedEntry->blog_image = 'uploads/blog-page/'.$fileName;
             }
        }

        if($updatedEntry->page_heading == 'news'){
               if(isset($newDetails['blog_image']) && $newDetails['blog_image']->isValid()){
                $file = $collectedData['blog_image'];
                $fileName = time().rand(10000,99999).'.'.$file->getClientOriginalExtension();
                $imgPath = public_path('uploads/news-page');
                $file->move($imgPath,$fileName);
                $updatedEntry->blog_image = 'uploads/news-page/'.$fileName;
             }
        }

        if($updatedEntry->page_heading == 'global'){
            if(isset($newDetails['blog_image']) && $newDetails['blog_image']->isValid()){
                $file = $collectedData['blog_image'];
                $fileName = time().rand(10000,99999).'.'.$file->getClientOriginalExtension();
                $imgPath = public_path('uploads/global-page');
                $file->move($imgPath,$fileName);
                $updatedEntry->blog_image = 'uploads/global-page/'.$fileName;
            }
        }
        if($updatedEntry->page_heading == 'contact_us'){
            if(isset($newDetails['contact_image']) && $newDetails['contact_image']->isValid()){
                $file = $collectedData['contact_image'];
                $fileName = time().rand(10000,99999).'.'.$file->getClientOriginalExtension();
                $imgPath = public_path('uploads/contact-page');
                $file->move($imgPath,$fileName);
                $updatedEntry->contact_image = 'uploads/contact-page/'.$fileName;
            }  
            $updatedEntry->google_map_link = $collectedData['google_map_link'];
            $updatedEntry->contact_info    = $collectedData['contact_info'];
            $updatedEntry->address         = $collectedData['address'];
            $updatedEntry->inqueries_and_feedback = $collectedData['inqueries_and_feedback'];
        }

        $updatedEntry->save();

        return $updatedEntry;
    }
}