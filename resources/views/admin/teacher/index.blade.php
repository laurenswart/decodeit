@extends('layouts.admin')

@section('title')
  Teachers
@endsection

@section('content')
<div class="layer-2 admin-box">
<div class="d-flex justify-content-end">  
    <form method="get" action="{{ route('teacher_adminIndex') }}">
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
              <th><a href="{{ route('teacher_adminIndex', ['sort'=>'id', 'order'=> ($currentQueries['sort']=='id' && $currentQueries['order']=='asc' ? 'desc' : 'asc'), 'filter'=> $currentQueries['filter']])}}">Id</a></th>
              <th><a href="{{ route('teacher_adminIndex', ['sort'=>'firstname', 'order'=> ($currentQueries['sort']=='firstname' && $currentQueries['order']=='asc' ? 'desc' : 'asc'), 'filter'=> $currentQueries['filter']])}}">Firstname</a></th>
              <th><a href="{{ route('teacher_adminIndex', ['sort'=>'lastname', 'order'=> ($currentQueries['sort']=='lastname' && $currentQueries['order']=='asc' ? 'desc' : 'asc'), 'filter'=> $currentQueries['filter']])}}">Lastname</a></th>
              <th><a href="{{ route('teacher_adminIndex', ['sort'=>'email', 'order'=> ($currentQueries['sort']=='email' && $currentQueries['order']=='asc' ? 'desc' : 'asc'), 'filter'=> $currentQueries['filter']])}}">Email</a></th>
              <th><a href="{{ route('teacher_adminIndex', ['sort'=>'created_at', 'order'=> ($currentQueries['sort']=='created_at' && $currentQueries['order']=='asc' ? 'desc' : 'asc'), 'filter'=> $currentQueries['filter']])}}">Created</a></th>
              <th></th>
          </tr>
      </thead>
    <tbody>
      @foreach($teachers as $teacher)
        
        <tr>
            <td>{{ $teacher->id }}</td>
            <td>{{ $teacher->firstname }}</td>
            <td>{{ $teacher->lastname }}</td>
            <td>{{ $teacher->email }}</td>
            <td>{{ $teacher->created_at }}<td>
            <td>{{ $teacher->currentSubscriptionPlan() ? $teacher->currentSubscriptionPlan()->title : '-' }}<td>
            <td><a href="{{ route('teacher_adminShow', $teacher->id) }}"><i class="fas fa-arrow-alt-square-right"></i>Checkout</a></td>
        </tr>
       
      @endforeach
  </tbody>
</table>
{{ $teachers->links() }}
</div>
@endsection

