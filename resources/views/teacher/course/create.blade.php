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
		@if($errors->get('students.*'))
			<p>Chosen user could not be found within your students. Please chose a student from your list of added students.</p>
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
		<!--SKILLS-->
		<div class="col-12 col-md-5">
			<div class="form-section layer-2 d-flex flex-column">
				<h3>Enrolments</h3>
				<input type="text" id="search" placeholder="Find Student">
				<ul class="list-group" id="options" style="display:block;position:relative;z-index:1;"></ul>
				<div id="students" class="mt-4 d-flex flex-column">
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
	<script>
		 window.onload = function(){
             let options = document.getElementById('options');
			 let students = document.getElementById('students');
			 let searchInput = document.getElementById('search');

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
				options.innerHTML = "";
              	searchInput.value = "";
				let div = document.createElement('div');
				div.classList.add('d-flex', 'justify-content-between', 'mt-2');
				let string = '<input type="hidden" name="students[]" value="'+email+'"  class="mt-3 d-block"><span>'+name+'</span><button type="button" class="btn btn-outline-danger" onclick="remove(this)">x</button>';
				div.innerHTML = string;
				students.appendChild(div);
			 }

			 
			};
			function remove(button){
				button.closest('div').remove();
			 }
	</script>
@endsection

