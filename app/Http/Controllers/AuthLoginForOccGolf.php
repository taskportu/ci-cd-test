<?php

namespace App\Http\Controllers;

use Hash;
use Session;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class AuthLoginForOccGolf extends Controller {

	/*public function authLoginForOccGolf(Request $request) {
		$json = array();
		$json['error'] = false;

		$password = $request->code;
		$givenDefaultPassword = '1964occ-sys';
		$givenUserPassword = '1964occ-reg';

       $request->session()->put('prevUrl', url()->previous());

		if(!empty($password) && $password == $givenDefaultPassword):
			$request->session()->put('authenticated', 'admin');
			$json['mode'] = 'admin';

		elseif(!empty($password) && $password == $givenUserPassword):
			$request->session()->put('user', 'user');
			$json['mode'] = 'user';

		else:
			$json['message'] = 'invalid password';
			$json['error'] = true;

		endif;

		return response()->json($json);
	}*/

    public function authLoginForOccGolf1(Request $request) {
        $json = array();
        $json['error'] = false;

        $password = $request->code;
        $givenDefaultPassword = '1964occ-sys';
        $givenUserPassword = '1964occ-reg';
       // return response()->json([$request->all(), (!empty($password) && $password == $givenUserPassword)]);

       // $request->session()->put('prevUrl', url()->previous());
        if($request->user_type === 'admin') {
            if(!empty($password) && $password == $givenDefaultPassword):
                $request->session()->put('authenticated', 'admin');
                $json['mode'] = 'admin';
            else:
                $json['message'] = 'Invalid Password';
                $json['error'] = true;
            endif;
        }
        elseif ($request->user_type === 'user') {
            if(!empty($password) && $password == $givenUserPassword):
                $request->session()->put('user', 'user');
                $json['mode'] = 'user';
            else:
                $json['message'] = 'Invalid Password';
                $json['error'] = true;
            endif;
        }

		// if(!empty($password) && $password == $givenDefaultPassword):
		// 	$request->session()->put('authenticated', 'admin');
		// 	$json['mode'] = 'admin';

		// elseif(!empty($password) && $password == $givenUserPassword):
		// 	$request->session()->put('user', 'user');
		// 	$json['mode'] = 'user';

		// else:
		// 	$json['message'] = 'invalid password';
		// 	$json['error'] = true;

		// endif;

        return response()->json($json);
    }

    public function authLoginForOccGolf(Request $request) {
        $json = array();
        $json['error'] = false;

        $username = $request->username;
        $password = $request->code;

        $user = User::where('username', $username)->orWhere('email', $username)->first();
        if(isset($user)) {
            if(Auth::attempt(['username' => $username, 'password' => $password])):
        		$user = Auth::user();
                $request->session()->put('authenticated', 'admin');
                $request->session()->put('authenticated_user', $user);

                $json['mode'] = 'admin';
            elseif(Auth::attempt(['email' => $username, 'password' => $password])):
                $user = Auth::user();
                $request->session()->put('authenticated', 'admin');
                $request->session()->put('authenticated_user', $user);

                $json['mode'] = 'admin';
            else:
                $json['message'] = 'Invalid Password';
                $json['error'] = true;
            endif;
        }
        elseif ($request->user_type === 'user') {
            $json['message'] = 'Invalid User';
            $json['error'] = true;
        }

        return response()->json($json);
    }

	public function authLogoutForOccGolf(Request $request){
		$request->session()->forget(['otp_send_success','member_id']);
		$request->session()->flush();
		return redirect('/auth');
	}

	public function applogout(Request $request)
	{
	    // dd('in');
		$request->session()->forget(['otp_send_success','member_id']);

        Cookie::queue(Cookie::forget('validated'));
        Cookie::queue(Cookie::forget('validated_otp'));
        Cookie::queue(Cookie::forget('validated_member'));
        Cookie::queue(Cookie::forget('otp_send_success'));
        Cookie::queue(Cookie::forget('member_id'));
       // Cookie::queue(Cookie::forget('mobile'));
       // Cookie::queue(Cookie::forget('0773315992'));

		$request->session()->flush();
		return redirect('/app');
	}

}
