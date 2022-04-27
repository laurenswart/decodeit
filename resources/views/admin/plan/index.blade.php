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
      @foreach($plans as $plan)
        
        <tr>
            <td>{{ $plan->id }}</td>
            <td><a href="{{ route('subscription_adminShow', $plan->id) }}">{{ $plan->title }}</a></td>
            <td>{{ $plan->description }}</td>
            <td>{{ $plan->is_custom }}</td>
            <td><i class="fas fa-{{ $plan->is_active ? 'check-circle' : 'times' }}"></i></td>
            <td>{{ $plan->nbUsers() }}<td>
        </tr>
       
      @endforeach
  </tbody>
</table>
</div>
<div class="row">
  <div id="profitPerSubscription" style="height: 300px;" class="layer-2 admin-box col-7"></div>
  <div class="layer-2 admin-box col">
    <div class="d-flex justify-content-between align-items-center">
      <h3>Paying Monthly</h3><span>{{ $nbMonthly }}</span>
    </div>
    <div class="d-flex justify-content-between align-items-center">
      <h3>Paying SemiYearly</h3><span>{{ $nbSemiyearly}}</span>
    </div>
    <div class="d-flex justify-content-between align-items-center">
      <h3>Paying Yearly</h3><span>{{ $nbYearly }}</span>
    </div>
  </div>
</div>

@endsection
@section('endScripts')
  <script>
  const profitPerSubscription = new Chartisan({
  el: '#profitPerSubscription',
  url: "@chart('profitPerSubscription')",
  hooks: new ChartisanHooks()
    .colors(['#9044b9'])
    .legend({ position: 'bottom'})
    .title('Total Profit per Subscription')
    .datasets(['bar'])
    });
    </script>
@endsection

