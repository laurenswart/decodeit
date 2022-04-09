@extends('layouts.teacher')


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
      @foreach($students as $student)
        
        <tr>
            <td>{{ $student->id }}</td>
            <td>{{ $student->firstname }}</td>
            <td>{{ $student->lastname }}</td>
            <td>{{ $student->email }}</td>
            <td>{{ $student->created_at }}<td>
        </tr>
       
      @endforeach
  </tbody>
</table>
</div>
@endsection

