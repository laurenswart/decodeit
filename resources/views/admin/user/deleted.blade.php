@extends('layouts.admin')

@section('title')
  Deleted Accounts
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
      @foreach($users as $user)
        
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->firstname }}</td>
            <td>{{ $user->lastname }}</td>
            <td>{{ $user->email }}</td>
            <td>{{ $user->created_at }}<td>
        </tr>
       
      @endforeach
  </tbody>
</table>
</div>
@endsection

