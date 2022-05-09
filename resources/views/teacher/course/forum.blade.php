@extends('layouts.student')

@section('content')


		<div class="h-end-link light-card  mt-4 layer-2">
			<h2 class=" block-title">{{ $course->title }}</h2>
			<a href="{{ url()->previous() }}"><i class="fas fa-arrow-alt-square-left"></i>Back</a>
		</div>

		<div class="forum">
        @foreach($messages as $message)
			<div class="layer-2 forum-msg form-section {{ $message->user->id == Auth::id() ? 'right' : ''}}">
				<div class="msg-header">
					<span>
						@if($message->user->id == Auth::id())
							Me
						@else
							{{ ucfirst($message->user->firstname) }} {{ ucfirst($message->user->lastname) }}
						@endif
						</span>
					<span class="date">{{ date('H:i:m d/m/Y', $message->created_at->timestamp) }}</span>
				</div>
				<p>{{$message->content}}</p>
			</div>
        @endforeach
		<div class="scroll"></div>
		</div>
		<div id="newMessage">
			<textarea rows="4" placeholder="Message ..." maxlength="65535"></textarea>
			<button class="myButton mt-2">Send</button>
		</div>
<script>
	function createFlashPopUp(msg, error = false){
    let div = document.createElement('div');
    div.classList.add('alert', 'flash-popup');
    if(error){
        div.classList.add('alert-danger');
    } else {
        div.classList.add('alert-success');
    }
    div.innerText = msg;
    document.body.appendChild(div);
}
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
		_token: "<?= csrf_token() ?>"
	});

	xhr.open('POST', "{{ route('message_teacherStore', $course->id) }}");
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
</script>
@endsection



