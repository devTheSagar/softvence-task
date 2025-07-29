@extends('master')

@section('title')
    Home
@endsection

@section('content')
<main class="mt-4">
  <div class="container border p-3">
    <form action="{{ route('course.store') }}" method="POST">
      @csrf

      <div class="row mt-2">
        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label">Course Title</label>
            <input type="text" name="courseTitle" class="form-control @error('courseTitle') is-invalid @enderror" value="{{ old('courseTitle') }}">
            @error('courseTitle')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>

        <div class="col-md-6">
          <div class="mb-3">
            <label class="form-label">Feature Video</label>
            <input type="text" name="featureVideo" class="form-control @error('featureVideo') is-invalid @enderror" value="{{ old('featureVideo') }}">
            @error('featureVideo')
              <div class="invalid-feedback">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>

      <hr>
      <button type="button" class="btn btn-primary mb-3" id="addModuleBtn">Add Module +</button>

      <div id="moduleContainer">
        <!-- Default Module -->
        <div class="row mb-3 module" data-module-index="0">
          <div class="col-md-11">
            <div class="accordion">
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#module-0">
                    Module 1
                  </button>
                </h2>
                <div id="module-0" class="accordion-collapse collapse show">
                  <div class="accordion-body">
                    <div class="mb-3">
                      <label class="form-label">Module Title</label>
                      <input type="text" name="modules[0][moduleTitle]" class="form-control @error('modules.0.moduleTitle') is-invalid @enderror" value="{{ old('modules.0.moduleTitle') }}">
                      @error('modules.0.moduleTitle')
                        <div class="invalid-feedback">{{ $message }}</div>
                      @enderror
                    </div>
                    <button type="button" class="btn btn-primary mb-3 add-content-btn">Add Content +</button>
                    <div class="contentContainer">
                      <div class="row mb-3 content">
                        <div class="col-md-11">
                          <div class="accordion-item mb-3">
                            <h2 class="accordion-header">
                              <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#content-0-0">
                                Content
                              </button>
                            </h2>
                            <div id="content-0-0" class="accordion-collapse collapse show">
                              <div class="accordion-body">
                                <div class="mb-3">
                                  <label class="form-label">Content Title</label>
                                  <input type="text" name="modules[0][contents][0][contentTitle]" class="form-control @error('modules.0.contents.0.contentTitle') is-invalid @enderror" value="{{ old('modules.0.contents.0.contentTitle') }}">
                                  @error('modules.0.contents.0.contentTitle')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                  @enderror
                                </div>
                                <div class="mb-3">
                                  <label class="form-label">Video Source Type</label>
                                  <select name="modules[0][contents][0][videoSourceType]" class="form-select @error('modules.0.contents.0.videoSourceType') is-invalid @enderror">
                                    <option value="">Choose</option>
                                    <option value="1" {{ old('modules.0.contents.0.videoSourceType') == '1' ? 'selected' : '' }}>YouTube</option>
                                    <option value="2" {{ old('modules.0.contents.0.videoSourceType') == '2' ? 'selected' : '' }}>Vimeo</option>
                                    <option value="3" {{ old('modules.0.contents.0.videoSourceType') == '3' ? 'selected' : '' }}>Self Hosted</option>
                                  </select>
                                  @error('modules.0.contents.0.videoSourceType')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                  @enderror
                                </div>
                                <div class="mb-3">
                                  <label class="form-label">Video URL</label>
                                  <input type="text" name="modules[0][contents][0][videoUrl]" class="form-control @error('modules.0.contents.0.videoUrl') is-invalid @enderror" value="{{ old('modules.0.contents.0.videoUrl') }}">
                                  @error('modules.0.contents.0.videoUrl')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                  @enderror
                                </div>
                                <div class="mb-3">
                                  <label class="form-label">Video Length</label>
                                  <input type="time" name="modules[0][contents][0][videoLength]" class="form-control @error('modules.0.contents.0.videoLength') is-invalid @enderror" value="{{ old('modules.0.contents.0.videoLength') }}">
                                  @error('modules.0.contents.0.videoLength')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                  @enderror
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- Optional remove content button -->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Modules added dynamically will go below -->
      </div>

      <button type="submit" class="btn btn-success mb-3">Submit</button>
    </form>
  </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', function () {
  let moduleIndex = 1;

  // Handle default "Add Content" for Module 0
  document.querySelector('.add-content-btn').addEventListener('click', function () {
    const contentContainer = this.closest('.accordion-body').querySelector('.contentContainer');
    const contentIndex = contentContainer.querySelectorAll('.content').length;
    contentContainer.appendChild(createContentRow(0, contentIndex));
  });

  document.getElementById('addModuleBtn').addEventListener('click', function () {
    const newModule = createModuleRow(moduleIndex);
    document.getElementById('moduleContainer').appendChild(newModule);
    moduleIndex++;
  });

  function createModuleRow(i) {
    const wrapper = document.createElement('div');
    wrapper.className = 'row mb-3 module';
    wrapper.dataset.moduleIndex = i;

    wrapper.innerHTML = `
      <div class="col-md-11">
        <div class="accordion">
          <div class="accordion-item">
            <h2 class="accordion-header">
              <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#module-${i}">
                Module ${i + 1}
              </button>
            </h2>
            <div id="module-${i}" class="accordion-collapse collapse show">
              <div class="accordion-body">
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
      <div class="col-md-1 d-flex align-items-start">
        <button type="button" class="btn btn-danger remove-module-btn mt-1">X</button>
      </div>
    `;

    wrapper.querySelector('.remove-module-btn').addEventListener('click', () => wrapper.remove());

    wrapper.querySelector('.add-content-btn').addEventListener('click', function () {
      const container = wrapper.querySelector('.contentContainer');
      const contentIndex = container.querySelectorAll('.content').length;
      container.appendChild(createContentRow(i, contentIndex));
    });

    return wrapper;
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
                  <option value="">Choose</option>
                  <option value="1">YouTube</option>
                  <option value="2">Vimeo</option>
                  <option value="3">Self Hosted</option>
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
        <button type="button" class="btn btn-danger remove-content-btn">X</button>
      </div>
    `;

    row.querySelector('.remove-content-btn').addEventListener('click', () => row.remove());
    return row;
  }
});
</script>
@endsection
