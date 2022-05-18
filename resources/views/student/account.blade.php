@extends('layouts.student')

@section('content')

	<h2 class="light-card block-title layer-2 ">My Details</h2>
<div class="row">
	<div class="layer-2 form-section col">
		<div class="label-value my-3">
			<span>Firstname</span>
			<span>{{ $student->firstname }}</span>
		</div>
		<div class="label-value  my-3">
			<span>Lastname</span>
			<span>{{ $student->lastname }}</span>
		</div>
		<div class="label-value my-3">
			<span>Email</span>
			<span>{{ $student->email }}</span>
		</div>
		<div class="d-flex flex-col align-items-end mt-3">
			<a href="{{ route('student_studentEdit') }}"><i class="fas fa-pen-square"></i>Edit</a>
		</div>
	</div>

		
		
	<div class="form-section col-12 col-md-6 layer-2">
		<h3>I wish to delete my account</h3>
		<p>You may delete your account at any time. All your personal information will be removed, such as name, email address and password.</p>
	
		<div class="d-flex flex-col align-items-end mt-3">
		<a href="{{ route('student_confirmDelete') }}"><i class="fas fa-minus-square"></i>Delete</a>
		</div>
		
	</div>

</div>
@endsection


	