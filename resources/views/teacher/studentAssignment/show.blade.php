@extends('layouts.teacher')


@section('content')

		<h2 class=" block-title light-card layer-2">{{ ucfirst($studentAssignment->assignment->title) }}</h2>

    <div class="row">
      <div class="col-12 col-xl-7 form-section layer-2 d-flex flex-col mx-2">
      
      <h3 class="title-3">Assignment</h3>
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
          <span>{{ $studentAssignment->assignment->start_time }}</span>
        </div>
        <div class="label-value">
          <span class="label">End</span>
          <span>{{ $studentAssignment->assignment->end_time }}</span>
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
      <div class="col form-section layer-2 mx-2 d-flex flex-col justify-content-between">
        <h3 class="title-3">{{ ucfirst($student->firstname) }} {{ ucfirst($student->lastname) }}</h3>
            <div class="label-value">
              <span class="label">Submissions</span>
              <span>{{ count($studentAssignment->submissions)}}</span>
            </div>
            <div class="label-value">
              <span class="label">Final Mark</span>
              <span>{{ $studentAssignment->mark!=null ? $studentAssignment->mark.' / '.$studentAssignment->assignment->max_mark :  '-' }}</span>
            </div>
            @if($studentAssignment->canBeMarked())
            <div class="d-flex justify-content-end"><a href="{{ route('studentAssignment_teacherEditMark', $studentAssignment->id) }}"><i class="fas fa-edit"></i>Edit Mark</a></div>
            @endif
            
      </div>
    </div>
    <h2 class=" block-title light-card layer-2">Submissions</h2>
    @if(count($studentAssignment->submissions)==0)
    <div class="form-section layer-2">
      <p>No submissions</p>
    </div>
    @else
      @foreach($studentAssignment->submissions as $submission)
      <div class="form-section layer-2">
        <div class="row">
          <div class="col-12 col-xl-9 mx-2">
            <h3>Submission on {{ $submission->created_at}}</h3>
            <div>{{$submission->content}}</div>
            @if($studentAssignment->assignment->can_execute && $submission->status)
              <h3>Console</h3>
              <ul class="console"><li></li><li>{{$submission->status ?? 'No console message'}}</li></ul>
            @endif
          </div>
          @if($submission->question)
          <div class="col mx-2">
            <h3>Question/Note</h3>
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

<script>

window.onload = function(){

//editable final url
  document.querySelectorAll(".updateFeedback > div > button").forEach( btn => {
      btn.addEventListener('click',  function(){
        let outerDiv =  this.closest('.updateFeedback');
        let p = outerDiv.querySelector('p');
        let currentText = p.innerText;
        
        let textarea = document.createElement('TEXTAREA');
        textarea.innerText = currentText;
        textarea.setAttribute('rows', 3);
        //textarea.setAttribute('cols', 150);
        textarea.style.width = '100%';
        textarea.setAttribute('width', '100%');
        
        this.style.display = 'none';
        let myButton = this;
        outerDiv.replaceChild(textarea, p);
        $(textarea).focus();
        $(textarea).blur(async function() {
          let newcont = $(this).val().trim();
           
          let xhr = new XMLHttpRequest();
          xhr.onload = function() { //Fonction de rappel
          let ans = false;
          if(this.status === 200) {
            let data = this.responseText;
            data = JSON.parse(data);
            if(data.success){
              ans = data.feedback;
            } 
          }
          if(!ans){
              createFlashPopUp('Oops, Something Went Wrong', true);
            } else {
              createFlashPopUp('Feedback Updated');
            }
            let p = document.createElement('p');
            p.innerText = ans ? ans : currentText;
            outerDiv.replaceChild(p, textarea);
            myButton.style.display = 'inline-block';
          
        };
        const data = JSON.stringify({
          _token: "<?= csrf_token() ?>",
          feedback: newcont,
        });

        xhr.open('POST', "/teacher/submissions/"+myButton.value+"/updateFeedback");
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.setRequestHeader("Content-Type", "application/json");
        xhr.send(data);  

            
        });
      }) 
    })
  };
    function createFlashPopUp(msg, error = false){
    let div = document.createElement('div');
    div.classList.add('alert', 'flash-popup');
    if(error){
        div.classList.add('alert-danger');
    } else {
        div.classList.add('alert-success');
    }
    div.innerText = msg;
    document.body.appendChild(div);
}

    
</script>

