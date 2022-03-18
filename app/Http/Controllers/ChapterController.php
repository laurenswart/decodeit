<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChapterController extends Controller
{
    public function studentChapter($id){

        $chapter = Chapter::find($id);
    
        return view('student.chapter', [
            'chapter'=>$chapter,
        ]);
    }
}
