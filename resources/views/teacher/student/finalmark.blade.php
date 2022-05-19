@extends('layouts.teacher')


@section('content')
  <nav class="back-nav">
			<a href="{{ route('student_teacherShow', $enrolment->student->id) }}"><i class="fas fa-arrow-alt-square-left"></i>{{ ucfirst($enrolment->student->firstname) }} {{ ucfirst($enrolment->student->lastname) }}</a>
		</nav>
		<h2 class=" block-title light-card layer-2">Skill Acquisition</h2>
    <div class="row">
      <div class="form-section layer-2 d-flex flex-col col-10 col-xl-6">
      
        <div class="label-value">
          <span class="label">Student</span>
          <span><a href="{{ route('student_teacherShow', $enrolment->student->id) }}">{{ ucfirst($enrolment->student->firstname) }} {{ ucfirst($enrolment->student->lastname) }}</a></span>
        </div>
        <div class="label-value">
          <span class="label">Course</span>
          <span><a href="{{ route('course_teacherShow', $enrolment->course_id) }}">{{ $enrolment->course->title }}</a></span>
        </div>
      </div>

      <div class="form-section layer-2 col">
        
        <form action="{{ route('enrolment_teacherUpdate', $enrolment->id) }}" method="post" >
          @csrf
          <div class="d-flex justify-content-between align-items-center">
            <h3 class="title-3">Mark</h3>
            <div>
              <input type="number" min="0" name="mark" max="100" value="{{ old('mark') ?? ($enrolment->final_mark ?? 0)}}">
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
            <p class="mb-4">No assignments linked to this skill.</p>
          @else 
          <table class="table mb-4">
              <thead>
                <tr>
                  <th scope="col"></th>
                  <th class="cell-center">Course Weight</th>
                  <th class="cell-center">Test</th>
                  <th scope="col" class="cell-center">Mark</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
              @foreach($assignments->sortBy('start_time') as $assignment)
                <tr>
                   <td class="label"><a href="{{ route('assignment_teacherShow', $assignment->id)}}">{{ ucfirst($assignment->title) }}</a></td>
                   <td class="cell-center">{{ $assignment->course_weight }}</td>
                   <td class="cell-center">{!! $assignment->is_test ? '<i class="fas fa-check-square greyed "></i>' : '-' !!}</td>
                   @if($assignment->studentAssignmentByStudent($enrolment->student_id)==null)
                      <td class="cell-center">-</td>
                      <td class="cell-center">
                      @if(strtotime($assignment->end_time) < now()->timestamp) 
                        <a href="{{ route('studentAssignment_teacherStore', [$assignment->id, $enrolment->student_id]) }}"><i class="fas fa-arrow-alt-square-right"></i>View Submissions</a>
                      @else 
                        -
                      @endif
                      </td>
                    @else
                      <td class="cell-center">
                          @if($assignment->studentAssignmentByStudent($enrolment->student_id)->mark!==null) 
                            {{$assignment->studentAssignmentByStudent($enrolment->student_id)->mark}} / {{ $assignment->max_mark}}
                          @elseif($assignment->studentAssignmentByStudent($enrolment->student_id)->canBeMarked()) 
                            To do<i class="fas fa-exclamation-square"></i>
                          @else 
                            -
                          @endif
                      </td>
					            <td class="cell-center"><a href="{{ route('studentAssignment_teacherShow', $assignment->studentAssignmentByStudent($enrolment->student_id)->id) }}"><i class="fas fa-arrow-alt-square-right"></i>View Submissions</a></td>
                    @endif
                    
                </tr>
              @endforeach
              </tbody>
            </table>
            @if($computation && $computedMark)
            <h3 class="title-3 mt-4">Predicted Final Mark</h3>
              <p>Based on the course weights and taking into account assignments with marks, the following mark is suggested for the student : </p>
              <p class="text-center">{!! $computation !!} = {{ $computedMark }} / 100</p>
            @endif
          @endif

          <div style="max-width:600px;">
            <h3 class="title-3">Skills</h3>
            @if(count($enrolment->course->skills)==0)
              <p>No skills created in this course</p>
            @else
            <table class="table mb-4">
              <thead>
                <tr>
                  <th scope="col"></th>
                  <th scope="col" class="cell-center">Mark</th>
                </tr>
              </thead>
              <tbody>
                @foreach($enrolment->course->skills->sort() as $skill)
                  <tr>
                    <td>{{ $skill->title}}</td>
                    <td class="cell-center">{{ $skill->studentMark($enrolment->student->id)!==null ? $skill->studentMark($enrolment->student->id).' /100' : '-'}}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
            @endif
          </div>
        </div>

   @endsection