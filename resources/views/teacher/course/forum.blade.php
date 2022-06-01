@extends('layouts.teacher')

@section('content')
		<nav class="back-nav">
			<a href="{{ url()->previous() }}"><i class="fas fa-arrow-alt-square-left"></i>Back</a>
		</nav>

		<h2 class="block-title light-card  layer-2">{{ $course->title }}</h2>
			
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
					<span class="date">{{ date('D d/m/Y, H:i:m ', $message->created_at->timestamp) }}</span>
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

@endsection

@section('scripts')
<script type="text/javascript">
	let courseId = <?= $course->id ?>;
	let csrfToken = "<?= csrf_token() ?>";
</script>
<script src="{{ asset('js/teacher/teacherForum.js') }}"></script>
@endsection



