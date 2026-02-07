<?php

namespace App\Helpers;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Laravel\Facades\Image;

class FileHelper
{
    public static function uploadFileToStorage(UploadedFile $file, string $directory): array
    {
        // Ganti ekstensi menjadi .webp secara paksa
        $filename = Str::random(20) . '.webp';
        $path = $directory . '/' . $filename;

        // Proses konversi ke webp
        $encodedImage = Image::read($file)->toWebp(80);

        // Simpan hasil konversi ke Storage public
        Storage::disk('public')->put($path, (string) $encodedImage);

        // Return data
        return [
            'directory' => $path,
            'file_url'  => asset('storage/' . $path)
        ];
    }
}