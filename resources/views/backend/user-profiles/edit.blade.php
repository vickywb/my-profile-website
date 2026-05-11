@extends('layouts.admin-app')

@section('title', 'Admin Dashboard - User Profile')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms /</span>User Profile</h4>

      {{-- include components message --}}
      @include('components._messages')

      <form action="{{ route('admin.user-profile.update', $userProfile) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="col-md-12">
          <div class="card">
            <h5 class="card-header">Form Edit User Profile</h5>

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
                <label for="formFile" class="form-label">Images Upload</label>
                <input class="form-control" type="file" id="formFile" name="image" accept=".jpg, .png"/>
                <span class="text-danger" style="font-size: 12px">max-files: 2 Mb</span>
              </div>

            </div>

            <div class="d-flex justify-content-end px-2">
                <div class="cta-buttons">
                  <div class="d-flex justify-content-between p-0">
                    <button type="submit" class="btn btn-primary mb-3" onclick="history.back()">Back</button>
                  </div>
                    <div class="d-flex justify-content-between p-0  ">
                  <button type="submit" class="btn btn-primary mb-3">Save</button>
                </div>
            </div>

          </div>
        </div>
      </form>

    </div>
@endsection