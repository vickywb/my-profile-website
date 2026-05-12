<?php

namespace App\Service;

use Exception;
use App\Models\Experience;
use App\Models\ExperienceTranslation;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repository\ExperienceRepository;

class ExperienceService
{
    public function __construct(private ExperienceRepository $experienceRepository) {}

    public function handleCreateExperience(array $data): Experience
    {
        try {
            $experience = DB::transaction(function () use ($data) {
                return $this->experienceRepository->save(new Experience($data));
            });

            Log::info('Experience successfully created.', [
                'experience_id' => $experience->id,
                'user_id'       => auth()->id(),
            ]);

            return $experience;

        } catch (\Throwable $th) {
            Log::error('Failed to create data:' . $th->getMessage());
            throw new Exception('Failed to create data:' . $th->getMessage());
        }
    }

    public function handleUpdateExperience(array $data, Experience $experience): Experience
    {
        try {
            $experience = DB::transaction(function () use ($data, $experience) {
                $experience->fill($data);

                return $this->experienceRepository->save($experience);
            });

            Log::info('Experience successfully updated.', [
                'experience_id' => $experience->id,
                'user_id'       => auth()->id(),
            ]);

            return $experience;

        } catch (\Throwable $th) {

            Log::error('Failed to update data:' . $th->getMessage());
            throw new Exception('Failed to update data:' . $th->getMessage());
        }
    }

    public function handleDeleteExperience(Experience $experience): void
    {
        try {
            DB::transaction(function () use ($experience) {
                $experience->delete();
            });

            Log::info('Experience successfully delete.');
        } catch (\Throwable $th) {
            Log::error('Failed to delete data:' . $th->getMessage());
            throw new Exception('Failed to delete data:' . $th->getMessage());
        }
    }

    public function handleUpdateOrCreateJobDescription(array $data, Experience $experience): ExperienceTranslation
    {
        try {
            $translation = DB::transaction(function () use ($data, $experience) {
                return ExperienceTranslation::updateOrCreate(
                    [
                        'experience_id' => $experience->id,
                        'lang'          => $data['lang'],
                    ],
                    [
                        'job_description' => $data['job_description'],
                    ]
                );
            });

            Log::info('Job Description successfully updated.', [
                'experience_id' => $experience->id,
                'lang'          => $data['lang'],
            ]);

            return $translation;
        } catch (\Throwable $th) {
            Log::error('Failed to update data: ' . $th->getMessage());
            throw new Exception('Failed to update data: ' . $th->getMessage()); 
        }
    }
}