@extends('layouts.teacher')

@section('content')

	<h2 class="light-card block-title layer-2 ">Edit Assignment</h2>
	@if($errors->any())
	<div class="form-section errors alert alert-danger">
		@foreach($errors->all() as $error)
			<p>{{ $error }}</p>
		@endforeach
	</div>
	@endif
	
	<x-head.tinymce-config :height="400"/>
	<form method="post" action="{{ route('assignment_teacherUpdate', $assignment->id)}}" class="d-flex flex-col" id="newAssignment">
		@csrf
		<div class="row justify-content-between">
			<!--LEFT-->
			<div class="col-12 col-xl-7">
				<div class="form-section layer-2">
					<!--TITLE-->
					<div class="mb-3 row d-flex align-items-center">
						<label for="title" class="col col-form-label title-3">Assignment Title</label>
						<div class="col-12 col-md-8">
							<input type="text" class="form-control-plaintext col" id="title" name="title" value="{{ old('title') ?? $assignment->title }}">
						</div>
					</div>
				</div>
				<!--DESCRIPTION-->
				<div class="form-section layer-2 mt-3">
					<label class="title-3" for="textEditor">Description</label>
					<textarea id="textEditor" name="description">{{ old('description') ?? $assignment->description }}</textarea>
				</div>
			</div>
			<div class="col form-section layer-2 ml-4">
				<div class="label-value">
					<label for="submissions">Nb. Submissions</label>
					<input type="number" name="submissions" id="submissions" value="{{ old('submissions') ?? $assignment->nb_submissions }}">
				</div>
				<div class="label-value mt-3">
					<label for="max-mark">Max. Mark</label>
					<input type="number" name="max-mark" id="max-mark" value="{{ old('max-mark') ?? $assignment->max_mark }}">
				</div>
				<div class="label-value mt-3">
					<label for="weight">Course Weight %</label>
					<input type="number" name="weight" id="weight" value="{{ old('weight') ?? $assignment->course_weight }}">
				</div>
				<div class="label-value mt-3">
					<label for="start">Start</label>
					<input type="datetime-local" name="start" id="start" value="{{ old('start') ?? date('Y-m-d\TH:i:s', strtotime($assignment->start_time)) }}">
				</div>
				<div class="label-value mt-3">
					<label for="end">End</label>
					<input type="datetime-local" name="end" id="end" value="{{ old('end') ?? date('Y-m-d\TH:i:s', strtotime($assignment->end_time)) }}">
				</div>
				<div class="label-value mt-3">
					<label for="test">Is a Test</label>
					<input type="checkbox" name="test" id="test" {{ (old('test') || (!$errors->any() && $assignment->is_test)) ? 'checked' : '' }}>
				</div>
				<div class="label-value mt-3">
					<label for="size">Submission Max. MB Size</label>
					<input type="number" name="size" id="size" value="{{ old('size') ?? $assignment->submission_size }}">
				</div>
				<div class="label-value mt-3">
					<label for="language">Language</label>
					<select name="language" id="language">
						<option value="" {{ (old('language') === '' || (!$errors->any() && empty($assignment->language))) ? 'selected' : '' }}>None</option>
						<option value="css" {{ (old('language') === 'css' || (!$errors->any() && $assignment->language=='css')) ? 'selected' : '' }}>CSS</option>
						<option value="html" {{ (old('language') === 'html' || (!$errors->any() && $assignment->language=='html')) ? 'selected' : '' }}>HTML</option>
						<option value="java" {{ (old('language') === 'java' || (!$errors->any() && $assignment->language=='java')) ? 'selected' : '' }}>Java</option>
						<option value="javascript" {{ (old('language') === 'javascript' || (!$errors->any() && $assignment->language=='javascript')) ? 'selected' : '' }}>Javascript</option>
						<option value="json" {{ (old('language') === 'json' || (!$errors->any() && $assignment->language=='json')) ? 'selected' : '' }}>JSON</option>
						<option value="php" {{ (old('language') === 'php' || (!$errors->any() && $assignment->language=='php')) ? 'selected' : '' }}>PHP</option>
						<option value="python" {{ (old('language') === 'python' || (!$errors->any() && $assignment->language=='python')) ? 'selected' : '' }}>Python</option>
						<option value="xml" {{ (old('language') === 'xml' || (!$errors->any() && $assignment->language=='xml')) ? 'selected' : '' }}>XML</option>
					</select>
				</div>
			</div>
		</div>
		<!--SKILLS-->
		@if(count($assignment->course->skills) >0 )
		<div class="form-section layer-2">
			<h3 class="title-3">Skills</h3>
			<div class="row justify-content-between">
				@foreach($assignment->course->skills as $skill)
					<span>
						<input type="checkbox" name="skills[{{ $skill->id }}]" id="skills[{{ $skill->id }}]" value="{{ $skill->id }}" {{ old('skills.'.$skill->id) ? 'checked' : (!$errors->any() && $assignment->skills->contains($skill->id) ? 'checked' : '')}}>
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
					<input type="checkbox" name="executable" id="executable" {{ (old('executable') || (!$errors->any() && $assignment->can_execute)) ? 'checked' : '' }}>
					<label for="executable" class="ml-3">Provide Editor and Console</label>
				</span>
			</div>
			<div class="row justify-content-between">
				<p id="testScriptInfo">Before writing a test script, you must select a valid language and enable the editor and console</p>
				<input name="script" type="text" hidden id="script" value="{{ (old('script') ?? (!$errors->any() ? $assignment->test_script : '')) }}">
				<div id="testScriptEditor"></div>
			</div>
		</div>
		<button type="submit" class="myButton bigButton align-self-center">Save</button>
	</form>
@endsection


	