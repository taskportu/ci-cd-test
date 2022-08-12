<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Courses;
use App\Models\Department;
use App\Models\Role;
use App\Models\Subject;
use App\Models\StudentSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
   
    // student add 
   public function studentAdd()
   {
       $departments=Department::all();
       $subjects=Subject::all();
       $courses=Courses::all();
       return view('student.StudentAdd',['courses'=>$courses,'subjects'=>$subjects,'departments'=>$departments]);
   }


    // student add process    
   public function studentAddProcess(Request $request)
   {

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:students,email',
            'phone_no' => 'required|unique:students,phone_no',
            'course_id' => 'required',
            'role_id' => 'required',
            'subject' => 'required',
        ]);

        if (count($request->subject)<2) {
            return redirect()->back()->with('erorr','please select minimum 2 subjects');
        }

        // student is default role    
        $roles=Role::where('name','Student')
        ->get();
        foreach ($roles as $role){ 
            $role_id= $role->id;
        }
        
        $student=new Student();
        $student->first_name=$request->first_name;
        $student->last_name=$request->last_name;
        $student->email=$request->email;
        $student->phone_no=$request->phone_no;
        $student->course_id=$request->course_id;
        $student->role_id=$role_id;
        $student->save();

        // selected subject save
        foreach ($request->subject as $subject_id) {
            $student_subject=new StudentSubject();
            $student_subject->student_id=$student->id;
            $student_subject->subject_id=$subject_id;
            $student_subject->save();
        }
        return redirect('student-show-all')->with('success','successfull added');
   }

    // student show all    
   public function studentShowAll()
   {
      $students=DB::table('students')
      ->join('courses','courses.id','=','students.course_id')
      ->join('roles','roles.id','=','students.role_id')
      ->select('students.*','roles.name as role_name','courses.course_name')
      ->paginate(7);
      return view('student.StudentShowAll',['students'=>$students]);
   }

    // student edit
   public function studentEdit($id)
   {    
       $student_subjects=DB::table('student_subjects')
       ->select('student_subjects.id','student_subjects.subject_id','student_subjects.student_id')
       ->where('student_subjects.student_id','=',$id)
       ->get();

       $departments=Department::all();
       $subjects=Subject::all();
       $courses=Courses::all();
       $student=Student::find($id);
       return view('student.StudentEdit',['student'=>$student,'courses'=>$courses,'subjects'=>$subjects,'student_subjects'=>$student_subjects,'departments'=>$departments]);
   }

    // student update process    
   public function studentUpdateProcess(Request $request)
   {
        $student=Student::find($request->id);
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:students,email,'.$student->id,
            'phone_no' => 'required|unique:students,phone_no,'.$student->id,
            'course_id' => 'required',
            'subject' => 'required',
        ]);

        if (count($request->subject)<2) {
            return redirect()->back()->with('erorr','please select minimum 2 subjects');
        }

       $student=Student::find($request->id);
       $student->first_name=$request->first_name;
       $student->last_name=$request->last_name;
       $student->email=$request->email;
       $student->phone_no=$request->phone_no;
       $student->course_id=$request->course_id;
       $student->save();

        // selected subjects update    
       foreach ($request->subject as $subject_id) {
        $student_subject=new StudentSubject();
        $student_subject->student_id=$student->id;
        $student_subject->subject_id=$subject_id;
        $student_subject->save();
       }
        
       return redirect('student-show-all')->with('success','successfull updated');
    }
}
