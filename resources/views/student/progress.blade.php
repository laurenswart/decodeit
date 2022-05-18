@extends('layouts.student')

@section('content')

<div class="accordion accordion-flush" id="accordion">
@foreach($courses as $course)
	<div class="accordion-item background">
	
		<h2 class="accordion-header" id="heading{{$course->id}}">
			<span class="accordion-button collapsed light-card block-title layer-2 py-4 fs-1" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$course->id}}" aria-controls="collapse{{$course->id}}" aria-expanded="false">
			{{ $course->title }}
			</span>
		</h2>
		<div id="collapse{{$course->id}}" class="accordion-collapse collapse" aria-labelledby="heading{{$course->id}}">
			<div class="accordion-body layer-2">
				<h3 >Chapters</h3>
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
						@foreach($course->chapters as $chapter)
							<tr>
								<td><a href="{{ route('chapter_studentShow', $chapter->id)}}">{{ $chapter->title }}</a></td>
								<td>@if($chapter->read()) <i class="fas fa-times-square"></i> @else<i class="fad fa-check-square greyed"></i>@endif</td>
							</tr>
						@endforeach
						</tbody>
					</table>
				@endif
				</div>
				
				<h3 >Assignments</h3>
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
						@foreach($course->assignments->sortByDesc('start_time') as $assignment)
							<tr>
								<td><a href="{{ route('assignment_studentShow', $assignment->id)}}">{{ $assignment->title }}</a></td>
								<td>{{ $assignment->start_time_string() }}</td>
								<td>{{ $assignment->end_time_string() }}</td>
								<td>@if($assignment->is_test)<i class="fas fa-exclamation-square"></i>Test @else Exercice @endif</td>
								<td>{!! $assignment->statusTextByStudent(Auth::id()) !!}</td>
								<td>{{$assignment->studentAssignmentByStudent(Auth::id())!==null ? $assignment->studentAssignmentByStudent(Auth::id())->mark.' / '.$assignment->max_mark : '-'}}</td>
							</tr>
						@endforeach
						</tbody>
					</table>
				@endif
				</div>
				
				<h3 >Skills</h3>
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
			</div>
		</div>
	</div>
@endforeach	
</div>
@endsection

