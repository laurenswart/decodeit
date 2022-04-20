@extends('layouts.teacher')

@section('content')
<section>

		<h2 class="light-card block-title layer-2">{{ $course->title }}</h2>
		<div class="row">
			<div class="form-section layer-2 col mx-2">
				<div class="h-end-link">
					<h3 class="title-3">Chapters</h3>
					<a href="{{ route('chapter_teacherCreate', $course->id) }}"><i class="fas fa-plus-square"></i>New Chapter</a>
				</div>
				@if(count($course->chapters)==0)
					<p>No Chapters Created in this Course</p>
				@else
					@foreach($course->chapters as $chapter)
					<a href="{{ route('chapter_teacherShow', $chapter->id)}}" class="listElement-h light-card row zoom">
						<span class="listElementTitle palette-medium col-12 col-md-4">{{ $chapter->title }}</span>
						<span class="listElementContent col background">
							<span>
								{{ count($chapter->assignments) }} Assignments
							</span>
							<span class="small-date "></span>
						</span>
					</a>
					@endforeach
				@endif
			</div>

			<div class="form-section layer-2 col-12 col-xl-4   mx-2">
				<h3 class="title-3">Manage</h3>
				<div class="label-value">
					<span>Created</span>
					<span>{{ $course->created_at }}</span>
				</div>
				<div class="label-value">
					<span>Last Updated</span>
					<span>{{ $course->updated_at }}</span>
				</div>
				<div class="label-value">
					<span>Active</span>
					<span>{{ $course->is_active ? 'Yes' : 'No' }}</span>
				</div>
				<div class="label-value mt-4">
					<span><a href="{{ route('course_teacherEdit', $course->id) }}"><i class="fas fa-pen-square"></i>Edit Course</a></span>
					<span><a href=""><i class="fas fa-trash-alt"></i>Delete Course</a></span>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-section layer-2 col mx-2">
				<h3 class="title-3">Assignments</h3>
				@if(count($assignments)==0)
					<p>No Assignments Created in this Course</p>
				@else
					@foreach($assignments as $assignment)
						<a href="{{ route('assignment_teacherShow', $assignment->id)}}" class="listElement-h light-card row zoom">
							<span class="listElementTitle palette-medium col-12 col-md-4">{{ $assignment->end_time }}</span>
							<span class="listElementContent col background">
								<span><i class="fas fa-clipboard-list greyed"></i>{{ $assignment->title }}</span>
							</span>
						</a>
					@endforeach
				@endif
			</div>

			<div class="form-section layer-2 col-12 col-xl-3   mx-2">
				<h3 class="title-3">Usage Details</h3>
				<div class="label-value">
					<span>Chapters</span>
					<span>{{ count($course->chapters) }}</span>
				</div>
				<div class="label-value">
					<span>Assignments</span>
					<span>{{ count($course->assignments) }}</span>
				</div>
				<div class="label-value">
					<span>Storage</span>
					<span>To Do</span>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="form-section layer-2 col mx-2">
				<h3 class="title-3">Skills</h3>
				@if(count($course->skills)==0)
					<p>No Skills Created in this Course</p>
				@else
					<table class="table">
						<thead>
							<tr>
							<th scope="col">Name</th>
							<th scope="col">Description</th>
							</tr>
						</thead>
						<tbody>
						@foreach($course->skills as $skill)
							<tr>
								<td>{{ $skill->title }}</td>
								<td>{{ $skill->description }}</td>
							</tr>
						@endforeach
						</tbody>
					</table>
				@endif
			</div>

			<div class="form-section layer-2 col-12 col-xl-6  mx-2">
				<h3 class="title-3">Enrolments</h3>
				@foreach($course->students as $student)
				<div class="label-value">
					<span>{{ $student->firstname.' '.$student->lastname }}</span>
					<span>{{ $student->email }}</span>
				</div>
				@endforeach
			</div>
		</div>
	</section>

@endsection

