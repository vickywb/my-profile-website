<?php

namespace App\Service;

use App\Models\Education;
use App\Repository\EducationRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EducationService
{
    public function __construct(private EducationRepository $educationRepository) {}

    public function handleEducation(array $data): Education
    {
        try {
            $education = DB::transaction(function () use ($data) {
                $education = new Education([
                    'user_id' => auth()->id(),
                    ...$data  // ✅ spread operator, karena key sama dengan $data
                ]);

                return $this->educationRepository->save($education);
            });

            Log::info('Education created successfully.', [
                'user_id'      => auth()->id(),
                'education_id' => $education->id,
            ]);

            return $education;

        } catch (\Throwable $th) {
            Log::error('Failed to create education: ' . $th->getMessage(), [
                'user_id' => auth()->id(),
            ]);

            throw new Exception('Failed to create education: ' . $th->getMessage());
        }
    }

    public function handleUpdateEducation(Education $education, array $data): Education
    {
        try {
            $updatedEducation = DB::transaction(function () use ($education, $data) {
                $education->fill($data);

                return $this->educationRepository->save($education);
            });

            Log::info('Education updated successfully.', [
                'user_id'      => auth()->id(),
                'education_id' => $education->id,
            ]);

            return $updatedEducation;

        } catch (\Throwable $th) {
            Log::error('Failed to update education: ' . $th->getMessage(), [
                'user_id' => auth()->id(),
                'education_id' => $education->id,
            ]);

            throw new Exception('Failed to update education: ' . $th->getMessage());
        }
    }

    public function handleDeleteEducation(Education $education): bool
    {
        try {
            $result = DB::transaction(function () use ($education) {
                return $this->educationRepository->delete($education);
            });

            Log::info('Education deleted successfully.', [
                'user_id'      => auth()->id(),
                'education_id' => $education->id,
            ]);

            return $result;

        } catch (\Throwable $th) {
            Log::error('Failed to delete education: ' . $th->getMessage(), [
                'user_id' => auth()->id(),
                'education_id' => $education->id,
            ]);

            throw new Exception('Failed to delete education: ' . $th->getMessage());
        }
    }
}