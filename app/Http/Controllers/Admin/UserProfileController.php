<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Lang;
use App\Models\UserProfile;
use Illuminate\Http\Request;
use App\Service\UserProfileService;
use App\Http\Requests\UserProfileUpdateRequest;
use App\Models\UserProfileTranslation;

class UserProfileController
{
    public function __construct(private UserProfileService $userProfileService) {}

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
        $data = $request->validate();
        $image = $request->file('image');

        $this->userProfileService->handleUpdateProfile($data, $image, $userProfile);

        return to_route('admin.user-profile.index')->with([
            'success' => 'User Profile successfully updated.'
        ]);
    }

    public function imageForm(UserProfile $userProfile)
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

        $image = $request->file('image');

        $this->userProfileService->uploadImageOnly($image, $userProfile);

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

    public function storeBio(Request $request, UserProfile $userProfile)
    {
        $request->validate([
            'bio' => 'required|string',
            'full_bio' => 'nullable|string',
            'lang' => 'required|string'
        ]); 

        $data = $request->only(['bio', 'full_bio', 'lang']);

        $this->userProfileService->handleCreateBio($data, $userProfile);

        return to_route('admin.user-profile.index')->with([
            'success' => 'New Bio successfully created.'
        ]);
    }

    public function editBio(UserProfile $userProfile, UserProfileTranslation $translation)
    {
        $languages = Lang::cases();

        return view('backend.user-profiles.update-bio-form', [
            'userProfile' => $userProfile,
            'languages' => $languages,
            'translation' => $translation
        ]);
    }

    public function updateBio(Request $request, UserProfile $userProfile, UserProfileTranslation $translation)
    {
        $request->validate([
            'bio' => 'required|string',
            'full_bio' => 'nullable|string',
            'lang' => 'required|string'
        ]); 

        $data = $request->only(['bio', 'full_bio', 'lang']);

        $this->userProfileService->handleCreateOrUpdateBio($data, $userProfile, $translation->id);

        return to_route('admin.user-profile.index')->with([
            'userProfile' => $userProfile,
            'success' => 'New Bio successfully created.'
        ]);
    }

    public function deleteBio(UserProfileTranslation $translation)
    {
        $this->userProfileService->handleDeleteBio($translation);

        return to_route('admin.user-profile.index')->with([
            'success' => 'Bio successfully deleted.'
        ]);
    }
}
