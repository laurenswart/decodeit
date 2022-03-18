@extends('layouts.student')

@section('content')
<!-- MAIN RIGHT SECTION -->
<div>
	<nav class="back-nav">
		<a href="{{ route('studentChapter', $assignment->chapters[0]->chapter_id) }}"><i class="fas fa-arrow-circle-left greyed"></i>Back to chapter</a>
	</nav>
	<section>
		<h2 class="light-card block-title layer-2">{{ $assignment->title }}</h2>
		<div class="listElement-v light-card row no-border">
			<span class="listElementTitle palette-medium col-12">Assignment Information</span>
			<span class="listElementContent  background">
				<span class="row">
					<span class="col-sm-6 col-md-8 col-12">
						<span class="label">Description</span>
						<p>{{ $assignment->description }}</p>
						<span class="label">Skills Linked</span>
						<p>{{ implode(', ', $assignment->skills->pluck('title')->toArray()) }}</p>
					</span>
					<span class="col">
						<p><span class="label">Type</span>{{ $assignment->is_test ? 'Test' : 'Exercise'}}</p>
						<p><span class="label">Max Submissions</span>{{ $assignment->nb_submissions }}</p>
						<p><span class="label">Start</span>{{ $assignment->start_time }}</p>
						<p><span class="label">End</span>{{ $assignment->end_time }}</p>
						<p><span class="label">Submission size</span>{{ $assignment->submission_size }}</p>
						<p><span class="label">Last Updated</span>{{ $assignment->updated_at ??  $assignment->created_at}}</p>
					</span>
					</span>
			</span>
		</div>

		<div class="listElement-v light-card row no-border">
			<span class="listElementTitle palette-medium col-12">Notes</span>
			
			<span class="listElementContent col background">
				@foreach($assignment->notes as $note)
				<p><span class="label">{{ $note->created_at }}</span>{{ $note->content }}</p>
				@endforeach
			</span>

		</div>
	</section>
	<section>
		<h2 class="light-card block-title layer-2">Previous Submissions</h2>
		<div class="">
			
		</div>

		<div class="accordion accordion-flush" id="accordion">
			<div class="accordion-item background">
				<h3 class="accordion-header  row zoom " id="headingOne">
				<span class="accordion-button listElement-h light-card no-border collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-controls="collapseOne">
					<span class="listElementTitle palette-medium col-12 col-md-4">10:05 10/12/2021</span>
					<span class="listElementContent col background">
						<span class=""><i class="fas fa-inbox-in greyed"></i>Has Feedback</span>
					</span>
				</span>
				</h3>
				<div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordion">
				<div class="accordion-body">
					<strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
				</div>
				</div>
			</div>
			<div class="accordion-item background">
				<h3 class="accordion-header  row zoom " id="headingTwo">
				<span class="accordion-button listElement-h light-card no-border collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-controls="collapseOne">
					<span class="listElementTitle palette-medium col-12 col-md-4">11:15 10/12/2021</span>
					<span class="listElementContent col background">
						<span class=""><i class="fas fa-hand-paper greyed"></i>Waiting on Feedback</span>
					</span>
				</span>
				</h3>
				<div id="collapseTwo" class="accordion-collapse collapse show" aria-labelledby="headingTwo" data-bs-parent="#accordion">
				<div class="accordion-body">
					<strong>This is the first item's accordion body.</strong> It is shown by default, until the collapse plugin adds the appropriate classes that we use to style each element. These classes control the overall appearance, as well as the showing and hiding via CSS transitions. You can modify any of this with custom CSS or overriding our default variables. It's also worth noting that just about any HTML can go within the <code>.accordion-body</code>, though the transition does limit overflow.
				</div>
				</div>
			</div>
		</div>

	</section>


	<section id="submission">
		<h2 class="light-card block-title layer-2">New Submission</h2>
		<div class="listElement-v light-card no-border">
			<span class="listElementTitle palette-medium ">Code</span>
			<span class="listElementContent  background">
				Code here
			</span>
		</div>
		<div class="row">
			<div class="listElement-v light-card no-border col-12 col-md-10">
				<span class="listElementTitle palette-medium ">Console</span>
				<span class="listElementContent  background" style="min-height:200px;">
					Code here
				</span>
			</div>
			<div class="btn-box col">
				<button class="btn btn-left myButton">Run</button>
				<button class="btn btn-left myButton">Submit</button>
				<button class="btn btn-left myButton">Ask For Help</button>
			</div>
		</div>
	</section>
	<div class="d-flex justify-content-center btn-box">
		<button class="btn btn-left myButton btn-highlight">Finished</button>
	</div>
</div>
@endsection

