@extends('layouts.student')

@section('content')
<!-- MAIN RIGHT SECTION -->
<div>
	<nav class="back-nav">
		<a href="{{ route('chapter_studentShow', $assignment->chapters[0]->id) }}"><i class="fas fa-arrow-circle-left greyed"></i>Back to chapter</a>
	</nav>
	<section id="info">
		<h2 class="light-card block-title layer-2">{{ $assignment->title }}</h2>
		<div class="listElement-v light-card row">
			<span class="listElementTitle palette-medium col-12">Assignment Information</span>
			<span class="listElementContent  layer-1">
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
							<span class="label">Submission size MB</span>
							<span>{{ $assignment->submission_size }}</span>
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
	<section>
		<h2 class="light-card block-title layer-2">Previous Submissions</h2>
		<div class="">
			
		</div>

		<div class="accordion accordion-flush" id="accordion">
			<div class="accordion-item background">
				<h3 class="accordion-header row zoom " id="headingOne">
				<span class="accordion-button listElement-h light-card collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-controls="collapseOne" aria-expanded="false">
					<span class="listElementTitle palette-medium col-12 col-md-4">10:05 10/12/2021</span>
					<span class="listElementContent col background">
						<span class=""><i class="fas fa-inbox-in greyed"></i>Has Feedback</span>
					</span>
				</span>
				</h3>
				<div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordion">
				<div class="accordion-body">
					<strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
				</div>
				</div>
			</div>
			<div class="accordion-item background">
				<h3 class="accordion-header  row zoom " id="headingTwo">
				<span class="accordion-button listElement-h light-card collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-controls="collapseTwo"  aria-expanded="false">
					<span class="listElementTitle palette-medium col-12 col-md-4">11:15 10/12/2021</span>
					<span class="listElementContent col background">
						<span class=""><i class="fas fa-hand-paper greyed"></i>Waiting on Feedback</span>
					</span>
				</span>
				</h3>
				<div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordion">
				<div class="accordion-body">
					<strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
				</div>
				</div>
			</div>
		</div>

	</section>

	<form method="post" action="#">
	<section id="submission">
		
		@csrf
		<h2 class="light-card block-title layer-2">New Submission</h2>

		<div class="form-section layer-2">
			<h3 class="title-3">Code</h3>
			<input name="script" type="text" hidden id="script">
			<div id="scriptEditor" data-lang="{{ $assignment->language }}"></div>
			<div  class="row my-4">
				<div class="col-12 col-md-8">
					<h3 class="title-3">Console</h3>
					<div id="console">
						<ul>
							<li>Some line</li>
							<li>Some other line</li>
						</ul>
					</div>
					
				</div>
				<div class="btn-box col-12 col-md-4 justify-content-between">
					<div class="d-flex">
						<button class="btn-left myButton btn-highlight col">Run</button>
					</div>
					<div class="d-flex flex-col">
						<button class="btn-left myButton" id="newSubmission">Submit</button>
						<button class="btn-left myButton">Ask For Help</button>
					</div>
				</div>
			</div>
		</div>
		
		
		
		
	</section>
	</form>

	<div class="d-flex justify-content-center btn-box">
		<button class="btn-left myButton btn-highlight">Done this assignment</button>
	</div>
</div>
@endsection

@section('scripts')
	<script src="{{ asset('js/student/studentAssignment.js') }}"></script>
@endsection

