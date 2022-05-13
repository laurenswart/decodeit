require('./functions.js');


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
		_token: csrfToken
	  });

	  xhr.open('POST', "/teacher/searchMyStudents");
	  xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	  xhr.setRequestHeader("Content-Type", "application/json");
	  xhr.send(data);
	  // end of ajax call
	});
	
	window.addStudent = function (name, email){
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
   window.remove = function (button){
	   button.closest('div').remove();
	}