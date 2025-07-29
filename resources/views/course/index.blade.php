@extends('master')

@section('title')
    Course
@endsection

@section('content')
    <main class="mt-4">
        <div class="container border p-3">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">course</th>
                        <th scope="col">module</th>
                        <th scope="col">content</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courses as $course)
                        @php
                            $moduleCount = $course->modules->count();
                        @endphp

                        @foreach ($course->modules as $moduleIndex => $module)
                            <tr>
                                @if ($moduleIndex === 0)
                                    <td rowspan="{{ $moduleCount }}">{{ $loop->parent->iteration }}</td>
                                    <td rowspan="{{ $moduleCount }}">{{ $course->courseTitle }}</td>
                                @endif

                                {{-- Module numbering --}}
                                <td>{{ $loop->iteration }}. {{ $module->moduleTitle }}</td>

                                {{-- Contents under each module --}}
                                <td>
                                    @foreach ($module->contents as $content)
                                        <div>{{ $loop->iteration }}. {{ $content->contentTitle }}</div>
                                    @endforeach
                                </td>

                                @if ($moduleIndex === 0)
                                    <td>
                                    <a href="{{route('course.view', ['id' => $course->id])}}" type="button" class="btn btn-sm btn-primary">View</a>
                                    <a href="{{route('course.edit', ['id' => $course->id])}}" type="button" class="btn btn-sm btn-success">Edit</a>
                                    <form action="{{route('course.delete', ['id' => $course->id])}}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this course?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                    </form>

                                </td>
                                @endif
                                
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>

@endsection