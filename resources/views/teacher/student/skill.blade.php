@extends('layouts.teacher')


@section('content')

		<h2 class=" block-title light-card layer-2">Skill Acquisition</h2>
    <div style="max-width:800px;margin:auto">
      <div class="form-section layer-2 d-flex flex-col">
      
        <div class="label-value">
          <span class="label">Student</span>
          <span>{{ ucfirst($student->firstname) }} {{ ucfirst($student->lastname) }}</span>
        </div>
        <div class="label-value">
          <span class="label">Course</span>
          <span>{{ $skill->course->title }}</span>
        </div>
        <div class="label-value">
          <span class="label">Skill</span>
          <span>{{ ucfirst($skill->title) }}</span>
        </div>
        <div class="label-value">
          <span class="label">Description</span>
          <span>{{ $skill->description }}</span>
        </div>
      </div>

      <div class="form-section layer-2">
        
        <form action="{{ route('studentSkill_teacherUpdate', [$student->id, $skill->id]) }}" method="post" >
          @csrf
          <div class="d-flex justify-content-between">
            <h3>Mark</h3>
            <div>
              <input type="number" min="0" name="mark" max="100" value="{{ old('mark') ?? ($currentMark ?? 0)}}">
                / 100
          </div>
          <div class="btn-box centered mb-3"> 
            <button class="myButton">Save</button>
          </div>
          
        </form>
        
      </div>
  </div>
  @if($errors->any())
          <div class="form-section errors alert alert-danger">
            @foreach($errors->all() as $error)
              <p>{{ $error }}</p>
            @endforeach
          </div>
          @endif
   @endsection