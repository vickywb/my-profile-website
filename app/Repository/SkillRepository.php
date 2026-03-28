<?php

namespace App\Repository;

use App\Models\Skill;

class SkillRepository
{
    public function __construct(private Skill $skill) {}

    public function save(Skill $skill)
    {
        $skill->save();
        return $skill->fresh();
    }

    public function findByColumn($value, $column)
    {
        return $this->skill->where($column, $value)->first();
    }
}