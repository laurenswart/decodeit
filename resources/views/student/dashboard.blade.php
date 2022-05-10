@extends('layouts.student')

@section('content')
<h2 class="block-title layer-2">
    Hey {{ ucfirst(auth()->guard('web')->user()->firstname) }}, here's what's been happening! 
</h2>

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


@endsection

