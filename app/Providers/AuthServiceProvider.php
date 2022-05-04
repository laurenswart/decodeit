<?php

namespace App\Providers;

use App\Http\Controllers\AssignmentNoteController;
use App\Http\Controllers\EnrolmentController;
use App\Models\Assignment;
use App\Models\AssignmentNote;
use App\Models\Chapter;
use App\Models\Course;
use App\Models\Enrolment;
use App\Models\Message;
use App\Models\Skill;
use App\Models\Student;
use App\Models\StudentAssignment;
use App\Models\Submission;
use App\Models\Subscription;
use App\Models\Teacher;
use App\Models\User;
use App\Policies\AssignmentNotePolicy;
use App\Policies\AssignmentPolicy;
use App\Policies\ChapterPolicy;
use App\Policies\CoursePolicy;
use App\Policies\EnrolmentPolicy;
use App\Policies\MessagePolicy;
use App\Policies\SkillPolicy;
use App\Policies\StudentAssignmentPolicy;
use App\Policies\StudentPolicy;
use App\Policies\SubmissionPolicy;
use App\Policies\SubscriptionPolicy;
use App\Policies\TeacherPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Course::class => CoursePolicy::class,
        Chapter::class => ChapterPolicy::class,
        Assignment::class => AssignmentPolicy::class,
        Student::class => StudentPolicy::class,
        Teacher::class => TeacherPolicy::class,
        User::class => UserPolicy::class,
        Subscription::class => SubscriptionPolicy::class,
        Message::class => MessagePolicy::class,
        AssignmentNote::class => AssignmentNotePolicy::class,
        Enrolment::class => EnrolmentPolicy::class,
        Skill::class => SkillPolicy::class,
        StudentAssignment::class => StudentAssignmentPolicy::class,
        Submission::class => SubmissionPolicy::class,
        
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
    }
}
