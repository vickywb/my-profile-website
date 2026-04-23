<?php

namespace App\Service;

use Exception;
use App\Models\Certification;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repository\CertificationRepository;

class CertificateService
{
    public function __construct(
        private CertificationRepository $certificationRepository,
        private FileService $fileService
    ) {}

    public function handleCreateCertificate(array $data, ?UploadedFile $image = null): Certification
    {
        try {
            $certificate = DB::transaction(function () use ($data, $image) {
                $fileId = null;

                if ($image) {
                    $newFile = $this->fileService->handleUploadAndSave($image, 'file/certificate');
                    $fileId  = $newFile->id;
                }

                return $this->certificationRepository->save(new Certification([
                    'user_id' => auth()->id(),
                    'file_id' => $fileId,
                    ...$data,
                ]));
            });

            Log::info('Certification successfully created.', [
                'certification_id' => $certificate->id,
                'user_id'          => auth()->id(),
            ]);

            return $certificate;

        } catch (\Throwable $th) {
            Log::error('Failed to create certification: ' . $th->getMessage(), [
                'user_id' => auth()->id(),
            ]);

            throw new Exception('Failed to create certification: ' . $th->getMessage());
        }
    }

    public function handleUpdateCertificate(array $data, ?UploadedFile $image, Certification $certificate): Certification
    {
        $oldFileId = $certificate->file_id;

        try {
            $certificate = DB::transaction(function () use ($data, $image, $certificate) {
                $fileId = $certificate->file_id;

                if ($image) {
                    $newFile = $this->fileService->handleUploadAndSave($image, 'file/certificate');
                    $fileId  = $newFile->id;
                }

                $certificate->fill([
                    'user_id' => auth()->id(),
                    'file_id' => $fileId,
                    ...$data,
                ]);

                return $this->certificationRepository->save($certificate);
            });

            if ($image && $oldFileId && $oldFileId !== $certificate->file_id) {
                $this->fileService->deleteFile($oldFileId);
            }

            Log::info('Certification successfully updated.', [
                'certification_id' => $certificate->id,
                'old_file_id'      => $oldFileId,
                'new_file_id'      => $certificate->file_id,
            ]);

            return $certificate;

        } catch (\Throwable $th) {
            Log::error('Failed to update certification: ' . $th->getMessage(), [
                'certification_id' => $certificate->id,
            ]);

            throw new Exception('Failed to update certification: ' . $th->getMessage());
        }
    }

    public function handleDeleteCertificate(Certification $certificate): void
    {
        $oldFileId = $certificate->file_id;
        try {
            DB::transaction(function () use ($certificate) {
                $certificate->delete();
            });

            if ($oldFileId) {
                $this->fileService->deleteFile($oldFileId);
            }

            Log::info('Certification successfully deleted.', [
                'certification_id' => $certificate->id,
                'user_id'          => auth()->id(),
            ]);

        } catch (\Throwable $th) {
            Log::error('Failed to delete certification: ' . $th->getMessage(), [
                'certification_id' => $certificate->id,
            ]);

            throw new Exception('Failed to delete certification: ' . $th->getMessage());
        }
    }
}