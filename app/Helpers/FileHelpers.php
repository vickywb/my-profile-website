<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class FileHelpers
{    
    /**
     * Upload file dan convert ke WebP.
     *
     * @param  UploadedFile  $file
     * @param  string  $directory  (e.g., 'profile-photos', 'events', 'documents')
     * @return array
     */
    public static function uploadFile(UploadedFile $file, string $directory): array
    {
        // 1. Dapatkan ekstensi asli file yang diupload
        $extension = strtolower($file->getClientOriginalExtension());
        
        // 2. Tentukan ekstensi apa saja yang dianggap gambar
        $imageExtensions = ['jpg', 'jpeg', 'png', 'webp'];
        $isImage = in_array($extension, $imageExtensions);

        if ($isImage) {
            // PROSES UNTUK GAMBAR (Kode aslimu yang sudah bagus)
            $filename = Str::random(20) . '.webp';
            $path = $directory . '/' . $filename;
            
            $encodedImage = Image::read($file)->toWebp(80);
            Storage::disk('public')->put($path, (string) $encodedImage);
        } else {
            // PROSES UNTUK NON-GAMBAR (Misal: PDF, Word, Excel)
            $filename = Str::random(20) . '.' . $extension;
            
            // Simpan langsung tanpa konversi WebP
            $path = $file->storeAs($directory, $filename, 'public');
        }

        return [
            'directory' => $path,
            'file_url'  => asset('storage/' . $path),
            'name' => $file->getClientOriginalName()
        ];
    }
    
    /**
     * Delete file from storage.
     *
     * @param  string  $path
     * @return bool
     */
    public static function delete(string $path): bool
    {
        return Storage::disk('public')->delete($path);
    }
}