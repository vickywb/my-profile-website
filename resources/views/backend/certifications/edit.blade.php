@extends('layouts.admin-app')

@section('title', 'Admin Dashboard - Edit Certificate')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms /</span> Edit Certificate</h4>

      {{-- include components message --}}
      @include('components._messages')

      <form action="{{ route('admin.certificate.update', $certificate) }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <div class="col-md-12">
          <div class="card mb-4">
            <h5 class="card-header">Form Edit Certificate</h5>

            <div class="card-body">
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Certificate Name</label>
                <input
                  type="text"
                  class="form-control"
                  id="exampleFormControlInput1"
                  name="cert_name"
                  placeholder="Certificate Name.."
                  value="{{ old('cert_name', $certificate->cert_name) }}"
                />
              </div>

                <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Issuing Organization</label>
                <input
                  type="text"
                  class="form-control"
                  id="exampleFormControlInput1"
                  name="issuing_organization"
                  placeholder="Issuing Organization.."
                  value="{{ old('issuing_organizatioon', $certificate->issuing_organization) }}"
                />
              </div>

              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Issue Date</label>
                <input
                  type="text"
                  class="form-control"
                  id="exampleFormControlInput1"
                  name="issue_date"
                  placeholder="Issue Date.."
                  value="{{ old('issue_date', $certificate->issue_date) }}"
                />
              </div>

              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Expired Date</label>
                <input
                  type="text"
                  class="form-control"
                  id="exampleFormControlInput1"
                  name="expired_date"
                  placeholder="Expired Date.."
                  value="{{ old('expired_date', $certificate->expired_date) }}"
                />
              </div>

              <div class="mb-3">
                
                <label for="formFile" class="form-label">Image Upload</label>
                <input class="form-control" type="file" id="formFile" name="image" accept=".jpg, .png"/>
                <span class="text-danger" style="font-size: 12px">max-files: 2 Mb</span>
                
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