@extends('layouts.teacher')

@section('content')
  <h2 class="light-card block-title layer-1">Payment Succeeded !</h2>
  <div class="form-section layer-2">
  <p>Thank you for subscribing to DecodeIt ! 
    <br>Checkout your <a href="{{ route('teacher_account') }}"> account information</a>, start <a href="{{ route('course_teacherCreate') }}">creating course content</a>, 
    or add <a href="{{ route('student_teacherIndex') }}">new students</a> ! </p>
  </div>

@endsection