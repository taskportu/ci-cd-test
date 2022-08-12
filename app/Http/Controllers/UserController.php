<?php

namespace App\Http\Controllers;

use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

use App\Models\Employee;
use App\Models\User;
use App\Models\PasswordReset;
use Mail;

class UserController extends Controller
{

    // user add from employee 
    public function employeeUserAdd()
    {
        $employees=DB::table('employees')
        ->select('employees.id','employees.email')
        ->get();
        return view('authentication.CoustomRegister',['employees'=>$employees]);
    }

    // user add process from employee 
    public function employeeUserAddProccess(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'txt_password' => 'required',
        ]);
        $employee=Employee::find($request->id);
        $user=new User();
        $user->employee_id=$request->id;
        $user->name=$employee->first_name." ".$employee->last_name;
        $user->email=$employee->email;
        $user->password=Hash::make($request->txt_password);
        $user->role_id=$employee->role_id;
        $user->save();
        return redirect('/employee-user-show-all')->with('success','successfull added');
    }

    // user show all
    public function employeeUserShowAll()
    {
        $employee_users=DB::table('users')
        ->select('users.id','users.name','users.email','roles.name as role_name')
        ->join('roles','roles.id','=','users.role_id')
        ->paginate(7);
        return view('user.EmployeeUserShowAll',['employee_users'=>$employee_users]);
    }

    // user authuentication privilage remove
    public function employeeUserDelete($id)
    {
        $user=User::find($id);
        $user->delete();
        return redirect('/employee-user-show-all')->with('success','successfull deleted');
    }

    // password reset before login
    public function resetPassword()
    {   
        return view('user.EmailForPasswordReset');
    }

    // check email for password reset before login
    public function checkEmailForPasswordReset(Request $request)
    {    
        // find user
        if ($user=User::where('email', '=',$request->email)->first()) {
            if ($password_reset=PasswordReset::where('user_id','=',$user->id)->first()) {
                $password_reset->user_id=$user->id;
                $password_reset->token=random_int(1000, 9999);
                if ( $password_reset->save()) {
                  $this->mailSend($request->email,$password_reset->token);
                }
            }else{     
                $password_reset=new PasswordReset();
                $password_reset->user_id=$user->id;
                $password_reset->token=random_int(1000, 9999);
                // $password_reset->token=Str::random(32);
                if ($password_reset->save()) {
                    $this->mailSend($request->email,$password_reset->token);
                }
            }
            return redirect('/token-verify-form');
        } 
        return redirect('/reset-password')->with('erorr','your email id is not found');
    }

    // mail send function
    public function mailSend(string $email,string $token){
       
        $data = [
            'email' => $email,
            'token' => $token
          ];
         
        Mail::send([],$data, function ($message) use ($data) {
            $message->setBody('Hi, welcome user!');
            $message->setBody('<h1>your token is :- '.$data["token"].'</h1>', 'text/html');
            $message->from('studentlaravel16@gmail.com', 'Student System');
            $message->sender('studentlaravel16@gmail.com', 'Student System');
            $message->to($data["email"]);
            $message->replyTo('studentlaravel16@gmail.com', 'Student System');
            $message->subject('Password Reset Verification');
        });
    }

    // token verify form
    public function tokenVerifyForm()
    {
       return view('user.TokenVerifyForm');
    }

    // token verify process
    public function tokenVerifyProcess(Request $request)
    {        
        if ($user=PasswordReset::where('token', '=',$request->token)->first()) {
            return redirect('/new-password-add-form')->with('user',$user);
        } else {
            return redirect('/token-verify-form')->with('erorr','your token wrong please try again');
        }
        
    }

    // new password add form
    public function newPasswordAddForm()
    {
       return view('user.NewPasswordAddForm');
    }

    // new password add process
    public function newPasswordAddProcess(Request $request)
    {      
            $user=User::find($request->id);
            $user->password=Hash::make($request->txt_password);
            $user->save();
            return redirect('/')->with('success','successfull change password please login');       
    }

    // user logOut
    public function logOut()
    {
        Auth::logout();
        return redirect('/');
    }

    // password change after login
    public function editPassword(Request $request)
    {
        if (Hash::check($request->txt_current_password, Auth::user()->password)) {
            $user=User::find(Auth::user()->id);
            $user->password=Hash::make($request->txt_password);
            $user->save();
            return redirect('/')->with('success','successfull change password please login');
        } else {
            return redirect('/employee-user-show-all')->with('erorr','password reset fail');
        }
    }

    public function getDetails()
    {
        // $employee_users=DB::table('users')
        // ->select('users.id','users.name','users.email','roles.name as role_name')
        // ->join('roles','roles.id','=','users.role_id')
        // ->get();

        $employee_users=User::all();
        return $employee_users;
    }
}