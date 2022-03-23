@extends('layouts.admin')

@section('title')
 Subscriptions
@endsection

@section('content')
<div class="layer-2 admin-box">
<table class="table">
    <thead>
        <tr>
            <th>Id</th>
            <th>Name</th>
            <th>Description</th>
            <th>Custom</th>
            <th>Active</th>
            <th>Current Users</th>
        </tr>
    </thead>
    <tbody>
      @foreach($subscriptions as $subscription)
        
        <tr>
            <td>{{ $subscription->subscription_id }}</td>
            <td><a href="{{ route('adminSubscriptionsShow', $subscription->subscription_id) }}">{{ $subscription->title }}</a></td>
            <td>{{ $subscription->description }}</td>
            <td>{{ $subscription->is_custom }}</td>
            <td>{{ $subscription->is_active }}</td>
            <td>{{ $subscription->nbUsers() }}<td>
        </tr>
       
      @endforeach
  </tbody>
</table>
</div>
@endsection

