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
                </span>
            </div>
        </div>
        <div class="col p-sides-10">
            <div class="listElement-v light-card row">
                <span class="listElementTitle palette-medium col-12 col-md-4">Subscription Details</span>
                <span class="listElementContent col background">
                    Some Text here
                    <div class="d-flex justify-content-end">
                    <a href="{{ route('billingPortal') }}" class="highlight"><i class="fas fa-arrow-circle-right"></i>Manage My Subscription</a>
                </div>
                </span>
                
            </div>
        </div>
            
    </div>
    @else
    <div class="listElement-v light-card row">
        <span class="listElementTitle palette-medium col-12 col-md-4">No Current Subscription</span>
        <span class="listElementContent col background">
            <p>You don't currently have an active subscription. 
            Select a subscription plan from our <a href="{{ route('plan_teacherIndex') }}" class="highlight text">different options</a> 
            to start fulling enjoying DecodeIt</p>
        </span>
    </div>
    @endif
@endsection

