public function app()
	{
		// return Session::get('otp_send_success');
		// return Session::get('mobile');
		if(empty(Session::get('otp_send_success')))
		{

			return view('app');
		}
		else{
			$memberdata = Members::where('MemberID',Session::get('member_id'))->first();
			$validate = "success_otp";
			return view('app',compact('validate','otp_send','memberdata'));
		}
	}

	public function validate_otp(Request $request)
	{
		// return $request;
		if(!empty($request->mobile))
		{
			$member = Members::wherePhoneMobile($request->mobile)->first();
			if(!empty($member))
			{


				$member_name = $member->Member_Fistname;
				$member_email = $member->email;
				$otp = mt_rand(100000, 999999);
				$otp_send = Session::put('otp_send', $otp);
				$otp_send = $otp;
				Session::put('LAST_ACTIVITY',time());
	
				Mail::send('email.otp', ['member_name' => $member_name, 'member_email' => $member_email, 'otp' => $otp], function ($message) use ($member_email) {
	
	
					$message->subject('OCC-GOLF APP');
					$message->to($member_email);
				});
				$validate = 'success';
				// $validate_otp = "";
			}
			else
			{
				$validate = 'check mobile';
			}
			$mobile = $request->mobile;
			
			return view('app',compact('validate','validate_otp','otp_send','mobile'));

		}
		else if(!empty($request->otp))
		{
			if (Session::get('LAST_ACTIVITY') && (time() - Session::get('LAST_ACTIVITY') > 60 ))
			{

				Session::forget('otp_send');
			}
			else
			{

				Session::get('otp_send');
			}

			$otp_get = Session::get('otp_send');
			if(!empty($otp_get) && $otp_get == $request->otp)
			{
				$memberdata = Members::wherePhoneMobile($request->typed_mobile)->first();

				$otp_send = Session::put('otp_send_success', $request->otp);
				$member_id = Session::put('member_id', $memberdata->MemberID);


				// $validate_otp = 'success';
				$validate = 'success_otp';
				// $otp = "success";
			}
			else
			{
				// $validate_otp = 'error';
				// $otp = "error";
				$member = '';
				$validate = 'otp not matched';
			}

			return view('app',compact('validate','otp_send','memberdata'));
		}
		else
		{
			return view('app');
		}
	}