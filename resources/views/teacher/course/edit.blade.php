@extends('layouts.teacher')

@section('content')

	<h2 class="light-card block-title layer-2 ">Edit Course</h2>
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


	<form action="{{ route('course_teacherUpdate', $course->id) }}" method="post"  class="d-flex flex-col">
	@csrf
	<div class="row justify-content-between ">
		<!--LEFT-->
		<div class="col-12 col-xl-7">
				<div class="form-section layer-2">
					<!--TITLE-->
					<div class="mb-3 row d-flex align-items-center">
						<label for="title" class="col col-form-label title-3">Chapter Title</label>
						<div class="col-12 col-md-8">
							<input type="text" class="form-control-plaintext col" id="title" name="title" value="{{ old('title') ?? $course->title }}">
						</div>
					</div>

					<!--ACTIVE-->
					<div class="form-check d-flex align-items-center">
						<input class="form-check-input" type="checkbox" id="active" name="active" {{ old('active')=='on'  ? 'checked' : ($course->is_active ? 'checked' : '') }}>
						<label class="form-check-label title-3 ml-4" for="active">
							Active
						</label>
					</div>
				</div>	
			<div class="form-section layer-2">
				<!--SKILLS-->
				<h3 class="title-3">Skills</h3>
				<div id="skills">
					@foreach($course->skills as $skill)
						<div class="mb-2">
							<div class="mb-3">
								<input type="text" class="form-control" name="oldSkills[{{ $skill->id }}][title]" placeholder="Skill Name" value="{{ $skill->title }}">
							</div>
							<div class="mb-3 ml-4">
								<textarea class="form-control" name="oldSkills[{{ $skill->id }}][description]" rows="3" placeholder="Skill Description .. ">{{ $skill->description }}</textarea>
							</div>
						</div>
					@endforeach
				</div>
				<div class="d-flex justify-content-end">
					<button type="button" class="highlight" id="addSkill"><i class="fas fa-plus-square"></i>More Skills</button>
				</div>
			</div>
		</div>
		<div class="col ml-4">
			<div class="form-section layer-2">
				<h3 class="title-3">Enrolments</h3>
				<div id="enrolments">
					@foreach($course->students as $student)
					<div class="mb-2">
						<input type="text" class="form-control" id="enrolments[{{ $student->id }}]" placeholder="Student" value="{{ $student->firstname.' '.$student->lastname}}" >
					</div>
					@endforeach
				</div>
				<div class="d-flex justify-content-end">
					<button type="button" class="highlight" id="addEnrolment"><i class="fas fa-plus-square"></i>More Students</button>
				</div>
			</div>
		</div>
	</div>
	
	<button type="submit" class="myButton bigButton align-self-center">Save</button>
</form>
	
@endsection

@section('scripts')
	<script src="{{ asset('js/teacher/manageCourse.js') }}"></script>
@endsection

