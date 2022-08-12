<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // role add
    public function roleAdd()
    {
        return view('role.RoleAdd');
    }
    
    // role add process
    public function roleAddProcess(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
        ]);
        $role=new Role();
        $role->name=$request->name;
        $role->save();
        return redirect('role-show-all')->with('success','successfull added');
    }

    // show all roles
    public function roleShowAll()
    {
        $data=Role::paginate(7);
        return view('role.RoleShowAll',['roles'=>$data]);
    }

    // role edit
    public function roleEdit($id)
    {
        $role=Role::find($id);
        return view('role.RoleEdit',['role'=>$role]);
    }

    // role update process
    public function roleUpdateProcess(Request $request)
    {
        $role=Role::find($request->id);
        $request->validate([
            'name' => 'required|unique:roles,name,'.$role->id,
        ]);
        
        $role->name=$request->name;
        $role->save();
        return redirect('role-show-all')->with('success','successfull updated');
    }
    
}
