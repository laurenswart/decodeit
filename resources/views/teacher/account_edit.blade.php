@extends('layouts.student')

@section('content')
<nav class="back-nav">
	<a href="{{ route('teacher_account') }}"><i class="fas fa-arrow-alt-square-left"></i>Back</a>
</nav>
<h2 class="light-card block-title layer-2 ">My Details</h2>
<form action="{{ route('teacher_teacherUpdate') }}" method="post">
	@csrf
	<div class="layer-2 form-section" style="max-width:800px;margin:auto">
		<div class="label-value mt-3">
			<span>Firstname</span>
			<input type="text" value="{{ old('firstname') ?? $teacher->firstname }}" name="firstname" id="firstname">
		</div>
		@if($errors->any('lastname'))
			<div class="error-msg">
			{{ $errors->first('firstname') }}
			</div>
		@endif
		<div class="label-value mt-3">
			<span>Lastname</span>
			<input type="text" value="{{ old('lastname') ?? $teacher->lastname }}" name="lastname" id="lastname">
		</div>
		@if($errors->any('lastname'))
			<div class="error-msg">
			{{ $errors->first('lastname') }}
			</div>
		@endif
		<div class="d-flex justify-content-center my-4">
			<button class="myButton bigButton">Save</button>
		</div>
	</div>
</form>
@endsection


	