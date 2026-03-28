<?php

namespace App\Repository;

use App\Models\File;

class FileRepository
{
    public function __construct(private File $file) {}

    public function create(array $fileData): File
    {
        return $this->file->create($fileData);
    }

    public function save(File $file): File
    {
        $file->save();
        return $file->fresh();
    }
    
    public function findById(int $id): ?File
    {
        return $this->file->find($id);
    }
    
    public function delete(File $file): bool
    {
        return $file->delete();
    }
}