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
			<div class="listElement-v light-card row">
				<span class="listElementTitle palette-medium col-12">Section I</span>
				<span class="listElementContent col background">
					<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Id eaque enim at qui soluta! 
						Sequi similique numquam ea ipsum minus sint voluptatum consectetur facere totam. 
						Quam fugiat facilis iste nulla.</p>
					<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Id eaque enim at qui soluta! 
					Sequi similique numquam ea ipsum minus sint voluptatum consectetur facere totam. 
					Quam fugiat facilis iste nulla.</p>
				</span>
			</div>

			<div class="listElement-v light-card row">
				<span class="listElementTitle palette-medium col-12">Section II</span>
				<span class="listElementContent col background">
					<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Id eaque enim at qui soluta! 
						Sequi similique numquam ea ipsum minus sint voluptatum consectetur facere totam. 
						Quam fugiat facilis iste nulla.</p>
					<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Id eaque enim at qui soluta! 
					Sequi similique numquam ea ipsum minus sint voluptatum consectetur facere totam. 
					Quam fugiat facilis iste nulla.</p>
					<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Id eaque enim at qui soluta! 
						Sequi similique numquam ea ipsum minus sint voluptatum consectetur facere totam. 
						Quam fugiat facilis iste nulla.</p>
					<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Id eaque enim at qui soluta! 
					Sequi similique numquam ea ipsum minus sint voluptatum consectetur facere totam. 
					Quam fugiat facilis iste nulla.</p>
				</span>
			</div>

			<div class="listElement-v light-card row">
				<span class="listElementTitle palette-medium col-12">Section III</span>
				<span class="listElementContent col background">
					<p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Id eaque enim at qui soluta! 
						Sequi similique numquam ea ipsum minus sint voluptatum consectetur facere totam. 
						Quam fugiat facilis iste nulla.</p>
				</span>
			</div>
			<div class="d-flex justify-content-center btn-box">
				<button class="btn-left myButton btn-highlight">Read</button>
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

