<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{

    // employee add
    public function employeeAdd()
    {
        $departments=Department::all();
        $roles=Role::all();
        return view('employee.EmployeeAdd',['departments'=>$departments,'roles'=>$roles]);
    }

    // employee add process
    public function employeeAddProcess(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:employees,email',
            'phone_no' => 'required|unique:employees,phone_no',
            'department_id' => 'required',
            'role_id' => 'required',
        ]);

        $employee=new Employee();
        $employee->first_name=$request->first_name;
        $employee->last_name=$request->last_name;
        $employee->email=$request->email;
        $employee->phone_no=$request->phone_no;
        $employee->department_id=$request->department_id;
        $employee->role_id=$request->role_id;
        $employee->save();
        return redirect('employee-show-all')->with('success','successfull added');
    }

    // employee show all
    public function employeeShowAll()
    {
        $employees=DB::table('employees')
        ->join('departments','departments.id','=','employees.department_id')
        ->join('roles','roles.id','=','employees.role_id')
        ->select('employees.*','departments.name as department_name','roles.name as role_name')
        ->paginate(7);
        return view('employee.EmployeeShowAll',['employees'=>$employees]);
    }

    // employee edit
    public function employeeEdit($id)
    {
        $departments=Department::all();
        $roles=Role::all();
        $employee=Employee::find($id);
        return view('employee.EmployeeEdit',['employee'=>$employee,'departments'=>$departments,'roles'=>$roles]);
    }

    // employee update process
    public function employeeUpdateProcess(Request $request)
    {
        $employee=Employee::find($request->id);
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:employees,email,'.$employee->id,
            'phone_no' => 'required|unique:employees,phone_no,'.$employee->id,
            'department_id' => 'required',
            'role_id' => 'required',
        ]);

        // employee update
        $employee->first_name=$request->first_name;
        $employee->last_name=$request->last_name;
        $employee->email=$request->email;
        $employee->phone_no=$request->phone_no;
        $employee->department_id=$request->department_id;
        $employee->role_id=$request->role_id;
        $employee->save();

        // employee have in user table so update in user table
        if ($user=User::where('users.employee_id','=',$request->id)->first()) {
            $user->name=$request->first_name." ".$request->last_name;
            $user->email=$request->email;
            $user->role_id=$request->role_id;
            $user->save();
        }
        return redirect('employee-show-all')->with('success','successfull updated');
    }
}
