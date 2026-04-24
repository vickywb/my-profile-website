@extends('layouts.admin-app')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css">
@endpush

@section('title', 'Admin Dashboard - Edit Project')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms /</span> Edit Project</h4>

      {{-- include components message --}}
      @include('components._messages')

      <form action="{{ route('admin.project.update', $project) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="col-md-12">
          <div class="card mb-4">
            <h5 class="card-header">Form Edit Project</h5>

            <div class="card-body">
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Project Title</label>
                <input
                  type="text"
                  class="form-control"
                  id="exampleFormControlInput1"
                  name="project_title"
                  placeholder="Project Title.."
                  value="{{ old('project_title', $project->project_title) }}"
                />
              </div>

              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Project Url</label>
                <input
                  type="text"
                  class="form-control"
                  id="exampleFormControlInput1"
                  name="project_url"
                  placeholder="Project Url.."
                  value="{{ old('project_url', $project->project_url) }}"
                />
              </div>
              
              <div class="mb-3">
                  <label class="form-label fw-medium" style="font-size: 13px;">Technologies</label>
              
                  <select id="techSelect"
                      name="technologies[]"
                      multiple
                      class="form-control"
                      style="width: 100%;">
              
                      @foreach ($technologies as $tech)
                          <option value="{{ $tech->id }}"
                              {{ isset($project) && $project->technologies->contains($tech->id) ? 'selected' : '' }}
                              {{ in_array($tech->id, old('technologies', [])) ? 'selected' : '' }}>
                              {{ $tech->name }}
                          </option>
                      @endforeach
              
                  </select>
              
                  @error('technologies')
                      <div class="text-danger mt-1" style="font-size: 12px;">{{ $message }}</div>
                  @enderror
              </div>

              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Github Url</label>
                <input
                  type="text"
                  class="form-control"
                  id="exampleFormControlInput1"
                  name="github_url"
                  placeholder="Github Url.."
                  value="{{ old('github_url', $project->github_url) }}"
                />
              </div>

              <div class="mb-3">
                  <label for="formFile" class="form-label">Images Upload</label>
                  <input class="form-control" type="file" id="formFile" name="image"/>
                  <span class="text-danger" style="font-size: 12px">max-files: 2 Mb</span>
              </div>
            
              <div>
                <label for="exampleFormControlTextarea1" class="form-label">Description</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description" placeholder="Description..">{{ old('description', $project->description) }}</textarea>
              </div>
            </div>

            <div class="row">
              <div class="d-flex justify-content-end px-5 py-">
                  <button type="submit" class="btn btn-primary mb-3">Save</button>
              </div>
            </div>

          </div>
        </div>
      </form>

    </div>
@endsection

@push('ckeditor')
    <script>
         ClassicEditor
            .create( document.querySelector( '#exampleFormControlTextarea1' ) )
            .catch( error => {
                console.error( error );
            } );
    </script>
@endpush

@push('scripts')
{{-- Skip jika jQuery sudah ada di layout --}}
@if (!defined('JQUERY_LOADED'))
<script src="https://cdn.jsdelivr.net/npm/jquery/dist/jquery.min.js"></script>
@php define('JQUERY_LOADED', true) @endphp
@endif
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('#techSelect').select2({
            placeholder: 'Search technology...',
            allowClear: true,
            width: '100%',
        });
    });
</script>
@endpush