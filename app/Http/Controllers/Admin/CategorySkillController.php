<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\CategorySkill;

class CategorySkillController
{
    public function index()
    {
        $categorySkills = CategorySkill::with('skills')->get();
        return view('backend.skills.index', [
            'categorySkills' => $categorySkills
        ]);
    }
}
