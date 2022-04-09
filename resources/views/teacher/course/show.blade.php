@extends('layouts.teacher')

@section('content')
<section>

		<h2 class="light-card block-title layer-2">{{ $course->title }}</h2>
        @foreach($course->chapters as $chapter)
		
		<a href="{{ route('chapter_teacherShow', $chapter->id)}}" class="listElement-h light-card row zoom">
			<span class="listElementTitle palette-medium col-12 col-md-4">{{ $chapter->title }}</span>
			<span class="listElementContent col background">
				<span>
					{{ count($chapter->assignments) }} Assignments
				</span>
				<span class="small-date "></span>
			</span>
		</a>
        @endforeach
	</section>

	<section id="coming-up">
		<h2 class="light-card block-title layer-2">Assignments</h2>
        @foreach($assignments as $assignment)
		<a href="{{ route('assignment_teacherShow', $assignment->id)}}" class="listElement-h light-card row zoom">
			<span class="listElementTitle palette-medium col-12 col-md-4">{{ $assignment->end_time }}</span>
			<span class="listElementContent col background">
				<span><i class="fas fa-clipboard-list greyed"></i>{{ $assignment->title }}</span>
			</span>
		</a>
        @endforeach
		
	</section>
@endsection

