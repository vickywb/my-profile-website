<?php

namespace App\Service;

use Exception;
use App\Models\Project;
use App\Helpers\FileHelper;
use App\Repository\FileRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Repository\ProjectRepository;
use Illuminate\Support\Facades\Storage;

/**
 * Class ProjectService
 * Handle business logic for Project operations
 */
class ProjectService
{
    private $projectRepository, $fileRepository;

    /**
     * ProjectService constructor
     * 
     * @param ProjectRepository $projectRepository
     * @param FileRepository $fileRepository
     */
    public function __construct(
        ProjectRepository $projectRepository,
        FileRepository $fileRepository
    ) {
        $this->projectRepository = $projectRepository;
        $this->fileRepository = $fileRepository; 
    }

    /**
     * Handle project creation with file upload
     * 
     * @param array $data Request data
     * @param mixed $request Request instance
     * @return Project
     * @throws \Exception When project creation fails
     */
    public function handleProject(array $data, $request)
    {
        try {
            DB::beginTransaction();

            // Handle image replacement or null
            $projectImageId = $request->hasFile('image') 
                ? $this->handleFileUpload($request->file('image'), 'file/project')
                : null;

            $projectData = [
                'project_title' => $data['project_title'],
                'description' => $data['description'],
                'github_url' => $data['github_url'],
                'file_id' => $projectImageId
            ];

            $project = new Project($projectData);
            $project = $this->projectRepository->save($project);

            DB::commit();

            Log::info('New Project successfully created.');
            return $project;
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error('Failed to create project.');
            throw new Exception('Failed to create project.');
        }
    }

    /**
     * Handle project update with file upload
     * 
     * @param array $data Request data
     * @param mixed $request Request instance
     * @param Project $project Project model instance
     * @return Project
     * @throws \Exception When project update fails
     */
    public function handleProjectUpdate(array $data, $request, $project)
    {
        try {
            DB::beginTransaction();

            // Handle image replacement
            $oldProjectImageId = $project->file_id;
            $projectImageId = $request->hasFile('image') 
                ? $this->handleFileUpload($request->file('image'), 'file/project')
                : $oldProjectImageId;
            
            $projectData = [
                'user_id' => auth()->id(),
                'project_title' => $data['project_title'],
                'description' => $data['description'],
                'github_url' => $data['github_url'],
                'file_id' => $projectImageId
            ];

            $project = $project->fill($projectData);
            $project = $this->projectRepository->save($project);

            DB::commit();

            // Cleanup old image if replaced
            if ($request->hasFile('image') && $oldProjectImageId && $oldProjectImageId !== $projectImageId) {
                $this->deleteOldFile($oldProjectImageId);
            }

            Log::info('Project successfully updated.');
            return $project;
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error('Failed to update project:' . $th->getMessage());
            throw new Exception('Failed to update project:' . $th->getMessage());
        }
    }

    /**
     * Delete project and its associated image
     * 
     * @param Project $project Project to delete
     * @return Project
     * @throws \Exception When project deletion fails
     */
    public function handleDeleteProject($project)
    {
        try {
            DB::beginTransaction();
            $oldProjectImageId = $project->file_id;

            $project->delete();

            DB::commit();

            if ($oldProjectImageId) {
                $this->deleteOldFile($oldProjectImageId);
            }

            Log::info('Project successfully deleted.');

            return $project;
        } catch (\Throwable $th) {
            DB::rollBack();

            Log::error('Failed to delete data:' . $th->getMessage());

            throw new Exception('Failed to delete data:' . $th->getMessage());
        }
    }
        
    /**
     * Handle file upload and store file data
     * 
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $directory Target directory
     * @return int File ID
     */
    private function handleFileUpload($file, $directory)
    {   
        try {
            // Upload new File using File Helper
            $fileResult = FileHelper::uploadFileToStorage($file, $directory);
            
            // Store to database
            $fileData = [
                'name' => $file->getClientOriginalName(),
                'directory' => $fileResult['directory'],
                'file_url' => $fileResult['file_url'],
            ];
        
            $fileRecord = $this->fileRepository->save($fileData);
        

            return $fileRecord->id;

        } catch (\Throwable $th) {

            Log::error('Failed to upload file:' . $th->getMessage());
            throw new Exception('Failedd to upload file:' . $th->getMessage());
        }
    }
    
    /**
     * Delete file from storage and database
     * Logs warning if deletion fails but doesn't stop process
     * 
     * @param int $fileId File ID to delete
     * @return void
     */
    private function deleteOldFile($fileId)
    {   
        try {
            if (empty($fileId)) {
                return; // Jika tidak ada fileId, langsung return
            }

            $oldFile = $this->fileRepository->findById($fileId);
            
            if (!$oldFile) {
                Log::warning("File with ID {$fileId} not found in database");
                return;
            }

            // Delete from storage
            if ($oldFile->directory && Storage::disk('public')->exists($oldFile->directory)) {
                Storage::disk('public')->delete($oldFile->directory);
            }

            // Delete from database
            $this->fileRepository->delete($fileId);

            Log::info("Old file (ID: {$fileId}) successfully deleted.");

        } catch (\Throwable $th) {
            Log::error('Old file failed to delete: ' . $th->getMessage());
            throw new Exception('Old file failed to delete: ' . $th->getMessage());
        }
    }
}