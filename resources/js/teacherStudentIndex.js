require('./functions.js');
window.onload = function(){
             
	let options = document.getElementById('options');
	let students = document.getElementById('students');
	let searchInput = document.getElementById('search');

	searchInput.addEventListener('keyup', function(){
	  var query = this.value; 
	  let xhr = new XMLHttpRequest();

	  xhr.onload = function() { //Fonction de rappel
		//console.log(this);
		if(this.status === 200) {
		  let data = this.responseText;
		  options.innerHTML = data;

		  document.querySelectorAll('#options button').forEach( (x) => {
			x.onclick = function(){
			  let option = this.closest('li');
			  let email = option.querySelector('small:first-of-type');
			  //add student to db by ajax request
			  addStudent(email.innerText);
			};
		  });
		}
	  };
	  const data = JSON.stringify({
		search:query,
		_token: csrfToken
	  });

	  xhr.open('POST', "/teacher/students/search");
	  xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	  xhr.setRequestHeader("Content-Type", "application/json");
	  xhr.send(data);
	  // end of ajax call
	});
  
  let body = document.querySelector('tbody');

  function addStudent(email){
	options.innerHTML = "";
	searchInput.value = "";

	let xhr = new XMLHttpRequest();

	xhr.onload = function() { //Fonction de rappel
	  if(this.status === 200) {
		let data = JSON.parse(this.responseText);
		if(data.success){
		  let student = data.student;
		  let tr = "<tr><td>"+student.firstname+"</td><td>"+student.lastname+"</td><td>"+student.email+"</td><td><a href='/teacher/students/"+student.id+"'><i class='fas fa-arrow-alt-square-right'></i>Manage</a></td>";
		  body.innerHTML += tr;
		  //show message
		  createFlashPopUp('Student Successfully Added');
		}
	  } else if(this.status === 403) {
		let data = JSON.parse(this.responseText);
		createFlashPopUp(data.msg, true);
	  } else {
		createFlashPopUp('Oops, Something Went Wrong', true);
	  }
	};
	const data = JSON.stringify({
	  email:email,
	  _token: csrfToken
	});

	xhr.open('POST', "/teacher/students/store");
	xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhr.setRequestHeader("Content-Type", "application/json");
	xhr.send(data);
  }
};