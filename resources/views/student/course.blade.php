@extends('layouts.student')

@section('content')
<section>

		<h2 class="light-card block-title layer-2">{{ $course->title }}</h2>
        @foreach($course->chapters as $chapter)
		
		<a href="{{ route('studentChapter', $chapter->chapter_id)}}" class="listElement-h light-card row zoom">
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
		<a href="{{ route('studentAssignment', $assignment->assignment_id)}}" class="listElement-h light-card row zoom">
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
@endsection

