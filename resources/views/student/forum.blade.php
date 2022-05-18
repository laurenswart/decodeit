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
			<textarea rows="4" placeholder="Message ..." maxlength="65535"></textarea>
			<button class="myButton mt-2">Send</button>
		</div>
@endsection

@section('scripts')
	<script type="text/javascript">
		let courseId = <?= $course->id ?>;
		let csrfToken = "<?= csrf_token() ?>";
	</script>
	<script src="{{ asset('js/student/studentForum.js') }}"></script>
@endsection



