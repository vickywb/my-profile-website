@extends('layouts.admin-app')

@section('title', 'Admin Dashboard - Category Skill Detail')
@section('content')

    <div class="content">
        <div class="container flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Index /</span> Category Skill Detail</h4>

            {{-- include message alert --}}
            @include('components._messages')

            <div class="card-header d-flex justify-content-end align-items-center">
                <a href="{{ route('admin.skill.create', $categorySkill) }}" class="btn btn-primary">Add Skill</a>
            </div>

            <!-- Basic Bootstrap Table -->
            <div class="card">
                <h5 class="card-header">Category Skill Detail</h5>
                
                <div class="card-body">
                    <div class="fw-bold fs-6 pe-2">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <div class="d-flex flex-wrap align-items-center text-gray-900 text-hover-primary me-5 mb-2">
                                    <div class="job-description me-5">
                                        Skill Name :
                                        @foreach ($categorySkill->skills as $item)
                                            <span class="text-gray-700 fs-7 fw-bolder btn btn-sm btn-info">{{ $item->skill_name }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                      <div class="cta-buttons">
                        <div class="justify-content-start p-0">
                        <button type="submit" class="btn btn-primary mb-3" onclick="history.back()">Back</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
@endsection