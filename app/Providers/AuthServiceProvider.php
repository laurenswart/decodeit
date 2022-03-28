<?php

namespace App\Providers;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\Student;
use App\Models\User;
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
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
 
        Gate::define('view-course', function (User $user, int $courseId) {
            $courses = Student::find($user->user_id)->courses;
            return in_array($courseId, $courses->pluck('course_id')->toArray()) ;
        });
    }
}
