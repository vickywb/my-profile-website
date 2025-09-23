@extends('layouts.admin-app')

@section('title', 'Admin Dashboard - Edit Experience')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms /</span> Edit Experience</h4>

      {{-- include components message --}}
      @include('components._messages')

      <form action="{{ route('admin.experience.update', $experience) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="col-md-12">
          <div class="card mb-4">
            <h5 class="card-header">Form Edit Experience</h5>

            <div class="card-body">
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Company Name</label>
                <input
                  type="text"
                  class="form-control"
                  id="exampleFormControlInput1"
                  name="company_name"
                  placeholder="Company Name.."
                  value="{{ old('company_name', $experience->company_name) }}"
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
                  value="{{ old('position', $experience->position) }}"
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
                  value="{{ old('location', $experience->location) }}"
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
                  value="{{ old('start_date', $experience->start_date) }}"
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
                  value="{{ old('end_date', $experience->end_date) }}"
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