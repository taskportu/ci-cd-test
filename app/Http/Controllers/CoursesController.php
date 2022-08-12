<?php

namespace App\Http\Controllers;

use App\Models\Courses;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CoursesController extends Controller
{
    // course add
    public function courseAdd()
    {
        $departments=Department::all();
        return view('course.CourseAdd',['departments'=>$departments]);
    }

    // cousre add process
    public function courseAddProcess(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:courses,course_name',
            'code' => 'required|unique:courses,course_code',
            'department_id' => 'required',
        ]);
        $course=new Courses();
        $course->course_name=$request->name;
        $course->course_code=$request->code;
        $course->description=$request->description;
        $course->department_id=$request->department_id;
        $course->save();
        return redirect('course-show-all')->with('success','successfull added');
    }

    // course show all
    public function courseShowAll()
    {
        $courses = DB::table('courses')
        ->join('departments', 'departments.id', '=', 'courses.department_id')
        ->select('courses.*', 'departments.name')
        ->paginate(7);
        return view('course.CourseShowAll',['courses'=>$courses]);
    }

    // course edit
    public function courseEdit($id)
    {
        $course=Courses::find($id);
        $departments=Department::all();
        return view('course.CourseEdit',['course'=>$course,'departments'=>$departments]);
    }

    // course update process
    public function courseUpdateProcess (Request $request)
    {
        $course=Courses::find($request->id);
        $request->validate([
            'name' => 'required|unique:courses,course_name,'.$course->id,
            'code' => 'required|unique:courses,course_code,'.$course->id,
            'department_id' => 'required',
        ]);
        
        $course->course_name=$request->name;
        $course->course_code=$request->code;
        $course->description=$request->description;
        $course->department_id=$request->department_id;
        $course->save();
        return redirect('course-show-all')->with('success','successfull updated');
    }
}