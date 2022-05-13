require('./functions.js');

window.onload = function(){

	//editable final url
	  document.querySelectorAll(".updateFeedback > div > button").forEach( btn => {
		  btn.addEventListener('click',  function(){
			let outerDiv =  this.closest('.updateFeedback');
			let p = outerDiv.querySelector('p');
			let currentText = p.innerText;
			
			let textarea = document.createElement('TEXTAREA');
			textarea.innerText = currentText;
			textarea.setAttribute('rows', 3);
			//textarea.setAttribute('cols', 150);
			textarea.style.width = '100%';
			textarea.setAttribute('width', '100%');
			
			this.style.display = 'none';
			let myButton = this;
			outerDiv.replaceChild(textarea, p);
			$(textarea).focus();
			$(textarea).blur(async function() {
			  let newcont = $(this).val().trim();
			   
			  let xhr = new XMLHttpRequest();
			  xhr.onload = function() { //Fonction de rappel
			  let ans = false;
			  if(this.status === 200) {
				let data = this.responseText;
				data = JSON.parse(data);
				if(data.success){
				  ans = data.feedback;
				} 
			  }
			if(!ans){
			    createFlashPopUp('Oops, Something Went Wrong', true);
			} else {
				createFlashPopUp('Feedback Updated');
			}
			let p = document.createElement('p');
			p.innerText = ans ? ans : currentText;
			outerDiv.replaceChild(p, textarea);
			myButton.style.display = 'inline-block';
			  
			};
			const data = JSON.stringify({
			  _token: csrfToken,
			  feedback: newcont,
			});
	
			xhr.open('POST', "/teacher/submissions/"+myButton.value+"/updateFeedback");
			xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
			xhr.setRequestHeader("Content-Type", "application/json");
			xhr.send(data);  
	
				
			});
		  }) 
		})
	  };
		
	