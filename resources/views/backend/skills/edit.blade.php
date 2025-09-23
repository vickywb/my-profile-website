@extends('layouts.admin-app')

@section('title', 'Admin Dashboard - Create User Profile')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms /</span> Create User Profile</h4>

      {{-- include components message --}}
      @include('components._messages')

      <form action="{{ route('admin.skill.update', $skill) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="col-md-12">
          <div class="card mb-4">
            <h5 class="card-header">Form Create User Profile</h5>

            <div class="card-body">
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Phone Number</label>
                <input
                  type="text"
                  class="form-control"
                  id="exampleFormControlInput1"
                  name="phone_number"
                  placeholder="Phone Number.."
                  value="{{ old('phone_number', $userProfile->phone_number) }}"
                />
              </div>

                <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Address</label>
                <input
                  type="text"
                  class="form-control"
                  id="exampleFormControlInput1"
                  name="address"
                  placeholder="Adress.."
                  value="{{ old('address', $userProfile->address) }}"
                />
              </div>

                <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Bio</label>
                <input
                  type="text"
                  class="form-control"
                  id="exampleFormControlInput1"
                  name="bio"
                  placeholder="Bio.."
                  value="{{ old('bio', $userProfile->bio) }}"
                />
              </div>

              <div class="mb-3">
                  <label for="formFile" class="form-label">Images Upload</label>
                  <input class="form-control" type="file" id="formFile" name="image"/>
                  <span class="text-danger" style="font-size: 12px">max-files: 2 Mb</span>
              </div>
              
              <div class="mb-3">
                  <label for="formFile" class="form-label">CV Upload</label>
                  <input class="form-control" type="file" id="formFile" name="cv"/>
                  <span class="text-danger" style="font-size: 12px">max-files: 2 Mb</span>
              </div>

              <div>
                <label for="exampleFormControlTextarea1" class="form-label">Full Bio</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="description" placeholder="Description..">{{ old('full_bio', $userProfile->full_bio) }}</textarea>
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