@extends('layouts.student')

@section('content')

		<h2 class="light-card block-title layer-2">{{ $course->title }}</h2>
		<div class="forum">
        @foreach($messages as $message)
			<div class="layer-2 forum-msg form-section {{ $message->user->id == Auth::id() ? 'right' : ''}}">
				<div class="msg-header">
					<span>
						@if($message->user->id == Auth::id())
							Me
						@else
							{{ ucfirst($message->user->firstname) }} {{ ucfirst($message->user->lastname) }}
							@if($message->user_id == $course->teacher_id)
							<i class="fas fa-star"></i>
							@endif
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
			
			<textarea rows="4"></textarea>
			<button class="myButton mt-2">Send</button>
		</div>
<script>
	console.log();
document.querySelector('.forum').scrollTop =document.querySelector('.forum').scrollHeight;
</script>
@endsection



