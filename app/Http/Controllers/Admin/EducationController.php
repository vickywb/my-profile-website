<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\EducationStoreRequest;
use App\Http\Requests\EducationUpdateRequest;
use App\Models\Education;
use App\Service\EducationService;

class EducationController
{
    public function __construct(
        private EducationService $educationService
    ){}
    
    public function index()
    {
        $educations = Education::with('user')->get();

        return view('backend.educations.index', [
            'educations' => $educations
        ]);
    }

    public function create()
    {
        return view('backend.educations.create');
    }

    public function store(EducationStoreRequest $request)
    {
        $this->educationService->handleEducation($request->validated());

        return to_route('admin.education.index')->with('success', 'Education created successfully');

    }

    public function edit(Education $education)
    {
        return view('backend.educations.edit', [
            'education' => $education
        ]);
    }

    public function update(EducationUpdateRequest $request, Education $education)
    {
        $this->educationService->handleUpdateEducation($education, $request->validated());

        return to_route('admin.education.index')->with('success', 'Education updated successfully');
    }

    public function destroy(Education $education)
    {
        $this->educationService->handleDeleteEducation($education);

        return to_route('admin.education.index')->with('success', 'Education deleted successfully');
    }
}
