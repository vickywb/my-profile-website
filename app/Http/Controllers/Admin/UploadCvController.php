<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Lang;
use App\Models\UserCvFile;
use Illuminate\Http\Request;
use App\Service\UploadCvService;
use App\Http\Controllers\Controller;

class UploadCvController extends Controller
{
    private $uploadCvService;

    public function __construct(UploadCvService $uploadCvService) {
        $this->uploadCvService = $uploadCvService;
    }

    public function cvForm(Request $request, UserCvFile $userCvFile)
    {
        $languages = Lang::cases();

        return view('backend.user-profiles.upload-cv', [
            'languages' => $languages,
            'userCvFile' => $userCvFile
        ]);
    }

    public function uploadedCV(Request $request, UserCvFile $userCvFile)
    {
        $request->validate([
            'cv' => 'required|file|mimes:pdf,doc,docx|max:2048',
            'lang' => 'required'
        ]);

        $data = $request->only(['cv', 'cv_id', 'lang']);

        $updateCv = $this->uploadCvService->uploadCVOnly($data, $request, $userCvFile);
        return to_route('admin.user-profile.index')->with([
            'success' => 'CV successfully updated.'
        ]);
    }

    public function deleteCv(Request $request, UserCvFile $userCvFile)
    {
        $deleteCv = $this->uploadCvService->handleDeleteCv($request, $userCvFile);

        return to_route('admin.user-profile.index')->with([
            'success' => 'CV successfully deleted.'
        ]);
    }
}
