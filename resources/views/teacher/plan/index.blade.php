@extends('layouts.teacher')

@section('content')
  @foreach($plans as $plan)
  <div class="layer-2 box">
        <h2>{{ $plan->title }}</h2>
        <div>{{ $plan->description }}</div>

        <table>
          <tbody>
            <tr>
              <th>Monthly</th>
              <td>{{ $plan->monthly_price }}</td>
              <td>
                <form action="{{ route('subscription_teacherCreate') }}" method="post">
                  @csrf
                  <input type="text" name="plan_id" value="{{ $plan->plan_id }}" hidden>
                  <input type="text" name="duration" value="monthly" hidden>
                  <button type="submit">Subscribe</button>
                </form>
              </td>
            </tr>
            <tr>
              <th>Semiyearly</th>
              <td>{{ $plan->semiyearly_price }}</td>
              <td>
                <form action="{{ route('subscription_teacherCreate') }}" method="post">
                  @csrf
                  <input type="text" name="plan_id" value="{{ $plan->plan_id }}" hidden>
                  <input type="text" name="duration" value="semiyearly" hidden>
                  <button type="submit">Subscribe</button>
                </form>
              </td>
            </tr>
            <tr>
              <th>Yearly</th>
              <td>{{ $plan->yearly_price }}</td>
              <td>
                <form action="{{ route('subscription_teacherCreate') }}" method="post">
                  @csrf
                  <input type="text" name="plan_id" value="{{ $plan->plan_id }}" hidden>
                  <input type="text" name="duration" value="yearly" hidden>
                  <button type="submit">Subscribe</button>
                </form>
              </td>
            </tr>
          </tbody>
        </table>
  </div>
  @endforeach
@endsection