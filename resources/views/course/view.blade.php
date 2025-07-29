@extends('master')

@section('title')
    View
@endsection

@section('content')
    <main class="mt-4">
        <div class="container border p-3">
            <div class="col-md-12">
                <ol>
                    <li>
                        <p><b>Course:</b> {{ $course->courseTitle }}</p>
                        <p>Featured video: <a href="{{ $course->featureVideo }}">{{ $course->featureVideo }}</a></p>
                        <ol>
                            @foreach ($course->modules as $module)
                                <li>
                                    <hr>
                                    <p><b>module title:</b> {{$module->moduleTitle}}</p>
                                    <ol>
                                        @foreach ($module->contents as $content)
                                            <li>
                                                <hr>
                                                <p><b>Content title:</b> {{ $content->contentTitle }}</p>
                                                <p>Video source type: @if ($content->videoSourceType === 1 )
                                                    YouTube
                                                @elseif ($content->videoSourceType === 2 )
                                                Vimeo
                                                @elseif ($content->videoSourceType === 3 )
                                                Self Hosted
                                                @endif</p>
                                                <p>Video URL: <a href="{{ $content->videoUrl }}">{{ $content->videoUrl }}</a></p>
                                                <p>video length: {{$content->videoLength}}</p>
                                            </li>
                                        @endforeach
                                        
                                    </ol>
                                </li>
                            @endforeach
                            
                        </ol>
                    </li>
                </ol>
            </div>
        </div>
    </main>

@endsection