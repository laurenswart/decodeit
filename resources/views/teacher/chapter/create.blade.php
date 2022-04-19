@extends('layouts.teacher')

@section('content')

	<h2 class="light-card block-title layer-2 ">New Chapter</h2>
	@if($errors->any())
	<div class="form-section errors alert alert-danger">
		@if($errors->get('title'))
			<p>The chapter title is required and must have less than 100 characters</p>
		@endif
	 	@if($errors->get('content'))
			<p>Error in content</p>
		@endif
	</div>
	@endif
	
	<x-head.tinymce-config :height="800"/>
	<form method="post" action="{{ route('chapter_teacherStore', $course->id)}}" class="d-flex flex-col">
		@csrf
		<div class="row justify-content-between">
			<!--LEFT-->
			<div class="col col-xl-8">
				<div class="form-section layer-2">
					<!--TITLE-->
					<div class="mb-3 row d-flex align-items-center">
						<label for="title" class="col col-form-label title-3">Chapter Title</label>
						<div class="col-12 col-md-8">
							<input type="text" class="form-control-plaintext col" id="title" name="title" value="{{ old('title') ?? '' }}">
						</div>
					</div>
					<!--ACTIVE-->
					<div class="form-check d-flex align-items-center">
						<input class="form-check-input" type="checkbox" id="active" name="active" {{ old('active')=='on' ? 'checked' : '' }}>
						<label class="form-check-label title-3 ml-4" for="active">
							Active
						</label>
					</div>
				</div>
			</div>
		</div>



		<div class="form-section layer-2">
			<label class="title-3" for="textEditor">Content</label>
			<textarea id="textEditor" name="content">{{ old('content') ?? 'Hello World !' }}</textarea>
		</div>

		<button type="submit" class="myButton bigButton align-self-center">Create</button>
	</form>
@endsection


	