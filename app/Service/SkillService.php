<?php

namespace App\Service;

use Exception;
use App\Models\Skill;
use Illuminate\Support\Facades\DB;
use App\Repository\SkillRepository;
use Illuminate\Support\Facades\Log;

class SkillService
{
    private $skillRepository;

    public function __construct(SkillRepository $skillRepository) {
        $this->skillRepository = $skillRepository;
    }

    public function handleSkill(array $data, $request, $categorySkill)
    {
        try {
            DB::beginTransaction();
            $skillData = [
                'user_id' => auth()->id(),
                'skill_name' => $data['skill_name'],
                'category_skill_id' => $categorySkill->id
            ];

            $skill = new Skill($skillData);
            $skill = $this->skillRepository->save($skill);

            DB::commit();
            Log::info('New Skill successfully created.');

            return $skill;
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error('Failed to create data.' . $th->getMessage());
            throw new Exception('Failed to create data:' . $th->getMessage());
        }
    }

    public function handleDeleteSkill($categorySkill)
    {
        try {
            DB::beginTransaction();

            $categorySkill->delete();

            DB::commit();
            Log::info('New Skill successfully deleted.');

            return $categorySkill;
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error('Failed to delete data.' . $th->getMessage());
            throw new Exception('Failed to delete data:' . $th->getMessage());
        }
    }
}