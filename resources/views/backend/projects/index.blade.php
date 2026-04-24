@extends('layouts.admin-app')

@section('title', 'Admin Dashboard - Project Index')
@section('content')

    @include('partials.backend.navbar')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Index /</span> Project Index</h4>

            {{-- include message alert --}}
            @include('components._messages')
            
            <!-- Basic Bootstrap Table -->
            <div class="card">
              <h5 class="card-header">Project Index</h5>
              <div class="table-responsive text-nowrap text-center">
                <table class="table">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Project Name</th>
                      <th>Project Url</th>
                      <th>Github Url</th>
                      <th>Description</th>
                      <th>Image</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody class="table-border-bottom-0">
                    @foreach ($projects as $project)
                        
                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $project->project_title ?? '-' }}</td>
                      <td>{{ $project->project_url ?? '-' }}</td>
                      <td>{{ $project->github_url ?? '-' }}</td>
                      <td>{!! Str::substr($project->description, 0, 50) !!}</td>
                      <td>
                        <img src="{{ asset( $project->file->file_url ??'backend/img/no-image.png') }}" alt="Avatar" class="rounded-circle m-0" style="width: 75px; height: 75px" />
                      </td>
                      <td>
                        <div class="dropdown">
                          <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                          </button>
                          <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('admin.project.edit', $project) }}"
                              ><i class="bx bx-edit-alt me-1"></i> Edit</a
                            >
                            <form action="{{ route('admin.project.destroy', $project) }}" method="post">
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
                <div class="d-flex justify-content-center mt-2 mb-2">
                    {{ $projects->links() }}
                </div>
              </div>
            </div>
        </div>
    </div>
    
@endsection