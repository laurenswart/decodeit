<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use Illuminate\Http\Request;

class AssignmentController extends Controller
{
    public function studentAssignment($id){

        $assignment = Assignment::find($id);
    
        return view('student.assignment', [
            'assignment'=>$assignment,
        ]);
    }
}
