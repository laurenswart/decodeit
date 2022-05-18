@extends('layouts.teacher')

@section('content')
		<nav class="back-nav">
			<a href="{{ route('course_teacherShow', $chapter->course->id) }}"><i class="fas fa-arrow-alt-square-left"></i>{{ $chapter->course->title}}</a>
		</nav>
		<h2 class="light-card block-title layer-2">{{ $chapter->title }}</h2>
		<div class="row">
			<div class="form-section layer-2 col mx-2">
					<div class="h-end-link">
						<h3 class="title-3">Assignments</h3>
						<a href="{{ route('assignment_teacherCreate', $chapter->id) }}"><i class="fas fa-plus-square"></i>New Assignment</a>
					</div>
					@if(count($assignments)==0)
						<p>No Assignments Related to this Chapter</p>
					@else
						<table class="table">
							<tbody>
							@foreach($assignments->sortBy('start_time')->sortBy('end_time') as $assignment)
								<tr>
									<td><a href="{{ route('assignment_teacherShow', $assignment->id)}}" class="label">{{ $assignment->title }}</a></td>
									<td>{{  $assignment->start_time_string() }}</td>
									<td>{{  $assignment->end_time_string() }}</td>
								</tr>
							@endforeach
							</tbody>
						</table>
					@endif
				</div>

			<div class="form-section layer-2 col-12 col-xl-4   mx-2">
				<h3 class="title-3">Manage</h3>
				<div class="label-value">
					<span>Course</span>
					<span><a href="{{ route('course_teacherShow', $chapter->course->id) }}">{{ $chapter->course->title}}</a></span>
				</div>
				<div class="label-value">
					<span>Created</span>
					<span>{{ date('d/m/Y, H:i', strtotime($chapter->created_at)) }}</span>
				</div>
				<div class="label-value">
					<span>Last Updated</span>
					<span>{{  date('d/m/Y, H:i', strtotime($chapter->updated_at)) }}</span>
				</div>
				<div class="label-value mb-3">
					<span>Active</span>
					<span>{{ $chapter->is_active ? 'Yes' : 'No' }}</span>
				</div>
				<hr>
				<div class="d-flex flex-col align-items-end mt-3">
					<a href="{{ route('chapter_teacherEdit', $chapter->id) }}"><i class="fas fa-pen-square"></i>Edit Chapter</a>
					<a href="{{ route('chapter_teacherConfirmDelete', $chapter->id) }}"><i class="fas fa-trash-alt"></i>Delete Chapter</a>
				</div>
			</div>
		</div>
		<h2 class="light-card block-title layer-2">Content</h2>
		<div class="form-section layer-2   mx-2">
			{!! clean($chapter->content) !!}
		</div>	
@endsection

