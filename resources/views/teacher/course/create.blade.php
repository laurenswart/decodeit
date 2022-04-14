@extends('layouts.teacher')

@section('content')

	<h2 class="light-card block-title layer-2 ">New Course</h2>
	@if($errors->any())
	<div class="form-section errors alert alert-danger">
		@if($errors->get('title'))
			<p>The course title is required and must have less than 100 characters</p>
		@endif
	 	@if($errors->get('skills.*.title'))
			<p>Skill titles must have less than 100 characters, and are required where the description is not empty.</p>
		@endif
		@if($errors->get('skills.*.description'))
			<p>Skill descriptions must have less than 255 characters</p>
		@endif
		
	</div>
	@endif


	<form action="{{ route('course_teacherStore') }}" method="post">
	@csrf
	<div class="row justify-content-between">
		<!--LEFT-->
		<div class="col col-md-6">
			<div class="form-section layer-2">
				<!--TITLE-->
				<div class="mb-3 row d-flex align-items-center">
					<label for="title" class="col col-form-label title-3">Course Title</label>
					<div class="col">
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
			<div class="form-section layer-2">
				<!--SKILLS-->
				<h3>Skills</h3>
				<div id="skills">
				</div>
				<div class="d-flex justify-content-end">
					<button type="button" class="highlight" id="addSkill"><i class="fas fa-plus-square"></i>More Skills</button>
				</div>
			</div>
		</div>
		<div class="col-12 col-md-5">
			<div class="form-section layer-2">
				<h3>Enrolments</h3>
				<div id="enrolments">
				</div>
				<div class="d-flex justify-content-end">
					<button type="button" class="highlight" id="addEnrolment"><i class="fas fa-plus-square"></i>More Students</button>
				</div>
			</div>
		</div>
	</div>
	
	<div class="d-flex justify-content-end">
		<button type="submit" class="myButton highlight">Create</button>
	</div>
</form>
	
@endsection

@section('scripts')
	<script src="{{ asset('js/teacher/manageCourse.js') }}"></script>
@endsection

