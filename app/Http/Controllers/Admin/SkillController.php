<?php

namespace App\Http\Controllers\Admin;

use App\Models\Skill;
use Illuminate\Http\Request;
use App\Models\CategorySkill;
use App\Service\SkillService;
use App\Http\Controllers\Controller;

class SkillController extends Controller
{
    public function __construct(private SkillService $skillService) {}

    public function index()
    {
        $categorySkills = CategorySkill::with('skills')->get();
        return view('backend.skills.index', [
            'categorySkills' => $categorySkills
        ]);
    }

    public function create(CategorySkill $categorySkill, Skill $skill)
    {
        return view('backend.skills.create', [
            'categorySkill' => $categorySkill,
            'skill' => $skill
        ]);
    }

    public function store(Request $request, CategorySkill $categorySkill)
    {
        $data = $request->only([
            'category_skill_id', 'skill_name' 
        ]);

        $this->skillService->handleSkill($data, $request, $categorySkill);

        return to_route('admin.skill.index')->with([
            'success' => 'New Skill successfully created.'
        ]);
    }

    public function show(CategorySkill $categorySkill)
    {
        return view('backend.skills.detail', [
            'categorySkill' => $categorySkill
        ]);
    }

    public function destroy(CategorySkill $categorySkill)
    {
        $categorySkill = $this->skillService->handleDeleteSkill($categorySkill);

        return to_route('admin.skill.index')->with([
            'success' => 'Category Skill successfully deleted.'
        ]);
    }
}
