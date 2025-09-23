@extends('layouts.admin-app')

@section('title', 'Admin Dashboard - Experience Detail')
@section('content')

    <div class="content">
        <div class="container flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Index /</span> Experience Detail</h4>

            {{-- include message alert --}}
            @include('components._messages')

            <!-- Basic Bootstrap Table -->

            <div class="card-header d-flex justify-content-end align-items-center">
                <a href="{{ route('admin.experience.add-translation', $experience) }}" class="btn btn-primary">Add Job Description</a>
            </div>

            <div class="card">
                
                <h5 class="card-header">Experience Detail</h5>
                
                <div class="card-body">
                   @if ($experience->experienceTranslations())
                    @foreach ($experience->experienceTranslations as $translation)
                        <div class="language-section mb-4">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="mb-0">Language/Locale : {{ $translation->lang }}</h6>
                                <a href="{{ route('admin.experience.edit-translation', [$experience->id, $translation->id]) }}" 
                                class="btn btn-outline-primary btn-sm">
                                    <i class="bx bx-edit me-1"></i>Edit
                                </a>
                            </div>
                            <div class="job-description">
                                Job Description : 
                                <div class="mt-2">
                                    {!! $translation->job_description !!}
                                </div>
                            </div>
                        </div>
                    @endforeach
                   @endif
                    <div class="cta-buttons">
                        <div class="d-flex justify-content-between p-0 gap-3">
                            <button type="submit" class="btn btn-primary mb-3" onclick="history.back()">Back</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection