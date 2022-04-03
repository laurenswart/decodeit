@extends('layouts.teacher')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <a href="{{ route('billingPortal') }}">Manage Subscription</a>
            <a href="{{ route('plan_teacherIndex') }}">Subscribe</a>
        </div>
    </div>
</div>
@endsection

