@extends('layouts.teacher')


@section('content')
    <nav class="back-nav">
			<a href="{{ route('student_teacherIndex') }}"><i class="fas fa-arrow-alt-square-left"></i>All Students</a>
		</nav>
		<h2 class=" block-title light-card layer-2">{{ ucfirst($student->firstname) }} {{ ucfirst($student->lastname) }}</h2>

    <div class="row">
      <div class="col form-section layer-2 ml-4 d-flex flex-col justify-content-between">
        <div>
        <h3 class="title-3">Enrolments</h3>
        @if(count($student->coursesForTeacher())===0)
          <p>{{ $student->firstname }} {{ $student->lastname }} is not enrolled in any of your courses</p>
        @else 
            <table class="table" id="existingEnrolments">
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
      </div>
      
      <div class="col-12 col-xl-5 form-section layer-2 d-flex flex-col">
        <h3 class="title-3">Other Courses</h3>
        @if(count($otherCourses)===0)
          <p>No other courses in which this student is not enrolled,.</p>
        @else 
            <table class="table">
              <thead>
                <tr>
                  <th>Title</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
              @foreach($otherCourses->sort() as $course)
                <tr>
                  <th class="label" scope="row"><a href="{{ route('course_teacherShow', $course->id) }}">{{ $course->title}}</a></th>
                  <td><button class="myButton smallButton add" value="{{ $course->id }}">Add</button></td>
                </tr>
                @endforeach
              </tbody>
            </table>
        @endif
      </div>
    </div>  
@endsection

@section('scripts')
	<script type="text/javascript">
		let studentId = {{ $student->id }};
    let csrfToken = "<?= csrf_token() ?>";
	</script>
	<script src="{{ asset('js/teacher/teacherStudentEnrolments.js') }}"></script>
@endsection


