@extends('layouts.teacher')

@section('content')

	<h2 class="light-card block-title layer-2 ">New Assignment</h2>
	@if($errors->any())
	<div class="form-section layer-2 errors">
		@foreach($errors->all() as $error)
			<p class="error-msg">{{ $error }}</p>
		@endforeach
	</div>
	@endif
	
	<x-head.tinymce-config :height="400"/>
	<form method="post" action="{{ route('assignment_teacherStore', $chapter->id)}}" class="d-flex flex-col" id="newAssignment">
		@csrf
		<div class="row justify-content-between">
			<!--LEFT-->
			<div class="col-12 col-xl-7">
				<!--TITLE-->
				<div class="form-section layer-2">
					<div class="mb-3 row d-flex align-items-center">
						<label for="title" class="col col-form-label title-3">Assignment Title</label>
						<div class="col-12 col-md-8">
							<input type="text" class="form-control-plaintext col" 
									id="title" name="title" value="{{ old('title') ?? '' }}" required>
						</div>
					</div>
				</div>
				<!--DESCRIPTION-->
				<div class="form-section layer-2 mt-3">
					<label class="title-3" for="textEditor">Description</label>
					<textarea id="textEditor" name="description">{{ old('description') ?? '' }}</textarea>
				</div>
			</div>
			<!--RIGHT-->
			<div class="col form-section layer-2 ml-4">
				<div class="label-value">
					<label for="submissions">Nb. Submissions</label>
					<input type="number" name="submissions" id="submissions" 
							value="{{ old('submissions') ?? '' }}" min="1" max="{{ $plan->nb_submissions}}" required>
				</div>
				<div class="label-value mt-3">
					<label for="max-mark">Max. Mark</label>
					<input type="number" name="max-mark" id="max-mark" value="{{ old('max-mark') ?? '' }}" required min="0" max="500">
				</div>
				<div class="label-value mt-3">
					<label for="weight">Course Weight %</label>
					<input type="number" name="weight" id="weight" value="{{ old('weight') ?? '' }}" required min="0" max="100">
				</div>
				<div class="label-value mt-3">
					<label for="start">Start</label>
					<input type="datetime-local" name="start" id="start" value="{{ old('start') ?? '' }}" required>
				</div>
				<div class="label-value mt-3">
					<label for="end">End</label>
					<input type="datetime-local" name="end" id="end" value="{{ old('end') ?? '' }}" required>
				</div>
				<div class="label-value mt-3">
					<label for="test">Is a Test</label>
					<input type="checkbox" name="test" id="test" {{ old('test') ? 'checked' : '' }}>
				</div>
				<div class="label-value mt-3">
					<label for="language">Language</label>
					<select name="language" id="language">
						<option value="" {{ old('language') === '' ? 'selected' : '' }}>None</option>
						<option value="css" {{ old('language') === 'css' ? 'selected' : '' }}>CSS</option>
						<option value="html" {{ old('language') === 'html' ? 'selected' : '' }}>HTML</option>
						<option value="javascript" {{ old('language') === 'javascript' ? 'selected' : '' }}>Javascript</option>
						<option value="json" {{ old('language') === 'json' ? 'selected' : '' }}>JSON</option>
						<option value="python" {{ old('language') === 'python' ? 'selected' : '' }}>Python</option>
						<option value="xml" {{ old('language') === 'xml' ? 'selected' : '' }}>XML</option>
					</select>
				</div>
				<div class="label-value mt-3">
					<label for="executable">Allow Code Execution and Provide Console</label>
					<input type="checkbox" name="executable" id="executable" {{ old('executable') ? 'checked' : '' }}>
				</div>
				<p>To enable code execution, select one of the following languages: 
				<strong> Javascript</strong> or<strong> Python</strong></p> 
			</div>
		</div>
		<!--SKILLS-->
		@if(count($chapter->course->skills) >0 )
		<div class="form-section layer-2">
			<h3 class="title-3">Skills</h3>
			<div class="row justify-content-between">
				@foreach($chapter->course->skills as $skill)
					<span>
						<input type="checkbox" name="skills[{{ $skill->id }}]" 
								id="skills[{{ $skill->id }}]" value="{{ $skill->id }}" {{ old('skills.'.$skill->id) ? 'checked' : '' }}>
						<label class="ml-3" for="skills[{{ $skill->id }}]">{{ $skill->title }}</label>
					</span>
				@endforeach
			</div>
		</div>
		@endif
		<!--TEST SCRIPT-->
		<div class="form-section layer-2">
			<h3 class="title-3">Script For Testing</h3>
			<div class="row justify-content-between">
				<p id="testScriptInfo">In order to write a code containing tests, you must enable script execution and select one of the 
					following languages:<strong> Javascript</strong> or <strong> Python</strong></p>
				<textarea name="script" type="text" hidden id="script">{{ old('script') ?? '' }}</textarea>
				<div id="testScriptEditor"></div>
			</div>
		</div>
		<button type="submit" class="myButton bigButton align-self-center">Create</button>
	</form>
@endsection


	