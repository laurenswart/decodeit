@extends('layouts.teacher')

@section('content')
<section>

		<h2 class="light-card block-title layer-2">{{ $chapter->title }}</h2>
		<div class="row">
			<div class="form-section layer-2 col mx-2">
					<div class="h-end-link">
						<h3 class="title-3">Assignments</h3>
						<a href="#"><i class="fas fa-plus-square"></i>New Assignment</a>
					</div>
					@if(count($assignments)==0)
						<p>No Assignments Related to this Chapter</p>
					@else
						@foreach($assignments as $assignment)
							<a href="{{ route('assignment_teacherShow', $assignment->id)}}" class="listElement-h light-card row zoom">
								<span class="listElementTitle palette-medium col-12 col-md-4">{{ $assignment->end_time }}</span>
								<span class="listElementContent col background">
									<span><i class="fas fa-clipboard-list greyed"></i>{{ $assignment->title }}</span>
								</span>
							</a>
						@endforeach
					@endif
				</div>

			<div class="form-section layer-2 col-12 col-xl-4   mx-2">
				<h3 class="title-3">Manage</h3>
				<div class="label-value">
					<span>Course</span>
					<span>{{ $chapter->course->title}}</span>
				</div>
				<div class="label-value">
					<span>Created</span>
					<span>{{ $chapter->created_at }}</span>
				</div>
				<div class="label-value">
					<span>Last Updated</span>
					<span>{{ $chapter->updated_at }}</span>
				</div>
				<div class="label-value">
					<span>Active</span>
					<span>{{ $chapter->is_active ? 'Yes' : 'No' }}</span>
				</div>
				<div class="label-value mt-4">
					<span><a href="#"><i class="fas fa-pen-square"></i>Edit Chapter</a></span>
					<span><a href="#"><i class="fas fa-trash-alt"></i>Delete Chapter</a></span>
				</div>
			</div>
		</div>
		<div class="form-section layer-2 col-12 col-xl-4   mx-2">
			<h3 class="title-3">Content</h3>
			{{ $chapter->content }}
		</div>
	</section>

@endsection

