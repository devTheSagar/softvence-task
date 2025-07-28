@extends('master')

@section('title')
    Home
@endsection

@section('content')
    <main class="mt-4">
  <div class="container border p-3">
    <div class="row mt-2">
      <div class="col-md-6">
        <div class="mb-3">
          <label class="form-label">Course Title</label>
          <input type="text" class="form-control">
        </div>
      </div>
      <div class="col-md-6">
        <div class="mb-3">
          <label class="form-label">Feature Video</label>
          <input type="text" class="form-control">
        </div>
      </div>
    </div>

    <hr>
    <button type="button" class="btn btn-primary mb-3" id="addModuleBtn">Add Module +</button>
    <div id="moduleContainer" class="row"></div>
    <button type="button" class="btn btn-success mb-3" id="addModuleBtn">Submit</button>
    <button type="button" class="btn btn-danger mb-3" id="addModuleBtn">Cancel</button>
  </div>
</main>

<!-- HIDDEN MODULE TEMPLATE -->
<div class="row module-template d-none">
  <div class="col-md-11 mb-3 module-item">
    <div class="accordion" data-module>
      <div class="accordion-item">
        <h2 class="accordion-header">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="">
            Module Title
          </button>
        </h2>
        <div class="accordion-collapse collapse show">
          <div class="accordion-body">
            <div class="mb-3">
              <label class="form-label">Module Title</label>
              <input type="text" class="form-control">
            </div>
            <button type="button" class="btn btn-primary mb-3 add-content-btn">Add Content +</button>
            <div class="contentContainer"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-1 mb-3">
    <button type="button" class="btn btn-danger remove-module-btn">X</button>
  </div>
</div>

<!-- HIDDEN CONTENT TEMPLATE -->
<div class="row content-template d-none">
  <div class="col-md-11">
    <div class="accordion-item mb-3">
      <h2 class="accordion-header">
        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="">
          Content
        </button>
      </h2>
      <div class="accordion-collapse collapse show">
        <div class="accordion-body">
          <div class="mb-3">
            <label class="form-label">Content Title</label>
            <input type="text" class="form-control">
          </div>
          <div class="mb-3">
            <label class="form-label">Video Source Type</label>
            <select class="form-select">
              <option selected>Choose</option>
              <option value="1">One</option>
              <option value="2">Two</option>
              <option value="3">Three</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Video URL</label>
            <input type="text" class="form-control">
          </div>
          <div class="mb-3">
            <label class="form-label">Video Length</label>
            <input type="time" class="form-control">
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-md-1">
    <button type="button" class="btn btn-danger mb-3 remove-content-btn">X</button>
  </div>
</div>
@endsection