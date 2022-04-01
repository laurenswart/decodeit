<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    /**
     * Show an assignment for the authenticated student
     *
     * @param int $id Id of the assignment
     * @return \Illuminate\Http\Response
     */
    public function studentShow($id){
        $assignment = Assignment::find($id);

        $this->authorize('studentView', $assignment);
    
        return view('student.assignment', [
            'assignment'=>$assignment,
        ]);
    }
}
