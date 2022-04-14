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
            <h3 class="title-3">Remove From My Students</h3>
            <p>Removing a student from your list will delete all associated data, such as marks, submissions, etc. This cannot be undone</p>
            <a class="align-self-end mb-2 highlight"><i class="fas fa-trash-alt"></i>Remove Student</a>
      </div>
      <div class="col form-section layer-2 ml-4 d-flex flex-col justify-content-between">
        <div>
        <h3 class="title-3">Courses</h3>
        @if(count($student->coursesForTeacher())===0)
          <p>{{ $student->firstname }} {{ $student->lastname }} is not enrolled in any of your courses</p>
        @else 
          @foreach($student->coursesForTeacher() as $course)
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">Name</th>
                  <th scope="col">Since</th>
                  <th scope="col">Final Mark</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">{{ $course->title}}</th>
                  <td>{{ $course->pivot->created_at ? date('d-m-Y', $course->pivot->created_at->timestamp) : '-'}}</td>
                  <td>{{ $course->pivot->final_mark ?? '-'}}</td>
                </tr>
              </tbody>
            </table>
            
          @endforeach
        @endif
        </div>
        <a class="myButton align-self-end mb-2">Manage Enrolments</a>
      </div>
    </div>
      
      


    @foreach($student->coursesForTeacher() as $course)
    
      <h2 class=" block-title light-card layer-2">{{ $course->title}}</h2>
      <div class="row form-section layer-2">
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
                    <td>{{ $chapter->isRead($student->id) }}</td>
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
              <span>TODO</span>
            </div>
          @endforeach
        </div>
    </div>
    @endforeach
      
@endsection

