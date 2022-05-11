@extends('layouts.teacher')


@section('content')

		<h2 class=" block-title light-card layer-2">{{ ucfirst($student->firstname) }} {{ ucfirst($student->lastname) }}</h2>

    <div class="row">
      <div class="col-12 col-xl-5 form-section layer-2 d-flex flex-col">
            <div class="label-value">
              <h4>Firstname</h4>
              <span>{{ $student->firstname }}</span>
            </div>
            <div class="label-value">
              <h4>Lastname</h4>
              <span>{{ $student->lastname }}</span>
            </div>
            <div class="label-value">
              <h4>Email</h4>
              <span>{{ $student->email }}</span>
            </div>
            <div class="d-flex justify-content-between">
              <a href="{{ route('student_teacherDownloadReport', $student->id) }}"><i class="fas fa-arrow-alt-to-bottom"></i>Download Report</a>
              <a href="{{ route('student_teacherConfirmDelete', $student->id) }}"><i class="fas fa-trash-alt"></i>Remove Student</a>
            </div>
      </div>
      <div class="col form-section layer-2 ml-4 d-flex flex-col justify-content-between">
        <div>
        <h3 class="title-3">Courses</h3>
        @if(count($student->coursesForTeacher())===0)
          <p>{{ $student->firstname }} {{ $student->lastname }} is not enrolled in any of your courses</p>
        @else 
         
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Name</th>
                  <th scope="col">Since</th>
                  <th scope="col">Final Mark</th>
                </tr>
              </thead>
              <tbody>
              @foreach($student->coursesForTeacher() as $course)
                <tr>
                  <th scope="row">{{ $course->title}}</th>
                  <td>{{ $course->pivot->created_at ? date('d-m-Y', $course->pivot->created_at->timestamp) : '-'}}</td>
                  <td>{{ $course->pivot->final_mark ?? '-'}}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
            
          
        @endif
        </div>
        <a class="myButton align-self-end mb-2">Manage Enrolments</a>
      </div>
    </div>
      
      


    @foreach($student->coursesForTeacher() as $course)
    
      <h2 class=" block-title light-card layer-2">{{ $course->title}}</h2>
      <div class="form-section layer-2">
        <div class="row">
        <div class="col-12 col-xl-7">
          <h4>Chapters</h4>
          @if(count($course->chapters)===0)
            <p>No chapters created</p>
          @else 
          <table class="table">
              <thead>
                <tr>
                  <th scope="col">Name</th>
                  <th scope="col">Read</th>
                  <th scope="col">Assignments Missed</th>
                </tr>
              </thead>
              <tbody>
            @foreach($course->chapters as $chapter)
                  <tr>
                    <th scope="row">{{ $chapter->title}}</th>
                    <td>{{ $chapter->isRead($student->id) ? 'Yes' : '-' }}</td>
                    <td>TODO</td>
                  </tr>
            @endforeach
              </tbody>
            </table>
            @endif
        </div>
        <div class="col ml-4">
          <h4>Skills</h4>
          @foreach($course->skills as $skill)
            <div class="label-value">
              <span>{{ $skill->title}}</span>
              <span>{{ $skill->studentMark($student->id)!==null ? $skill->studentMark($student->id).' /100' : '-'}}<a href="{{ route('studentSkill_teacherEdit', [$student->id, $skill->id]) }}"><i class="fas fa-pen-square"></i></a></span>
            </div>
          @endforeach
        </div>
        </div>
        <div>
        <h4>Assignments</h4>
          @if(count($course->assignments)===0)
            <p>No assignments created</p>
          @else 
          <table class="table">
              <thead>
                <tr>
                  <th scope="col">Name</th>
                  <th scope="col">Submissions</th>
				          <th scope="col">Questions to Answer</th>
                  <th scope="col">Mark</th>
				          <th></th>
                </tr>
              </thead>
              <tbody>
              @foreach($course->assignments as $assignment)
                <tr>
                   <th>{{ ucfirst($assignment->title) }}</th>
              @if($assignment->studentAssignmentByStudent($student->id)==null)
              <td colspan="3">No submissions</td>
              @else
               
                   <td>{{ count($assignment->studentAssignmentByStudent($student->id)->submissions) ?? '-'}}</td>
				          <td>
                    @if(count($assignment->studentAssignmentByStudent($student->id)->submissions->whereNull('feedback')->whereNotNull('question')))
                      <i class="fas fa-exclamation-square"></i>
                    @else
                      -
                    @endif
                  </td>
                  <td>
                  @if($assignment->studentAssignmentByStudent($student->id)->mark) 
                    {{$assignment->studentAssignmentByStudent($student->id)->mark}} / {{ $assignment->max_mark}}
                  @elseif($assignment->studentAssignmentByStudent($student->id)->canBeMarked()) 
                    To do<i class="fas fa-exclamation-square"></i>
                  @else 
                    -
                  @endif</td>
					      <td><a href="{{ route('studentAssignment_teacherShow', $assignment->studentAssignmentByStudent($student->id)->id) }}"><i class="fas fa-arrow-alt-square-right greyed"></i>Manage</a></td>
                </tr>
                @endif
              
              @endforeach
              </tbody>
            </table>
            @endif
        </div>
    </div>

    @endforeach
      
@endsection

