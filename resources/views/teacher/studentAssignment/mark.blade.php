@extends('layouts.teacher')


@section('content')

		<h2 class=" block-title light-card layer-2">{{ ucfirst($studentAssignment->assignment->title) }}</h2>
    <div style="max-width:800px;margin:auto">
      <div class="form-section layer-2 d-flex flex-col">
      
        <div class="label-value">
          <span class="label">Student</span>
          <span>{{ ucfirst($student->firstname) }} {{ ucfirst($student->lastname) }}</span>
        </div>
        <div class="label-value">
          <span class="label">Course</span>
          <span>{{ $studentAssignment->assignment->course->title }}</span>
        </div>
        <div class="label-value">
          <span class="label">Chapter</span>
          <span>{{ $studentAssignment->assignment->chapters[0]->title }}</span>
        </div>
        <div class="label-value">
          <span class="label">Start</span>
          <span>{{ $studentAssignment->assignment->start_time_string() }}</span>
        </div>
        <div class="label-value">
          <span class="label">End</span>
          <span>{{ $studentAssignment->assignment->end_time_string() }}</span>
        </div>
        <div class="label-value">
          <span class="label">Type</span>
          <span>{{ $studentAssignment->assignment->is_test ? 'Test' : 'Exercise' }}</span>
        </div>
        <div class="label-value">
          <span class="label">Language</span>
          <span>{{ $studentAssignment->assignment->language ? ucfirst($studentAssignment->assignment->language).($studentAssignment->assignment->can_execute ? ' ( With Code Execution )' : ' ( Without Code Execution )') : '-' }}</span>
        </div>
      </div>

      <div class="form-section layer-2">
        
        <form action="{{ route('studentAssignment_teacherUpdateMark', $studentAssignment->id) }}" method="post" >
          @csrf
          <div class="d-flex justify-content-between">
            <h3>Final Mark</h3>
            <div>
              <input type="number" min="0" name="mark" max="{{ $studentAssignment->assignment->max_mark}}" value="{{ old('mark') ?? ($studentAssignment->mark ?? 0)}}">
                / {{ $studentAssignment->assignment->max_mark}}
            </div>
          </div>
          <div class="btn-box centered mb-3"> 
            <button class="myButton">Save</button>
          </div>
          @if($errors->any())
          <div class="form-section errors alert alert-danger">
            @foreach($errors->all() as $error)
              <p>{{ $error }}</p>
            @endforeach
          </div>
          @endif
        </form>
      </div>
  </div>
   @endsection