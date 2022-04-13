@extends('layouts.teacher')

@section('content')
<section>
		<h2 class="light-card block-title layer-2">Courses<a style="float:right;" href="{{ route('course_teacherCreate') }}"><i class="fas fa-plus-square"></i>New</a></h2>
        @foreach($courses as $course)
		<a href="{{ route('course_teacherShow', $course->id)}}" class="listElement-h light-card row zoom">
			<span class="listElementTitle palette-medium col-12 col-md-4">{{ $course->title }}</span>
			<span class="listElementContent col background">
			</span>
		</a>
        @endforeach
	</section>
@endsection

