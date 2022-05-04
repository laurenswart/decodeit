<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Show a course for the authenticated student
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
}
