@extends('master')

@section('title')
    Edit
@endsection

@section('content')
    <main class="mt-4">
      <div class="container border p-3">
        <form action="{{route('course.update', ['id' => $course->id])}}" method="POST">
          @csrf
          <div class="row mt-2">
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Course Title</label>
              <input type="text" value="{{$course->courseTitle}}" name="courseTitle" class="form-control">
            </div>
          </div>
          <div class="col-md-6">
            <div class="mb-3">
              <label class="form-label">Feature Video</label>
              <input type="text" value="{{$course->featureVideo}}" name="featureVideo" class="form-control">
            </div>
          </div>
        </div>

        <hr>
        <button type="button" class="btn btn-primary mb-3" id="addModuleBtn">Add Module +</button>
        {{-- <div id="moduleContainer" class="row"></div> --}}

        <div id="moduleContainer" class="row">
            @foreach ($course->modules as $moduleIndex => $module)
                <div class="row mb-3 module" data-module-index="{{ $moduleIndex }}">
                    <div class="col-md-11 mb-3 module-item">
                        <div class="accordion" data-module>
                            <div class="accordion-item">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#module-{{ $moduleIndex }}">
                                        Module {{ $moduleIndex + 1 }}
                                    </button>
                                </h2>
                                <div id="module-{{ $moduleIndex }}" class="accordion-collapse collapse show">
                                    <div class="accordion-body">
                                        <input type="hidden" name="modules[{{ $moduleIndex }}][id]" value="{{ $module->id }}">
                                        <div class="mb-3">
                                            <label class="form-label">Module Title</label>
                                            <input type="text" name="modules[{{ $moduleIndex }}][moduleTitle]" value="{{ $module->moduleTitle }}" class="form-control">
                                        </div>
                                        <button type="button" class="btn btn-primary mb-3 add-content-btn">Add Content +</button>
                                        <div class="contentContainer">
                                            @foreach ($module->contents as $contentIndex => $content)
                                                <div class="row mb-3 content">
                                                    <div class="col-md-11">
                                                        <div class="accordion-item mb-3">
                                                            <h2 class="accordion-header">
                                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#content-{{ $moduleIndex }}-{{ $contentIndex }}">
                                                                    Content {{ $contentIndex + 1 }}
                                                                </button>
                                                            </h2>
                                                            <div id="content-{{ $moduleIndex }}-{{ $contentIndex }}" class="accordion-collapse collapse show">
                                                                <div class="accordion-body">
                                                                    <input type="hidden" name="modules[{{ $moduleIndex }}][contents][{{ $contentIndex }}][id]" value="{{ $content->id }}">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Content Title</label>
                                                                        <input type="text" name="modules[{{ $moduleIndex }}][contents][{{ $contentIndex }}][contentTitle]" value="{{ $content->contentTitle }}" class="form-control">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Video Source Type</label>
                                                                        <select name="modules[{{ $moduleIndex }}][contents][{{ $contentIndex }}][videoSourceType]" class="form-select">
                                                                            <option value="1" @selected($content->videoSourceType == 1)>One</option>
                                                                            <option value="2" @selected($content->videoSourceType == 2)>Two</option>
                                                                            <option value="3" @selected($content->videoSourceType == 3)>Three</option>
                                                                        </select>
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Video URL</label>
                                                                        <input type="text" name="modules[{{ $moduleIndex }}][contents][{{ $contentIndex }}][videoUrl]" value="{{ $content->videoUrl }}" class="form-control">
                                                                    </div>
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Video Length</label>
                                                                        <input type="time" name="modules[{{ $moduleIndex }}][contents][{{ $contentIndex }}][videoLength]" value="{{ $content->videoLength }}" class="form-control">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-1">
                                                        <button type="button" class="btn btn-danger mb-3 remove-content-btn">X</button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-1 mb-3">
                        <button type="button" class="btn btn-danger remove-module-btn">X</button>
                    </div>
                </div>
            @endforeach
        </div>


        <button type="submit" class="btn btn-success mb-3" id="addModuleBtn">Submit</button>
        <button type="button" class="btn btn-danger mb-3" id="addModuleBtn">Cancel</button>


        <input type="hidden" name="deletedModules" id="deletedModules">
        <input type="hidden" name="deletedContents" id="deletedContents">

        </form>
      </div>
    </main>

    <script>
document.addEventListener('DOMContentLoaded', () => {
    const moduleContainer = document.getElementById('moduleContainer');
    const deletedModulesInput = document.getElementById('deletedModules');
    const deletedContentsInput = document.getElementById('deletedContents');
    let deletedModuleIds = [];
    let deletedContentIds = [];
    let moduleIndex = {{ $course->modules->count() }};

    // Track remove buttons on existing modules
    document.querySelectorAll('.module').forEach((moduleRow, modIdx) => {
        const addContentBtn = moduleRow.querySelector('.add-content-btn');
        const contentContainer = moduleRow.querySelector('.contentContainer');
        const moduleIdInput = moduleRow.querySelector('input[name^="modules"][name$="[id]"]');

        if (addContentBtn) {
            addContentBtn.addEventListener('click', () => {
                const contentIndex = contentContainer.querySelectorAll('.content').length;
                const newContent = createContentRow(modIdx, contentIndex);
                contentContainer.appendChild(newContent);
            });
        }

        const removeModuleBtn = moduleRow.querySelector('.remove-module-btn');
        if (removeModuleBtn) {
            removeModuleBtn.addEventListener('click', () => {
                if (moduleIdInput?.value) {
                    deletedModuleIds.push(moduleIdInput.value);
                    updateDeletedInputs();
                }
                moduleRow.remove();
            });
        }

        moduleRow.querySelectorAll('.remove-content-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const contentRow = btn.closest('.content');
                const contentIdInput = contentRow.querySelector('input[name$="[id]"]');
                if (contentIdInput?.value) {
                    deletedContentIds.push(contentIdInput.value);
                    updateDeletedInputs();
                }
                contentRow.remove();
            });
        });
    });

    // Create new module
    document.getElementById('addModuleBtn').addEventListener('click', () => {
        const newModule = createModuleRow(moduleIndex);
        moduleContainer.appendChild(newModule);
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

        row.querySelector('.remove-module-btn').addEventListener('click', () => row.remove());

        const contentContainer = row.querySelector('.contentContainer');
        row.querySelector('.add-content-btn').addEventListener('click', () => {
            const contentIndex = contentContainer.querySelectorAll('.content').length;
            const contentRow = createContentRow(i, contentIndex);
            contentContainer.appendChild(contentRow);
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
                            Content ${contentIndex + 1}
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

    function updateDeletedInputs() {
        deletedModulesInput.value = deletedModuleIds.join(',');
        deletedContentsInput.value = deletedContentIds.join(',');
    }
});
</script>



@endsection