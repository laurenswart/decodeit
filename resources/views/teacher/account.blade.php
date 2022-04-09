@extends('layouts.teacher')

@section('content')
    <h2 class="light-card block-title layer-2">My Subscription</h2>
    @if($plan)
    <div class="row">
        <div class="col p-sides-10">
            <div class="listElement-v light-card row">
                <span class="listElementTitle palette-medium col-12 col-md-4">{{ ucfirst($plan->title) }} Plan</span>
                <span class="listElementContent col background">
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
                    <div class="text-end w-100">
                        <a href="{{ route('plan_teacherIndex') }}" class="highlight"><i class="fas fa-arrow-circle-right"></i>Other Subscription Plans</a>
                    </div>
                </span>
            </div>
        </div>
        <div class="col p-sides-10">
            <div class="listElement-v light-card row">
                <span class="listElementTitle palette-medium col-12 col-md-4">Subscription Details</span>
                <span class="listElementContent col background">
                    <div class="align-self-stretch d-flex justify-content-between align-items-center">
                        <span>Created</span>
                        <span>{{ $subscription->created_at }}</span>
                    </div>
                    <div class="align-self-stretch d-flex justify-content-between align-items-center">
                        <span>Ends</span>
                        <span>{{ $subscription->ends_at }}</span>
                    </div>
                    <div class="align-self-stretch d-flex justify-content-between align-items-center">
                        <span>Status</span>
                        <span>{{ ucfirst($subscription->stripe_status) }}
                        </span>
                    </div>
                    @if($subscription->stripe_status=='canceled')
                        <p class="text-end w-100">My subscription is canceled?<br>
                        You may still use our subscription plan until the end of the billing period.<br>
                        No new automatic payment will be made.</p>
                    @endif
                        <a href="{{ route('billingPortal') }}" class="myButton mb-3 mt-5 align-self-end">Manage My Subscription</a>
                </span>
                
            </div>
        </div>
            
    </div>
    @else
    <div class="listElement-v light-card row">
        <span class="listElementTitle palette-medium col-12 col-md-4">No Current Subscription</span>
        <span class="listElementContent col background">
            <p class="w-100">You don't currently have an active subscription. 
            Select a subscription plan from our different options
            to start fulling enjoying DecodeIt</p>
            <a href="{{ route('plan_teacherIndex') }}" class="myButton align-self-end mr-3 mb-3">View Plans</a>
        </span>
    </div>
    @endif
@endsection

