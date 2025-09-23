@extends('layouts.admin-app')
@section('title', 'Admin Dashboard - Upload CV')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms /</span> Upload File</h4>
      {{-- include components message --}}
      @include('components._messages')

      <form id="{{ route('admin.upload-cv.uploaded-cv') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="col-md-12">
            
          <div class="card">
            <h5 class="card-header">Form Upload CV</h5>

            <div class="card-body">
               <label for="language">Pilih Bahasa:</label>
              <select class="form-select" name="lang" id="language">
                  @foreach($languages as $lang)
                      <option value="{{ $lang->value }}">
                          {{ $lang->name }}
                      </option>
                  @endforeach
              </select>
            </div>

            <div class="card-body">
                <label for="formFile" class="form-label">CV Upload</label>
                <input class="form-control" type="file" id="formFile" name="cv" accept=".pdf, .docx"/>
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
      </form>
    </div>
@endsection