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
						<div class="row">
							<div class="col">
								<h4>Feedback</h4>
								<p>{{ $submission->feedback ?? '-'}}</p>
							</div>
							<div class="col-12 col-xl-5 ">
								@if(!$submission->question && $studentAssignment->mark == null)
								<h4>Attach a Note</h4>
								<div class="mt-4 mx-6 d-flex flex-col submissionQuestion">
									<textarea id="question" rows="3" cols="50" ></textarea>
									<button type="button" onclick="addQuestion(this)" data-submissionId={{$submission->id}} class="myButton align-self-end mt-4" id="btAddQuestion">Add Note or Question</button>
								</div>
								@else 
									<h4>Attached Note</h4>
									<p>{{$submission->question}}</p>
								@endif
							</div>
						</div>
						
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
	<script>
		function createFlashPopUp(msg, error = false){
    let div = document.createElement('div');
    div.classList.add('alert', 'flash-popup');
    if(error){
        div.classList.add('alert-danger');
    } else {
        div.classList.add('alert-success');
    }
    div.innerText = msg;
    document.body.appendChild(div);
}

		let btnAddQuestion = document.getElementById('btnAddQuestion');
		let question = document.getElementById('question');

		function addQuestion(button){
			let questionDiv = button.closest('.submissionQuestion');
			let questionContent = questionDiv.querySelector('textarea').value;
			let submissionId = button.dataset.submissionid;
			//if question empty do nothing
			if(questionContent=='') {
				createFlashPopUp('Please enter a question', true);
				return;
			}
			
			//send ajax request
			console.log(questionContent);
			console.log(submissionId);
			let xhr = new XMLHttpRequest();

			xhr.onload = function() { //Fonction de rappel
				console.log(this);
				if(this.status === 200) {
					let data = this.responseText;
					data = JSON.parse(data);
					console.log(data);
					if(data.success){
						//remove textareaand display question
						let p = document.createElement('p');
						p.innerText = questionContent;
						questionDiv.parentNode.insertBefore(p, questionDiv);
						
						//change h4 content
						questionDiv.parentElement.querySelector('h4').innerText = 'Note Attached';
						questionDiv.remove();
						createFlashPopUp('Note Successfully Added');
					}
				} else {
					createFlashPopUp('Oops, Something Went Wrong', true);
				}
				
			};
			const data = JSON.stringify({
				_token: "<?= csrf_token() ?>",
				question: questionContent,
			});

			xhr.open('POST', "/student/submission/"+submissionId+"/addQuestion");
			xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
			xhr.setRequestHeader("Content-Type", "application/json");
			xhr.send(data);
			// end of ajax call
		};
	</script>
@endsection

