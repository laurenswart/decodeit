@extends('layouts.student')

@section('content')

	<h2 class="light-card block-title layer-2 ">My Details</h2>

	<div class="layer-2 form-section"  style="max-width:800px;margin:auto">
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
@endsection


	