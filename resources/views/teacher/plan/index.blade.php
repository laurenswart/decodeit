@extends('layouts.teacher')

@section('content')
  @foreach($plans as $plan)

    <h2 class="light-card block-title layer-2">{{ ucfirst($plan->title) }} Plan</h2>
    <div class="row">
      <div class="col form-section layer-2">
          <h3 class="title-3">Description</h3>
         
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
      </div>
      <div class="col form-section layer-2">
        
          <h3 class="title-3">Payment Options</h3>
          <div>
              <div class="align-self-stretch d-flex justify-content-between align-items-center mt-2">
                  <div><h3 class="d-inline-block">{{ $plan->monthly_price }} &#8364</h3> / MONTH</div>
                  @if(!$hasSubscription)
                  <form action="{{ route('create-checkout-session') }}" method="POST">
                    @csrf
                    <input type="text" name="plan_id" value="{{ $plan->id }}" hidden>
                    <input type="text" name="duration" value="monthly" hidden>
                    <input type="hidden" name="price_id" value="{{  $plan->monthly_stripe_id }}" />
                    <button id="checkout-and-portal-button" class="myButton" type="submit">Subscribe</button>
                  </form>
                  @endif
              </div>
              <div class="align-self-stretch d-flex justify-content-between align-items-center mt-2">
                <div><h3 class="d-inline-block">{{ $plan->semiyearly_price }} &#8364</h3> / 6 MONTHS</div>
                @if(!$hasSubscription)
                  <form action="{{ route('create-checkout-session') }}" method="POST">
                    @csrf
                    <input type="text" name="plan_id" value="{{ $plan->id }}" hidden>
                    <input type="text" name="duration" value="semiyearly" hidden>
                    <input type="hidden" name="price_id" value="{{  $plan->semiyearly_stripe_id }}" />
                    <button id="checkout-and-portal-button" class="myButton" type="submit">Subscribe</button>
                  </form>
                  @endif
              </div>
              <div class="align-self-stretch d-flex justify-content-between align-items-center mt-2">
                <div><h3 class="d-inline-block">{{ $plan->yearly_price }} &#8364</h3> / YEAR</div>
                @if(!$hasSubscription)
                  <form action="{{ route('create-checkout-session') }}" method="POST">
                    @csrf
                    <input type="text" name="plan_id" value="{{ $plan->id }}" hidden>
                    <input type="text" name="duration" value="yearly" hidden>
                    <input type="hidden" name="price_id" value="{{  $plan->yearly_stripe_id }}" />
                    <button id="checkout-and-portal-button" class="myButton" type="submit">Subscribe</button>
                  </form>
                  @endif
              </div>
          </div>
      </div>
  </div>
  @endforeach
  @if(!$hasSubscription)
  <h2 class="light-card block-title layer-2">Custom Plan</h2>
    <div class="col p-sides-10">
      <div class="listElement-v light-card row">
        <span class="listElementTitle palette-medium col-12 col-md-4 ">What's that ?</span>
        <span class="listElementContent col background">
          <p class="w-100">If none of the plans above seem to suit your needs, please get in touch with us and we can determine
          an offer adapted specifically to you. </p>
          <span class="text-end w-100">
              <a href="#" class="highlight"><i class="fas fa-arrow-circle-right"></i>Get in Touch</a>
          </div>
        </span>
      </div>
    </div>
  @endif
  
@endsection