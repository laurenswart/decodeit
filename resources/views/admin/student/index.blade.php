@extends('layouts.admin')

@section('title')
  Students
@endsection

@section('content')
<div class="layer-2 admin-box">
  <div class="d-flex justify-content-end">  
    <form method="get" action="{{ route('student_adminIndex') }}">
      @csrf
      <input type="text" placeholder="Search.." name="filter" value="{{ $currentQueries['filter'] ?? ''}}">
      <input type="text" hidden value="{{ $currentQueries['sort'] }}" name="sort">
      <input type="text" hidden value="{{ $currentQueries['order'] }}" name="order">
      <button class="myButton">Search</button>
    </form>
  </div>
  <table class="table">
      <thead>
          <tr>
              <th><a href="{{ route('student_adminIndex', ['sort'=>'id', 'order'=> ($currentQueries['sort']=='id' && $currentQueries['order']=='asc' ? 'desc' : 'asc'), 'filter'=> $currentQueries['filter']])}}">Id</a></th>
              <th><a href="{{ route('student_adminIndex', ['sort'=>'firstname', 'order'=> ($currentQueries['sort']=='firstname' && $currentQueries['order']=='asc' ? 'desc' : 'asc'), 'filter'=> $currentQueries['filter']])}}">Firstname</a></th>
              <th><a href="{{ route('student_adminIndex', ['sort'=>'lastname', 'order'=> ($currentQueries['sort']=='lastname' && $currentQueries['order']=='asc' ? 'desc' : 'asc'), 'filter'=> $currentQueries['filter']])}}">Lastname</a></th>
              <th><a href="{{ route('student_adminIndex', ['sort'=>'email', 'order'=> ($currentQueries['sort']=='email' && $currentQueries['order']=='asc' ? 'desc' : 'asc'), 'filter'=> $currentQueries['filter']])}}">Email</a></th>
              <th><a href="{{ route('student_adminIndex', ['sort'=>'created_at', 'order'=> ($currentQueries['sort']=='created_at' && $currentQueries['order']=='asc' ? 'desc' : 'asc'), 'filter'=> $currentQueries['filter']])}}">Created</a></th>
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
  {{ $students->links() }}
</div>
@endsection

