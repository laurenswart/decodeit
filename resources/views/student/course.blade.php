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
<section class="col-12 col-xl-8">


		<h2 class="light-card block-title layer-2">Chapters</h2>
        @foreach($course->chapters as $chapter)
		
		<a href="{{ route('chapter_studentShow', $chapter->id)}}" class="listElement-h light-card row zoom">
			<span class="listElementTitle palette-medium col-12 col-md-4">{{ $chapter->title }}</span>
			<span class="listElementContent col background">
				<span>
					@if(count($chapter->assignments)!= 0)
					<div class="progressbar layer-1">
						<div class="progress"  style="width:{{ $chapter->nbAssignmentsDone() / count($chapter->assignments)  }}%">
						</div>
					</div>{{ $chapter->nbAssignmentsDone() }} / {{ count($chapter->assignments)}} Assignments
					@endif
				</span>
				<span class="small-date "><i class="fas fa-eye {{ $chapter->read() ? 'greyed' : '' }}"></i></span>
			</span>
		</a>
        @endforeach
	</section>

	<section id="coming-up">
		<h2 class="light-card block-title layer-2">Assignments</h2>
        @foreach($assignments as $assignment)
		<a href="{{ route('assignment_studentShow', $assignment->id)}}" class="listElement-h light-card row zoom">
			<span class="listElementTitle palette-medium col-12 col-md-4">{{ $assignment->end_time_string() }}</span>
			<span class="listElementContent col background">
				<span><i class="fas fa-clipboard-list greyed"></i>{{ $assignment->title }}</span>
				<span>
					$assignment->statusTextForAuth()
				</span>
			</span>
		</a>
        @endforeach
		
	</section>
@endsection
</div>

