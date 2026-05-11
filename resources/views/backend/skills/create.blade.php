@extends('layouts.admin-app')

@section('title', 'Admin Dashboard - Create Skill')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms /</span> Create Skill</h4>

      {{-- include components message --}}
      @include('components._messages')

      <form action="{{ route('admin.skill.store', $categorySkill) }}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="col-md-12">
          <div class="card mb-4">
            <h5 class="card-header">Form Create Skill</h5>

            <div class="card-body">

              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Skill Name</label>
                <input
                  type="text"
                  class="form-control"
                  id="exampleFormControlInput1"
                  name="skill_name"
                  placeholder="Skill Name.."
                  value="{{ old('skill_name') }}"
                />
              </div>

            </div>

            <div class="row">
              <div class="d-flex justify-content-end px-5">
                  <div class="cta-buttons">
                    <div class="d-flex justify-content-between p-0 gap-3">
                        <button type="submit" class="btn btn-primary mb-3" onclick="history.back()">Back</button>
                    </div>
                        <div class="d-flex justify-content-between p-0 gap-3">
                        <button type="submit" class="btn btn-primary mb-3">Save</button>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </form>

    </div>
@endsection