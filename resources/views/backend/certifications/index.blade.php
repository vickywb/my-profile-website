@extends('layouts.admin-app')

@section('title', 'Admin Dashboard - User Profile Index')
@section('content')

    @include('partials.backend.navbar')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Index /</span> Certificate Index</h4>

            {{-- include message alert --}}
            @include('components._messages')
            
            <!-- Basic Bootstrap Table -->
            <div class="card">
              <h5 class="card-header">Certificate Index</h5>
              <div class="table-responsive text-nowrap text-center">
                <table class="table">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Certificate Name</th>
                      <th>Issuing Organization</th>
                      <th>Issue Date</th>
                      <th>Expired Date</th>
                      <th>Image</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody class="table-border-bottom-0">
                    @foreach ($certificates as $certificate)
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $certificate->cert_name ?? '-' }}</td>
                      <td>{{ $certificate->issuing_organization ?? '-'}}</td>
                      <td>{{ $certificate->issue_date ?? '-' }}</td>
                      <td>{{ $certificate->expired_date ?? '-' }}</td>
                      <td>
                        <img src="{{ asset( $certificate->file->file_url ?? 'backend/img/no-image.png') }}" alt="ceritificate-of-{{ $certificate->cert_name ?? 'no-name' }}" class="rounded-circle m-0" style="width: 75px; height: 75px" />
                      </td>
                      <td>
                        <div class="dropdown">
                          <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                          </button>
                          <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('admin.certificate.edit', $certificate) }}"
                              ><i class="bx bx-edit-alt me-1"></i> Edit</a
                            >
                            <form action="{{ route('admin.certificate.destroy', $certificate) }}" method="post">
                              @csrf
                              @method('DELETE')
                              <button
                                  onclick="return confirm('Are you sure to delete?')"
                                  type="submit"
                                  class="dropdown-item"
                              >
                              <i class="bx bx-trash me-1"></i> Delete
                              </button>
                            </form>
                          </div>
                        </div>
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
        </div>
    </div>
    
@endsection