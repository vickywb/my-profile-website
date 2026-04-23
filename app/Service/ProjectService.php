<?php

namespace App\Service;

use Exception;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repository\ProjectRepository;
use Illuminate\Http\UploadedFile;

class ProjectService
{
    public function __construct(
       private ProjectRepository $projectRepository,
       private FileService $fileService
    ) {}

    public function handleCreateProject(array $data, ?UploadedFile $image = null): Project
    {
        try {
           $project = DB::transaction(function () use ($data, $image) {
                $fileId = null;

                if ($image) {
                    $newFile = $this->fileService->handleUploadAndSave($image, 'file/project');
                    $fileId  = $newFile->id;
                }

                $technologyIds = $data['technologies'] ?? [];
                unset($data['technologies']);

                $project = $this->projectRepository->save(new Project([
                    'user_id' => auth()->id(),
                    'file_id' => $fileId,
                    ...$data
                ]));

                if (!empty($technologyIds)) {
                    $project->technologies()->sync($technologyIds);
                }

                return $project;
           });

            Log::info('New Project successfully created.', [
                'project_id' => $project->id,
                'user_id'    => auth()->id(),
            ]);

            return $project;

        } catch (\Throwable $th) {
            Log::error('Failed to create project: ' . $th->getMessage(), [
                'user_id' => auth()->id(),
            ]);

            throw new Exception('Failed to create project.');
        }
    }

    public function handleProjectUpdate(array $data, ?UploadedFile $image = null, $project): Project
    {
        $oldFileId = $project->file_id;
        try {
            $project = DB::transaction(function () use ($data, $image, $project) {
                $fileId = $project->file_id;

                if ($image) {
                    $newFile = $this->fileService->handleUploadAndSave($image, 'file/project');
                    $fileId  = $newFile->id;
                }

                $technologyIds = $data['technologies'] ?? [];
                unset($data['technologies']);

                $project = $this->projectRepository->save($project->fill([
                    'user_id' => auth()->id(),
                    'file_id' => $fileId,
                    ...$data
                ]));

                $project->technologies()->sync($technologyIds);

                return $project;
            });

            // Cleanup old image if replaced
            if ($image && $oldFileId && $oldFileId !== $project->file_id) {
                $this->fileService->deleteFile($oldFileId);
            }

            Log::info('Project successfully updated.', [
                'project_id' => $project->id,
                'user_id'    => auth()->id(),
            ]);
            
            return $project;

        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error('Failed to update project:' . $th->getMessage());
            throw new Exception('Failed to update project:' . $th->getMessage());
        }
    }

    public function handleDeleteProject(Project $project): void
    {
        $oldFileId = $project->file_id;
        try {
            DB::transaction(function () use ($project) {
                $project->delete();
            });

            if ($oldFileId) {
                $this->fileService->deleteFile($oldFileId);
            }

            Log::info('Project successfully deleted.', [
                'project_id' => $project->id,
                'user_id'    => auth()->id(),
            ]);

        } catch (\Throwable $th) {

            Log::error('Failed to delete data:' . $th->getMessage());

            throw new Exception('Failed to delete data:' . $th->getMessage());
        }
    }
}