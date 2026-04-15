<?php

use App\Http\Controllers\Admin\CertificationController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EducationController;
use App\Http\Controllers\Admin\ExperienceController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\Admin\SkillController;
use App\Http\Controllers\Admin\UploadCvController;
use App\Http\Controllers\Admin\UserProfileController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/lang/{lang}', [HomeController::class, 'switchLang'])->name('lang.switch');
Route::get('/download-cv', [HomeController::class, 'downloadCV'])->name('download.cv');


Route::prefix('auth')
    ->controller(AuthController::class)
    ->group(function () {
        Route::get('login', 'login')->name('login')->middleware('throttle: 5,1');
        Route::post('login', 'loginProcess')->name('login.process');
        Route::post('logout', 'logout')->name('logout')->middleware('is_admin');
    }
);


Route::prefix('admin')
    ->name('admin.')
    ->middleware('is_admin')
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // User Profile
        Route::prefix('user-profiles')
            ->name('user-profile.')
            ->controller(UserProfileController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/{userProfile}/detail', 'show')->name('show');
                Route::get('/{userProfile}/edit', 'edit')->name('edit');
                Route::patch('/{userProfile}/update', 'update')->name('update');

                // Upload Image
                Route::get('/upload-image/{userProfile}', 'imageForm')->name('image-form');
                Route::patch('/upload-image/{userProfile}', 'uploadImage')->name('upload-image');

                // Bio and Full Bio
                Route::get('/{userProfile}/create-bio', 'createBio')->name('bio-form');
                Route::post('/{userProfile}/store-bio', 'storeBio')->name('store-bio');
                Route::get('/{userProfile}/edit-bio/{translation}', 'editBio')->name('edit-bio-form');
                Route::patch('/{userProfile}/update-bio/{translation}', 'updateBio')->name('update-bio');
                Route::delete('/{translation}/delete', 'deleteBio')->name('delete-bio');
            }
        );

        // Upload CV
        Route::prefix('upload-cvs')
            ->name('upload-cv.')
            ->controller(UploadCvController::class)
            ->group(function () {
                Route::get('/upload-cv', 'cvForm')->name('cv-form');
                Route::post('/upload-cv', 'uploadedCV')->name('uploaded-cv');
                Route::delete('{userCvFile}/delete', 'deleteCv')->name('deleted');
            });
        
        // Certificate
        Route::prefix('certificates')
            ->name('certificate.')
            ->controller(CertificationController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/{certificate}/edit', 'edit')->name('edit');
                Route::patch('/{certificate}/update', 'update')->name('update');
                Route::delete('/{certificate}/delete', 'destroy')->name('destroy');
            }
        );
        
        // Experience
        Route::prefix('experiences')
            ->name('experience.')
            ->controller(ExperienceController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::get('/{experience}/detail', 'show')->name('show');
                Route::post('/store', 'store')->name('store');
                Route::get('/{experience}/edit', 'edit')->name('edit');
                Route::patch('/{experience}/update', 'update')->name('update');
                Route::delete('/{experience}/delete', 'destroy')->name('destroy');

                // Routes translation
                Route::get('/{experience}/add-translation', 'addTranslation')
                    ->name('add-translation');
                Route::post('/{experience}/translations', 'storeTranslation')
                    ->name('store-translation');
                Route::get('/{experience}/edit-translations/{translation}', 'editTranslation')
                    ->name('edit-translation');
            }
        );

        // Project
        Route::prefix('projects')
            ->name('project.')
            ->controller(ProjectController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::get('/{project}/detail', 'show')->name('show');
                Route::post('/store', 'store')->name('store');
                Route::get('/{project}/edit', 'edit')->name('edit');
                Route::patch('/{project}/update', 'update')->name('update');
                Route::delete('/{project}/delete', 'destroy')->name('destroy');
            }
        );

        //Education
        Route::prefix('educations')
            ->name('education.')
            ->controller(EducationController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/{education}/edit', 'edit')->name('edit');
                Route::patch('/{education}/update', 'update')->name('update');
                Route::delete('/{education}/delete', 'destroy')->name('destroy');
            }
        );
        
        // Skill
        Route::prefix('skills')
            ->name('skill.')
            ->controller(SkillController::class)
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create/{categorySkill}', 'create')->name('create');
                Route::post('/store/{categorySkill}', 'store')->name('store');
                Route::get('/{skill}/edit', 'edit')->name('edit');
                Route::get('/{categorySkill}/detail', 'show')->name('show');
                Route::patch('/{skill}/update', 'update')->name('update');
                Route::delete('/{skill}/delete', 'destroy')->name('destroy');
            }
        );
    }
);