<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentNote;
use App\Models\Chapter;
use App\Models\Enrolment;
use App\Models\Message;
use App\Models\Student;
use App\Models\Submission;
use App\Models\Teacher;
use App\Models\User;
use Dompdf\Adapter\PDFLib;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Boolean;
use PHPUnit\Framework\MockObject\Builder\Stub;
use PDF;
class StudentController extends Controller
{
    /**
     * Show dashboard for the authenticated student
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {

        //dd(Student::find(Auth::id())->notifications());
        
        return view('student.dashboard', [
            'notifications' => Student::find(Auth::id())->notifications()
        ]);
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
     * Show students for the authenticated teacher
     *
     * @param int $id Student id
     * @return \Illuminate\Http\Response
     */
    public function teacherShow(int $id){
        $student = Student::find($id);
        $this->authorize('teacherView', $student);

        return view('teacher.student.show', [
            'student'=>$student
        ]);
    }


    /**
     * Return list of students which firstname or lastname in search data of ajax request
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response 
     */
    public function teacherSearch(Request $request){
        
        if($request->ajax('search')) {

            $teacher = Teacher::find(Auth::id());
            $search = $request->post('search');
           
            $data = Student::
                where('firstname', 'LIKE', $search.'%')
                ->orWhere('lastname', 'LIKE', $search.'%')
                ->get();
            
            $existingStudents = $teacher->students->pluck('id')->toArray();
            $output = '';
            if (count($data)>0) {
                $output = '<ul class="list-group" style="display: block; position: relative; z-index: 1">';
                foreach ($data as $row){
                    if(in_array($row->id, $existingStudents)){
                        continue;
                    }
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

    /**
     * Add a student to list of teacher's students, by ajax request
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response 
     */
    public function teacherStore(Request $request){
        
        if($request->ajax('email') &&  $request->post('email')) {
            //check teacher has room in subscription
            $teacher = Teacher::find(Auth::id());
            $plan = $teacher->currentSubscriptionPlan();
            if ($plan === null){
                return response()->json([
                    'success' => false, 
                    'msg' => 'You do not have an active subscription.'
                ], 403);
            } else if (count($teacher->students) >=  $plan->nb_students){
                return response()->json([
                    'success' => false, 
                    'msg' => 'You have reached your subscription limit!'
                ], 403);
            }
            //find student to add
            $email = $request->post('email');
            $student = Student::firstWhere('email', $email);

            if(empty($student)){
                return response()->json([
                    'success' => false, 
                    'msg' => 'User not found.'
                ], 500);
            }

            //attach student to teacher
            $teacher = Teacher::find(Auth::id());
            $teacher->students()->attach($student->id);

            if($teacher->students->contains($student)){
                return response()->json([
                    'success' => true, 
                    'student' => $student,
                ], 200);
            } else {
                return response()->json([
                    'success' => false, 
                    'msg' => 'User not found.'
                ], 500);
            }

           
        }
    }

    /**
     * Progress for authenticated student in all courses
     * 
     * @return \Illuminate\Http\Response
     */
    public function studentProgress(){
        $courses = Student::find(Auth::id())->courses;

        $this->authorize('studentProgress', Student::class);

        return view("student.progress", [
            "courses" =>$courses
        ]);
    }



    /**
     * Shows the confirmation page for deletion
     * 
     * @param int $id Course Id
     * @return \Illuminate\Http\Response
     */
    public function teacherConfirmDelete($id){
        $student = Student::find($id);
        if(empty($student)){
            return redirect(route('student_teacherIndex'))->with('flash_modal', "Sorry, we were unable to handle your request.");
        }
        $this->authorize('delete', $student);
        $message = "<p>You have chosen to remove the following student: <strong>".$student->firstname." ".$student->lastname."</strong></p>";
        $message .= "<p>Please be aware that this will remove all associated data, progress, assignment attempts, marks, etc.</p>";
        $message .= "<p>Sure you want to remove ?</p>";
        return view('teacher.confirmDelete', [
            'route'=> route('student_teacherDelete', $id),
            'message'=>$message,
            'backRoute'=> route('student_teacherShow', $id),
            'resource'=>'student'
        ]);
    }

    /**
     * Soft Deleted the student
     * 
     * @param int $id Course Id
     * @return \Illuminate\Http\Response
     */
    public function teacherDelete($id){
        $student = Student::find($id);
        if(empty($student)){
            return redirect(route('student_teacherIndex'))->with('flash_modal', "Sorry, we were unable to handle your request.");
        }
        $teacher = Teacher::find(Auth::id());

        $this->authorize('delete', $student);        
         //delete enrolments for this student and teacher
         $enrolments = DB::table('enrolments')
         ->where('student_id', $student->id)
         ->whereIn('course_id', $teacher->courses->pluck('id'))
         ->update(array('deleted_at' => DB::raw('NOW()')));

        $teacher->students()->detach($student->id);

        if (!$teacher->students->contains($student)){
            return redirect(route('student_teacherIndex'))->with('success', 'Student Removed');
        } else {
            return redirect(route('student_teacherShow', $id))->with('error', 'Student Could not be Removed');
        }
    }

    public function teacherDownloadReport($id){
        $student = Student::find($id);

        $this->authorize('teacherView', $student);


        $pdf = PDF::loadView('teacher.student.report', compact('student'));
        return $pdf->download($student->firstname.'_'.$student->lastname.'.pdf');
    }
}
