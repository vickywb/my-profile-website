<?php

namespace App\Service;

use Exception;
use App\Helpers\FileHelper;
use App\Models\UserProfile;
use App\Models\UserProfileTranslation;
use App\Repository\FileRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Repository\UserProfileRepository;

/**
 * Handle business logic for User Profile operations
 * Including profile data, image, and CV management
 */
class UserProfileService
{
    private $userProfileRepository;
    private $fileRepository;
    
    /**
     * UserProfileService constructor
     * 
     * @param UserProfileRepository $userProfileRepository
     * @param FileRepository $fileRepository
     */
    public function __construct(
        UserProfileRepository $userProfileRepository,
        FileRepository $fileRepository
    ) {
        $this->userProfileRepository = $userProfileRepository;
        $this->fileRepository = $fileRepository;
    }

    /**
     * Update user profile data
     * 
     * @param array $data Request data
     * @param mixed $request Request instance
     * @return UserProfile
     * @throws \Exception When profile creation/update fails
     */
    public function handleUpdateProfile(array $data, $request, $userProfile)
    {
        try {
            DB::beginTransaction();

            $oldImageId = $userProfile->file_id;
            $newFileId = 
                $request->hasFile('image') 
                ? $this->handleFileUpload($request->file('image'), 'file/profile')
                : $oldImageId;
            
            $profileData = [
                'phone_number' => $data['phone_number'] ?? null,
                'address' => $data['address'] ?? null,
                'file_id' => $newFileId
            ];
            
            // Simpan user profile menggunakan Repository
            $userProfile = $userProfile->fill($profileData);
            $userProfile = $this->userProfileRepository->save($userProfile);

            DB::commit();

            Log::info('User Profile has been updated.');

            // Cleanup old image if replaced
            if ($request->hasFile('image') && $oldImageId && $oldImageId != $newFileId) {
                $this->deleteOldFile($oldImageId);
            }

            return $userProfile;
            
        } catch (\Throwable $th) {
            DB::rollBack();
            
            Log::error('Failed to update profile: ' . $th->getMessage());
            Log::error('User Profile ID: ' . $userProfile->id);

            throw new Exception('Failed to update profile: ' . $th->getMessage());
        }
    }
    
    /**
     * Update profile image only
     * Handles old image deletion if exists
     * 
     * @param mixed $request Request instance with image file
     * @param UserProfile $userProfile Profile to update
     * @return UserProfile
     * @throws \Exception When no image provided or upload fails
     */
    public function uploadImageOnly($request, $userProfile)
    {
        try {
            DB::beginTransaction();
            
            // Store file data and directory by handleFileUpload
            $oldFileId = $userProfile->file_id;
            $newFileId = $request->hasFile('image')
                ? $this->handleFileUpload($request->file('image'), 'file/profile')
                : $oldFileId;

            // Update user profile file_id with new File id
            $userProfile->update(['file_id' => $newFileId]);
            
            DB::commit();

            // Cleanup old image if replaced
            if ($request->hasFile('image') && $oldFileId && $oldFileId != $newFileId) {
                $this->deleteOldFile($oldFileId);
            }

            return $userProfile->fresh();
            
        } catch (\Throwable $th) {
            DB::rollBack();
            
            Log::error('Failed to upload image: ' . $th->getMessage());
            Log::error('User Profile ID: ' . $userProfile->id);

            throw new Exception('Failed to upload image: ' . $th->getMessage());
        }
    }

    /**
     * Update or Create Biography and Full Biography with Lang
     * Handles create bio and full bio, update if lang exists
     * 
     * @param mixed $request Request instance with image file
     * @param UserProfile $userProfile Profile to update
     * @return UserProfile
     * @throws \Exception When no image provided or upload fails
     */
    public function handleCreateOrUpdateBio(array $data, $request, $userProfile)
    {
        try {
            DB::beginTransaction();

            // updateOrCreate - if lang exists = update, if not exists = create
            $storeTranslation =  UserProfileTranslation::updateOrCreate(
                [
                    'user_profile_id' => $userProfile->id,
                    'lang' => $data['lang']
                ],
                [
                    'bio' => $data['bio'],
                    'full_bio' => $data['full_bio']
                ]
            );

            DB::commit();

            Log::info('Bio Translation successfully update.');
            
            return $storeTranslation;

        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error('Faild to update data:' . $th->getMessage());
            throw new Exception('Failed to update data:' . $th->getMessage());
        }
    }
        
    /**
     * Handle file upload and store file data
     * 
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $directory Target directory
     * @return int File ID
     */
    private function handleFileUpload($file, $directory)
    {   
        try {
            // Upload new File using File Helper
            $fileResult = FileHelper::uploadFileToStorage($file, $directory);
            
            // Store to database
            $fileData = [
                'name' => $file->getClientOriginalName(),
                'directory' => $fileResult['directory'],
                'file_url' => $fileResult['file_url'],
            ];
        
            $fileRecord = $this->fileRepository->save($fileData);
        

            return $fileRecord->id;

        } catch (\Throwable $th) {

            Log::error('Failed to upload file:' . $th->getMessage());
            throw new Exception('Failedd to upload file:' . $th->getMessage());
        }
    }
    
    /**
     * Delete file from storage and database
     * Logs warning if deletion fails but doesn't stop process
     * 
     * @param int $fileId File ID to delete
     * @return void
     */
    private function deleteOldFile($fileId)
    {   
        try {
            if (empty($fileId)) {
                return; // Jika tidak ada fileId, langsung return
            }

            $oldFile = $this->fileRepository->findById($fileId);
            
            if (!$oldFile) {
                Log::warning("File with ID {$fileId} not found in database");
                return;
            }

            // Delete from storage
            if ($oldFile->directory && Storage::disk('public')->exists($oldFile->directory)) {
                Storage::disk('public')->delete($oldFile->directory);
            }

            // Delete from database
            $this->fileRepository->delete($fileId);

            Log::info("Old file (ID: {$fileId}) successfully deleted.");

        } catch (\Throwable $th) {
            Log::error('Old file failed to delete: ' . $th->getMessage());
            throw new Exception('Old file failed to delete: ' . $th->getMessage());
        }
    }
}