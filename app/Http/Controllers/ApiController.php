<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Retrive a user's info
     */
    public function user(Request $request){
        return $request->user();
    }

    /**
     * Retrieve user's courses
     */
    public function courses(Request $request){
        if($request->user()->isTeacher()){
            $data = Teacher::find($request->user()->id)->courses;
        } else {
            $data =  Student::find($request->user()->id)->courses;
        }

        return $data;
    }

    /**
     * Retrieve chapters for a course
     * 
     * @param int $id Course id
     */
    public function chapters(Request $request, $id){
        if($request->user()->isTeacher()){
            $course = Teacher::find($request->user()->id)->courses->firstWhere('id', $id);
        } else {
            $course = Student::find($request->user()->id)->courses->firstWhere('id', $id);
        }

        if(empty($course)){
            return response()->json([
                'data'=>'Invalid course ID'
            ], '400');
        }
        return $course->chapters;
    }

    /**
     * Retrieve assignments for a course
     * 
     * @param int $id Course id
     */
    public function assignmentsByCourse(Request $request, $id){
        if($request->user()->isTeacher()){
            $course = Teacher::find($request->user()->id)->courses->firstWhere('id', $id);
        } else {
            $course = Student::find($request->user()->id)->courses->firstWhere('id', $id);
        }

        if(empty($course)){
            return response()->json([
                'data'=>'Invalid course ID'
            ], '400');
        }
        return $course->assignments;
    }

    /**
     * Retrieve assignments for a chapter
     * 
     * @param int $id chapter id
     */
    public function assignmentsByChapter(Request $request, $id){
        $chapter = Chapter::find($id);
        if(empty($chapter)){
            return response()->json([
                'data'=>'Invalid chapter ID'
            ], '400');
        }

        if($request->user()->isTeacher()){
            $course = Teacher::find($request->user()->id)->courses->firstWhere('id', $chapter->course_id);
        } else {
            $course = Student::find($request->user()->id)->courses->firstWhere('id', $chapter->course_id);
        }
        if(empty($course)){
            return response()->json([
                'data'=>'Unauthorized Action'
            ], '403');
        }
        return $chapter->assignments;
    }
}
