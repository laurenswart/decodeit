require('./functions.js');


document.querySelector('.forum').scrollTop =document.querySelector('.forum').scrollHeight;

document.querySelector('#newMessage button').addEventListener('click', function(){
	var content = document.querySelector('#newMessage textarea').value; 
	//if question empty do nothing
	if(content=='') {
		return;
	}
	let xhr = new XMLHttpRequest();

	xhr.onload = function() { //Fonction de rappel
		if(this.status === 200) {
			let data = JSON.parse(this.responseText);
			createMessage(data.msg, data.date);
			document.querySelector('textarea').value='';
		} else {
			createFlashPopUp('Oops, Something went wrong', true);
		}
	};
	const data = JSON.stringify({
		content:content,
		_token: csrfToken
	});

	xhr.open('POST', "/student/courses/"+courseId+"/forum");
	xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhr.setRequestHeader("Content-Type", "application/json");
	xhr.send(data);
	// end of ajax call
});

function createMessage(content, date){
	let div = document.createElement('div');

	div.classList.add( 'layer-2', 'forum-msg', 'form-section', 'right');

	div.innerHTML = '<div class="msg-header"><span>Me</span><span class="date">'+date+'</span></div><p>'+content+'</p>';

	document.querySelector('.forum').appendChild(div);
	document.querySelector('.forum').scrollTop =document.querySelector('.forum').scrollHeight;
}