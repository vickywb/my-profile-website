<?php

namespace App\Repository;

use App\Models\Skill;

class SkillRepository
{
    private $skill;

    public function __construct(Skill $skill) {
        $this->skill = $skill;
    }

    public function save(Skill $skill)
    {
        $skill->save();
        return $skill;
    }
}