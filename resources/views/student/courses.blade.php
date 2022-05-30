@extends('layouts.student')

@section('content')
<section>
		<h2 class="light-card block-title layer-2">Courses</h2>
        @foreach($courses as $course)
		<a href="{{ route('course_studentShow', $course->id)}}" class="listElement-h light-card row zoom">
			<span class="listElementTitle palette-medium col-12 col-md-4"><p>{{ $course->title }}</p></span>
			<span class="listElementContent col background">
			</span>
		</a>
        @endforeach
		@if(count($courses)!=0)
		<nav class="d-flex justify-content-end">
			<a href="{{ route('studentProgress') }}">Checkout my overall progress<i class="fas fa-arrow-alt-square-right"></i></a>
		</nav>
		@endif
	</section>

	<section id="coming-up">
		<h2 class="light-card block-title layer-2">Coming Up</h2>
        @foreach($assignments as $assignment)
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
		
	</section>
@endsection

