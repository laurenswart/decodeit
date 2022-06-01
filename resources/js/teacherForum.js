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

	xhr.open('POST', 'forum');
	xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhr.setRequestHeader("Content-Type", "application/json");
	xhr.send(data);
	// end of ajax call
});

function createMessage(content, date){
	let div = document.createElement('div');
	div.classList.add( 'layer-2', 'forum-msg', 'form-section', 'right');

	let innerDiv = document.createElement('div');
	innerDiv.classList.add( 'msg-header');
	let divSpan1 = document.createElement('span');
	divSpan1.innerText = 'Me';
	let divSpan2 = document.createElement('span');
	divSpan2.classList.add( 'date');
	divSpan2.innerText = date;

	let p = document.createElement('p');
	p.innerText = content;

	innerDiv.appendChild(divSpan1);
	innerDiv.appendChild(divSpan2);
	div.appendChild(innerDiv);
	div.appendChild(p);

	document.querySelector('.forum').appendChild(div);
	document.querySelector('.forum').scrollTop =document.querySelector('.forum').scrollHeight;
}
