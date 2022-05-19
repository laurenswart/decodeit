@extends('layouts.teacher')

@section('content')
    <nav class="back-nav">
        <a href="{{ route('teacher_adminIndex') }}"><i class="fas fa-arrow-alt-square-left"></i>Teachers</a>
    </nav>
    <h2 class="light-card block-title layer-2">{{ $teacher->firstname }} {{ $teacher->lastname }}</h2>

    <div class="row">
        <div class="col form-section layer-2">
                @if($plan)
                <h3 class="title-3">{{ ucfirst($plan->title) }} Plan</h3>
                
                    <table class="table caption-top">
                    <tbody>
                            <tr>
                                <th>Nb Courses</th>
                                <td class="cell-center">{{ count($teacher->courses) }} / {{ $plan->nb_courses }}</td>
                            </tr>
                            <tr>
                                <th>Nb Chapters</th>
                                <td class="cell-center">{{ count($teacher->chapters) }} / {{ $plan->nb_chapters*$plan->nb_courses }}</td>
                            </tr>
                            <tr>
                                <th>Nb Students</th>
                                <td class="cell-center">{{ count($teacher->students) }} / {{ $plan->nb_students }}</td>
                            </tr>
                            <tr>
                                <th>Nb Assignments</th>
                                <td class="cell-center">{{ $nbAssignments }} / {{ $plan->nb_assignments }}</td>
                            </tr>
                        </tbody>
                    </table>
                @else
                    <p>No current subscription plan</p>
                @endif
        </div>
        <div class="col form-section layer-2">
            
                <h3 class="title-3">Account Details</h3>
                <div class="label-value my-3">
                    <span>Firstname</span>
                    <span>{{ $teacher->firstname }}</span>
                </div>
                <div class="label-value  my-3">
                    <span>Lastname</span>
                    <span>{{ $teacher->lastname }}</span>
                </div>
                <div class="label-value my-3">
                    <span>Email</span>
                    <span>{{ $teacher->email }}</span>
                </div>
                <div class="label-value my-3">
                    <span>Account Created</span>
                    <span>{{ $teacher->created_at }}</span>
                </div>
                <div class="label-value my-3">
                    <span>Account Deleted</span>
                    <span>{{ $teacher->deleted_at ??  '-' }}</span>
                </div>

                <div class="label-value my-3">
                    <span>Subscription Created</span>
                    <span>{{ $subscription ? $subscription->created_at : '-' }}</span>
                </div>
                <div class="label-value my-3">
                    <span>Subscription Ends</span>
                    <span>{{ $subscription ? $subscription->ends_at : '-' }}</span>
                </div>
                <div class="label-value my-3">
                    <span>Subscription Status</span>
                    <span>{{$subscription ? ucfirst( $subscription->stripe_status) : '-' }}</span>
                </div>
        </div>
    </div>
	
    <h2 class="light-card block-title layer-2">Payments</h2>
    <div class="row  form-section layer-2">
        <table class="table caption-top">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Amount Due</th>
                    <th>Amount Paid</th>
                    <th>Currency</th>
                    <th>Stripe Invoice</th>
                    <th>Reason</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($teacher->payments->sortBy('create_at') as $payment)
                    <td>{{ $payment->created_at}}</td>
                    <td>{{ $payment->amount_due / 100}}</td>
                    <td>{{ $payment->amount_paid / 100}}</td>
                    <td>{{ $payment->currency}}</td>
                    <td>{{ $payment->stripe_invoice_id}}</td>
                    <td>{{ $payment->reason}}</td>
                    <td>{{ $payment->status}}</td>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection

