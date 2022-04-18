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
	
	<x-head.tinymce-config/>
	<form method="post" action="{{ route('chapter_teacherUpdate', $chapter->id)}}" class="d-flex flex-col">
		@csrf
		<div class="form-section layer-2 row">
			<!--TITLE-->
			<div class="mb-3 col-12 d-flex align-items-center">
				<label for="title" class="col col-form-label title-3">Chapter Title</label>
				<input type="text" class="form-control-plaintext" id="title" name="title" value="{{ old('title') ?? $chapter->title }}">
			</div>
			<!--ACTIVE-->
			<div class="form-check col-12 col-md-2 d-flex align-items-center">
				<input class="form-check-input" type="checkbox" id="active" name="active" {{ old('active')=='on' ? 'checked' : ($chapter->is_active ? 'checked' : '' )}}>
				<label class="form-check-label title-3 ml-4" for="active">Active</label>
			</div>
		</div>

		<div class="form-section layer-2">
			<label class="title-3" for="textEditor">Content</label>
			<textarea id="textEditor" name="content">{{ old('content') ?? $chapter->content }}</textarea>
		</div>

		<button type="submit" class="myButton bigButton align-self-center">Save</button>
	</form>
@endsection


	