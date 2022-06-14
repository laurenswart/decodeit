@extends('layouts.student')

@section('content')

		<nav class="back-nav">
			<a href="{{ route('course_studentShow', $course->id)}}"><i class="fas fa-arrow-alt-square-left"></i>Back to Course</a>
		</nav>
		<section>
			<h2 class="light-card block-title layer-2">{{ $course->title }}</h2>

			<div class="form-section layer-2">
				<h3 class="title-3">Teacher</h3>
				<p>{{ ucfirst($course->teacher->firstname) }} {{ ucfirst($course->teacher->lastname) }} - {{ $course->teacher->email }}</p>
			</div>
			<div class="form-section layer-2">
				<h3 class="title-3">Participants</h3>
				@if(count($course->students)==0)
					<p>No participants</p>
				@else
					<table class="table">
						<tbody>
						@foreach($course->students->sortBy('firstname', SORT_NATURAL | SORT_FLAG_CASE ) as $student)
						<tr>
							<td class="label"><a href="{{ route('student_teacherShow', $student->id) }}">{{ ucwords($student->firstname.' '.$student->lastname) }}</a></td>
							<td>{{ $student->email }}</td>
						</tr>
						@endforeach
					</tbody>
					</table>
				@endif
			</div>
		</section>


		

@endsection

