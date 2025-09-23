@extends('layouts.admin-app')

@section('title', 'Admin Dashboard - Skill Index')
@section('content')

    @include('partials.backend.navbar')

    <div class="content-wrapper">
        <div class="container-xxl flex-grow-1 container-p-y">
            <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Index /</span> Skill Index</h4>

            {{-- include message alert --}}
            @include('components._messages')
            
            <!-- Basic Bootstrap Table -->
            <div class="card">
              <h5 class="card-header">Skill Index</h5>
              <div class="table-responsive text-nowrap text-center">
                <table class="table">
                  <thead>
                    <tr>
                      <th>No.</th>
                      <th>Category Skill</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody class="table-border-bottom-0">
                    @foreach ($categorySkills as $skill)

                    <tr>
                      <td>{{ $loop->iteration }}</td>
                      <td>{{ $skill->name }}</td>
                      <td>
                        <div class="dropdown">
                          <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                            <i class="bx bx-dots-vertical-rounded"></i>
                          </button>
                          <div class="dropdown-menu">
                            <a class="dropdown-item" href="{{ route('admin.skill.show', $skill) }}"
                              ><i class="bx bx-info-square me-1"></i> Detail</a
                            >
                            <form action="{{ route('admin.skill.destroy', $skill) }}" method="post">
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