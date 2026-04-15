@extends('layouts.admin-app')

@section('title', 'Admin Dashboard - User Profile Detail')

@section('content')
<div class="content">
    <div class="container flex-grow-1 container-p-y">

        {{-- Page Header --}}
        <div class="mb-4">
            <p class="text-muted mb-1" style="font-size: 13px;">Index / User Profile</p>
            <h4 class="fw-semibold mb-0">Detail User Profile</h4>
        </div>

        {{-- Alert Messages --}}
        @include('components._messages')

        {{-- ==================== User Profile Detail ==================== --}}
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center py-3">
                <h6 class="mb-0 fw-semibold">User profile detail</h6>
                <a href="{{ route('admin.user-profile.edit', $userProfile) }}" class="btn btn-primary btn-sm d-inline-flex align-items-center gap-1">
                    <i class="fas fa-pen fa-xs"></i> Edit profile
                </a>
            </div>
            <div class="card-body">
                <div class="row align-items-start">

                    {{-- Info Fields --}}
                    <div class="col-md-8">
                        <table class="table table-borderless mb-0" style="font-size: 13px;">
                            <tbody>
                                <tr>
                                    <td class="text-muted ps-0 py-2" style="width: 160px;">Phone number</td>
                                    <td class="py-2">{{ $userProfile->phone_number ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-muted ps-0 py-2">Address</td>
                                    <td class="py-2">{{ $userProfile->address ?? '-' }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    {{-- Profile Image --}}
                    <div class="col-md-4 d-flex flex-column align-items-end gap-2">
                        @if ($userProfile->profileImage)
                            <img src="{{ asset($userProfile->profileImage->file_url ?? 'backend/img/avatars/1.png') }}"
                                alt="Profile Image"
                                class="rounded"
                                style="width: 100px; height: 100px; object-fit: cover; border: 1px solid var(--bs-border-color);">
                        @else
                            <div class="rounded d-flex align-items-center justify-content-center bg-light text-muted"
                                style="width: 100px; height: 100px; font-size: 12px; border: 1px solid var(--bs-border-color);">
                                No image
                            </div>
                        @endif
                        <a href="{{ route('admin.user-profile.upload-image', $userProfile) }}" class="btn btn-outline-secondary btn-sm">
                            Upload image
                        </a>
                    </div>

                </div>
            </div>
        </div>

        {{-- ==================== CV Documents ==================== --}}
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center py-3">
                <h6 class="mb-0 fw-semibold">CV documents</h6>
                <a href="{{ route('admin.upload-cv.cv-form') }}" class="btn btn-primary btn-sm d-inline-flex align-items-center gap-1">
                    <i class="fas fa-plus fa-xs"></i> Create CV
                </a>
            </div>
            <div class="card-body">
                @forelse ($userProfile->user->userCvFiles ?? [] as $cv)
                    <div class="d-flex align-items-center justify-content-between p-3 rounded mb-2"
                        style="border: 0.5px solid var(--bs-border-color); font-size: 13px;">

                        <div class="d-flex align-items-center gap-2">
                            <span class="badge text-bg-secondary fw-normal" style="font-size: 11px;">
                                {{ $cv->lang }}
                            </span>
                            <span class="fw-medium">{{ $cv->cvFile->name }}</span>
                        </div>

                        <div class="d-flex gap-2">
                            <a href="{{ asset($cv->cvFile->file_url) }}" target="_blank"
                                class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center gap-1">
                                <i class="fas fa-eye fa-xs"></i> View
                            </a>
                            <form method="POST" action="{{ route('admin.upload-cv.deleted', $cv) }}"
                                class="d-inline"
                                onsubmit="return confirm('Are you sure you want to delete this CV?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm d-inline-flex align-items-center gap-1">
                                    <i class="fas fa-trash fa-xs"></i> Delete
                                </button>
                            </form>
                        </div>

                    </div>
                @empty
                    <p class="text-muted mb-0" style="font-size: 13px;">No CV uploaded yet.</p>
                @endforelse
            </div>
        </div>

        {{-- ==================== Bio Information ==================== --}}
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center py-3">
                <h6 class="mb-0 fw-semibold">Bio information</h6>
                <a href="{{ route('admin.user-profile.bio-form', $userProfile) }}" class="btn btn-primary btn-sm d-inline-flex align-items-center gap-1">
                    <i class="fas fa-plus fa-xs"></i> Create bio
                </a>
            </div>
            <div class="card-body d-flex flex-column gap-3">
                @forelse ($userProfile->userProfileTranslations ?? [] as $translation)
                    <div class="rounded overflow-hidden" style="border: 0.5px solid var(--bs-border-color);">

                        {{-- Bio Block Header --}}
                        <div class="d-flex align-items-center justify-content-between px-3 py-2"
                            style="background: var(--bs-tertiary-bg); border-bottom: 0.5px solid var(--bs-border-color);">
                            <span class="badge text-bg-secondary fw-normal" style="font-size: 11px;">
                                {{ $translation->lang ?? '-' }}
                            </span>
                            <div class="d-flex gap-2">
                                <a href="{{ route('admin.user-profile.edit-bio-form', [$userProfile, $translation]) }}"
                                    class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center gap-1" style="font-size: 12px;">
                                    <i class="fas fa-pen fa-xs"></i> Edit
                                </a>
                                <form method="POST" action="{{ route('admin.user-profile.delete-bio', $translation) }}"
                                    class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to delete this bio?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                        class="btn btn-outline-danger btn-sm d-inline-flex align-items-center gap-1" style="font-size: 12px;">
                                        <i class="fas fa-trash fa-xs"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>

                        {{-- Bio Block Body --}}
                        <div class="p-3 d-flex flex-column gap-3" style="font-size: 13px;">
                            <div>
                                <p class="text-muted mb-1" style="font-size: 11px; font-weight: 500; letter-spacing: 0.05em; text-transform: uppercase;">Bio</p>
                                <p class="mb-0" style="line-height: 1.65;">{!! $translation->bio ?? '-' !!}</p>
                            </div>
                            <div>
                                <p class="text-muted mb-1" style="font-size: 11px; font-weight: 500; letter-spacing: 0.05em; text-transform: uppercase;">Full bio</p>
                                <p class="mb-0" style="line-height: 1.65;">{!! $translation->full_bio ?? '-' !!}</p>
                            </div>
                        </div>

                    </div>
                @empty
                    <p class="text-muted mb-0" style="font-size: 13px;">No bio added yet.</p>
                @endforelse
            </div>
        </div>

        {{-- Back Button --}}
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center gap-1" onclick="history.back()">
                <i class="fas fa-arrow-left fa-xs"></i> Back
            </button>
        </div>

    </div>
</div>
@endsection