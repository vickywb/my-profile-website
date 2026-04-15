<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Lang;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExperienceStoreRequest;
use App\Http\Requests\ExperienceUpdateRequest;
use App\Models\Experience;
use App\Models\ExperienceTranslation;
use App\Service\ExperienceService;
use Illuminate\Http\Request;

class ExperienceController extends Controller
{
    private $experienceService;

    public function __construct(ExperienceService $experienceService) {
        $this->experienceService = $experienceService;
    }

    public function index()
    {
        $experiences = Experience::with('user')->get();

        return view('backend.experiences.index', [
            'experiences' => $experiences
        ]);
    }

    public function create()
    {
        return view('backend.experiences.create');
    }

    public function store(ExperienceStoreRequest $request)
    {
        $data = $request->validated();

        $this->experienceService->handleExperience($data, $request);

        return to_route('admin.experience.index')->with([
            'success' => 'New Experience successfully created.'
        ]);
    }

    public function show(Experience $experience)
    {
        return view('backend.experiences.detail', [
            'experience' => $experience
        ]);
    }

    public function edit(Experience $experience)
    {
        return view('backend.experiences.edit', [
            'experience' => $experience
        ]);
    }

    public function update(ExperienceUpdateRequest $request, Experience $experience)
    {
        $data = $request->validated();

        $this->experienceService->handleUpdateExperience($data, $experience);

        return to_route('admin.experience.index')->with([
            'success' => 'Experience successfully updated.'
        ]);
    }

    public function destroy(Experience $experience)
    {
        $experience = $this->experienceService->handleDeleteExperience($experience);

        return to_route('admin.experience.index')->with([
            'success' => 'Experience successfully deleted.'
        ]);
    }

    public function addTranslation(Experience $experience)
    {
        $languages = Lang::cases();

        return view('backend.experiences.create-description', [
            'experience' => $experience,
            'languages' => $languages
        ]);
    }

    public function editTranslation(Experience $experience, ExperienceTranslation $translation)
    {
        $translation = ExperienceTranslation::where('experience_id', $experience->id)
                                        ->where('lang', $translation->lang)
                                        ->firstOrFail();
        
        $languages = Lang::cases();
        return view('backend.experiences.edit-description', [
            'experience' => $experience,
            'translation' => $translation,
            'languages' => $languages,
        ]);
    }

    public function storeTranslation(Request $request, Experience $experience)
    {
        $request->validate([
            'lang' => 'required|string',
            'job_description' => 'required|string'
        ]);

        $data = $request->only([
            'lang', 'job_description'
        ]);

        $this->experienceService->handleUpdateOrCreateJobDescription($data, $experience);

        return to_route('admin.experience.show', $experience)->with([
            'success' => 'Job Description Experience successfully updated.'
        ]);
    }
}
