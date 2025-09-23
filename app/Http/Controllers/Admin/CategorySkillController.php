<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\CategorySkill;
use App\Http\Controllers\Controller;

class CategorySkillController extends Controller
{
    public function index()
    {
        $categorySkills = CategorySkill::with('skills')->get();
        return view('backend.skills.index', [
            'categorySkills' => $categorySkills
        ]);
    }

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
