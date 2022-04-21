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
		@if($errors->get('students.*.*'))
			<p>We are unable to add these students.</p>
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
						<input class="form-check-input" type="checkbox" id="active" name="active" {{ old('active')=='on'  ? 'checked' : (!$errors->any() && $course->is_active ? 'checked' : '') }}>
						<label class="form-check-label title-3 ml-4" for="active">
							Active
						</label>
					</div>
				</div>	
			<div class="form-section layer-2">
				<!--SKILLS-->
				<h3 class="title-3">Skills</h3>
				<div id="skills">
					@if(count($course->skills) >0 )
						@foreach($course->skills as $skill)
							<div class="mb-2">
								<div class="mb-3">
									<input type="text" class="form-control" name="oldSkills[{{ $skill->id }}][title]" placeholder="Skill Name" value="{{ old('oldSkills.'.$skill->id.'.title') ?? (!$errors->any() ? $skill->title : '') }}">
								</div>
								<div class="mb-3 ml-4">
									<textarea class="form-control" name="oldSkills[{{ $skill->id }}][description]" rows="3" placeholder="Skill Description .. ">{{ old("oldSkills.$skill->id.description") ?? ( !$errors->any() ?$skill->description : '') }}</textarea>
								</div>
							</div>
						@endforeach
					@endif
					@if(old('skills'))
						@foreach(old('skills') as $newSkillId => $newSkillData)
							<div class="mb-2">
								<div class="mb-3">
									<input type="text" class="form-control" name="skills[{{ $newSkillId }}][title]" placeholder="Skill Name" value="{{ old('skills.'.$newSkillId.'.title') ?? '' }}">
								</div>
								<div class="mb-3 ml-4">
									<textarea class="form-control" name="skills[{{ $newSkillId }}][description]" rows="3" placeholder="Skill Description .. ">{{ old("skills.$newSkillId.description") ?? ''}}</textarea>
								</div>
							</div>
						@endforeach
					@endif
				</div>
				<div class="d-flex justify-content-end">
					<button type="button" class="highlight" id="addSkill"><i class="fas fa-plus-square"></i>More Skills</button>
				</div>
			</div>
		</div>
		<div class="col ml-4">
			<div class="form-section layer-2 d-flex flex-column">
				<h3 class="title-3">New Enrolments</h3>
				<input type="text" id="search" placeholder="Find Student">
				<ul class="list-group" id="options" style="display:block;position:relative;z-index:1;"></ul>
				<div id="students" class="mt-4 d-flex flex-column">
					@if(old('students'))
						@foreach(old('students') as $newStudentId => $newStudent)
						<div class="d-flex justify-content-between mt-2 newStudent">
							<input type="hidden" name="students[{{$newStudentId}}][name]" value="{{ old('students.'.$newStudentId.'.name') ?? '' }}"  class="mt-3 d-block">
							<input type="hidden" name="students[{{$newStudentId}}][email]" value="{{ old('students.'.$newStudentId.'.email') ?? '' }}"  class="mt-3 d-block">
							<span>{{ old('students.'.$newStudentId.'.name') ?? '' }}</span>
							<button type="button" class="btn btn-outline-danger" onclick="remove(this)">x</button>
						</div>
						@endforeach
					@endif
					
				</div>
				@if(count($course->students)>0)
					<h4>Existing Enrolments</h4>
					@foreach($course->students as $oldStudent)
					<div class="mt-2">
						<span>{{ $oldStudent->firstname}} {{ $oldStudent->lastname}}</span>
					</div>
					@endforeach
				@endif
			</div>
		</div>
	</div>
	
	<button type="submit" class="myButton bigButton align-self-center">Save</button>
</form>
	
@endsection

@section('scripts')
	<script src="{{ asset('js/teacher/manageCourse.js') }}"></script>
	<script>
		 window.onload = function(){
             let options = document.getElementById('options');
			 let students = document.getElementById('students');
			 let searchInput = document.getElementById('search');
			 

			 let nbNewStudentsInPage = document.querySelectorAll('#students div.newStudent');

			 let nbNewStudents = nbNewStudentsInPage!=null ? nbNewStudentsInPage.length : 0;


			 searchInput.addEventListener('keyup', function(){
			   var query = this.value; 
			   let xhr = new XMLHttpRequest();

			   xhr.onload = function() { //Fonction de rappel
				 if(this.status === 200) {
				   let data = this.responseText;

				   options.innerHTML = data;
				   //students.parentNode.insertBefore(ul, students);
				   //ptions.innerHTML = data;

				   document.querySelectorAll('#options button').forEach( (x) => {
					 x.onclick = function(){
					   let option = this.closest('li');
					   let name = option.querySelector('span:first-of-type');
					   let email = option.querySelector('small:first-of-type');
					   //add student current form
					   addStudent(name.innerText, email.innerText);
					 };
				   });
				 }
			   };
			   const data = JSON.stringify({
				 search:query,
				 _token: "<?= csrf_token() ?>"
			   });

			   xhr.open('POST', "/teacher/searchMyStudents");
			   xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
			   xhr.setRequestHeader("Content-Type", "application/json");
			   xhr.send(data);
			   // end of ajax call
			 });
			 
			 function addStudent(name, email){
				nbNewStudents++;
				options.innerHTML = "";
              	searchInput.value = "";
				let div = document.createElement('div');
				div.classList.add('d-flex', 'justify-content-between', 'mt-2', 'newStudent');
				let string = '<input type="hidden" name="students['+nbNewStudents+'][name]" value="'+name+'"><input type="hidden" name="students['+nbNewStudents+'][email]" value="'+email+'"><span>'+name+'</span><button type="button" class="btn btn-outline-danger" onclick="remove(this)">x</button>';
				div.innerHTML = string;
				students.appendChild(div);
			 }

			 
			};
			function remove(button){
				button.closest('div').remove();
			 }
	</script>
@endsection

