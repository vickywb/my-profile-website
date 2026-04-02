<?php

namespace App\Service;

use Exception;
use App\Models\UserCvFile;
use App\Service\FileService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CvsService
{
    public function __construct(
        private FileService $fileService
    ) {}

    /**
     * Create or Update CV
     * Handles old CV deletion if exists
     *
     * @param array $data
     * @param UploadedFile $cv
     * @return UserCvFile
     * @throws Exception
     */
    public function uploadCvOnly(array $data, UploadedFile $cv): UserCvFile
    {
        $userId = auth()->id();
        $lang   = $data['lang'];

        $existingUserCv = UserCvFile::where('user_id', $userId)
            ->where('lang', $lang)
            ->first();

        $oldCvId = $existingUserCv?->cv_id;

        try {
            $result = DB::transaction(function () use ($cv, $lang, $userId) {
                $newFile = $this->fileService->handleUploadAndSave($cv, 'file/cvs/' . $lang);

                $userCv = UserCvFile::updateOrCreate(
                    ['user_id' => $userId, 'lang' => $lang],
                    ['cv_id'   => $newFile->id]
                );

                return [
                    'file'   => $newFile,
                    'userCv' => $userCv
                ];
            });

            if ($oldCvId && $oldCvId !== $result['file']->id) {
                $this->fileService->deleteFile($oldCvId);
            }

            Log::info('CV uploaded successfully.', [
                'user_id'   => $userId,
                'lang'      => $lang,
                'old_cv_id' => $oldCvId,
                'new_cv_id' => $result['file']->id,
            ]);

            return $result['userCv'];

        } catch (\Throwable $th) {
            Log::error('Failed to upload CV: ' . $th->getMessage(), [
                'user_id' => $userId,
                'lang'    => $lang,
            ]);

            throw new Exception('Failed to upload CV: ' . $th->getMessage());
        }
    }

    public function handleDeleteCv(UserCvFile $userCvFile): void
    {
        $oldCvId = $userCvFile->cv_id;

        try {
            DB::transaction(function () use ($userCvFile) {
                $userCvFile->delete(); // hapus UserCvFile record
            });

            // Hapus file setelah commit ✅ storage + file record DB
            if ($oldCvId) {
                $this->fileService->deleteFile($oldCvId);
            }

            Log::info('CV deleted successfully.', [
                'user_id' => $userCvFile->user_id,
                'cv_id'   => $oldCvId,
            ]);

        } catch (\Throwable $th) {
            Log::error('Failed to delete CV: ' . $th->getMessage(), [
                'user_id' => $userCvFile->user_id,
                'cv_id'   => $oldCvId,
            ]);

            throw new Exception('Failed to delete CV: ' . $th->getMessage());
        }
    }
}