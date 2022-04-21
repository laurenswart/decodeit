@extends('layouts.teacher')

@section('content')

	<h2 class="light-card block-title layer-2 ">Are you sure want to delete this {{ $resource }}?</h2>

	<div class="layer-2 form-section">
		<a href="{{ $backRoute }}" class="top-right"><i class="fas fa-arrow-alt-square-left"></i>Cancel</a>
		<p>{!! $message!!}</p>
		<form method="post" action="{{ $route }}" class="d-flex justify-content-center">
			@csrf
			@method("DELETE")
			<button type="submit" class="myButton">Confirm</button>
		</form>
	</div>
@endsection


	