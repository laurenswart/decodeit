@extends('layouts.teacher')

@section('content')
<section>
		<div class="h-end-link light-card  mt-4 layer-2">
			<h2 class=" block-title">Courses</h2>
			<a href="{{ route('course_teacherCreate') }}"><i class="fas fa-plus-square"></i>New</a>
		</div>
        @foreach($courses as $course)
		<a href="{{ route('course_teacherShow', $course->id)}}" class="listElement-h light-card row zoom">
			<span class="listElementTitle palette-medium col-12 col-md-4">{{ $course->title }}</span>
			<span class="listElementContent col background">
			</span>
		</a>
        @endforeach
	</section>
@endsection

