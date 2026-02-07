<?php

namespace App\Service;

use Exception;
use App\Helpers\FileHelper;
use App\Models\Certification;
use App\Repository\FileRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Repository\CertificationRepository;

/**
 * Handle business logic for Certificate operations
 */
class CertificateService
{
    private $certificationRepository, $fileRepository;

    /**
     * CertificateService constructor
     * 
     * @param CertificationRepository $certificationRepository
     * @param FileRepository $fileRepository
     */
    public function __construct(
        CertificationRepository $certificationRepository,
        FileRepository $fileRepository
    ) {
        $this->certificationRepository = $certificationRepository;
        $this->fileRepository = $fileRepository;
    }

    /**
     * Create new certificate with optional image upload
     * 
     * @param array $data Request data
     * @param mixed $request Request instance with file
     * @return Certification
     * @throws \Exception When certificate creation fails
     */
    public function handleCertificate(array $data, $request)
    {
        try {
            DB::beginTransaction();

            // check is request has file
            $certificateImageId = $request->hasFile('image')
                ? $this->handleFileUpload($request->file('image'), 'file/certificate')
                : null;

            $certificationData = [
                'user_id'              => auth()->id(),
                'cert_name'            => $data['cert_name'],
                'issuing_organization' => $data['issuing_organization'],
                'issue_date'           => $data['issue_date'],
                'expired_date'         => $data['expired_date'],
                'file_id'                => $certificateImageId,
            ];

            $certificate = new Certification($certificationData);
            $certificate = $this->certificationRepository->save($certificate);

            DB::commit();

            Log::info('New Certification successfully created.');

            return $certificate;
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error('Failed to create data:' . $th->getMessage());

            throw new Exception('Failed to create data:' . $th->getMessage());
        }
    }

    /**
     * Update existing certificate and handle image replacement
     * 
     * @param array $data Request data
     * @param mixed $request Request instance with file
     * @param Certification $certificate Certificate model instance
     * @return Certification
     * @throws \Exception When certificate update fails
     */
    public function handleUpdateCertificate(array $data, $request, $certificate)
    {
        try {
            DB::beginTransaction();

            // Handle image replacement
            $oldCertificateImageId = $certificate->file_id;
            $certificateImageId = $request->hasFile('image')
                ? $this->handleFileUpload($request->file('image'), 'file/certificate')
                : $oldCertificateImageId;

            $certificationData = [
                'user_id'              => auth()->id(),
                'cert_name'            => $data['cert_name'],
                'issuing_organization' => $data['issuing_organization'],
                'issue_date'           => $data['issue_date'],
                'expired_date'         => $data['expired_date'],
                'file_id'              => $certificateImageId,
            ];

            $certificate = $certificate->fill($certificationData);
            $certificate = $this->certificationRepository->save($certificate);

            DB::commit();

            // Cleanup old image if replaced
            if ($request->hasFile('image') && $oldCertificateImageId && $oldCertificateImageId != $certificateImageId) {
                $this->deleteOldFile($oldCertificateImageId);
            }

            Log::info('Certification successfully updated.');

            return $certificate;
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error('Failed to update data:' . $th->getMessage());

            throw new Exception('Failed to update data:' . $th->getMessage());
        }
    }

    /**
     * Delete certificate and its associated image
     * 
     * @param Certification $certificate Certificate to delete
     * @return Certification
     * @throws \Exception When certificate deletion fails
     */
    public function handleDeleteCertificate($certificate)
    {
        try {
            DB::beginTransaction();
            $oldCertificateImageId = $certificate->file_id;

            $certificate->delete();

            DB::commit();

            if ($oldCertificateImageId) {
                $this->deleteOldFile($oldCertificateImageId);
            }

            Log::info('Certification successfully deleted.');

            return $certificate;
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error('Failed to delete data:' . $th->getMessage());

            throw new Exception('Failed to delete data:' . $th->getMessage());
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