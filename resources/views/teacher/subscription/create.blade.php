@extends('layouts.teacher')

@section('content')
  <div class="layer-2 box">
        <h2>{{ ucfirst($plan->title) }} Subscription</h2>
        <div>{{ $plan->description }}</div>
        <div>Paying {{ $duration}}</div>
        <div>Price {{ $plan->$price_token}}</div>
        <form action="{{ route('create-checkout-session') }}" method="POST">
          @csrf
          <input type="text" name="plan_id" value="{{ $plan->plan_id }}" hidden>
          <input type="text" name="duration" value="{{ $duration}}" hidden>
          <input type="hidden" name="price_id" value="{{ $price_key }}" />
          <button id="checkout-and-portal-button" type="submit">Checkout</button>
        </form>
  </div>
@endsection