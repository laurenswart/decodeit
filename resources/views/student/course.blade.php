@extends('layouts.student')

@section('content')
<div class="row">
	<div class="col  layer-2 form-section" id="sidebar">
		<h1>{{ $course->title }}</h1>
		<ul>
			<li><a href="{{ route('message_studentForum', $course->id) }}">Forum</a></li>
			<li><a href="">Upcoming Tests</a></li>
			<li><a href="">Students</a></li>
			<li><a href="{{ route('course_studentProgress', $course->id) }}">My Progress</a></li>
		</ul>
	</div>
	<div class="col-12 col-xl-8">

		<nav class="back-nav">
			<a href="{{ route('course_studentIndex') }}"><i class="fas fa-arrow-alt-square-left"></i>Courses</a>
		</nav>
		<h2 class="light-card block-title layer-2">Chapters</h2>
        @foreach($course->chapters as $chapter)
		
		<a href="{{ route('chapter_studentShow', $chapter->id)}}" class="listElement-h light-card row zoom">
			<span class="listElementTitle palette-medium col-12 col-md-8"><p>{{ $chapter->order_id }}. {{ $chapter->title }}</p></span>
			<span class="listElementContent col background">
				<span class="flex-fill d-flex">
					@if(count($chapter->assignments)!= 0)
					<div class="progressbar layer-1">
						<div class="progress"  style="width:{{ $chapter->nbAssignmentsDone() / count($chapter->assignments)  }}%">
						</div>
					</div><p>{{ $chapter->nbAssignmentsDone() }} / {{ count($chapter->assignments)}} Assignments</p>
					@endif
				</span>
				
				<span class="small-date" style="width:30px;"><i class="fas fa-eye {{ $chapter->read() ? 'fa-eye greyed' : 'fa-eye-slash' }}"></i></span>
			</span>
		</a>
        @endforeach
	</div>
</div>

	<section id="coming-up">
		<h2 class="light-card block-title layer-2">Assignments</h2>
        @foreach($chapter->course->assignments as $assignment)
		<a href="{{ route('assignment_studentShow', $assignment->id)}}" class="listElement-h light-card row zoom">
			<span class="listElementTitle palette-medium col-12 col-md-4"><p>{{  date('D d/m/Y, H:i', strtotime($assignment->start_time)) }} to {{ date('D d/m/Y, H:i', strtotime($assignment->end_time)) }}</p></span>
			<span class="listElementContent col background">
				<span><p><i class="fas fa-clipboard-list greyed no-hover"></i>{{ $assignment->title }}</p></span>
				<span>{!! $assignment->statusTextForAuth() !!}</span>
			</span>
		</a>
        @endforeach
		
	</section>
@endsection
</div>

