@extends('layouts.student')

@section('content')
<section>
		<h2 class="light-card block-title layer-2">Courses</h2>
        @foreach($courses as $course)
		<a href="{{ route('course_studentShow', $course->id)}}" class="listElement-h light-card row zoom">
			<span class="listElementTitle palette-medium col-12 col-md-4">{{ $course->title }}</span>
			<span class="listElementContent col background">
			</span>
		</a>
        @endforeach
	</section>

	<section id="coming-up">
		<h2 class="light-card block-title layer-2">Coming Up</h2>
        @foreach($assignments as $assignment)
		<a href="{{ route('assignment_studentShow', $assignment->id) }}" class="listElement-h light-card row zoom">
			<span class="listElementTitle palette-medium col-12 col-md-4">{{ $assignment->end_time_string() }}</span>
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
@endsection

