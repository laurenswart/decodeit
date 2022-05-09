<?php

namespace App\Models;

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
            ->whereNull('enrolments.deleted_at');
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
        $createdChapters = Chapter::where('created_at', '>',$lastConnection)->where('is_active', true)->whereIn('course_id', $student->courses->pluck('id'))->get();
        
        //updated chapter content

        //create assignment:Eloquent\Collection
        $createdAssignments = Assignment::where('created_at', '>',$lastConnection)->whereIn('course_id', $student->courses->pluck('id'))->get();
        
        
        //got feedback on submission :Eloquent\Collection
        $feedbackedSubmissions = Submission::where('updated_at', '>',$lastConnection)->where('updated_at', '!=','created_at')->get();
        
        //got mark on student_assignment :Array
        $markedStudentAssignments = $student->studentAssignments->where('marked_at', '>',$lastConnection)->whereIn('id',  $student->studentAssignments->pluck('id'))->all();
        

        //forum messages :Array
        $updatedForumCourseIds = Message::
                        groupBy('course_id')
                        ->where('created_at', '>',$lastConnection)
                        ->pluck('course_id')->all();
                        
        $updatedForumCourses = $student->courses->whereIn('id', $updatedForumCourseIds);
        
        //new enrolment :Eloquent\Collection
        $createdEnrolments = Enrolment::where('student_id', Auth::id())->where('created_at', '>',$lastConnection)->get();
        
        //got an enrolment final mark :Eloquent\Collection
        $markedEnrolments = Enrolment::where('student_id', Auth::id())->where('marked_at', '>',$lastConnection)->get();
        
        
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
            $createdChapter->type='created chapter';
            $models[] = $createdChapter;
        }
        foreach($createdAssignments as $createdAssignment){
            $createdAssignment->type='created assignment';
            
            $models[] = $createdAssignment;
        }
        foreach($feedbackedSubmissions as $feedbackedSubmission){
            $feedbackedSubmission->type='feedback';
            $feedbackedSubmission->created_at = $feedbackedSubmission->updated_at;//temporary or sorting, not saved
            $models[] = $feedbackedSubmission;
        }
        foreach($markedStudentAssignments as $markedStudentAssignment){
            $markedStudentAssignment->type='assignment mark';
            $markedStudentAssignment->created_at = $markedStudentAssignment->marked_at;//temporary or sorting, not saved
            $models[] = $markedStudentAssignment;
        }
        foreach($updatedForumCourses as $updatedForumCourse){
            $updatedForumCourse->type='forum';
            $updatedForumCourse->created_at = now();//temporary or sorting, not saved
            $models[] = $updatedForumCourse;
        }
        foreach($createdEnrolments as $createdEnrolment){
            $createdEnrolment->type='created enrolment';
            $models[] = $createdEnrolment;
        }
        foreach($markedEnrolments as $markedEnrolment){
            $markedEnrolment->type='final mark';
            $markedEnrolment->created_at = $markedEnrolment->marked_at;//temporary or sorting, not saved
            $models[] = $markedEnrolment;
        }
        foreach($createdNoteAssignments as $createdNoteAssignment){
            $createdNoteAssignment->type='updated note';
            $models[] = $createdNoteAssignment;
        }
     
        
        

            uasort($models, function($a, $b){
                if ($a->created_at == $b->created_at) {
                    return 0;
                }
                return ($a->created_at > $b->created_at) ? -1 : 1;
            });
        return $models;
    }

}
