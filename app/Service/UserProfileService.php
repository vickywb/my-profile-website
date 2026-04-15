<?php

namespace App\Service;

use Exception;
use App\Models\UserProfile;
use App\Models\UserProfileTranslation;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repository\UserProfileRepository;

class UserProfileService
{
    public function __construct(
        private UserProfileRepository $userProfileRepository,
        private FileService $fileService
    ) {}

    public function handleUpdateProfile(array $data, ?UploadedFile $image, UserProfile $userProfile): UserProfile
    {
        $oldFileId = $userProfile->file_id;

        try {
            $newFile = DB::transaction(function () use ($data, $image, $userProfile) {
                $newFile   = null;
                $newFileId = $userProfile->file_id;

                if ($image) {
                    $newFile   = $this->fileService->handleUploadAndSave($image, 'file/profile');
                    $newFileId = $newFile->id;
                }

                $userProfile->fill([
                    'phone_number' => $data['phone_number'] ?? null,
                    'address'      => $data['address'] ?? null,
                    'file_id'      => $newFileId,
                ]);

                $this->userProfileRepository->save($userProfile);

                return $newFile;
            });

            if ($image && $newFile && $oldFileId && $oldFileId !== $newFile->id) {
                $this->fileService->deleteFile($oldFileId);
            }

            Log::info('User profile updated.', [
                'user_profile_id' => $userProfile->id,
                'old_file_id'     => $oldFileId,
                'new_file_id'     => $newFile?->id,
            ]);

            return $userProfile->fresh();

        } catch (\Throwable $th) {
            Log::error('Failed to update profile: ' . $th->getMessage(), [
                'user_profile_id' => $userProfile->id,
            ]);

            throw new Exception('Failed to update profile: ' . $th->getMessage());
        }
    }

    public function uploadImageOnly(UploadedFile $image, UserProfile $userProfile): UserProfile
    {
        $oldFileId = $userProfile->file_id;

        try {
            $newFile = DB::transaction(function () use ($image, $userProfile) {
                $newFile = $this->fileService->handleUploadAndSave($image, 'file/profile');
                $userProfile->update(['file_id' => $newFile->id]);
                return $newFile;
            });
            
            if ($oldFileId && $oldFileId !== $newFile->id) {
                $this->fileService->deleteFile($oldFileId);
            }

            Log::info('Profile image updated.', [
                'user_profile_id' => $userProfile->id,
                'old_file_id'     => $oldFileId,
                'new_file_id'     => $newFile->id,
            ]);

            return $userProfile->fresh();

        } catch (\Throwable $th) {
            Log::error('Failed to upload image: ' . $th->getMessage(), [
                'user_profile_id' => $userProfile->id,
            ]);

            throw new Exception('Failed to upload image: ' . $th->getMessage());
        }
    }

    public function handleCreateBio(array $data, UserProfile $userProfile): UserProfileTranslation
    {
        try {
          $translation = DB::transaction(function () use ($data, $userProfile) {
                return UserProfileTranslation::create([
                    'user_profile_id' => $userProfile->id,
                    ...$data
                ]);
            });
            
            Log::info('Bio translation created.', [
                'user_profile_id' => $translation->user_profile_id,
                'lang'            => $translation->lang,
            ]);

            return $translation;

        } catch (\Throwable $th) {
            Log::error('Failed to create bio: ' . $th->getMessage(), [
                'user_profile_id' => $data['user_profile_id'] ?? null,
            ]);

            throw new Exception('Failed to create bio: ' . $th->getMessage());
        }
    }

    public function handleCreateOrUpdateBio(array $data, UserProfile $userProfile, ?int $translationId = null): UserProfileTranslation
    {
        try {
            $translation = DB::transaction(function () use ($data, $userProfile, $translationId) {
                return UserProfileTranslation::updateOrCreate(
                    [
                        'id' => $translationId,
                        'user_profile_id' => $userProfile->id,
                        'lang'            => $data['lang'],
                    ],
                    [
                        'bio'      => $data['bio'],
                        'full_bio' => $data['full_bio'],
                    ]
                );
            });

            Log::info('Bio translation updated.', [
                'user_profile_id' => $userProfile->id,
                'lang'            => $data['lang'],
            ]);

            return $translation;

        } catch (\Throwable $th) {
            Log::error('Failed to update bio: ' . $th->getMessage(), [
                'user_profile_id' => $userProfile->id,
            ]);

            throw new Exception('Failed to update bio: ' . $th->getMessage());
        }
    }

    public function handleDeleteBio(UserProfileTranslation $translation): void
    {
        try {
            DB::transaction(function () use ($translation) {
                $translation->delete();
            });

            Log::info('Bio translation deleted.', [
                'user_profile_translation_id' => $translation->id,
                'lang'                      => $translation->lang,
            ]);

        } catch (\Throwable $th) {
            Log::error('Failed to delete bio: ' . $th->getMessage(), [
                'user_profile_translation_id' => $translation->id,
            ]);

            throw new Exception('Failed to delete bio: ' . $th->getMessage());
        }
    }
}