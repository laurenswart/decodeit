<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    /**
     * Show dashboard for the authenticated student
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        return view('student.dashboard');
    }

    /**
     * Show students for the authenticated admin
     *
     * @return \Illuminate\Http\Response
     */
    public function adminIndex(){
        $students = Student::all();
        return view('admin.student.index', [
            'students'=>$students
        ]);
    }

    /**
     * Show students for the authenticated teacher
     *
     * @return \Illuminate\Http\Response
     */
    public function teacherIndex(){
        $this->authorize('teacherViewAny', Student::class);

        $students = Teacher::find(Auth::id())->students->sortBy('firstname');
        return view('teacher.student.index', [
            'students'=>$students
        ]);
    }

    /**
     * Show form to manage current student list
     *
     * @return \Illuminate\Http\Response
     */
    public function teacherCreate(){
        //$this->authorize('teacherViewAny', Student::class);

        $students = Teacher::find(Auth::id())
            ->students
            ->sortBy('firstname');
        return view('teacher.student.create', [
            'students'=>$students
        ]);
    }

    /**
     * Show form to manage current student list
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function teacherStore(Request $request){
        //$this->authorize('teacherViewAny', Student::class);

        $students = Teacher::find(Auth::id())->students;
        return redirect( route('student_teacherIndex') );
    }

    public function teacherSearch(Request $request){
        
        if($request->ajax('search')) {
          
            $search = $request->post('search');
            $data = Student::where('firstname', 'LIKE', $search.'%')
                ->orWhere('lastname', 'LIKE', $search.'%')
                ->get();

            $output = '';
            if (count($data)>0) {
                $output = '<ul class="list-group" style="display: block; position: relative; z-index: 1">';
                foreach ($data as $row){
                    $output .= '<li class="list-group-item d-flex justify-content-between"><span>'.$row->firstname.' '.$row->lastname.'</span><span><small class="text-muted">'.$row->email.'</small></span><button class="btn btn-outline-success">Add</button></li>';
                }
                $output .= '</ul>';
            }
            else {
                $output .= '<li class="list-group-item">'.'No results'.'</li>';
            }
           
            return $output;
        } else {
            return 'in else';
        }
    }
}
