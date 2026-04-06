<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Lang;
use App\Models\UserCvFile;
use App\Http\Controllers\Controller;
use App\Http\Requests\CvStoreRequest;
use App\Service\CvsService;

class UploadCvController extends Controller
{
    public function __construct(private CvsService $cvsService) {}

    public function cvForm(UserCvFile $userCvFile)
    {
        $languages = Lang::cases();

        return view('backend.user-profiles.upload-cv', [
            'languages' => $languages,
            'userCvFile' => $userCvFile
        ]);
    }

    public function uploadedCV(CvStoreRequest $request)
    {
        $data = $request->validated();
        $cv = $request->file('cv');

        $this->cvsService->uploadCVOnly($data, $cv);

        return to_route('admin.user-profile.index')->with([
            'success' => 'CV successfully updated.'
        ]);
    }
    
    public function deleteCv(UserCvFile $userCvFile)
    {
        $this->cvsService->handleDeleteCv($userCvFile);

        return to_route('admin.user-profile.index')->with([
            'success' => 'CV successfully deleted.'
        ]);
    }
}
