<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Lang;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Service\UserProfileService;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserProfileStoreRequest;
use App\Http\Requests\UserProfileUpdateRequest;
use App\Models\UserProfileTranslation;

class UserProfileController extends Controller
{
    private $userProfileService;

    public function __construct(UserProfileService $userProfileService) {
        $this->userProfileService = $userProfileService;
    }

    public function index()
    {
        $user = auth()->user();
        return view('backend.user-profiles.index', [
            'user' => $user
        ]);
    }

    public function show(UserProfile $userProfile)
    {
        $userProfile->load(['user']);
        return view('backend.user-profiles.detail', [
            'userProfile' => $userProfile
        ]);
    }

    public function edit(UserProfile $userProfile)
    {
        return view('backend.user-profiles.edit', [
            'userProfile' => $userProfile
        ]);
    }

    public function update(UserProfileUpdateRequest $request, UserProfile $userProfile)
    {
        $data = $request->only([
            'phone_number', 'address'
        ]);

        $userProfile = $this->userProfileService->handleUpdateProfile($data, $request, $userProfile);

        return to_route('admin.user-profile.index')->with([
            'success' => 'User Profile successfully updated.'
        ]);
    }

    public function imageForm(Request $request, UserProfile $userProfile)
    {
        return view('backend.user-profiles.upload-image', [
            'userProfile' => $userProfile
        ]);
    }

    public function uploadImage(Request $request, UserProfile $userProfile)
    {
        $request->validate([
            'image' => 'required|file|image|mimes:jpeg,png,webp|max:2048'
        ]);

        $updatedProfile = $this->userProfileService->uploadImageOnly($request, $userProfile);

        return to_route('admin.user-profile.index')->with([
            'success' => 'Image successfully updated.'
        ]);
    }

    public function createBio(UserProfile $userProfile)
    {
        $languages = Lang::cases();
        return view('backend.user-profiles.create-bio-form', [
            'userProfile' => $userProfile,
            'languages' => $languages
        ]);
    }

    public function editBio(UserProfile $userProfile, UserProfileTranslation $translation)
    {
        $translation = UserProfileTranslation::where('user_profile_id', $userProfile->id)
            ->where('lang', $translation->lang)
            ->firstOrFail();

        $languages = Lang::cases();

        return view('backend.user-profiles.edit-bio-form', [
            'userProfile' => $userProfile,
            'languages' => $languages,
            'translation' => $translation
        ]);
    }

    public function storeBio(Request $request, UserProfile $userProfile, UserProfileTranslation $translation)
    {
        $request->validate([
            'bio' => 'required|string',
            'full_bio' => 'nullable|string',
            'lang' => 'required|string'
        ]);

        $data = $request->only([
            'bio', 'full_bio', 'lang'
        ]);

        $translation = $this->userProfileService->handleCreateOrUpdateBio($data, $request, $userProfile);

        return to_route('admin.user-profile.index')->with([
            'success' => 'New Bio successfully created.'
        ]);
    }

    public function deleteBio()
    {
        
    }
}
