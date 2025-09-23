<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Skill;
use App\Models\Project;
use App\Models\Experience;
use App\Models\SocialLink;
use Illuminate\Http\Request;
use App\Models\CategorySkill;
use App\Models\Certification;
use App\Models\UserCvFile;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    public function index()
    {
        $user = User::with([
            'userProfile.profileImage',
            'education', 
            'skills.categorySkill' => function($query) {
                $query->orderBy('id', 'asc');
            },
            'experiences' => function($query) {
                $query->orderBy('id', 'desc');
            },
            'certifications' => function($query) {
                $query->orderBy('id', 'desc');
            },
            'socialLinks' => function($query) {
                $query->orderBy('display_order', 'asc');
            },
            'projects.technologies' => function($query) {
                $query->orderBy('id', 'desc');
            }
        ])->first();
        
        $categorySkill = $user->skills->groupBy('categorySkill.name');
    
        return view('home', [
            'user' => $user,
            'categorySkill' => $categorySkill
        ]);
    }

    public function downloadCV()
    {
        // Download CV for frontend (without parameter ID)
        $lang = app::getLocale();
        $userUploadCv = UserCvFile::where('user_id', 1)
            ->where('lang', $lang)
            ->first();
            
        if (!$userUploadCv || !$userUploadCv->cv_id) {
            return redirect()->back()->with('error', 'CV not available');
        }

        $file = $userUploadCv->cvFile;
        $filePath = storage_path('app/public/' . $file->directory);
        
        if (!file_exists($filePath)) {
            return redirect()->back()->with('error', 'CV file not found');
        }

        $userName = str_replace(' ', '_', $userUploadCv->user->name);
        // Download dengan nama yang professional
        $downloadName = 'CV_' . $userName . '_' . date('Y') . '.' .
                       pathinfo($file->name, PATHINFO_EXTENSION);
        
        return response()->download($filePath, $downloadName);
    }
    
    public function switchLang($lang)
    {
        // Debug before
            Log::info('BEFORE - Session: ' . Session::get('locale') . ', App: ' . App::getLocale());
        
        if (in_array($lang, ['en', 'id'])) {
            Session::put('locale', $lang);
            App::setLocale($lang); // Set immediately
            
            // Debug after
            Log::info('AFTER - Session: ' . Session::get('locale') . ', App: ' . $lang);
        }
        
        return redirect()->back();
    }
}
