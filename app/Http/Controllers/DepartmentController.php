<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{

    // show all departments
    function department_showall()
    {
        $data=Department::paginate(7);
        return view('department.department_showall',['departments'=>$data]);
    }

    // department add
    public function department_add(){
        return view('department.department_add');
    }

    // department add process
    public function department_add_process(Request $request){
        $request->validate([
            'name' => 'required|unique:departments,name',
            'code' => 'required|unique:departments,code',
        ]);

        $department=new Department();
        $department->code=$request->code;
        $department->name=$request->name;
        $department->description=$request->description;
        $department->save();
        return redirect('departmentshowall')->with('success', 'succesfull added');
    }

    // department edit
    function department_edit($id)
    {
        $data=Department::find($id);
        return view('department.department_edit',['departments'=>$data]);
    } 

    // department update process
    public function departmentUpdateProcess(Request $request)
    {
        $department=Department::find($request->id);
        $request->validate([
            'name' => 'required|unique:departments,name,'.$department->id,
            'code' => 'required|unique:departments,code,'.$department->id,
        ]);
        
        $department->code=$request->code;
        $department->name=$request->name;
        $department->description=$request->description;
        $department->save();
        return redirect('departmentshowall')->with('success', 'succesfull updated');
    }

    // department delete
    public function department_delete(Request $request)
    {
        $department=Department::find($request->id);
        $department->delete();
        return redirect('departmentshowall')->with('success', 'succesfull deleted');
    }
}
