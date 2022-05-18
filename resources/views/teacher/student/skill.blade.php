@extends('layouts.teacher')


@section('content')
  <nav class="back-nav">
			<a href="{{ route('student_teacherShow', $student->id) }}"><i class="fas fa-arrow-alt-square-left"></i>{{ ucfirst($student->firstname) }} {{ ucfirst($student->lastname) }}</a>
		</nav>
		<h2 class=" block-title light-card layer-2">Skill Acquisition</h2>
    <div class="row">
      <div class="form-section layer-2 d-flex flex-col col-10 col-xl-6">
      
        <div class="label-value">
          <span class="label">Student</span>
          <span><a href="{{ route('student_teacherShow', $student->id) }}">{{ ucfirst($student->firstname) }} {{ ucfirst($student->lastname) }}</a></span>
        </div>
        <div class="label-value">
          <span class="label">Course</span>
          <span><a href="{{ route('course_teacherShow', $skill->course_id) }}">{{ $skill->course->title }}</a></span>
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

      <div class="form-section layer-2 col">
        
        <form action="{{ route('studentSkill_teacherUpdate', [$student->id, $skill->id]) }}" method="post" >
          @csrf
          <div class="d-flex justify-content-between align-items-center">
            <h3 class="title-3">Mark</h3>
            <div>
              <input type="number" min="0" name="mark" max="100" value="{{ old('mark') ?? ($currentMark ?? 0)}}">
                / 100
            </div>
          </div>
          @if($errors->get('mark'))
            <div class="error-msg">
              {{ $errors->first('mark') }}
            </div>
          @endif
          <div class="btn-box centered mb-3"> 
            <button class="myButton">Save</button>
          </div>
          
        </form>
        
          </div>
      </div>

      <div class="form-section layer-2">
        <h3 class="title-3">Assignments</h3>
        @if(count($assignments)===0)
            <p>No assignments linked to this skill.</p>
          @else 
          <table class="table">
              <thead>
                <tr>
                  <th scope="col"></th>
                  <th scope="col" class="cell-center">Mark</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
              @foreach($assignments->sortBy('start_time') as $assignment)
                <tr>
                   <td class="label"><a href="{{ route('assignment_teacherShow', $assignment->id)}}">{{ ucfirst($assignment->title) }}</a></td>
                    @if($assignment->studentAssignmentByStudent($student->id)==null)
                      <td class="cell-center">-</td>
                      <td class="cell-center">-</td>
                      <td>
                      @if(strtotime($assignment->end_time) < now()->timestamp) 
                        <a href="{{ route('studentAssignment_teacherStore', [$assignment->id, $student->id]) }}"><i class="fas fa-arrow-alt-square-right"></i>View Submissions</a>
                      @else 
                        -
                      @endif
                      </td>
                    @else
                      <td class="cell-center">
                          @if($assignment->studentAssignmentByStudent($student->id)->mark!==null) 
                            {{$assignment->studentAssignmentByStudent($student->id)->mark}} / {{ $assignment->max_mark}}
                          @elseif($assignment->studentAssignmentByStudent($student->id)->canBeMarked()) 
                            To do<i class="fas fa-exclamation-square"></i>
                          @else 
                            -
                          @endif
                      </td>
					            <td><a href="{{ route('studentAssignment_teacherShow', $assignment->studentAssignmentByStudent($student->id)->id) }}"><i class="fas fa-arrow-alt-square-right"></i>View Submissions</a></td>
                
                    @endif
                </tr>
              @endforeach
              </tbody>
            </table>
            @endif
      </div>
   @endsection