@extends('layouts.student')

@section('content')

<h2 class="light-card block-title layer-2 ">My Details</h2>
<form action="{{ route('student_studentUpdate') }}" method="post">
	@csrf
	<div class="layer-2 form-section" style="max-width:800px;margin:auto">
		<div class="label-value mt-3">
			<span>Firstname</span>
			<input type="text" value="{{ old('firstname') ?? $student->firstname }}" name="firstname" id="firstname">
		</div>
		<div class="label-value mt-3">
			<span>Lastname</span>
			<input type="text" value="{{ old('lastname') ?? $student->lastname }}" name="lastname" id="lastname">
		</div>
		<div class="label-value my-3">
			<span>Email</span>
			<input type="email" value="{{ old('email') ?? $student->email }}" name="email" id="email">
		</div>
		<div class="d-flex justify-content-center my-4">
			<button class="myButton bigButton">Save</button>
		</div>
	</div>
</form>
@endsection


	