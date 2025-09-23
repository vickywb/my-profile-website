@extends('layouts.admin-app')

@section('title', 'Admin Dashboard - Create Experience')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms /</span> Create Experience</h4>

      {{-- include components message --}}
      @include('components._messages')

      <form action="{{ route('admin.experience.store') }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="col-md-12">
          <div class="card mb-4">
            <h5 class="card-header">Form Create Experience</h5>

            <div class="card-body">
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Company Name</label>
                <input
                  type="text"
                  class="form-control"
                  id="exampleFormControlInput1"
                  name="company_name"
                  placeholder="Company Name.."
                  value="{{ old('company_name') }}"
                />
              </div>

                <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Position</label>
                <input
                  type="text"
                  class="form-control"
                  id="exampleFormControlInput1"
                  name="position"
                  placeholder="Position.."
                  value="{{ old('position') }}"
                />
              </div>

              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Location</label>
                <input
                  type="text"
                  class="form-control"
                  id="exampleFormControlInput1"
                  name="location"
                  placeholder="Location.."
                  value="{{ old('location') }}"
                />
              </div>

              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Start Date</label>
                <input
                  type="text"
                  class="form-control"
                  id="exampleFormControlInput1"
                  name="start_date"
                  placeholder="Start Date.."
                  value="{{ old('start_date') }}"
                />
              </div>
              
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">End Date</label>
                <input
                  type="text"
                  class="form-control"
                  id="exampleFormControlInput1"
                  name="end_date"
                  placeholder="End Date.."
                  value="{{ old('end_date') }}"
                />
              </div>
            
              <div>
                <label for="exampleFormControlTextarea1" class="form-label">Job Description</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="job_description" placeholder="Job Description..">{{ old('job_description') }}</textarea>
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
            .create( document.querySelector( '#exampleFormControlTextarea1' ))
            .catch( error => {
                console.error( error );
            } );
    </script>
@endpush