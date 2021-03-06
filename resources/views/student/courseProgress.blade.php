@extends('layouts.student')

@section('content')
	<nav class="back-nav">
		<a href="{{ route('course_studentShow', $course->id) }}"><i class="fas fa-arrow-alt-square-left"></i>Back to Course</a>
	</nav>
	
		<h2 class="light-card block-title layer-2">{{ $course->title }}</h2>
		<div class="form-section">
		@if(count($course->chapters)==0)
			<p>No existing chapters</p>
		@else
			<table class="table">
				<thead>
					<tr>
						<th scope="col">Chapter</th>
						<th scope="col">Read</th>
					</tr>
				</thead>
				<tbody>
				@foreach($course->chapters->sortBy('order_id')->where('is_active', true) as $chapter)
					<tr>
						<td><a href="{{ route('chapter_studentShow', $chapter->id)}}">{{ $chapter->title }}</a></td>
						<td>@if($chapter->read()) <i class="fas fa-check-square greyed "></i> @else<i class="fas fa-times-square"></i>@endif</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		@endif
		</div>

		<h2 class="light-card block-title layer-2">Assignments</h2>
		<div class="form-section">
		@if(count($course->assignments)==0)
			<p>No existing assignments</p>
		@else
			<table class="table">
				<thead>
					<tr>
						<th scope="col">Assignment</th>
						<th scope="col">Opens</th>
						<th scope="col">Ends</th>
						<th scope="col">Type</th>
						<th scope="col">Status</th>
						<th scope="col">Mark</th>
					</tr>
				</thead>
				<tbody>
				@foreach($course->assignments->sortBy('start_time') as $assignment)
					@if($assignment->chapters[0]->is_active)
					<tr>
						<td><a href="{{ route('assignment_studentShow', $assignment->id)}}">{{ $assignment->title }}</a></td>
						<td>{{ $assignment->start_time_string() }}</td>
						<td>{{ $assignment->end_time_string() }}</td>
						<td>@if($assignment->is_test)Test @else Exercice @endif</td>
						<td>{!! $assignment->statusTextByStudent(Auth::id()) !!}</td>
						<td>{{$assignment->studentAssignmentByStudent(Auth::id()) !==null && $assignment->studentAssignmentByStudent(Auth::id())->mark !== null ? $assignment->studentAssignmentByStudent(Auth::id())->mark.' / '.$assignment->max_mark : '-'}}</td>
					</tr>
					@endif
				@endforeach
				</tbody>
			</table>
		@endif
		</div>

		<h2 class="light-card block-title layer-2">Skills</h2>
		<div class="form-section">
		@if(count($course->skills)==0)
			<p>No existing skills</p>
		@else
			<table class="table">
				<thead>
					<tr>
						<th scope="col">Skill</th>
						<th scope="col">Description</th>
						<th scope="col">Mark</th>
					</tr>
				</thead>
				<tbody>
				@foreach($course->skills as $skill)
					<tr>
						<td>{{ $skill->title }}</td>
						<td>{{ $skill->description }}</td>
						<td>{{ $assignment->course->enrolmentForStudent(Auth::id())->skills->find($skill->id)->pivot->mark ?? '-'  }} / 100</td>
					</tr>
				@endforeach
				</tbody>
			</table>
		@endif
		</div>

@endsection

