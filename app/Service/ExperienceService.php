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
    private $experienceRepository;

    public function __construct(ExperienceRepository $experienceRepository) {
        $this->experienceRepository = $experienceRepository;
    }

    public function handleExperience(array $data): Experience
    {
        try {
            $experience = DB::transaction(function () use ($data) {
                return $this->experienceRepository->save(new Experience($data));

                Log::info('Experience successfully created.', [
                    'experience_id' => $experience->id,
                    'user_id'       => auth()->id(),
                ]);

                return $experience;
            });

        } catch (\Throwable $th) {

            Log::error('Faild to create data:' . $th->getMessage());
            throw new Exception('Failed to create data:' . $th->getMessage());
        }
    }

    public function handleUpdateExperience(array $data, $experience): Experience
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

            Log::error('Faild to update data:' . $th->getMessage());
            throw new Exception('Failed to update data:' . $th->getMessage());
        }
    }

    public function handleDeleteExperience($experience): void
    {
        try {
           $experience = DB::transaction(function () use ($experience) {
                $experience->delete();

                Log::info('Experience successfully delete.');
                return $experience;
            });

        } catch (\Throwable $th) {

            Log::error('Faild to delete data:' . $th->getMessage());
            throw new Exception('Failed to delete data:' . $th->getMessage());
        }
    }

    public function handleUpdateOrCreateJobDescription(array $data, $experience): ExperienceTranslation
    {
        try {
            $experience = DB::transaction(function () use ($data, $experience) {

                return ExperienceTranslation::updateOrCreate(
                    [
                        'experience_id' => $experience->id,
                        'lang' => $data['lang'],
                    ],
                    [
                        'job_description' =>  $data['job_description']
                    ]
                );
                
                Log::info('Job Description successfully update.');
                
                return $experience;
            });

        } catch (\Throwable $th) {

            Log::error('Faild to update data:' . $th->getMessage());
            throw new Exception('Failed to update data:' . $th->getMessage());
        }
    }
}