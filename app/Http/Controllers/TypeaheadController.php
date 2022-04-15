<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TypeaheadController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function newEnrolmentByTeacher(Request $request)
    {
        if($request->ajax('search') && $request->post('search')) {
            $search = $request->post('search');
            $teacher = Teacher::find( Auth::id());
            $data = Student::
                where(function($query) use ($search){
                    $query->where('firstname', 'LIKE', $search.'%')
                        ->orWhere('lastname', 'LIKE', $search.'%');
                })->whereIn('id', $teacher->students->pluck('id'))->get();

                

            $output = '';
            if (count($data)>0) {
                foreach ($data as $row){
                    $output .= '<li class="list-group-item d-flex justify-content-between"><span>'.$row->firstname.' '.$row->lastname.'</span><span><small class="text-muted">'.$row->email.'</small></span><button class="btn btn-outline-success" type="button">Add</button></li>';
                }
            }
            else {
                $output .= '<li class="list-group-item">'.'No results'.'</li>';
            }
            
            return $output;
        }
    } 
}