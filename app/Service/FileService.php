<?php

namespace App\Service;

use App\Helpers\FileHelpers;
use App\Models\File;
use App\Repository\FileRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;

class FileService
{
    public function __construct(private FileRepository $fileRepository){}

    // Upload file to storage
    public function uploadFileToStorage(?UploadedFile $file, string $directory): ?array
    {
        if (!$file) return null;

        return FileHelpers::uploadFile($file, $directory);
    }

    // Save file to Database
    public function saveFileToDatabase(array $fileInfo): File
    {
        return $this->fileRepository->create($fileInfo);
    }

    // Delete file from storage
    public function deleteFileFromStorage(string $filePath): void
    {
        FileHelpers::delete($filePath);
    }

    // Function untuk menghandle upload dan store data ke database, jika gagal file akan dihapus di storage
    public function handleUploadAndSave(UploadedFile $file, string $directory): ?File
    {
        $fileInfo = $this->uploadFileToStorage($file, $directory);

        if (!$fileInfo) return null;

        try {
            $savedFile = $this->saveFileToDatabase($fileInfo);

            Log::info('Success Upload File.');

            return $savedFile;

        } catch (\Throwable $th) {

            $this->deleteFileFromStorage($fileInfo['directory']);

            Log::alert('Failed to save file to DB, storage cleaned up.');

            throw $th;
        }
    }

    // Delete File on databse and storage
    public function deleteFile(int $fileId): bool
    {
        $file = $this->fileRepository->findById($fileId);
        if (!$file) return false;

        try {
            // Hapus fisik dulu
            FileHelpers::delete($file->directory); 
            
            // Hapus DB
            return $this->fileRepository->delete($file); 
        } catch (\Throwable $th) {

            Log::error("Failed to delete file with ID {$fileId}: " . $th->getMessage());
            throw $th;
        }
    }
}