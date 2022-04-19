@extends('layouts.teacher')

@section('content')

	<h2 class="light-card block-title layer-2 ">New Assignment</h2>
	@if($errors->any())
	<div class="form-section errors alert alert-danger">
		@if($errors->get('title'))
			<p>The chapter title is required and must have less than 100 characters</p>
		@endif
	 	@if($errors->get('description'))
			<p>Error in description</p>
		@endif
	</div>
	@endif
	
	<x-head.tinymce-config :height="400"/>
	<form method="post" action="{{ route('assignment_teacherStore', $chapter->id)}}" class="d-flex flex-col">
		@csrf
		<div class="row justify-content-between">
			<!--LEFT-->
			<div class="col-12 col-xl-7">
				<div class="form-section layer-2">
					<!--TITLE-->
					<div class="mb-3 row d-flex align-items-center">
						<label for="title" class="col col-form-label title-3">Assignment Title</label>
						<div class="col-12 col-md-8">
							<input type="text" class="form-control-plaintext col" id="title" name="title" value="{{ old('title') ?? '' }}">
						</div>
					</div>
				</div>
				<!--DESCRIPTION-->
				<div class="form-section layer-2 mt-3">
					<label class="title-3" for="textEditor">Description</label>
					<textarea id="textEditor" name="content">{{ old('content') ?? '' }}</textarea>
				</div>
			</div>
			<div class="col form-section layer-2 ml-4">
				<div class="label-value">
					<label for="submissions">Nb. Submissions</label>
					<input type="number" name="submissions" id="submissions" value="{{ old('submissions') ?? '' }}">
				</div>
				<div class="label-value mt-3">
					<label for="max-mark">Max. Mark</label>
					<input type="number" name="max-mark" id="max-mark" value="{{ old('max-mark') ?? '' }}">
				</div>
				<div class="label-value mt-3">
					<label for="weight">Course Weight %</label>
					<input type="number" name="weight" id="weight" value="{{ old('weight') ?? '' }}">
				</div>
				<div class="label-value mt-3">
					<label for="start">Start</label>
					<input type="datetime-local" name="start" id="start" value="{{ old('start') ?? '' }}">
				</div>
				<div class="label-value mt-3">
					<label for="end">End</label>
					<input type="datetime-local" name="end" id="end" value="{{ old('end') ?? '' }}">
				</div>
				<div class="label-value mt-3">
					<label for="test">Is a Test</label>
					<input type="checkbox" name="test" id="test" {{ old('test') ? 'checked' : '' }}>
				</div>
				<div class="label-value mt-3">
					<label for="size">Submission Max. MB Size</label>
					<input type="number" name="size" id="size" value="{{ old('size') ?? '' }}">
				</div>
				<div class="label-value mt-3">
					<label for="language">Language</label>
					<select name="language" id="language">
						<option value="js">Javascript</option>
						<option value="python">Python</option>
						<option value="java">Java</option>
					</select>
				</div>
			</div>
		</div>
		<!--SKILLS-->
		@if(count($chapter->course->skills) >0 )
		<div class="form-section layer-2">
			<h3 class="title-3">Skills</h3>
			<div class="row justify-content-between">
				@foreach($chapter->course->skills as $skill)
					<span>
						<input type="checkbox" name="skills[{{ $skill->id }}]" id="skills[{{ $skill->id }}]">
						<label class="ml-3" for="skills[{{ $skill->id }}]">{{ $skill->title }}</label>
					</span>
				@endforeach
			</div>
		</div>
		@endif
		<!--SCRIPT-->
		<div class="form-section layer-2">
			<div class="h-end-link">
				<h3 class="title-3">Script For Testing</h3>
				<span>
					<input type="checkbox" name="script" id="script">
					<label for="script" class="ml-3">Provide Editor and Console</label>
				</span>
			</div>
			<div class="row justify-content-between">
				<div id="editor"></div>
			</div>
		</div>
		<button type="submit" class="myButton bigButton align-self-center">Create</button>
	</form>
@endsection


	