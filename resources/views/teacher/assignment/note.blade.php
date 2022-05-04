@extends('layouts.teacher')


@section('content')

		<h2 class=" block-title light-card layer-2">{{ ucfirst($assignment->title) }}</h2>
    <div style="max-width:800px;margin:auto">
      <div class="form-section layer-2 d-flex flex-col">
        <h3>New Note</h3>
        <form action="{{ route('assignmentNote_teacherStore', $assignment->id) }}" method="post" >
          @csrf
          <textarea name="note" style="width:100%" rows=4></textarea>
          <div class="btn-box btn-right mb-3"> 
            <button class="myButton">Save</button>
          </div>
          @if($errors->get('note'))
          <div class="form-section errors alert alert-danger">
            <p>Please enter a note between 0 and 65,535 characters.</p>
          </div>
          @endif
        </form>
      </div>
  </div>
   @endsection