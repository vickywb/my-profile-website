@extends('layouts.admin-app')

@section('title', 'Admin Dashboard - Create User Profile')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms /</span> Upload Image</h4>

      {{-- include components message --}}
      @include('components._messages')

      <form id="{{ route('admin.user-profile.upload-image', $userProfile) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="col-md-12">
          <div class="card">
            <h5 class="card-header">Form Upload Image</h5>

            <div class="card-body">
                <label for="formFile" class="form-label">Images Upload</label>
                <input class="form-control" type="file" id="formFile" name="image" accept=".jpg, .png"/>
                <span class="text-danger" style="font-size: 12px">max-files: 2 Mb</span>
            </div>
            
            <div class="cta-buttons">
                <div class="justify-content-start p-0">
                  <button type="submit" class="btn btn-primary mb-3" onclick="history.back()">Back</button>
                </div>
                <div class="justify-content-end px-2">
                  <button type="submit" class="btn btn-primary mb-3">Save</button>
                </div>
            </div>

          </div>
        </div>
      </form>

    </div>
@endsection