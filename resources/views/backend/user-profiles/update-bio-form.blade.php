@extends('layouts.admin-app')
@section('title', 'Admin Dashboard - Biography')
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms /</span> Biography</h4>
      
      @include('components._messages')
      
      <form action="{{ route('admin.user-profile.update-bio', [$userProfile, $translation]) }}" method="post">
        @csrf
        @method('PATCH')
        
        <div class="col-md-12">
          <div class="card mb-4">
            <h5 class="card-header">Create or Update Biography Translation</h5>
            
            <!-- Language Display -->
            <div class="card-body">
            <div class="mb-3">
                <label for="language">Language:</label>
                <select class="form-select" name="lang" id="language">
                @foreach($languages as $lang)
                    <option value="{{ $lang->value }}" @selected(old('lang', $translation->lang) == $lang->value)>
                        {{ $lang->name }}
                    </option>
                @endforeach
                </select>
            </div>

              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Biography</label>
                <input
                  type="text"
                  class="form-control"
                  id="exampleFormControlInput1"
                  name="bio"
                  placeholder="Biography.."
                  value="{{ old('bio', $translation->bio) }}"
                />
              </div>
            <!-- Job Description -->
              <label for="fullBio" class="form-label">Full Biography</label>
              <textarea class="form-control" id="fullBio" rows="3" name="full_bio">{{ old('full_bio', $translation->full_bio) }}</textarea>
            </div>
            
            <div class="d-flex justify-content-end px-5 py-3">
                <div class="cta-buttons">
                    <div class="d-flex justify-content-between p-0 gap-3">
                        <button type="submit" class="btn btn-primary mb-3" onclick="history.back()">Back</button>
                    </div>
                        <div class="d-flex justify-content-between p-0 gap-3">
                        <button type="submit" class="btn btn-primary mb-3">Update</button>
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
        .create(document.querySelector('#fullBio'))
        .catch(error => {
            console.error(error);
        });
</script>
@endpush