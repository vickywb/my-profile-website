@extends('layouts.admin-app')

@section('title', 'Admin Dashboard - Edit Education')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms /</span> Create Education</h4>

      {{-- include components message --}}
      @include('components._messages')

      <form action="{{ route('admin.experience.update', $education) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="col-md-12">
          <div class="card mb-4">
            <h5 class="card-header">Form Edit Experience</h5>

            <div class="card-body">
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Institution Name</label>
                <input
                  type="text"
                  class="form-control"
                  id="exampleFormControlInput1"
                  name="institution_name"
                  placeholder="Institution Name"
                  value="{{ old('institution_name', $education->institution_name) }}"
                />
              </div>

                <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Degree</label>
                <input
                  type="text"
                  class="form-control"
                  id="exampleFormControlInput1"
                  name="degree"
                  placeholder="Institution Name"
                  value="{{ old('degree', $education->degree) }}"
                />
              </div>

                <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Field Of Study</label>
                <input
                  type="text"
                  class="form-control"
                  id="exampleFormControlInput1"
                  name="position"
                  placeholder="Field of Study"
                  value="{{ old('field_of_study', $education->field_of_study) }}"
                />
              </div>

              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Grade GPA</label>
                <input
                  type="text"
                  class="form-control"
                  id="exampleFormControlInput1"
                  name="grade_gpa"
                  placeholder="Grade GPA"
                  value="{{ old('grade_gpa', $education->grade_gpa) }}"
                />
              </div>

              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Start Date</label>
                <input
                  type="text"
                  class="form-control"
                  id="exampleFormControlInput1"
                  name="start_at"
                  placeholder="Start Date"
                  value="{{ old('start_at', $education->start_at) }}"
                />
              </div>
              
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">End Date</label>
                <input
                  type="text"
                  class="form-control"
                  id="exampleFormControlInput1"
                  name="end_at"
                  placeholder="End Date"
                  value="{{ old('end_at', $education->end_at) }}"
                />
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