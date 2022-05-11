@extends('layouts.teacher')

@section('content')
	<nav class="back-nav">
		<a href="{{ route('chapter_teacherShow', $assignment->chapters[0]->id) }}"><i class="fas fa-arrow-alt-square-left"></i>{{ $assignment->chapters[0]->title}}</a>
	</nav>

		<h2 class="light-card block-title layer-2">{{ $assignment->title }}</h2>
		<div class="row">
			<div class="form-section layer-2 col mx-2">
				<h3 class="title-3">Associated Skills</h3>
				@if(count($assignment->skills) >0)
					<table class="table">
						<tbody>
						@foreach($assignment->skills->sort() as $skill)
							<tr>
								<td>{{ $skill->title }}</td>
							</tr>
						@endforeach
						</tbody>
					</table>
				@else
					<p>No skills</p>
				@endif
			</div>

			<div class="form-section layer-2 col-12 col-xl-4   mx-2">
				<h3 class="title-3">Manage</h3>
				<div class="label-value">
					<span>Course</span>
					<span><a href="{{ route('course_teacherShow', $assignment->course_id) }}">{{ $assignment->course->title }}</a></span>
				</div>
				<div class="label-value">
					<span>Chapter</span>
					<span><a href="{{ route('chapter_teacherShow', $assignment->chapters[0]->id) }}">{{ $assignment->chapters[0]->title }}</a></span>
				</div>
				<div class="label-value">
					<span>Created</span>
					<span>{{ $assignment->created_at }}</span>
				</div>
				<div class="label-value mb-3">
					<span>Last Updated</span>
					<span>{{ $assignment->updated_at }}</span>
				</div>
				<div class="d-flex flex-col align-items-end mt-3">
					<a href="{{ route('assignment_teacherEdit', $assignment->id) }}"><i class="fas fa-pen-square"></i>Edit Assignment</a>
					<a href="{{ route('assignment_teacherConfirmDelete', $assignment->id) }}"><i class="fas fa-trash-alt"></i>Delete Assignment</a>
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
					<span>{{ date('D d/m/Y, H:i', strtotime($assignment->start_time)) }}</span>
				</div>
				<div class="label-value mt-3">
					<span>End</span>
					<span>{{ date('D d/m/Y, H:i', strtotime($assignment->end_time)) }}</span>
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

		<h2 class="light-card block-title layer-2">Added Notes</h2>
		
		<div class="form-section layer-2   mx-2">
			@if(count($assignment->notes)==0)
			<p>No notes have been added.</p>
			@else
				@foreach($assignment->notes->sortBy('created_at') as $note)
					<div class="msg">
						<span class="date">{{ date('D d/m/Y, H:i', strtotime($note->created_at)) }}</span>
						<p>{{ $note->content}}</p>
					</div>
				@endforeach
			@endif
			<div class="btn-right btn-box">
			<a class="myButton " href="{{ route('assignmentNote_teacherCreate', $assignment->id) }}">Add Note</a>
			</div>	
		</div>

		<h2 class="light-card block-title layer-2">Student Submissions</h2>
		<div class="form-section layer-2   mx-2">
		@if(count($assignment->studentAssignments)==0)
				<p>No submissions</p>
		@else	
			
			<table class="table">
              <thead>
                <tr>
                  <th scope="col">Student</th>
                  <th scope="col" class="cell-center">Submissions</th>
				  <th scope="col" class="cell-center">Questions to Answer</th>
                  <th scope="col" class="cell-center">Mark</th>
				  <th></th>
                </tr>
              </thead>
              <tbody>
			  @foreach($assignment->studentAssignments as $studentAssignment)
                <tr>
                   <th scope="row"><a href="{{ route('student_teacherShow', $studentAssignment->enrolment->student_id) }}">{{ ucfirst($studentAssignment->enrolment->student->firstname) }} {{ ucfirst($studentAssignment->enrolment->student->lastname) }}</th>
                   <td class="cell-center">{{ count($studentAssignment->submissions) ?? '-'}}</td>
				   <td class="cell-center">
						@if(count($studentAssignment->submissions->whereNull('feedback')->whereNotNull('question')))
							<i class="fas fa-exclamation-square"></i>
						@else
							-
						@endif
					</td>
				   <td class="cell-center">
					@if($studentAssignment->mark) 
						{{$studentAssignment->mark}} / {{ $assignment->max_mark}}
					@elseif($studentAssignment->canBeMarked()) 
						<i class="fas fa-exclamation-square"></i>To do
					@else 
						-
					@endif</td>
					<td><a href="{{ route('studentAssignment_teacherShow', $studentAssignment->id) }}"><i class="fas fa-arrow-alt-square-right"></i>Manage Submissions</a></td>
                </tr>
				@endforeach
              </tbody>
            </table>
			
		@endif
		</div>

@endsection

