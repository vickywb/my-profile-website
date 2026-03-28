<?php

namespace App\Repository;

use App\Models\Certification;

class CertificationRepository
{
    public function __construct(private Certification $certification) {}

    public function findByColumn($value, $column)
    {
        $this->certification->where($column, $value)->first();
    }

    public function save(Certification $certification)
    {
        $certification->save();
        return $certification->fresh();
    }
}