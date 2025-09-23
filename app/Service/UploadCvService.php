<?php

namespace App\Service;

use Exception;
use App\Models\UserCvFile;
use App\Helpers\FileHelper;
use App\Repository\FileRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class UploadCvService
{
    private $fileRepository;

    public function __construct(FileRepository $fileRepository) {
        $this->fileRepository = $fileRepository;
    }
    
    /**
     * Create Or Update CV 
     * Handles old CV deletion if exists
     * 
     * @param mixed $request Request instance with CV file
     * @param UserCvFile $userCvFile to update
     * @return UserCvFile
     * @throws \Exception When no CV provided or upload fails
     */
    public function uploadCVOnly(array $data, $request, string $lang): UserCvFile
    {
        $userId = auth()->id();
        $lang = $data['lang'];
        
        // ✅ Query existing record to get old CV ID
        $existingUserCv = UserCvFile::where('user_id', $userId)
                                  ->where('lang', $lang)
                                  ->first();

        $oldCvId = $existingUserCv?->cv_id;

        // Check is request has file
        if (!$request->hasFile('cv')) {
            throw new Exception('No CV file provided');
        }

        try {
            DB::beginTransaction();

            // Store old CV id
            $newFileId = $request->hasFile('cv')
                ? $this->handleFileUpload($request->file('cv'), 'file/cvs/' . $lang)
                : $oldCvId;

            // Update user Cv File cv_id with new Cv id
                $userCv = UserCvFile::updateOrCreate(
                    [
                        'user_id' => $userId,
                        'lang' => $lang
                    ], 
                    [
                        'cv_id' => $newFileId  // Update cv_id with new file
                    ]
                );
            
            DB::commit();
            
            // Cleanup old cv if replaced
            if ($request->hasFile('cv') && $oldCvId && $oldCvId != $newFileId) {
                $this->deleteOldFile($oldCvId);
            }

            return $userCv->fresh();

        } catch (\Throwable $th) {
            DB::rollBack();
            
            Log::error('Failed to upload CV: ' . $th->getMessage());

            throw new Exception('Failed to upload CV: ' . $th->getMessage());
        }
    }

    public function handleDeleteCv($request, $userCvFile)
    {
        try {
            DB::beginTransaction();

            $oldCvId = $userCvFile->cv_id;

            if ($oldCvId) {
                $this->deleteOldFile($oldCvId);
            }

            $userCvFile->delete();

            DB::commit();

            return $userCvFile->fresh();

        } catch (\Throwable $th) {
            DB::rollBack();
            
            Log::error('Failed to delete CV: ' . $th->getMessage());

            throw new Exception('Failed to delete CV: ' . $th->getMessage());
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
            // Check fileId
            if (!empty($fileId)) {
                $oldFile = $this->fileRepository->findById($fileId);
            }
            
            if ($oldFile->id) {
                // Store path on variable
                $oldFilePath = $oldFile->directory;
            }

            if (isset($oldFilePath)) {
                // Delete from storage
                Storage::delete($oldFilePath);
            }

            // Delete from database
            $this->fileRepository->delete($fileId);

            Log::info('Old file successfully deleted.');

        } catch (\Throwable $th) {

            Log::error('Old file failed to delete:' . $th->getMessage());
            throw new Exception('Old file failed to delete:' . $th->getMessage());
        }
    }
}