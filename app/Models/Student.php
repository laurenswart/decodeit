<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class Student extends User
{
    use HasFactory;

    public function teachers(){
        return $this->belongsToMany(Student::class, 'teacher_student', 'student_id', 'teacher_id', 'id', 'id', );
    }

    public function enrolments(){
        return $this->hasMany(Enrolment::class, 'student_id', 'id')->whereNull('enrolments.deleted_at');
    }

    public function newQuery($excludeDeleted = true)
    {
        return parent::newQuery($excludeDeleted)
            ->whereRoleId(2);
    }

    public function courses(){
        return $this->belongsToMany(Course::class, 'enrolments', 'student_id', 'course_id', 'id', 'id')
            ->withPivot('final_mark', 'created_at', 'deleted_at')
            ->whereNull('enrolments.deleted_at')
            ->where('courses.is_active', true);
    }

    public function coursesForTeacher(){
        return $this->courses->where('teacher_id', Auth::id());
    }

    /**
     * Get all of the studentAssignments for the student.
     */
    public function studentAssignments(){
        return $this->hasManyThrough(StudentAssignment::class, Enrolment::class);
    }


    
    /**
     * 
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function notifications(){
        $student = Student::find( Auth::id());
        $lastConnection = $student->last_connected;

        //created chapter :Eloquent\Collection
        //chapter is active, course id active, and student is enroled
        $createdChapters = Chapter::where('created_at', '>',$lastConnection)->where('is_active', true)->whereIn('course_id', $student->courses->pluck('id'))->get();
        
        //updated chapter content

        //create assignment:Eloquent\Collection
        //student is enroled in course
        $createdAssignments = Assignment::where('created_at', '>',$lastConnection)->whereIn('course_id', $student->courses->pluck('id'))->get();
        
        
        //got feedback on submission :Eloquent\Collection
        //studentAssignment is for auth student
        $feedbackedSubmissions = Submission::where('updated_at', '>',$lastConnection)->where('updated_at', '!=','created_at')->whereIn('student_assignment_id', $student->studentAssignments->pluck('id'))->get();
        
        //got mark on student_assignment :Array
        //studentAssignment is for auth student
        $markedStudentAssignments = $student->studentAssignments->where('marked_at', '>',$lastConnection)->whereIn('id',  $student->studentAssignments->pluck('id'))->all();
        

        //forum messages :Eloquent\Collection
        //student is enroled in course and course is active
        $updatedForumCourseIds = Message::
                        select('course_id', DB::raw("min(forum_messages.created_at) as 'created_at'"), 'title')
                        ->join('courses', 'courses.id', 'forum_messages.course_id')
                        ->groupBy('course_id', 'title')
                        ->where('forum_messages.created_at', '>',$lastConnection)
                        ->get();
        
        //new enrolment :Eloquent\Collection
        //student is enroled in course and course is active
        $createdEnrolments = $student->courses()->wherePivot('created_at', '>',$lastConnection)->get();
        
        //got an enrolment final mark :Eloquent\Collection
        //student is enroled in course and course is active
        $markedEnrolments = $student->courses()->wherePivot('marked_at', '>',$lastConnection)->get();
        
        
        //new assignment notes :Array
        $assignmentIds = AssignmentNote::
                        groupBy('assignment_id')
                        ->where('assignment_notes.created_at', '>',$lastConnection)
                        ->pluck('assignment_id', DB::raw('min(assignment_notes.created_at) as created_at'))->all();
        $createdNoteAssignments = [];
        
        foreach($assignmentIds as $created_at => $assignmentId){
            $assignment = Assignment::find($assignmentId);
            if(in_array($assignment->course_id, $student->courses->pluck('id')->toArray())){
                $assignment->created_at = $created_at;
                $createdNoteAssignments[] = $assignment;
            }
        }

        

        //make a collection
        $models = [];
        foreach($createdChapters as $createdChapter){
            $models[] = [
                'icon'=>'<i class="fas fa-plus-square"></i>',
                'route'=> route('chapter_studentShow', $createdChapter->id),
                'text'=> 'New Chapter in ',
                'resource' => ucfirst($createdChapter->course->title),
                'date'=> Carbon::parse($createdChapter->created_at)
            ];
        }
        foreach($createdAssignments as $createdAssignment){
            $models[] = [
                'icon'=>'<i class="fas fa-plus-square"></i>',
                'route'=> route('assignment_studentShow', $createdAssignment->id),
                'text'=> 'New Assignment in ',
                'resource' => ucfirst($createdChapter->course->title),
                'date'=> Carbon::parse($createdAssignment->created_at)
            ];
        }
        foreach($feedbackedSubmissions as $feedbackedSubmission){
            $models[] = [
                'icon'=>'<i class="fad fa-inbox-in"></i>',
                'route'=> route('assignment_studentShow', $feedbackedSubmission->studentAssignment->assignment_id),
                'text'=> 'Feedback Received for ',
                'resource' => ucfirst($feedbackedSubmission->studentAssignment->assignment->title),
                'date'=> Carbon::parse($feedbackedSubmission->updated_at)
            ];
        }
        foreach($markedStudentAssignments as $markedStudentAssignment){
            $models[] = [
                'icon'=>'<i class="fad fa-inbox-in"></i>',
                'route'=> route('assignment_studentShow', $markedStudentAssignment->assignment_id),
                'text'=> 'Mark Received for ',
                'resource' => ucfirst($markedStudentAssignment->assignment->title),
                'date'=> Carbon::parse($markedStudentAssignment->marked_at)
            ];
        }
        foreach($updatedForumCourseIds as $updatedForumCourse){
            $models[] = [
                'icon'=>'<i class="fas fa-comment-alt-dots"></i>',
                'route'=> route('message_teacherForum', $updatedForumCourse['course_id']),
                'text'=> 'New Messages in ',
                'resource' => ucfirst($updatedForumCourse['title']),
                'date'=> Carbon::parse($updatedForumCourse['created_at'])
            ];
        }
        foreach($createdEnrolments as $createdEnrolment){
            $models[] = [
                'icon'=>'<i class="fas fa-plus-square"></i>',
                'route'=> route('course_studentShow', $createdEnrolment->id),
                'text'=> 'New Course: ',
                'resource' => ucfirst($createdEnrolment->course->title),
                'date'=> Carbon::parse($createdEnrolment->created_at)
            ];
        }
        foreach($markedEnrolments as $markedEnrolment){
            $models[] = [
                'icon'=>'<i class="fad fa-inbox-in"></i>',
                'route'=> route('course_studentShow', $markedEnrolment->id),
                'text'=> 'Final Mark Received for ',
                'resource' => ucfirst($markedEnrolment->course->title),
                'date'=> Carbon::parse( $markedEnrolment->marked_at)
            ];
        }
        foreach($createdNoteAssignments as $createdNoteAssignment){
            $models[] = [
                'icon'=>'<i class="fas fa-comment-alt-dots"></i>',
                'route'=> route('assignment_studentShow', $createdNoteAssignment->id),
                'text'=> 'New Assignment Note for ',
                'resource' => ucfirst($createdNoteAssignment->title),
                'date'=> Carbon::parse($createdNoteAssignment->created_at)
            ];
        }
     
        
        

            uasort($models, function($a, $b){
                if ($a['date'] == $b['date']) {
                    return 0;
                }
                return ($a['date'] > $b['date']) ? -1 : 1;
            });
        return $models;
    }

}
