@extends('layouts.teacher')

@section('content')
<section>

		<h2 class="light-card block-title layer-2">{{ $assignment->title }}</h2>
		<div class="row">
			<div class="form-section layer-2 col mx-2">
				<h3 class="title-3">Associated Skills</h3>
				@if(count($assignment->skills) >0)
					@foreach($assignment->skills as $skill)
					<ul>
						<li>{{ $skill->title }}</li>
					</ul>
					@endforeach
				@else
					<p>No skills</p>
				@endif
			</div>

			<div class="form-section layer-2 col-12 col-xl-4   mx-2">
				<h3 class="title-3">Manage</h3>
				<div class="label-value">
					<span>Course</span>
					<span>{{ $assignment->course->title }}</span>
				</div>
				<div class="label-value">
					<span>Chapter</span>
					<span>{{ $assignment->chapters[0]->title }}</span>
				</div>
				<div class="label-value">
					<span>Created</span>
					<span>{{ $assignment->created_at }}</span>
				</div>
				<div class="label-value">
					<span>Last Updated</span>
					<span>{{ $assignment->updated_at }}</span>
				</div>
				<div class="label-value mt-4">
					<span><a href="{{ route('assignment_teacherEdit', $assignment->id) }}"><i class="fas fa-pen-square"></i>Edit Assignment</a></span>
					<span><a href="{{ route('assignment_teacherConfirmDelete', $assignment->id) }}"><i class="fas fa-trash-alt"></i>Delete Assignment</a></span>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-md-7 form-section layer-2 mx-2">
				<h3 class="title-3">Description</h3>
				<div>{!! clean($assignment->description) !!}</div>
			</div>
			<div class="col form-section layer-2 mx-2">
				<h3 class="title-3">Details</h3>
				<div class="label-value">
					<span>Nb. Submissions</span>
					<span>{{ $assignment->nb_submissions }}</span>
				</div>
				<div class="label-value mt-3">
					<span>Max. Mark</span>
					<span>{{ $assignment->max_mark }}</span>
				</div>
				<div class="label-value mt-3">
					<span>Course Weight %</span>
					<span>{{ $assignment->course_weight }}</span>
				</div>
				<div class="label-value mt-3">
					<span>Start</span>
					<span>{{ $assignment->start_time }}</span>
				</div>
				<div class="label-value mt-3">
					<span>End</span>
					<span>{{ $assignment->end_time }}</span>
				</div>
				<div class="label-value mt-3">
					<span>Is a Test</span>
					<span>{{ $assignment->is_test ? 'Yes' : 'No' }}</span>
				</div>
				<div class="label-value mt-3">
					<span>Submission Max. MB Size</span>
					<span>{{ $assignment->submission_size }} MB</span>
				</div>
				<div class="label-value mt-3">
					<span>Language</span>
					<span>{{ ucfirst($assignment->language) }}</span>
				</div>
				<div class="label-value mt-3">
					<span>Editor and Console Enabled</span>
					<span>{{ $assignment->can_execute ? 'Yes' : 'No' }}</span>
				</div>
			</div>
	
		</div>
		@if($assignment->test_script)
		<h2 class="light-card block-title layer-2">Test Script</h2>
		<div class="form-section layer-2   mx-2">
			{!! clean($assignment->test_script) !!}
		</div>
		@endif

		<h2 class="light-card block-title layer-2">Student Submissions</h2>
		<div class="form-section layer-2   mx-2">
		@if(count($assignment->studentAssignments)==0)
			
				<p>No submissions</p>
			
		@else	
			
			<table class="table">
              <thead>
                <tr>
                  <th scope="col">Student</th>
                  <th scope="col">Submissions</th>
				  <th scope="col">Questions to Answer</th>
                  <th scope="col">Mark</th>
				  <th></th>
                </tr>
              </thead>
              <tbody>
			  @foreach($assignment->studentAssignments as $studentAssignment)
                <tr>
                   <th scope="row">{{ ucfirst($studentAssignment->enrolment->student->firstname) }} {{ ucfirst($studentAssignment->enrolment->student->lastname) }}</th>
                   <td>{{ count($studentAssignment->submissions) ?? '-'}}</td>
				   <td>
						@if(count($studentAssignment->submissions->whereNull('feedback')->whereNotNull('question')))
							<i class="fas fa-exclamation-square"></i>
						@else
							-
						@endif
					</td>
				   <td>
					@if($studentAssignment->mark) 
						{{$studentAssignment->mark}} / {{ $assignment->max_mark}}
					@elseif($studentAssignment->canBeMarked()) 
						To do<i class="fas fa-exclamation-square"></i>
					@else 
						-
					@endif</td>
					<td><a href="{{ route('studentAssignment_teacherShow', $studentAssignment->id) }}"><i class="fas fa-arrow-alt-square-right greyed"></i>Manage</a></td>
                </tr>
				@endforeach
              </tbody>
            </table>
			
		@endif
		</div>
	</section>

@endsection

