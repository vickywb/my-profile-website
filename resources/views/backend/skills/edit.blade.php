@extends('layouts.admin-app')

@section('title', 'Admin Dashboard - Edit Skill')
@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
      <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Forms /</span> Edit Skill</h4>

      @include('components._messages')

      <form action="{{ route('admin.skill.update', $skill) }}" method="post">
        @csrf
        @method('PATCH')

        <div class="col-md-12">
          <div class="card mb-4">
            <h5 class="card-header">Edit Skill</h5>

            <div class="card-body">
              <div class="mb-3">
                <label class="form-label">Category Skill</label>
                <select class="form-select" name="category_skill_id">
                  @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_skill_id', $skill->category_skill_id) == $category->id)>
                      {{ $category->name }}
                    </option>
                  @endforeach
                </select>
              </div>

              <div class="mb-3">
                <label class="form-label">Skill Name</label>
                <input
                  type="text"
                  class="form-control"
                  name="skill_name"
                  placeholder="Skill Name.."
                  value="{{ old('skill_name', $skill->skill_name) }}"
                />
              </div>
            </div>

            <div class="row">
              <div class="d-flex justify-content-end px-5">
                <button type="submit" class="btn btn-primary mb-3">Update</button>
              </div>
            </div>

          </div>
        </div>
      </form>

    </div>
@endsection