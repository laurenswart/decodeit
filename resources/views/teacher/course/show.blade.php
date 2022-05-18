@extends('layouts.teacher')

@section('content')
		<nav class="back-nav">
			<a href="{{ route('course_teacherIndex') }}"><i class="fas fa-arrow-alt-square-left"></i>All Courses</a>
		</nav>
		<h2 class="light-card block-title layer-2">{{ $course->title }}</h2>
		
		<div class="row">
			<div class="form-section layer-2 col">
				<div class="h-end-link">
					<h3 class="title-3">Chapters</h3>
					<a href="{{ route('chapter_teacherCreate', $course->id) }}"><i class="fas fa-plus-square"></i>New Chapter</a>
				</div>
				@if(count($course->chapters)==0)
					<p>No Chapters Created in this Course</p>
				@else
					<table class="table">
						<tbody>
						@foreach($course->chapters->sortBy('order_id') as $chapter)
							<tr>
								<td><a href="{{ route('chapter_teacherShow', $chapter->id)}}" class="label">{{ $chapter->title }}</a></td>
								<td>{{ count($chapter->assignments)!=0 ? count($chapter->assignments).( count($chapter->assignments)==1 ? ' Assignment' : ' Assignments') : '-'}}</td>
							</tr>
						@endforeach
						</tbody>
					</table>
				@endif
			</div>

			<div class="form-section layer-2 col-12 col-xl-4">
				<h3 class="title-3">Manage</h3>
				<div class="label-value">
					<span>Created</span>
					<span>{{ $course->created_at }}</span>
				</div>
				<div class="label-value">
					<span>Last Updated</span>
					<span>{{ $course->updated_at }}</span>
				</div>
				<div class="label-value mb-3">
					<span>Active</span>
					<span>{{ $course->is_active ? 'Yes' : 'No' }}</span>
				</div>
				<hr>
				<div class="d-flex flex-col align-items-end mt-3">
					<a href="{{ route('message_teacherForum', $course->id) }}"><i class="fas fa-comment-alt-dots"></i>Forum</a>
					<a href="{{ route('course_teacherDownloadReports', $course->id) }}"><i class="fas fa-arrow-alt-to-bottom"></i>Download Reports</a>
					<a href="{{ route('course_teacherEdit', $course->id) }}"><i class="fas fa-pen-square"></i>Edit Course</a>
					<a href="{{ route('course_teacherConfirmDelete', $course->id) }}"><i class="fas fa-trash-alt"></i>Delete Course</a>
				</div>
				
			</div>
		</div>
		<div>
			<div class="form-section layer-2">
				<h3 class="title-3">Assignments</h3>
				@if(count($assignments)==0)
					<p>No Assignments Created in this Course</p>
				@else
					<table class="table">
						<thead>
							<tr>
								<th></th>
								<th>Starts</th>
								<th>Ends</th>
								<th class="cell-center">To Mark</th>
								<th class="cell-center">Questions</th>
							</tr>
						</thead>
						<tbody>
						@foreach($assignments as $assignment)
							<tr>
								<td class="label"><a href="{{ route('assignment_teacherShow', $assignment->id)}}">{{ $assignment->title }}</a></td>
								<td>{{  $assignment->start_time_string() }}</td>
								<td>{{  $assignment->end_time_string() }}</td>
								<td class="cell-center">
									@if(date_$assignment->end_time_carbon->lt(now()) || count($assignment->studentAssignments->whereNotNull('to_mark'))!=0)
										<i class="fas fa-exclamation-square"></i>
									@else 
										-
									@endif
								</td>
								<td class="cell-center">
									@if(count($assignment->submissions->whereNotNull('question')->whereNull('feedback'))!=0)
										<i class="fas fa-exclamation-square"></i>
									@else 
										-
									@endif
								</td>
							</tr>
						@endforeach
						</tbody>
					</table>
				@endif
			</div>
			
		</div>
		<div class="row">
			<div class="form-section layer-2 col">
				<h3 class="title-3">Skills</h3>
				@if(count($course->skills)==0)
					<p>No Skills Created in this Course</p>
				@else
					@foreach($course->skills->sortBy('id') as $skill)
						<div class="d-flex flex-col mb-4">
							<div class="h-end-link">
								<span class="label">{{ $skill->title }}</span>
								<a href="{{ route('skill_teacherConfirmDelete', $skill->id) }}"><i class="fas fa-times-square greyed"></i></a>
							</div>
							<span class="pl-3">{{ $skill->description }}</span>
						</div>
						<hr>
					@endforeach
				@endif
			</div>

			<div class="form-section layer-2 col-12 col-xl-6">
				<h3 class="title-3">Enrolments</h3>
				
				<table class="table">
					<tbody>
					@foreach($course->students->sortBy('firstname', SORT_NATURAL | SORT_FLAG_CASE ) as $student)
					<tr>
						<td class="label"><a href="{{ route('student_teacherShow', $student->id) }}">{{ ucwords($student->firstname.' '.$student->lastname) }}</a></td>
						<td>{{ $student->email }}</td>
						<td><a href="{{ route('enrolment_teacherConfirmDelete', $student->pivot->id) }}"><i class="fas fa-times-square greyed"></i></a></span>
					</tr>
					@endforeach
				</tbody>
				</table>
			</div>
		</div>
@endsection

