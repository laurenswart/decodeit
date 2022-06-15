@extends('layouts.teacher')


@section('content')
    <nav class="back-nav">
			<a href="{{ route('student_teacherIndex') }}"><i class="fas fa-arrow-alt-square-left"></i>All Students</a>
		</nav>
		<h2 class=" block-title light-card layer-2">{{ ucfirst($student->firstname) }} {{ ucfirst($student->lastname) }}</h2>

    <div class="row">
      <div class="col form-section layer-2 ml-4 d-flex flex-col justify-content-between">
        <div>
        <h3 class="title-3">Courses</h3>
        @if(count($student->coursesForTeacher())===0)
          <p>{{ $student->firstname }} {{ $student->lastname }} is not enrolled in any of your courses</p>
        @else 
         
            <table class="table">
              <thead>
                <tr>
                  <th>Title</th>
                  <th scope="col">Since</th>
                  <th scope="col">Final Mark</th>
                </tr>
              </thead>
              <tbody>
              @foreach($student->coursesForTeacher()->sort() as $course)
                <tr>
                  <th class="label" scope="row"><a href="{{ route('course_teacherShow', $course->id) }}">{{ $course->title}}</a></th>
                  <td>{{ $course->pivot->created_at ? date('d/m/Y', $course->pivot->created_at->timestamp) : '-'}}</td>
                  <td>{{ $course->pivot->final_mark ? $course->pivot->final_mark.' / 100' : '-'}}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
            
          
        @endif
        </div>
        <a class="myButton align-self-end mb-2" href="{{ route('student_teacherEnrolments', $student->id) }}">Manage Enrolments</a>
      </div>
      
      <div class="col-12 col-xl-5 form-section layer-2 d-flex flex-col">
        <h3 class="title-3">Student Info</h3>
            <div class="label-value">
              <span>Firstname</span>
              <span>{{ $student->firstname }}</span>
            </div>
            <div class="label-value">
              <span>Lastname</span>
              <span>{{ $student->lastname }}</span>
            </div>
            <div class="label-value mb-3">
              <span>Email</span>
              <span>{{ $student->email }}</span>
            </div>
            <hr>
				    <div class="d-flex flex-col align-items-end mt-3">
              <a href="{{ route('student_teacherDownloadReport', $student->id) }}"><i class="fas fa-arrow-alt-to-bottom"></i>Download Report</a>
              <a href="{{ route('student_teacherConfirmDelete', $student->id) }}"><i class="fas fa-trash-alt"></i>Remove Student</a>
            </div>
      </div>
    </div>
      
      
@if(count($student->coursesForTeacher())>0)

    @foreach($student->coursesForTeacher() as $course)
    
      <h2 class=" block-title light-card layer-2">{{ $course->title}}</h2>
      <div class="">
        <div class="row">
        <div class="col-12 col-xl-7 form-section layer-2">
          <h3  class="title-3">Chapters</h3>
          @if(count($course->chapters->sortBy('order_id'))===0)
            <p>No chapters created</p>
          @else 
          <table class="table">
              <thead>
                <tr>
                  <th scope="col">Name</th>
                  <th scope="col">Read</th>
                </tr>
              </thead>
              <tbody>
            @foreach($course->chapters as $chapter)
                  <tr>
                    <th class="label"><a href="{{ route('chapter_teacherShow', $chapter->id)}}">{{ $chapter->title}}</a></th>
                    <td class="cell-center">{!! $chapter->isRead($student->id) ? '<i class="fas fa-check-square greyed no-hover"></i>' : '-' !!}</td>
                  </tr>
            @endforeach
              </tbody>
            </table>
            @endif
        </div>
        <div class="col ml-4 form-section layer-2 d-flex flex-col justify-content-between">
          <div>
            <h3 class="title-3">Skills</h3>
            @foreach($course->skills->sort() as $skill)
              <div class="label-value">
                <span>{{ $skill->title}}</span>
                <span>{{ $skill->studentMark($student->id)!==null ? $skill->studentMark($student->id).' /100' : '-'}}<a href="{{ route('studentSkill_teacherEdit', [$student->id, $skill->id]) }}"><i class="fas fa-pen-square"></i>Edit</a></span>
              </div>
            @endforeach
          </div>
          <div class="d-flex flex-col">
            <h3 class="title-3">Final Mark</h3>
            <div class="align-self-end title-3">{{ $course->enrolmentForStudent($student->id)->final_mark ?? '-'}} / 100</div>
            <div class="align-self-end"><a href="{{ route('enrolment_teacherEdit', $course->enrolmentIdForStudent($student->id)) }}"><i class="fas fa-pen-square"></i>Edit</a></div>
          </div>
        </div>
        </div>
        <div class="form-section layer-2">
        <h3 class="title-3">Linked Assignments</h3>
          @if(count($course->assignments)===0)
            <p>No assignments created</p>
          @else 
          <table class="table">
              <thead>
                <tr>
                  <th scope="col">Name</th>
                  <th scope="col" class="cell-center">Submissions</th>
				          <th scope="col" class="cell-center">Questions to Answer</th>
                  <th scope="col" class="cell-center">Mark</th>
				          <th></th>
                </tr>
              </thead>
              <tbody>
              @foreach($course->assignments->sort() as $assignment)
                <tr>
                   <td class="label"><a href="{{ route('assignment_teacherShow', $assignment->id)}}">{{ ucfirst($assignment->title) }}</a></td>
              @if($assignment->studentAssignmentByStudent($student->id)==null)
              <td class="cell-center">-</td>
              <td class="cell-center">-</td>
              <td class="cell-center">-</td>
              <td class="cell-center">    @if(strtotime($assignment->end_time) < now()->timestamp) 
                    <a href="{{ route('studentAssignment_teacherStore', [$assignment->id, $student->id]) }}"><i class="fas fa-arrow-alt-square-right"></i>Manage</a>
                  @else 
                    -
                  @endif
                </td>
              @else
               
                   <td class="cell-center">{{ count($assignment->studentAssignmentByStudent($student->id)->submissions) ?? '-'}}</td>
				          <td class="cell-center">
                    @if(count($assignment->studentAssignmentByStudent($student->id)->submissions->whereNull('feedback')->whereNotNull('question')))
                      <i class="fas fa-exclamation-square"></i>
                    @else
                      -
                    @endif
                  </td>
                  <td class="cell-center">
                  @if($assignment->studentAssignmentByStudent($student->id)->mark!==null) 
                    {{$assignment->studentAssignmentByStudent($student->id)->mark}} / {{ $assignment->max_mark}}
                  @elseif($assignment->studentAssignmentByStudent($student->id)->canBeMarked()) 
                    To do<i class="fas fa-exclamation-square"></i>
                  @else 
                    -
                  @endif</td>
					        <td class="cell-center"><a href="{{ route('studentAssignment_teacherShow', $assignment->studentAssignmentByStudent($student->id)->id) }}"><i class="fas fa-arrow-alt-square-right"></i>Manage</a></td>
                </tr>
                @endif
              
              @endforeach
              </tbody>
            </table>
            @endif
        </div>
    </div>

    @endforeach
  @endif    
@endsection

