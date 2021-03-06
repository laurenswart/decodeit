<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentNote;
use App\Models\Chapter;
use App\Models\Course;
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
    public function dashboard(){
        $courses = Student::find(Auth::id())->courses;
        $assignmentsAll = Assignment::all()
        ->sortBy('start_time')
        ->whereIn('course_id', $courses->pluck('id'))
        ->where('end_time', '>=', now());

        $assignments = [];
        foreach($assignmentsAll as $assignment){
            //chapter is active, student is enrolled in course and course is active
            if($assignment->chapters[0]->is_active){
                $assignments[] = $assignment;
            }
        }

        return view('student.dashboard', [
            'notifications' => Student::find(Auth::id())->notifications(),
            'assignments' => $assignments
        ]);
    }

    /**
     * Show students for the authenticated admin
     *
     * @return \Illuminate\Http\Response
     */
    public function adminIndex(Request $request){
        $currentQueries = $request->query();
        $sort = $request->query('sort') ?? 'firstname';
        $order = $request->query('order') ?? 'asc';
        $filter = $request->query('filter') ?? '';
        $students = Student::
                orderBy($sort, $order)
                ->where(function ($query) use ($filter){
                    $query->where('firstname', 'like', "%$filter%")
                          ->orWhere('lastname', 'like',"%$filter%");
                })
                ->paginate(10)
                ->appends( ['sort'=>$sort, 'order'=>$order, 'filter'=>$filter ]);
        
        $currentQueries['sort'] = $sort;
        $currentQueries['order'] = $order;
        $currentQueries['filter'] = $filter;
        return view('admin.student.index', [
            'students'=>$students,
            'currentQueries'=>$currentQueries
        ]);
    }

    /**
     * Show students for the authenticated teacher
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function teacherIndex(Request $request){
        $this->authorize('teacherViewAny', Student::class);
        $currentQueries = $request->query();
        //dd($currentQueries);
        $sort = $request->query('sort') ?? 'firstname';
        $order = $request->query('order') ?? 'asc';
        $filter = $request->query('filter') ?? '';
        $students = Teacher::find(Auth::id())->students()
                ->orderBy($sort, $order)
                ->where(function ($query) use ($filter){
                    $query->where('firstname', 'like', "%$filter%")
                          ->orWhere('lastname', 'like',"%$filter%");
                })
                ->paginate(10)
                ->appends( ['sort'=>$sort, 'order'=>$order, 'filter'=>$filter ]);
        
        $currentQueries['sort'] = $sort;
        $currentQueries['order'] = $order;
        $currentQueries['filter'] = $filter;

        return view('teacher.student.index', [
            'students'=>$students,
            'currentQueries'=>$currentQueries
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


    /**
     * Show account details for the student
     *
     * @return \Illuminate\Http\Response
     */
    public function studentShow(){
        $this->authorize('studentShow', Student::class);
        $student = Student::find(Auth::id());

        return view('student.account', [
            'student'=>$student
        ]);
    }

    /**
     * Show edit form for student details
     *
     * @return \Illuminate\Http\Response
     */
    public function studentEdit(){
        $this->authorize('studentShow', Student::class);
        $student = Student::find(Auth::id());
        

        return view('student.account_edit', [
            'student'=>$student
        ]);
    }

    /**
     * Update student details
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function studentUpdate(Request $request){
        $this->authorize('studentShow', Student::class);
        $student = Student::find(Auth::id());
        
        $rules = [
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
        ];
        $validated = $request->validate($rules);

        $student->firstname = $validated['firstname'];
        $student->lastname = $validated['lastname'];
        $student->save();
        
        return view('student.account', [
            'student'=>$student
        ]);
    }

    /**
     * Show confirmation page to delete account
     *
     * @return \Illuminate\Http\Response
     */
    public function studentConfirmDelete(){
        $this->authorize('studentShow', Student::class);
        
        $message = "<p>You have chosen to delete your account.</p>";
        $message .= "<p>Please be aware that this will remove all of your data data, such as submissions, marks, progress etc.</p>";
        $message .= "<p>This action cannot be undone.</p>";
        $message .= "<p>Are you sure you want to delete ?</p>";
        return view('student.confirm', [
            'confirmAction'=> route('student_studentDelete'),
            'message'=>$message,
            'confirmLabel'=>'Delete',
            'title'=>'Delete Account',
            'backRoute'=> route('student_studentShow'),
            'delete'=>true
        ]);
    }

    /**
     * Remove personnal information from student
     *
     * @return \Illuminate\Http\Response
     */
    public function studentDelete(){
        $this->authorize('studentShow', Student::class);
        //remove firstname, lastname, email, password    
        $userId = Auth::id();
        $student = Student::find($userId);
        $student->firstname = 'firstname_'.$userId;
        $student->lastname = 'lastname_'.$userId;
        $student->email = 'email_'.$userId;
        $student->save();
        $student->delete();
        Auth::logout();
        return redirect(route('welcome'));
    }


    /**
     * Display enrolments and form to add new ones for a student
     * 
     * @param int $id Student id
     * @return \Illuminate\Http\Response
     */
    public function teacherEnrolments($id){
        $student= Student::find($id);
        $currentEnrolments = $student->coursesForTeacher();
        //dd($currentEnrolments->pluck('id'));//74 75 76

        $otherCourses = Teacher::find(Auth::id())->courses->whereNotIn('id',   $currentEnrolments->pluck('id'));
        return view('teacher.student.enrolments', [
            'student' => $student,
            'otherCourses' => $otherCourses
        ]);
    }

    /**
     * Add new enrolment for a student
     * 
     * @param \Illuminate\Http\Request $request
     * @param int $id Student id
     * @return \Illuminate\Http\Response
     */
    public function teacherAddEnrolment(Request $request, $id){
        if($request->ajax()) {
            //validate question
            if(empty($request->post('courseId'))){
                return response()->json([
                    'success' => false, 
                    'msg' => 'No course received'
                ], 400);
            }

            //find student
            $student = Student::find($id);
            if(empty($student)){
                return response()->json([
                    'success' => false, 
                    'msg' => 'User not found.'
                ], 500);
            }
            $courseId = $request->post('courseId');
            $course = Course::find($courseId);
            if (empty($course) || $request->user()->cannot('teacherAddEnrolment', [$student, $course])){
                return response()->json([
                    'success' => false, 
                    'msg' => 'Unauthorized action'
                ], 403);
            }

            //create enrolment
            $student->courses()->attach([$courseId]);

            if($student->courses->contains($course)){
                return response()->json([
                    'success' => true,
                    'courseName' => $course->title,
                    'route' => route('course_teacherShow', $course->id),
                    'created' => date('d/m/Y', now()->timestamp)
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
