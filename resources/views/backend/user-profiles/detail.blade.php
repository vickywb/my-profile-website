@extends('layouts.admin-app')

@section('title', 'Admin Dashboard - User Profile Detail')
@section('content')

    <div class="content">
        <div class="container flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Index /</span> Detail User Profile</h4>

            {{-- include message alert --}}
            @include('components._messages')

            <div class="card info-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">User Profile Detail</h5>
                    
                    <a href="{{ route('admin.user-profile.edit', $userProfile) }}" class="btn btn-primary btn-sm"><i class="fas fa-edit me-1"></i>Edit Profile</a>  
                </div>
                <div class="card-body">
                    <div class="row">
                        <!-- Personal Info -->
                        <div class="col-md-8">
                            <div class="info-item">
                                <span class="info-label">Phone Number:</span>
                                <span>{{ $userProfile->phone_number ?? '-' }}</span>
                            </div>
                            <div class="info-item">
                                <span class="info-label">Address:</span>
                                <span>{{ $userProfile->address ?? '-' }}</span>
                            </div>
                        </div>
                        
                        <!-- Profile Image -->
                        <div class="col-md-4">
                            <div class="text-end">
                                <h6>Profile Image:</h6>
                                <div class="d-flex flex-column align-items-end mb-3">
                                    @if($userProfile->profileImage)
                                    <img src="{{ asset($userProfile->profileImage->file_url ?? asset('backend/img/avatars/1.png')) }}" 
                                        class="img-thumbnail mb-2" style="width: 150px; height: 150px; object-fit: cover;">
                                    @else
                                        <p class="text-muted">No image uploaded</p>
                                    @endif
                                </div>
                                <a href="{{ route('admin.user-profile.upload-image', $userProfile) }}" class="btn btn-primary btn-sm">Upload Image</a>  
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CV Files Card -->
            <div class="card info-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">CV Documents</h5>
                    <a href="{{ route('admin.upload-cv.cv-form') }}" class="btn btn-primary btn-sm">Create CV</a>  
                </div>
                <div class="card-body">
                    @if ($userProfile->user->userCvFiles)
                        @foreach ($userProfile->user->userCvFiles as $cv)
                        <div class="cv-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <span class="language-tag">{{ $cv->lang }}</span>
                                    <strong class="ms-2">{{ $cv->cvFile->name }}</strong>
                                </div>
                                <div class="btn-group" role="group">
                                <a href="{{ asset($cv->cvFile->file_url) }}" target="_blank" 
                                class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-eye me-1"></i>View
                                </a>
                                <form method="POST" action="{{ route('admin.upload-cv.deleted', $cv) }}" 
                                    class="d-inline px-1" onsubmit="return confirm('Are you sure you want to delete this CV?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm">
                                        <i class="fas fa-trash me-1"></i>Delete
                                    </button>
                                </form>
                            </div>
                            </div>
                        </div>
                        @endforeach
                    @endif
                </div>
            </div>

            <!-- Bio Card -->
            <div class="card info-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Bio Information</h5>
                    <a href="{{ route('admin.user-profile.bio-form') }}" class="btn btn-primary btn-sm">Create Bio</a>
                </div>
                <div class="card-body">
                    <!-- English Version -->
                    @if ($userProfile->userProfileTranslations)
                        @foreach ($userProfile->userProfileTranslations as $translation)
                            <div class="language-section mb-4">

                                <div class="d-flex justify-content-between align-items-center mb-2 py-1">
                                    <h6 class="mb-0"><span class="language-tag">{{ $translation->lang ?? '-' }}</span></h6>
                                     <div class="btn-group" role="group">
                                        <a href="{{ route('admin.user-profile.edit-bio-form', [$userProfile, $translation]) }}" class="btn btn-outline-primary btn-sm">
                                            <i class="fas fa-eye me-1"></i>Edit
                                        </a>
                                        <form method="POST" action="{{ route('admin.user-profile.delete-bio', $translation) }}" 
                                            class="d-inline px-1" onsubmit="return confirm('Are you sure you want to delete this CV?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                                <i class="fas fa-trash me-1"></i>Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>

                                <div class="info-item">
                                    <span class="info-label">Bio:</span>
                                    <span>{!! $translation->bio ?? '-' !!}</span>

                                <div class="info-item">
                                    <span class="info-label">Full Bio:</span>
                                    <span>{!! $translation->full_bio ?? '-' !!}</span>
                                </div>
                            </div>
                        @endforeach
                    @endif
                    
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-primary" onclick="history.back()">
                    <i class="fas fa-arrow-left me-1"></i>Back
                </button>
            </div>
        </div>
    </div>
@endsection