<?php

namespace App\Repository;

use App\Models\File;

class FileRepository
{
    private $file;

    public function __construct(File $file) {
        $this->file = $file;
    }

    public function save($data)
    {
        $file = $this->file->create($data);
        return $file;
    }
    
    public function findById($id)
    {
        return $this->file->find($id);
    }
    
    public function delete($id)
    {
        return $this->file->destroy($id);
    }
}