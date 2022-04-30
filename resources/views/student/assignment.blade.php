@extends('layouts.student')

@section('content')
<!-- MAIN RIGHT SECTION -->
<div>
	<nav class="back-nav">
		<a href="{{ route('chapter_studentShow', $assignment->chapters[0]->id) }}"><i class="fas fa-arrow-circle-left greyed"></i>Back to chapter</a>
	</nav>
	<section id="info">
		<h2 class="light-card block-title layer-2">{{ $assignment->title }}</h2>
		<div class="listElement-v light-card row no-border">
			<span class="listElementTitle palette-medium col-12">Assignment Information</span>
			<span class="listElementContent  layer-2">
				<span class="row w-100">
					<span id="description" class="col-sm-6 col-md-8 col-12">
						<div>
							<div class="label">Description</div>
							<div>{!! clean($assignment->description) !!}</div>
						</div>
						<div>
							<div class="label">Skills Linked</div>
							<div>{{ implode(', ', $assignment->skills->pluck('title')->toArray()) }}</div>
						</div>
					</span>
					<span id="details" class="col">
						<span>
							<span class="label">Status</span>
							<span>{{ ucwords($assignment->statusForAuth()) }}</span>
						</span>
						<span>
							<span class="label">Type</span>
							<span>{{ $assignment->is_test ? 'Test' : 'Exercise'}}</span>
						</span>
						<span>
							<span class="label">Max Submissions</span>
							<span>{{ $assignment->nb_submissions }}</span>
						</span>
						<span>
							<span class="label">Start</span>
							<span>{{ $assignment->start_time }}</span>
						</span>
						<span>
							<span class="label">End</span>
							<span>{{ $assignment->end_time }}</span>
						</span>
						<span>
							<span class="label">Last Updated</span>
							<span>{{ $assignment->updated_at ??  $assignment->created_at}}</span>
						</span>
					</span>
					</span>
			</span>
		</div>
		@if(count($assignment->notes)>0)
		<div class="listElement-v light-card row">
			<span class="listElementTitle palette-medium col-12">Notes</span>
			<span class="listElementContent col layer-1">
				@foreach($assignment->notes as $note)
				<p><span class="label">{{ $note->created_at }}</span>{{ $note->content }}</p>
				@endforeach
			</span>
		</div>
		@endif
	</section>
	@if(count($submissions)>0)
	<section>
		<h2 class="light-card block-title layer-2">Previous Submissions</h2>
		<div class="accordion accordion-flush" id="accordion">
			@foreach($submissions as $id => $submission)
			<div class="accordion-item background">
				<h3 class="accordion-header row zoom " id="heading{{$id}}">
				<span class="accordion-button listElement-h light-card collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{$id}}" aria-controls="collapse{{$id}}" aria-expanded="false">
					<span class="listElementTitle palette-medium col-12 col-md-4">{{ $submission->created_at }}</span>
					<span class="listElementContent col background">
						<span class="">
							@if(!empty($submission->feedback))
								<i class="fas fa-inbox-in greyed"></i>Has Feedback
							@else	
								<i class="fas fa-hand-paper greyed"></i>Waiting on Feedback
							@endif
						</span>
					</span>
				</span>
				</h3>
				<div id="collapse{{$id}}" class="accordion-collapse collapse" aria-labelledby="heading{{$id}}" data-bs-parent="#accordion">
					<div class="accordion-body layer-2">
					@if($submission->feedback)
						<h4>Feedback</h4>
						<p>{{ $submission->feedback}}</p>
					@endif
					<h4>Code</h4>
					<div>
						{{ $submission->content }}
					</div>
						
					</div>
				</div>
			</div>
			@endforeach
		</div>
		
	</section>
	@endif


	@if($assignment->nb_submissions > count($submissions) && !$studentAssignment->to_mark && ($assignment->start_time <= now() && $assignment->end_time >= now()))
	<form method="post" action="{{ route('submission_studentStore', $assignment->id) }}" id="newSubmission">
	<section id="submission">
		
		@csrf
		<h2 class="light-card block-title layer-2">New Submission</h2>

		<div class="form-section layer-2">
			<h3 class="title-3">Code</h3>
			<input name="script" type="text" hidden id="script">
			<input name="console" type="text" hidden id="hiddenConsole">
			<div id="scriptEditor" data-lang="{{ $assignment->language }}"></div>
			<div class="btn-box centered">
				<button class="myButton" id="btRun" type="button">Run</button>
			</div>
			
			<div  class="row my-4">
				<div>
					<div class="d-flex justify-content-between">
						<button type="button" id="btClearConsole"><i class="fas fa-eraser"></i>Clear Console</button>
						<p id="codeStatus"></p>
					</div>
					<ul  id="console" class="my-0">
						<li></li>
					</ul>
				</div>
				<div class="btn-box centered">
					<button class="myButton" id="newSubmission" type="submit">Submit</button>
				</div>
				

			</div>

			@if($errors->any())
		<div class="form-section errors alert alert-danger">
			@foreach ($errors->all() as $error)
				<p>{{ $error }}</p>
			@endforeach
		</div>
		@endif
		</section>
		</form>
		@endif
		</div>

		
	@if(!$studentAssignment->to_mark && ($assignment->start_time <= now() && $assignment->end_time >= now()))
	<div class="btn-box centered">
		<a href="{{ route('studentAssignment_studentConfirmDone', $assignment->id) }}" class="myButton btn-highlight">Done this assignment</a>		
	</div>
	@endif
	

</div>
@endsection

@section('scripts')
	<script src="{{ asset('js/student/studentAssignment.js') }}"></script>

@endsection

