@extends('layouts.admin')

@section('title')
  {{ ucfirst($subscription->title) }}
@endsection

@section('content')
<div class="row">
<div class="layer-2 admin-box col">
<table class="table caption-top">
  <tbody>
      <tr>
        <th>Id</th>
        <td>{{ $subscription->id }}</td>
      </tr>
      <tr>
        <th>Nb Courses</th>
        <td>{{ $subscription->nb_courses }}</td>
      </tr>
      <tr>
        <th>Nb Chapters</th>
        <td>{{ $subscription->nb_chapters }}</td>
      </tr>
      <tr>
        <th>Nb Students</th>
        <td>{{ $subscription->nb_students }}</td>
      </tr>
      <tr>
        <th>Nb Submissions</th>
        <td>{{ $subscription->nb_submissions }}</td>
      </tr>
      <tr>
        <th>Nb Assignments</th>
        <td>{{ $subscription->nb_assignments }}</td>
      </tr>
      <tr>
        <th>Max Upload Size</th>
        <td>{{ $subscription->max_upload_size }}</td>
      </tr>
      <tr>
        <th>Custom</th>
        <td>{{ $subscription->is_custom }}</td>
      </tr>
      <tr>
        <th>Active</th>
        <td>{{ $subscription->is_active }}</td>
      </tr>
      <tr>
        <th>Current Users</th>
        <td>{{ $subscription->nbUsers() }}</td>
      </tr>
      <tr>
        <th>Related Payments</th>
        <td>{{ $subscription->nbRelatedPayments() }}</td>
      </tr>
      <tr>
        <th>Created</th>
        <td>{{ $subscription->created_at }}</td>
      </tr>
      <tr>
        <th>Last Updated</th>
        <td>{{ $subscription->updated_at }}</td>
      </tr>
  </tbody>
</table>
</div>
<div class="col">
  <div class="row layer-2 admin-box">
    <p><strong>Description</strong><br>{{ $subscription->description }}</p>
  </div>
  <div class="row layer-2 admin-box">
        <p><strong>Monthly Price</strong>{{ $subscription->monthly_price }}</p>
        <p><strong>Semiyearly Price</strong>{{ $subscription->semiyearly_price }}</p>
        <p><strong>Yearly Price</strong>{{ $subscription->yearly_price }}</p>

  </div>
</div>
</div>


@endsection

