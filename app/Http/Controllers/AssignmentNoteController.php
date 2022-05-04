<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentNote;
use Illuminate\Http\Request;

class AssignmentNoteController extends Controller
{
    /**
     * Show form to create a note
     *
     * @param int $id Assignment id
     * @return \Illuminate\Http\Response 
     */
    public function teacherCreate($id){
        $assignment = Assignment::find($id);

        //todo
        $this->authorize('create', $assignment);

        return view('teacher.assignment.note', [
            'assignment' => $assignment,
        ]);
    }

    /**
     * Process form create note
     *
     * @param int $id Assignment id
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response 
     */
    public function teacherStore(Request $request, $id){
        $assignment = Assignment::find($id);

        //todo
        $this->authorize('create', $assignment);

        //validate inputs
        $rules = [
            'note' => "required|max:65535",
        ];

        
        $validated = $request->validate($rules);

        $noteId = AssignmentNote::insertGetId( [
            'content' => $validated['note'],
            'assignment_id' => $assignment->id,
            'created_at' => now()
        ]);

        if($noteId){
            return redirect(route('assignment_teacherShow', $assignment->id));
        } else {
            return redirect(route('assignment_teacherShow', $assignment->id))
                ->with('error', 'Sorry, something went wrong');
        }
    }
}
