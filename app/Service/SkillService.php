<?php

namespace App\Service;

use App\Models\CategorySkill;
use Exception;
use App\Models\Skill;
use Illuminate\Support\Facades\DB;
use App\Repository\SkillRepository;
use Illuminate\Support\Facades\Log;

class SkillService
{
    public function __construct(private SkillRepository $skillRepository) {}

    public function handleCreateSkill(array $data, CategorySkill $categorySkill): Skill
    {
        try {
           $skill = DB::transaction(function () use ($data, $categorySkill) {
                return $this->skillRepository->save(new Skill([
                    'user_id' => auth()->id(),
                    'skill_name' => $data['skill_name'],
                    'category_skill_id' => $categorySkill->id
                ]));
            });

            Log::info('New Skill successfully created.', [
                'skill_id'   => $skill->id,
                'skill_name' => $skill->skill_name,
            ]);

            return $skill;

        } catch (\Throwable $th) {
            Log::error('Failed to create data.' . $th->getMessage());
            throw new Exception('Failed to create data:' . $th->getMessage());
        }
    }

    public function handleUpdateSkill(array $data, Skill $skill): Skill
    {
        try {
            $skill = DB::transaction(function () use ($data, $skill) {
                $skill->fill($data);
                return $this->skillRepository->save($skill);
            });

            Log::info('Skill successfully updated.', [
                'skill_id' => $skill->id,
                'skill_name' => $skill->skill_name,
            ]);

            return $skill;
        } catch (\Throwable $th) {
            Log::error('Failed to update skill.' . $th->getMessage());
            throw new Exception('Failed to update data:' . $th->getMessage());
        }
    }

    public function handleDeleteSkill(CategorySkill $categorySkill): void
    {
        try {
            DB::transaction(function () use ($categorySkill) {
                $categorySkill->delete();
            });

            Log::info('New Skill successfully deleted.');

        } catch (\Throwable $th) {
            Log::error('Failed to delete data.' . $th->getMessage());
            throw new Exception('Failed to delete data:' . $th->getMessage());
        }
    }
}