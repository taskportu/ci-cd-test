<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Subject;
use App\Models\Courses;
use Illuminate\Http\Request;

class SubjectController extends Controller
{

    // subject add
   public function subjectAdd()
   {
       $courses=Courses::all();
       return view('subject.SubjectAdd',['courses'=>$courses]);
   }

    // subject add process
   public function subjectAddProcess(Request $request)
   {
        $request->validate([
            'name' => 'required|unique:subjects,subject_name',
            'course_id' => 'required',
        ]);

       $subject=new Subject();
       $subject->subject_name=$request->name;
       $subject->course_id=$request->course_id;
       $subject->save();
       return redirect('subject-show-all')->with('success','successfull added');
   }

    // subject show all   
   public function subjectShowAll()
   {
       $subjects=DB::table('subjects')
       ->join('courses','courses.id','=','subjects.course_id')
       ->select('subjects.*','courses.course_name')
       ->get();
       return view('subject.SubjectShowAll',['subjects'=>$subjects]);
   }

    // subject edit
   public function subjectEdit($id)
   {
       $subject=Subject::find($id);
       $courses=Courses::all();
       return view('subject.SubjectEdit',['subject'=>$subject,'courses'=>$courses]);
   }

    // subject update process
   public function subjectUpdateProcess(Request $request)
   {
    $subject=Subject::find($request->id);

        $request->validate([
            'name' => 'required|unique:subjects,subject_name,'.$subject->id,
            'course_id' => 'required',
        ]);
       
       $subject->subject_name=$request->name;
       $subject->course_id=$request->course_id;
       $subject->save();
       return redirect('subject-show-all')->with('success','successfull updated');   
   }
}
