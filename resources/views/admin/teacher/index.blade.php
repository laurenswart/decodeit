@extends('layouts.admin')

@section('title')
  Teachers
@endsection

@section('content')
<div class="layer-2 admin-box">
<table class="table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Firstname</th>
            <th>Lastname</th>
            <th>Email</th>
            <th>Created</th>
        </tr>
    </thead>
    <tbody>
      @foreach($teachers as $teacher)
        
        <tr>
            <td>{{ $teacher->teacher_id }}</td>
            <td>{{ $teacher->firstname }}</td>
            <td>{{ $teacher->lastname }}</td>
            <td>{{ $teacher->email }}</td>
            <td>{{ $teacher->created_at }}<td>
        </tr>
       
      @endforeach
  </tbody>
</table>
</div>
@endsection

