@extends('layouts.teacher')

@section('content')

    <h1 class="light-card block-title layer-2">Dashboard</h1>
    @if($teacher->isOnFreeTrial())
    <div class="listElement-v light-card row">
        <span class="listElementTitle palette-medium col-12 col-md-4">Free Trial</span>
        <span class="listElementContent col background">
            <p class="w-100">You don't currently have an active subscription.
            However, you can play around and discover a couple of the awesome functionalities DecodeIt has to offer.<br>
            This free trial will last <strong>three days</strong>, after which you will need to subscribe to continue using our application.<br>
            You can select a subscription plan from our different options
            to start fulling enjoying DecodeIt</p>
            <a href="{{ route('plan_teacherIndex') }}" class="myButton align-self-end mr-3 mb-3">View Plans</a>
        </span>
    </div>
    @else 
        @foreach($notifications as $notification)
		<a href="{{ $notification['route'] }}" class="listElement-h light-card row zoom">
			<span class="listElementTitle palette-medium col-12 col-md-4 col-xl-3">{{  $notification['date']->format('H:i:s - D d/m/Y') }}</span>
			<span class="listElementContent col background">
                <span>
                {!! $notification['icon'] !!}
                {{ $notification['text'] }}<strong>{{$notification['resource']}}</strong>
                </span>
			</span>
		</a>
        @endforeach
    @endif
@endsection

