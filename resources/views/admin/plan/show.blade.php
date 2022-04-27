@extends('layouts.admin')

@section('title')
  {{ ucfirst($plan->title) }}
@endsection

@section('content')
<div class="row">
<div class="layer-2 admin-box col">
<table class="table caption-top">
  <tbody>
      <tr>
        <th>Id</th>
        <td>{{ $plan->id }}</td>
      </tr>
      <tr>
        <th>Nb Courses</th>
        <td>{{ $plan->nb_courses }}</td>
      </tr>
      <tr>
        <th>Nb Chapters</th>
        <td>{{ $plan->nb_chapters }}</td>
      </tr>
      <tr>
        <th>Nb Students</th>
        <td>{{ $plan->nb_students }}</td>
      </tr>
      <tr>
        <th>Nb Submissions</th>
        <td>{{ $plan->nb_submissions }}</td>
      </tr>
      <tr>
        <th>Nb Assignments</th>
        <td>{{ $plan->nb_assignments }}</td>
      </tr>
      <tr>
        <th>Max Upload Size</th>
        <td>{{ $plan->max_upload_size }}</td>
      </tr>
      <tr>
        <th>Custom</th>
        <td>{{ $plan->is_custom }}</td>
      </tr>
      <tr>
        <th>Active</th>
        <td>{{ $plan->is_active }}</td>
      </tr>
      <tr>
        <th>Current Users</th>
        <td>{{ $plan->nbUsers() }}</td>
      </tr>
      <tr>
        <th>Created</th>
        <td>{{ $plan->created_at }}</td>
      </tr>
      <tr>
        <th>Last Updated</th>
        <td>{{ $plan->updated_at }}</td>
      </tr>
  </tbody>
</table>
</div>
<div class="col">
  <div class="row layer-2 admin-box">
    <p><strong>Description</strong><br>{{ $plan->description }}</p>
  </div>
  <div class="row layer-2 admin-box">
      <div class="label-value">
        <span><strong>Monthly Price</strong></span>
        <span>{{ $plan->monthly_price }}&#8364</span>
      </div>
      <div class="label-value">
        <span><strong>Semiyearly Price</strong></span>
        <span>{{ $plan->semiyearly_price }}&#8364</span>
      </div>
      <div class="label-value">
        <span><strong>Yearly Price</strong></span>
        <span>{{ $plan->yearly_price }}&#8364</span>
      </div>
  </div>
</div>
</div>


@endsection

