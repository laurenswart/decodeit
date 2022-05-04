<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Message;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * Show forum messages for a course
     *
     * @param int $id Id of the course
     * @return \Illuminate\Http\Response
     */
    public function studentForum($id){
        $course = Course::find($id);

        $this->authorize('studentForum', [Message::class, $course]);

        $messages = $course->messages->sortBy('created_at');

        return view('student.forum', [
            'course'=>$course,
            'messages'=>$messages
        ]);
    }

    /**
     * Create a new message
     *
     * @param Request $request
     * @param int $id Id of the course
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id){
        $course = Course::find($id);

        if($request->ajax() && $request->post('content')) {
            //find chapter
            $user = Auth::user();
            $user = $user->isStudent() ?  Student::find($user->id) : Teacher::find($user->id);
            if(empty($user) || empty($course)){
                return response()->json([
                    'success' => false, 
                ], 403);
            } else if ($request->user()->cannot('create', [Message::class, $course])){
                return response()->json([
                    'success' => false, 
                    'msg' => 'You do not have permission to access this resource.'
                ], 403);
            }

            //update DB
            $message =  Message::create([
                'user_id'=>$user->id,
                'course_id'=>$id,
                'content'=>$request->post('content'),
            ]);

            if($message->exists){
                return response()->json([
                    'success' => true, 
                    'msg' => $message->content,
                    'date' => date('H:i:m d/m/Y', $message->created_at->timestamp),
                ], 200);
            } else {
                return response()->json([
                    'success' => false, 
                    'msg' => 'Oops, Something went wrong.'
                ], 500);
            }
            

        }
    }
}
