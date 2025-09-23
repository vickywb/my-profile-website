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

    public function handleExperience(array $data, $request)
    {
        try {
            DB::beginTransaction();
            
            $experienceData = [
                'user_id' => auth()->id(),
                'company_name' => $data['company_name'],
                'position' =>  $data['position'],
                'location' => $data['location'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date']
            ];

            $experience = new Experience($experienceData);
            $experience = $this->experienceRepository->save($experience);

            DB::commit();

            Log::info('New Experience successfully created.');
            return $experience;
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error('Faild to create data:' . $th->getMessage());
            throw new Exception('Failed to create data:' . $th->getMessage());
        }
    }

    public function handleUpdateExperience(array $data, $request, $experience)
    {
        try {
            DB::beginTransaction();
            
            $experienceData = [
                'user_id' => auth()->id(),
                'company_name' => $data['company_name'],
                'position' =>  $data['position'],
                'location' => $data['location'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date']
            ];

            $experience = $experience->fill($experienceData);
            $experience = $this->experienceRepository->save($experience);

            DB::commit();

            Log::info('Experience successfully updated.');
            return $experience;
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error('Faild to update data:' . $th->getMessage());
            throw new Exception('Failed to update data:' . $th->getMessage());
        }
    }

    public function handleDeleteExperience($experience)
    {
        try {
            DB::beginTransaction();
            
            $experience->delete();

            DB::commit();

            Log::info('Experience successfully delete.');
            return $experience;
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error('Faild to delete data:' . $th->getMessage());
            throw new Exception('Failed to delete data:' . $th->getMessage());
        }
    }

    public function handleUpdateOrCreateJobDescription(array $data, $request, $experience)
    {
        try {
            DB::beginTransaction();
            
            // updateOrCreate - if lang exists = update, if not exists = create
            $storeJobDescription = ExperienceTranslation::updateOrCreate(
                [
                    'experience_id' => $experience->id,
                    'lang' => $data['lang'],
                ],
                [
                    'job_description' =>  $data['job_description']
                ]
            );

            DB::commit();

            Log::info('Job Description successfully update.');
            
            return $storeJobDescription;

        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error('Faild to update data:' . $th->getMessage());
            throw new Exception('Failed to update data:' . $th->getMessage());
        }
    }
}