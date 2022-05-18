@extends('layouts.student')

@section('content')

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
			<span class="listElementTitle palette-medium col-12 col-md-4"><p>{{ $assignment->title }}</p></span>
			<span class="listElementContent col background">
				<span><p><i class="fas fa-clipboard-list greyed no-hover"></i><strong>Starts</strong> {{ $assignment->start_time_string() }}  -   <strong>Ends</strong> {{ $assignment->end_time_string() }}</p></span>
				<span>{!! $assignment->statusTextForAuth() !!}</span>
			</span>
		</a>
        @endforeach
		
	</section>
		@endif

@endsection

@section('scripts')
	<script type="text/javascript">
		let chapterId = <?= $chapter->id ?>;
		let csrfToken = "<?= csrf_token() ?>";
	</script>
	<script src="{{ asset('js/student/studentChapter.js') }}"></script>
@endsection

