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

    <script>
      document.addEventListener('DOMContentLoaded', () => {
          const moduleContainer = document.getElementById('moduleContainer');
          let moduleIndex = 0;

          // Add Module Button
          document.querySelectorAll('#addModuleBtn')[0].addEventListener('click', () => {
              const moduleRow = createModuleRow(moduleIndex);
              moduleContainer.appendChild(moduleRow);
              moduleIndex++;
          });

          function createModuleRow(i) {
              const row = document.createElement('div');
              row.className = 'row mb-3 module';
              row.dataset.moduleIndex = i;

              row.innerHTML = `
                  <div class="col-md-11 mb-3 module-item">
                      <div class="accordion" data-module>
                          <div class="accordion-item">
                              <h2 class="accordion-header">
                                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#module-${i}">
                                      Module ${i + 1}
                                  </button>
                              </h2>
                              <div id="module-${i}" class="accordion-collapse collapse show">
                                  <div class="accordion-body">
                                      <input type="hidden" name="modules[${i}][id]" value="">
                                      <div class="mb-3">
                                          <label class="form-label">Module Title</label>
                                          <input type="text" name="modules[${i}][moduleTitle]" class="form-control">
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
              `;

              // Remove module
              row.querySelector('.remove-module-btn').addEventListener('click', () => {
                  row.remove();
              });

              // Add content
              row.querySelector('.add-content-btn').addEventListener('click', () => {
                  const container = row.querySelector('.contentContainer');
                  const contentIndex = container.querySelectorAll('.content').length;
                  const contentRow = createContentRow(i, contentIndex);
                  container.appendChild(contentRow);
              });

              return row;
          }


          function createContentRow(moduleIndex, contentIndex) {
              const row = document.createElement('div');
              row.className = 'row mb-3 content';

              row.innerHTML = `
                  <div class="col-md-11">
                      <div class="accordion-item mb-3">
                          <h2 class="accordion-header">
                              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#content-${moduleIndex}-${contentIndex}">
                                  Content
                              </button>
                          </h2>
                          <div id="content-${moduleIndex}-${contentIndex}" class="accordion-collapse collapse show">
                              <div class="accordion-body">
                                  <div class="mb-3">
                                      <label class="form-label">Content Title</label>
                                      <input type="text" name="modules[${moduleIndex}][contents][${contentIndex}][contentTitle]" class="form-control">
                                  </div>
                                  <div class="mb-3">
                                      <label class="form-label">Video Source Type</label>
                                      <select name="modules[${moduleIndex}][contents][${contentIndex}][videoSourceType]" class="form-select">
                                          <option selected>Choose</option>
                                          <option value="1">One</option>
                                          <option value="2">Two</option>
                                          <option value="3">Three</option>
                                      </select>
                                  </div>
                                  <div class="mb-3">
                                      <label class="form-label">Video URL</label>
                                      <input type="text" name="modules[${moduleIndex}][contents][${contentIndex}][videoUrl]" class="form-control">
                                  </div>
                                  <div class="mb-3">
                                      <label class="form-label">Video Length</label>
                                      <input type="time" name="modules[${moduleIndex}][contents][${contentIndex}][videoLength]" class="form-control">
                                  </div>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-1">
                      <button type="button" class="btn btn-danger mb-3 remove-content-btn">X</button>
                  </div>
              `;

              row.querySelector('.remove-content-btn').addEventListener('click', () => {
                  row.remove();
              });

              return row;
          }
      });
    </script>

@endsection