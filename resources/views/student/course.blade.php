@extends('layouts.student')

@section('content')
<div class="row">
	<div class="col  layer-2 form-section" id="sidebar">
		<h1>{{ $course->title }}</h1>
		<ul>
			<li><a href="{{ route('message_studentForum', $course->id) }}">Forum</a></li>
			<li><a href="{{ route('course_studentParticipants', $course->id) }}">Students</a></li>
			<li><a href="{{ route('course_studentProgress', $course->id) }}">My Progress</a></li>
		</ul>
	</div>
	<div class="col-12 col-xl-8">

		<nav class="back-nav">
			<a href="{{ route('course_studentIndex') }}"><i class="fas fa-arrow-alt-square-left"></i>Courses</a>
		</nav>
		<h2 class="light-card block-title layer-2">Chapters</h2>
        @foreach($course->chapters->where('is_active', true) as $chapter)
		
		<a href="{{ route('chapter_studentShow', $chapter->id)}}" class="listElement-h light-card row zoom">
			<span class="listElementTitle palette-medium col-12 col-md-8"><p>{{ $chapter->order_id }}. {{ $chapter->title }}</p></span>
			<span class="listElementContent col background">
				<span class="flex-fill d-flex">
					@if(count($chapter->assignments)!= 0)
					<div class="progressbar layer-1">
						<div class="progress"  style="width:{{ $chapter->nbAssignmentsDone() / count($chapter->assignments) * 100}}%"></div>
					</div>
					<p>{{ $chapter->nbAssignmentsDone() }} / {{ count($chapter->assignments)}} Assignments</p>
					@endif
				</span>
				
				<span class="small-date" style="width:30px;"><i class="fas fa-eye {{ $chapter->read() ? 'fa-eye greyed no-hover' : 'fa-eye-slash' }}"></i></span>
			</span>
		</a>
        @endforeach
	</div>
</div>


		<h2 class="light-card block-title layer-2">Assignments</h2>
        @foreach($course->assignments->sortBy('start_time') as $assignment)
			@if($assignment->chapters[0]->is_active)
			<a href="{{ route('assignment_studentShow', $assignment->id)}}" class="listElement-h light-card row zoom palette-medium">
				<span class="listElementTitle palette-medium col-12 col-md-4"><p>{{ $assignment->title }}</p></span>
				<span class="listElementContent col background">
					<span><p><i class="fas fa-clipboard-list greyed no-hover"></i><strong>Starts</strong> {{ $assignment->start_time_string() }}  -   <strong>Ends</strong> {{ $assignment->end_time_string() }}</p></span>
					<span><p>{!! $assignment->statusTextByStudent(Auth::id()) !!}</p></span>
				</span>
			</a>
			@endif
        @endforeach
		

@endsection
</div>

