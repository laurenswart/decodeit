@extends('layouts.student')

@section('content')
<h2 class="block-title layer-2">
    Hey {{ ucfirst(auth()->guard('web')->user()->firstname) }}, here's what's been happening! 
</h2>

@foreach($notifications as $notification)
<a href="{{ $notification['route'] }}" class="listElement-h light-card row zoom palette-medium">
    <span class="listElementTitle palette-medium col-12 col-md-4 col-xl-3"><p>{{  $notification['date']->format('H:i - D d/m/Y') }}</p></span>
    <span class="listElementContent col background">

            <p>
        {!! $notification['icon'] !!}
        {{ $notification['text'] }}<strong>{{$notification['resource']}}</strong>
            </p>

    </span>
</a>
@endforeach
@if(count($notifications)==0)
    <div class="form-section layer-2">
        Nothing new to show
    </div>
@endif
<h2 class="block-title layer-2">
    Upcoming Assignments
</h2>
@if(count($assignments)==0)
    <div class="form-section layer-2">
        No assignments coming up
    </div>
@else 
    @foreach($assignments as $assignment)
    <a href="{{ route('assignment_studentShow', $assignment->id)}}" class="listElement-h light-card row zoom palette-medium">
			<span class="listElementTitle palette-medium col-12 col-md-4"><p>{{ $assignment->title }}</p></span>
			<span class="listElementContent col background">
				<span><p><i class="fas fa-clipboard-list greyed no-hover"></i><strong>Starts</strong> {{ $assignment->start_time_string() }}  -   <strong>Ends</strong> {{ $assignment->end_time_string() }}</p></span>
				<span><p>{!! $assignment->statusTextByStudent(Auth::id()) !!}</p></span>
			</span>
		</a>
    @endforeach
@endif
@endsection

