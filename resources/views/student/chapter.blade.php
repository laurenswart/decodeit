@extends('layouts.student')

@section('content')
<div class="row">
	<!-- LEFT SIDEBAR -->
	<div class="col-4 d-none d-lg-block" id="sidebar">
		<div class="sticky-top light-card  layer-1" style="top:111px">
			<h2 class="block-title">Sections</h2>
			<ul >
				<li><a class="animate-v" href="#">Sub chapter I</a></li>
				<li><a class="animate-v" href="#">Sub chapter II</a></li>
				<li><a class="animate-v" href="#">Sub chapter III</a></li>
			</ul>	
		</div>
	</div>

	<!-- MAIN RIGHT SECTION -->
	<div class="col" >
		<nav class="back-nav">
			<a href="{{ route('course_studentShow', $chapter->course_id)}}"><i class="fas fa-arrow-circle-left greyed"></i>Back</a>
		</nav>
		<section id="chapter-content">
			<h2 class="light-card block-title layer-2">Chapter Name</h2>
			<div class="listElementContent d-flex flex-col align-items-start layer-2 form-section">
				{!! clean($chapter->content) !!}
			</div>
			<div class="d-flex justify-content-center btn-box">
				@if($chapter->isRead(Auth::id()))
					<button class="myButton empty" id="readBtn">Mark as not read</button>
				@else
					<button class="myButton btn-highlight" id="readBtn">I Have Read This Chapter</button>
				@endif
			</div>
		</section>


		@if( count($chapter->assignments) !=0 )
		<section id="coming-up">
		<h2 class="light-card block-title layer-2">Assignments</h2>
        @foreach($chapter->assignments as $assignment)
		<a href="{{ route('assignment_studentShow', $assignment->id)}}" class="listElement-h light-card row zoom">
			<span class="listElementTitle palette-medium col-12 col-md-4">{{ $assignment->end_time }}</span>
			<span class="listElementContent col background">
				<span><i class="fas fa-clipboard-list greyed"></i>{{ $assignment->title }}</span>
				<span>
					{{ ucwords($assignment->statusForAuth()) }}
					@switch( $assignment->statusForAuth() )
						@case('to do')
							<i class="fas fa-exclamation-circle"></i>
							@break
						@case('marked')
							<i class="fas fa-inbox-in greyed"></i>
							@break
						@case('done')
							<i class="fas fa-check-circle greyed"></i>
							@break
						@default
							<i class="fas fa-question-circle"></i>
					@endswitch
				</span>
			</span>
		</a>
        @endforeach
		
	</section>
		@endif
	</div>

</div>
@endsection

@section('scripts')
	<script type="text/javascript">
		let chapterId = <?= $chapter->id ?>;
		let csrfToken = "<?= csrf_token() ?>";
	</script>
	<script src="{{ asset('js/student/studentChapter.js') }}"></script>
@endsection

