@extends('layouts.student')

@section('content')
<h2 class="block-title layer-2">
    Hey {{ ucfirst(auth()->guard('web')->user()->firstname) }}, here's what's been happening! 
</h2>

@foreach($notifications as $notification)
		<a href="" class="listElement-h light-card row zoom">
			<span class="listElementTitle palette-medium col-12 col-md-4">{{ $notification->created_at }}</span>
			<span class="listElementContent col background">
                {{ $notification->type }}
			</span>
		</a>
        @endforeach


@endsection

