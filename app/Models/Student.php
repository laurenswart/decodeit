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
            $models[] = [
                'icon'=>'<i class="fas fa-plus-square"></i>',
                'route'=> route('chapter_studentShow', $createdChapter->id),
                'text'=> 'New Chapter in ',
                'resource' => ucfirst($createdChapter->course->title),
                'date'=> $createdChapter->created_at
            ];
        }
        foreach($createdAssignments as $createdAssignment){
            $models[] = [
                'icon'=>'<i class="fas fa-plus-square"></i>',
                'route'=> route('assignment_studentShow', $createdAssignment->id),
                'text'=> 'New Assignment in ',
                'resource' => ucfirst($createdChapter->course->title),
                'date'=> $createdAssignment->created_at
            ];
        }
        foreach($feedbackedSubmissions as $feedbackedSubmission){
            $models[] = [
                'icon'=>'<i class="fad fa-inbox-in"></i>',
                'route'=> route('assignment_studentShow', $feedbackedSubmission->studentAssignment->assignment_id),
                'text'=> 'Feedback Received for ',
                'resource' => ucfirst($feedbackedSubmission->studentAssignment->assignment->title),
                'date'=> $feedbackedSubmission->updated_at
            ];
        }
        foreach($markedStudentAssignments as $markedStudentAssignment){
            $models[] = [
                'icon'=>'<i class="fad fa-inbox-in"></i>',
                'route'=> route('assignment_studentShow', $markedStudentAssignment->assignment_id),
                'text'=> 'Mark Received for ',
                'resource' => ucfirst($markedStudentAssignment->assignment->title),
                'date'=> $markedStudentAssignment->marked_at
            ];
        }
        foreach($updatedForumCourses as $updatedForumCourse){
            $models[] = [
                'icon'=>'<i class="fas fa-comment-alt-dots"></i>',
                'route'=> route('message_studentForum', $updatedForumCourse->id),
                'text'=> 'New Messages in ',
                'resource' => ucfirst($updatedForumCourse->title),
                'date'=> now()
            ];
        }
        foreach($createdEnrolments as $createdEnrolment){
            $models[] = [
                'icon'=>'<i class="fas fa-plus-square"></i>',
                'route'=> route('course_studentShow', $createdEnrolment->course_id),
                'text'=> 'New Course: ',
                'resource' => ucfirst($createdEnrolment->course->title),
                'date'=> $createdEnrolment->created_at
            ];
        }
        foreach($markedEnrolments as $markedEnrolment){
            $models[] = [
                'icon'=>'<i class="fad fa-inbox-in"></i>',
                'route'=> route('course_studentShow', $markedEnrolment->course_id),
                'text'=> 'Final Mark Received for ',
                'resource' => ucfirst($markedEnrolment->course->title),
                'date'=> $markedEnrolment->marked_at
            ];
        }
        foreach($createdNoteAssignments as $createdNoteAssignment){
            $models[] = [
                'icon'=>'<i class="fas fa-comment-alt-dots"></i>',
                'route'=> route('assignment_studentShow', $createdNoteAssignment->id),
                'text'=> 'New Assignment Note for ',
                'resource' => ucfirst($createdNoteAssignment->title),
                'date'=> $createdNoteAssignment->created_at
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
