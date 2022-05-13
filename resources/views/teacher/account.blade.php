@extends('layouts.teacher')

@section('content')
    <h2 class="light-card block-title layer-2">My Subscription</h2>
    @if($plan && $plan->title!='free')
    <div class="row">
        <div class="col form-section layer-2">
            
                <h3 class="title-3">{{ ucfirst($plan->title) }} Plan</h3>
               
                    <table class="table caption-top">
                        <tbody>
                            <tr>
                                <th>Nb Courses</th>
                                <td>{{ count($teacher->courses) }} / {{ $plan->nb_courses }}</td>
                            </tr>
                            <tr>
                                <th>Nb Chapters</th>
                                <td>{{ $plan->nb_chapters }}</td>
                            </tr>
                            <tr>
                                <th>Nb Students</th>
                                <td>{{ count($teacher->students) }} / {{ $plan->nb_students }}</td>
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
                        <a href="{{ route('plan_teacherIndex') }}" class="highlight"><i class="fas fa-arrow-square-right"></i>Other Subscription Plans</a>
                    </div>
        </div>
        <div class="col form-section layer-2">
            
                <h3 class="title-3">Subscription Details</h3>
                
                    <div class="label-value">
                        <span>Created</span>
                        <span>{{ $subscription->created_at }}</span>
                    </div>
                    <div class="label-value">
                        <span>Ends</span>
                        <span>{{ $subscription->ends_at }}</span>
                    </div>
                    <div class="label-value">
                        <span>Status</span>
                        <span>{{ ucfirst($subscription->stripe_status) }}</span>
                    </div>
                    @if($subscription->stripe_status=='canceled')
                        <p class="text-end w-100">My subscription is canceled?<br>
                        You may still use our subscription plan until the end of the billing period.<br>
                        No new automatic payment will be made.</p>
                    @endif
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('billingPortal') }}" class="myButton mb-3 mt-5">Manage My Subscription</a>
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
    <h2 class="light-card block-title layer-2 ">My Details</h2>

	<div class="layer-2 form-section"  style="max-width:500px;">
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
		<div class="d-flex flex-col align-items-end mt-3">
			<a href="{{ route('teacher_teacherEdit') }}"><i class="fas fa-pen-square"></i>Edit</a>
		</div>
	</div>
@endsection

