<?php

namespace App\Repository;

use App\Models\Certification;

class CertificationRepository
{
    private $certification;

    public function __construct(Certification $certification) {
        $this->certification = $certification;
    }

    public function findByColumn($value, $column)
    {
        $this->certification->where($column, $value)->first();
    }

    public function save(Certification $certification)
    {
        $certification->save();
        return $certification;
    }
}