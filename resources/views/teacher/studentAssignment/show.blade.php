@extends('layouts.teacher')


@section('content')
  <nav class="back-nav">
			<a href="{{ route('student_teacherShow',  $studentAssignment->enrolment->student_id) }}"><i class="fas fa-arrow-alt-square-left"></i>{{ ucfirst($student->firstname) }} {{ ucfirst($student->lastname) }}</a>
		</nav>
		<h2 class=" block-title light-card layer-2">{{ $studentAssignment->assignment->title }}</h2>

    <div class="row">
     
      <div class="col form-section layer-2 mx-2 d-flex flex-col justify-content-between">
        <h3 class="title-3">{{ ucfirst($student->firstname) }} {{ ucfirst($student->lastname) }}</h3>
            <div class="label-value">
              <span class="label">Submissions</span>
              <span>{{ count($studentAssignment->submissions)}}</span>
            </div>
            <div class="label-value">
              <span class="label">Final Mark</span>
              <span class="fs-2 fw-bold">{{ $studentAssignment->mark!=null ? $studentAssignment->mark.' / '.$studentAssignment->assignment->max_mark :  '-' }}</span>
            </div>
            @if($studentAssignment->canBeMarked())
            <div class="d-flex justify-content-end"><a href="{{ route('studentAssignment_teacherEditMark', $studentAssignment->id) }}"><i class="fas fa-edit"></i>Edit Mark</a></div>
            @endif
      </div>
      <div class="col-12 col-xl-7 form-section layer-2 d-flex flex-col mx-2">
        <h3 class="title-3">Details</h3>
        <div class="label-value">
          <span class="label">Assignment</span>
          <span><a href="{{ route('assignment_teacherShow', $studentAssignment->assignment_id) }}">{{ $studentAssignment->assignment->title }}</a></span>
        </div>
        <div class="label-value">
          <span class="label">Chapter</span>
          <span><a href="{{ route('chapter_teacherShow', $studentAssignment->assignment->chapters[0]->id) }}">{{ $studentAssignment->assignment->chapters[0]->title }}</a></span>
        </div>
        <div class="label-value">
          <span class="label">Course</span>
          <span><a href="{{ route('course_teacherShow', $studentAssignment->id) }}">{{ $studentAssignment->assignment->course->title }}</a></span>
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
    </div>
    <h2 class="block-title light-card layer-2">Submissions</h2>
    @if(count($studentAssignment->submissions)==0)
    <div class="form-section layer-2">
      <p>No submissions</p>
    </div>
    @else
      @foreach($studentAssignment->submissions->sortBy('created_at') as $submission)
      <div class="form-section layer-2">
        <div class="row">
          <div class="col-12 col-xl-9 mx-2">
            <h3>Submission on {{ date('D d/m/Y, H:i', strtotime( $submission->created_at)) }}</h3>
            <div>{{$submission->content}}</div>
            @if($studentAssignment->assignment->can_execute && $submission->status)
              <h3>Console</h3>
              <ul class="console"><li></li><li>{{$submission->status ?? 'No console message'}}</li></ul>
            @endif
          </div>
          @if($submission->question)
          <div class="col mx-2">
            <h3>Question</h3>
            <p>{{ $submission->question }}</p>
          </div>
          @endif
        </div>
        <div class="mx-2 mt-4 form-highlight-section ">
          <h3>Feedback</h3>
          <div class="updateFeedback">
            <p>{{$submission->feedback ?? ''}}</p>
          
            <div class="btn-box btn-right"> 
              <button type="button" class="myButton" value="{{ $submission->id }}">Update Feedback</button>
            </div>
          </div>
        </div>
      </div>
      @endforeach
    @endif
@endsection

@section('scripts')
	<script type="text/javascript">
		let csrfToken = "<?= csrf_token() ?>";
	</script>
	<script src="{{ asset('js/teacher/teacherStudentAssignmentShow.js') }}"></script>
@endsection

