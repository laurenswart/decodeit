<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChapterController extends Controller
{

    /**
     * Show a chapter for the authenticated student
     *
     * @param int $id Id of the chapter
     * @return \Illuminate\Http\Response
     */
    public function studentShow($id){
        $chapter = Chapter::find($id);

        $this->authorize('studentView', $chapter);
    
        return view('student.chapter', [
            'chapter'=>$chapter,
        ]);
    }
}
