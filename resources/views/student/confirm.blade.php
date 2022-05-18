@extends('layouts.teacher')

@section('content')

	<h2 class="light-card block-title layer-2 ">{{ $title }}</h2>

	<div class="layer-2 form-section">
		<a href="{{ $backRoute }}" class="top-right"><i class="fas fa-arrow-alt-square-left"></i>Cancel</a>
		<p>{!! $message!!}</p>
		<form method="post" action="{{ $confirmAction }}" class="d-flex justify-content-center">
			@csrf
			@if($delete)  
				@method('DELETE')
			@endif
			<button class="myButton btn-highlight my-4" type="submit">{{ $confirmLabel }}</button>
		</form>
	</div>
@endsection


	