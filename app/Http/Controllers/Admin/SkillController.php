<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\SkillStoreRequest;
use App\Http\Requests\SkillUpdateRequest;
use App\Models\Skill;
use Illuminate\Http\Request;
use App\Models\CategorySkill;
use App\Service\SkillService;

class SkillController
{
    public function __construct(private SkillService $skillService) {}

    public function index()
    {
        $categorySkills = CategorySkill::with('skills')->get();
        return view('backend.skills.index', [
            'categorySkills' => $categorySkills
        ]);
    }

    public function create(CategorySkill $categorySkill)
    {
        return view('backend.skills.create', [
            'categorySkill' => $categorySkill
        ]);
    }

    public function store(SkillStoreRequest $request, CategorySkill $categorySkill)
    {
        $this->skillService->handleCreateSkill($request->validated(), $categorySkill);

        return to_route('admin.skill.index')->with([
            'success' => 'New Skill successfully created.'
        ]);
    }

    public function edit(Skill $skill)
    {
        $categories = CategorySkill::all();

        return view('backend.skills.edit', [
            'skill' => $skill,
            'categories' => $categories,
        ]);
    }

    public function update(SkillUpdateRequest $request, Skill $skill)
    {
        $this->skillService->handleUpdateSkill($request->validated(), $skill);

        return to_route('admin.skill.show', $skill->categorySkill)->with([
            'success' => 'Skill successfully updated.'
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
        $this->skillService->handleDeleteSkill($categorySkill);

        return to_route('admin.skill.index')->with([
            'success' => 'Category Skill successfully deleted.'
        ]);
    }
}
