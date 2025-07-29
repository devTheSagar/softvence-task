@extends('master')

@section('title')
    Home
@endsection

@section('content')
    <main class="mt-4">
      <div class="container border p-3">
        <form action="{{route('course.store')}}" method="POST">
          @csrf
          <div class="row mt-2">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Course Title</label>
              <input type="text" name="courseTitle" class="form-control">
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Feature Video</label>
              <input type="text" name="featureVideo" class="form-control">
            </div>
          </div>
        </div>

        <hr>
        <button type="button" class="btn btn-primary mb-3" id="addModuleBtn">Add Module +</button>
        <div id="moduleContainer" class="row"></div>
        <button type="submit" class="btn btn-success mb-3" id="addModuleBtn">Submit</button>
        <button type="button" class="btn btn-danger mb-3" id="addModuleBtn">Cancel</button>
        </form>
      </div>
    </main>

@endsection