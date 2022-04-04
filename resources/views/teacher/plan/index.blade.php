@extends('layouts.teacher')

@section('content')
  @foreach($plans as $plan)

    <h2 class="light-card block-title layer-2">{{ ucfirst($plan->title) }} Plan</h2>
    <div class="row">
      <div class="col p-sides-10">
        <div class="listElement-v light-card row">
          <span class="listElementTitle palette-medium col-12 col-md-4 ">Description</span>
          <span class="listElementContent col background">
          @if($plan->description)
            <p>{{ $plan->description }}</p>
          @endif
          <table class="table caption-top">
                <tbody>
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
                </tbody>
            </table>
          </span>
        </div>
      </div>
      <div class="col p-sides-10">
        <div class="listElement-v light-card">
          <span class="listElementTitle palette-medium col-12 col-md-4">Payment Options</span>
          <span class="listElementContent col background">
              <div class="align-self-stretch d-flex justify-content-between align-items-center">
                  <div><h3 class="d-inline-block">{{ $plan->monthly_price }} &#8364</h3>/ MONTH</div>
                  <form action="{{ route('create-checkout-session') }}" method="POST">
                    @csrf
                    <input type="text" name="plan_id" value="{{ $plan->plan_id }}" hidden>
                    <input type="text" name="duration" value="monthly" hidden>
                    <input type="hidden" name="price_id" value="{{  $plan->monthly_stripe_id }}" />
                    <button id="checkout-and-portal-button" class="myButton" type="submit">Subscribe</button>
                  </form>
              </div>
              <div class="align-self-stretch d-flex justify-content-between align-items-center">
                <div><h3 class="d-inline-block">{{ $plan->semiyearly_price }} &#8364</h3>/ 6 MONTHS</div>
                  <form action="{{ route('create-checkout-session') }}" method="POST">
                    @csrf
                    <input type="text" name="plan_id" value="{{ $plan->plan_id }}" hidden>
                    <input type="text" name="duration" value="semiyearly" hidden>
                    <input type="hidden" name="price_id" value="{{  $plan->semiyearly_stripe_id }}" />
                    <button id="checkout-and-portal-button" class="myButton" type="submit">Subscribe</button>
                  </form>
              </div>
              <div class="align-self-stretch d-flex justify-content-between align-items-center">
                <div><h3 class="d-inline-block">{{ $plan->yearly_price }} &#8364</h3>/ Year</div>
                  <form action="{{ route('create-checkout-session') }}" method="POST">
                    @csrf
                    <input type="text" name="plan_id" value="{{ $plan->plan_id }}" hidden>
                    <input type="text" name="duration" value="yearly" hidden>
                    <input type="hidden" name="price_id" value="{{  $plan->yearly_stripe_id }}" />
                    <button id="checkout-and-portal-button" class="myButton" type="submit">Subscribe</button>
                  </form>
              </div>
          </span>
        </div>
      </div>
  </div>
  @endforeach
@endsection