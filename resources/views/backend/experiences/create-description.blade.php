@extends('layouts.admin-app')
@section('title', 'Admin Dashboard - Create Translation')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms /</span> Create Translation</h4>
      
      @include('components._messages')
      
      <form action="{{ route('admin.experience.store-translation', $experience) }}" method="post">
        @csrf
        
        <div class="col-md-12">
          <div class="card mb-4">
            <h5 class="card-header">Create Experience Translation</h5>
            
            <!-- Language Display (Read-only) -->
            <div class="card-body">
                <label for="language">Language:</label>
                <select class="form-select" name="lang" id="language">
                @foreach($languages as $lang)
                    <option value="{{ $lang->value }}">
                        {{ old('lang', $lang->name) }}
                    </option>
                @endforeach
                </select>
            </div>
            
            <!-- Job Description -->
            <div class="card-body">
              <label for="jobDescription" class="form-label">Job Description</label>
              <textarea class="form-control" id="jobDescription" rows="3" name="job_description" placeholder="Add Job Description..">{{ old('job_description') }}</textarea>
            </div>
            
            <div class="d-flex justify-content-end px-5 py-3">
                <div class="cta-buttons">
                    <div class="d-flex justify-content-between p-0 gap-3">
                        <button type="submit" class="btn btn-primary mb-3" onclick="history.back()">Back</button>
                    </div>
                        <div class="d-flex justify-content-between p-0 gap-3">
                        <button type="submit" class="btn btn-primary mb-3">Create</button>
                    </div>
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
        .create(document.querySelector('#jobDescription'))
        .catch(error => {
            console.error(error);
        });
</script>
@endpush