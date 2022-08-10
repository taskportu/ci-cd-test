<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Mail;
use Session;
use App\Reg;
use App\club;
use App\Members;
use App\UserLog;
use App\NewsInfo;
use Carbon\Carbon;
use App\TicketSmsLog;
use App\Models\Ticket;
use App\Models\HcpRegitar;
use App\Models\AppTracking;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\GuestPlayController;
use function foo\func;

class MembersController extends Controller
{
    public function hcpimport()
    {
        return 'oksd';
    }

    public function update_hcp_status(Request $request)
    {
        if(isset($request->type)) {
            DB::table('members')
                ->where('OccID', $request->manual_occid)
                ->update([
                    'sms_news_letter' => ($request->sms_status === 'on') ? 1 : 0
                ]);
        }
        else {
            DB::table('members')
                ->where('OccID', $request->manual_occid)
                ->update([
                    'app_hcp_status' => $request->hcp_status
                ]);
        }

        return response()->json([
            'success' => true,
        ]);
    }

    public function hcp_manuval_update(Request $request)
    {
        // return $request;
        $new_handicap = '';
        $online_hcp = '';
        if (strpos($request->manuval_hcp, ',') !== false) {
            // echo 'true';
            $new_handicap = $request->manuval_hcp;
        } else {
            $new_handicap = (strlen($request->manuval_hcp) <= 3) ? $request->manuval_hcp . ',0' : str_replace(".", ",", $request->manuval_hcp);
        }

        if (strpos($request->online_hcp, ',') !== false) {
            // echo 'true';
            $online_hcp = $request->online_hcp;
        } else {
            $online_hcp = (strlen($request->manuval_hcp) <= 3) ? $request->manuval_hcp . ',0' : str_replace(".", ",", $request->manuval_hcp);
        }

        if ($request->hcp_type == 'manual') {
            $member = Members::where('OccID', $request->manual_occid)->first()->toArray();
            if ($member['email'] != '' && $member['email'] != null) {

                $member_name = $member['Member_Fistname'] . ' ' . $member['Member_Lastname'];
                $member_email = $member['email'];
                $member_phoneno = $member['phone_mobile'];
                Mail::send('email.app_manuval_hcp', ['member_phoneno' => $member_phoneno, 'new_hcp' => $new_handicap], function ($message) use ($member_email) {

                    // $message->from('noreply@digifront.biz', 'HCP Update');
                    $message->subject('Oppdater HCP i OCC Medlemssystem');
                    $message->to($member_email);
                });
            }
            DB::table('members')
                ->where('OccID', $request->manual_occid)
                ->update([
                    'handicap' => $new_handicap,
                    // 'app_hcp_status' =>  $request->hcp_type
                ]);
            // return 'manual';
        } else if ($request->hcp_type == 'online') {
            // halculations
            // return $request->club;
            $hcp = HcpRegitar::orderBy('id', 'desc')->where('OccID', $request->manual_occid)->where('hcp_status', '1')->first();
            $unique_hcp = Members::where('OccID', $request->manual_occid)->first();
            $hc2 = HcpRegitar::where('OccID', $request->manual_occid)->where('hcp_status', '1')->sum('cal_hcp');
            $unique1_hcp = str_replace(",", ".", $unique_hcp['HCP']);
            $online_hcp = str_replace(",", ".", $request->online_hcp);
            if (7 >= $hcp['round_palyed']) {
                $default_hcp = (!empty($hcp['round_palyed']) ? ($hcp['round_palyed'] + 1) : 1);

                $total = (8 - $default_hcp) * $unique1_hcp;

                $total_cal = ($total + $online_hcp + (!empty($hc2) ? $hc2 : 0)) / 8;
                $new_total = (string)number_format($total_cal, 1);

                $last = HcpRegitar::orderBy('id', 'desc')->where('OccID', $request->manual_occid)->where('hcp_status', '1')->first();
                $count = (!empty($last) ? $last->round_palyed : 0);
                $round_palyed = $count + 1;

                $hcpreg = new HcpRegitar;
                $hcpreg->OccID = $request->manual_occid;
                $hcpreg->hcp = str_replace(".", ",", $new_total);

                $hcpreg->date = date('Y-m-d', strtotime($request->date));
                // date("m-d-Y", strtotime($orgDate));
                $hcpreg->round_palyed = $round_palyed;
                $hcpreg->cal_hcp = $request->online_hcp;
                $hcpreg->club = $request->club;
                $hcpreg->hcp_status = '1';
                $hcpreg->save();
                $count = HcpRegitar::where('OccID', $request->manual_occid)->count();

                $new_hcp = str_replace(".", ",", $new_total);
                $member = Members::where('OccID', $request->manual_occid)->first()->toArray();

                if ($member['email'] != '') {

                    // if ($request->old_hcp != $request->hcp) {

                    $member_name = $member['Member_Fistname'] . ' ' . $member['Member_Lastname'];
                    $member_email = $member['email'];
                    // Mail::send('email.hcpupdate', ['member_name' => $member_name, 'member_email' => $member_email, 'old_hcp' => $request->old_hcp, 'new_hcp' => $new_hcp], function ($message) use ($member_email) {

                    // 	// $message->from('noreply@digifront.biz', 'HCP Update');
                    // 	$message->subject('OCC-GOLF APP');
                    // 	$message->to($member_email);
                    // });
                }
                DB::table('members')
                    ->where('OccID', $request->manual_occid)
                    ->update([
                        'new_hcp' => $new_hcp,
                        'new_club' => $request->club,
                        'counted' => $count,
                        // 'app_hcp_status' =>  $request->hcp_type
                    ]);
                // }
                // return response()->json([
                // 	// 'success' => true,
                // 	'message' => ($request->old_hcp != $request->hcp) ? true  : false,
                // 	'fullname' => $member['Member_Fistname'] . ' ' . $member['Member_Lastname'],
                // 	'hcp' => $new_hcp,
                // ]);
            } else {

                $ids = array();
                $bestids = array();
                $bestids1 = array();
                $dbhcp = array();
                $hcp_datess = HcpRegitar::where('OccID', $request->manual_occid)->where('hcp_status', '1')
                    ->orderBy('date', 'desc')
                    ->orderBy('cal_hcp', 'ASC')
                    ->limit(20)
                    ->get();

                foreach ($hcp_datess as $hcp_date) :
                    $ids[] = $hcp_date['id'];
                endforeach;

                $hcp_sums = HcpRegitar::whereIn('id', $ids)->where('hcp_status', '1')
                    ->orderBy('cal_hcp', 'ASC')
                    ->limit(8)
                    ->get();

                foreach ($hcp_sums as $hcp_sum) :
                    $dbhcp[] = $hcp_sum['id'];
                    if ($hcp_sum['cal_hcp'] <= $request->online_hcp) {
                        $bestids[] = $hcp_sum['cal_hcp'];
                        // $bestids1[] = $hcp_sum['id'];
                    } else {
                        unset($bestids);
                    }
                    if ($hcp_sum['cal_hcp'] >= $request->online_hcp) {
                        $bestids1[] = $hcp_sum['id'];
                    }
                    // else {
                    //     unset($bestids1);
                    // }
                endforeach;

                if (!empty($bestids)) {

                    $total_cal_above = array_sum($bestids) / 8; //above result ok
                }
                // $diffrent = array_diff($dbhcp, $bestids1);
                // $total_ids = array_merge($diffrent, $bestids1);
                // return $hcp_datess;
                $hcp_sums = HcpRegitar::whereIn('id', $ids)->where('hcp_status', '1')
                    ->orderBy('cal_hcp', 'ASC')
                    ->limit(7)
                    ->get();
                $sum_ids = array();

                foreach ($hcp_sums as $hcp_sum) :
                    $sum_ids[] = $hcp_sum['id'];
                endforeach;
                $cal_sums = HcpRegitar::whereIn('id', $sum_ids)->where('hcp_status', '1')->sum('cal_hcp');
                $total_cals = ($cal_sums + $online_hcp) / 8;


                if (!empty($total_cal_above)) {
                    $total_cal = (string)number_format($total_cal_above, 1);
                } else {
                    $total_cal = (string)number_format($total_cals, 1);
                }


                // $total_cal = !empty($total_cals) ? $total_cals : $total_cal_above;
                $last = HcpRegitar::orderBy('id', 'desc')->where('OccID', $request->manual_occid)->where('hcp_status', '1')->first();
                $count = (!empty($last) ? $last->round_palyed : 0);
                $round_palyed = $count + 1;

                $hcpreg = new HcpRegitar;
                $hcpreg->OccID = $request->manual_occid;
                $hcpreg->hcp = str_replace(".", ",", $total_cal);
                $hcpreg->date =
                    date("Y-m-d", strtotime($request->date));
                $hcpreg->round_palyed = $round_palyed;
                $hcpreg->cal_hcp = $request->online_hcp;
                $hcpreg->club = $request->club;
                $hcpreg->hcp_status = '1';
                $hcpreg->save();
                $count = HcpRegitar::where('OccID', $request->manual_occid)->where('hcp_status', '1')->count();


                // $new_hcp = (strlen($total_cal) <= 3) ? $total_cal . ',0' : str_replace(".", ",", $total_cal);
                $new_hcp = str_replace(".", ",", $total_cal);
                $member = Members::where('OccID', $request->manual_occid)->first()->toArray();

                if ($member['email'] != '') {

                    // if ($request->old_hcp != $request->hcp) {

                    $member_name = $member['Member_Fistname'] . ' ' . $member['Member_Lastname'];
                    $member_email = $member['email'];
                    Mail::send('email.hcpupdate', ['member_name' => $member_name, 'member_email' => $member_email, 'old_hcp' => $request->old_hcp, 'new_hcp' => $new_hcp], function ($message) use ($member_email) {

                        // $message->from('noreply@digifront.biz', 'HCP Update');
                        $message->subject('OCC-GOLF APP');
                        $message->to($member_email);
                    });
                }
                DB::table('members')
                    ->where('OccID', $request->manual_occid)
                    ->update([
                        'new_hcp' => $new_hcp,
                        'new_club' => $request->club,
                        'counted' => $count

                    ]);

                // return response()->json([
                // 	// 'success' => true,
                // 	'message' => ($request->old_hcp != $request->hcp) ? true  : false,
                // 	'fullname' => $member['Member_Fistname'] . ' ' . $member['Member_Lastname'],
                // 	'hcp' => $new_hcp,
                // ]);
                DB::table('members')
                    ->where('OccID', $request->manual_occid)
                    ->update([
                        'HCP' => $new_hcp,
                        'new_hcp' => $new_hcp,
                        // 'app_hcp_status' =>  $request->hcp_type

                    ]);
            }
            // END caluclations
            // DB::table('members')
            // ->where('OccID', $request->manual_occid)
            // ->update([
            // 	'HCP' => $new_hcp,
            // 	'new_hcp'=> $new_hcp,

            // ]);
        }

        return response()->json([
            'success' => true,
            'new_manuval_hcp' => $new_handicap,
            'new_online_hcp' => (!empty($new_hcp) ? $new_hcp : $request->online_hcp)
        ]);
    }

    public function app(Request $request)
    {
        $parameter = (isset($request->name)) ? $request->name : 'front';
        $memberPlayRegData = [];
        $tickets = null;
        $newsInfo = null;
        $transfer_ticket = null;

        if (empty(Cookie::get('otp_send_success'))) {
            return view('app', compact('parameter'));
        }
        else {
            $memberdata = Members::where('MemberID', Cookie::get('member_id'))->first();
            // $occ_ic = Session::put('occ_id', $memberdata->OccID);
            $validate = "success_otp";

            $newsInfo = NewsInfo::where('status', 1)->where('id', 1)->orderBy('id', 'ASC')->first();
            if($parameter === 'ferry' || $parameter === 'buggy' || $parameter === 'pro-lessons') {
                $tickets = Ticket::where('occid', '=', $memberdata->MemberID)
                                ->whereDate('created_at', '>=', Carbon::now()->startOfYear()->format('Y-m-d H:i:s'))
                                ->whereDate('created_at', '<=', Carbon::now()->endOfYear()->format('Y-m-d H:i:s'));

                if ($parameter === 'ferry') {
                    $tickets = $tickets->where(function ($where)  {
                        $where->where('product', 'Ferry');
                        $where->whereNull('ticket_used');
                        $where->orWhere('ticket_used', '=', 'used');
                    });
                }
                else if ($parameter === 'buggy') {
                    $tickets = $tickets->where(function ($where) {
                        $where->where('product', 'Buggy');
                        $where->where('ticket_used', '=', 'used');
                    });
                }
                else if ($parameter === 'pro-lessons') {
                    $tickets = $tickets->where(function ($where) {
                        $where->where('product', 'Pro lessons');
                        $where->whereNull('ticket_type');
                        $where->whereNull('ticket_used');
                        $where->orWhere('ticket_used', '=', 'used');
                    });
                }
                $tickets = $tickets->orderBy('ticket_used', 'ASC')
                                    ->orderBy('ticket_type', 'DESC')
                                    ->orderBy('date_used', 'DESC')
                                    ->get()
                                    ->groupBy('product');
            }
            else if($parameter === 'greenfee') {
                $tickets_tmp1 = Ticket::select('tickets.*', 'r.reg_auto', 'r.reg_phone', 'r.reg_fistname', 'r.reg_lastname', 'r.reg_time', 'r.reg_member_id', 'r.created_by')
                    ->whereDate('tickets.created_at', '>=', Carbon::now()->startOfYear()->format('Y-m-d H:i:s'))
                    ->whereDate('tickets.created_at', '<=', Carbon::now()->endOfYear()->format('Y-m-d H:i:s'))
                    ->where('tickets.product', 'Greenfee')
                    ->whereNull('tickets.ticket_type')
                    ->leftJoin('registrations as r', 'r.reg_auto', '=', 'guest_id');

                $tickets_tmp2 = clone $tickets_tmp1;

                $tickets['Greenfee'][""] = clone $tickets_tmp1->where('tickets.occid', '=', $memberdata->MemberID)
                    ->whereNull('tickets.ticket_used')
                    ->orderBy('ticket_used', 'ASC')
                    ->orderBy('transfered_date', 'ASC')
                    ->orderBy('date_used', 'DESC')
                    ->get();

                $tickets['Greenfee']["used"] = clone $tickets_tmp2->where(function ($where) use($memberdata) {
                        $where->where(function ($w) use($memberdata) {
                            $w->where('tickets.occid', '=', $memberdata->MemberID);
                            $w->where('tickets.ticket_used', '=', 'used');
                        });
                        $where->orWhere(function ($w) use($memberdata) {
                            $w->whereNotNull('tickets.transfered_from');
                            $w->whereNotNull('tickets.transfered_date');
                            $w->where('tickets.transfered_from', $memberdata->MemberID);
                        });
                    })
                    ->orderBy('ticket_used', 'ASC')
                    ->orderBy('transfered_date', 'ASC')
                    ->orderBy('date_used', 'DESC')
                ->get();
//                dd($tickets['Greenfee']["used"]);
            }
            else if ($parameter === 'play') {
//                $parameter = 'front';
                if (Cookie::has('member_id')) {
                    $memberdata = Members::where('MemberID', Cookie::get('member_id'))->first();

                    /* Family Members List */
                    $occGroup = substr($memberdata->OccID, -3);
                    $occStarting = str_replace($occGroup, '', $memberdata->OccID);
                    $occStarting = (int)($occStarting / 10) * 10;
                    $family = [];
                    for ($i = $occStarting; $i < $occStarting+10; $i++) $family[] = (int)$i.''.$occGroup;
                    $familyMembers = Members::whereIn('OccID', $family)
                                            ->where('member_type', '!=', 'Slettet');

                    $familyPluck = $familyMembers->pluck('MemberID')->toArray();
                    $familyMembers = $familyMembers->where('OccID', '!=', $memberdata->OccID)->get();

//                    $memberHcp = HcpRegitar::where('OccId', $memberdata->OccID)->whereDate('date', Carbon::now()->format('Y-m-d'))->count();

                    $currentMemberPlayReg = Reg::whereIn('reg_member_id', $familyPluck)
                                                ->leftJoin('members as m', 'm.MemberID', '=', 'registrations.reg_member_id')
                                                ->where('reg_time', '>=', Carbon::now()->startOfDay()->format('Y-m-d H:i:s'))
                                                ->where('reg_time', '<=', Carbon::now()->endOfDay()->format('Y-m-d H:i:s'))
                                                ->whereNull('reg_guest_member')
                                                ->get();
                    $memberPlayRegData['currentMemberPlayReg'] = $currentMemberPlayReg;

                    $currentMemberPlayRegPluckId = $currentMemberPlayReg->pluck('reg_auto')->toArray();
                    $memberPlayRegData['currentMemberPlayRegPluckId'] = $currentMemberPlayRegPluckId;

//                    dd($currentMemberPlayRegPluckId);
                    if($currentMemberPlayReg) {
                        $currentMemberOtherPlayReg = Reg::whereIn('reg_guest_member', $currentMemberPlayRegPluckId)
                                                    ->leftJoin('members as m', 'm.MemberID', '=', 'registrations.reg_member_id')
                                                    ->where('reg_time', '>=', Carbon::now()->startOfDay()->format('Y-m-d H:i:s'))
                                                    ->where('reg_time', '<=', Carbon::now()->endOfDay()->format('Y-m-d H:i:s'))
                                                    ->orderby('reg_member_id', 'DESC')
                                                    ->orderby('reg_time', 'DESC')
                                                    ->get()
                                                    ->groupBy('reg_guest_member')
                                                    ->toArray();
//                        dd($currentMemberOtherPlayReg);
                        $memberPlayRegData['todayRegistration'] = $currentMemberOtherPlayReg;
                    }
//                    dd($memberPlayRegData['todayRegistration']);

                    $clubs = club::all();
                    $memberPlayRegData['familyMembers'] = $familyMembers;
                    $memberPlayRegData['clubs'] = $clubs;
//                    $memberPlayRegData['memberHcp'] = $memberHcp;
                }
                else {
                    return redirect()->route('app');
                }
                $tickets = null;
            }
            else if($parameter === 'info') {
                $newsInfo = NewsInfo::where('status', 1)->orderBy('id', 'ASC')->get();
            }
            else if($parameter === 'ticket') {
                $transfer_ticket = Ticket::where('id', $request->ticket)
                                        ->where('product', 'Greenfee')
                                        ->whereNull('ticket_used')
                                        ->where('occid', $memberdata->MemberID)
                                        ->first();
                if(!$transfer_ticket) {
                    $transfer_ticket = Ticket::where('id', $request->ticket)
                                            ->where('product', 'Greenfee')
                                            ->whereNull('ticket_used')
                                            ->where('transfered_from', $memberdata->MemberID)
                                            ->first();
                }
                if(!$transfer_ticket)
                    return redirect()->route('app', ['name' => 'greenfee'])->with('error', 'No Ticket Found');
                // dd($transfer_ticket);
            }
            else $tickets = null;

//            dd($memberdata, $parameter);
			return view('app', compact('validate', 'memberdata', 'parameter', 'tickets', 'memberPlayRegData', 'newsInfo', 'transfer_ticket'));
		}
    }

    public function validate_otp(Request $request, $type = '')
    {
        // return $request;
        $parameter = $request->get('name');

        if (!empty($request->mobile)) {
            $member = Members::wherePhoneMobile($request->mobile)->first();
            if (!empty($member)) {

                $member_name = $member->Member_Fistname;
                $member_email = $member->email;
                $send = false;

//                Cookie::queue(Cookie::forget($request->mobile));
//                Cookie::forget($request->mobile);
//				dd(Cookie::get($request->mobile), Cookie::has($request->mobile), $type);
//                $response = new Response();
                if (Cookie::get($request->mobile) !== null && isset($request->type) && $request->type === 'new-otp') $type = 'new-otp';
                if (Cookie::get($request->mobile) === null || $type === 'new-otp') {
                    $otp = mt_rand(1000, 9999);
//                    Cache::put('current_otp', $otp, 60 * 60 * 24);
//                    Cache::put('mobile', $request->mobile, 60 * 60 * 24);
                    $cookie_mobile = Cookie::queue('mobile', $request->mobile, 60 * 60 * 24);
//                    Cache::put('current_otp_created_time', Carbon::now()->format('Y-m-d H:i:s'), 60 * 60 * 24);
//                    Cache::put($request->mobile, ['otp' => $otp, 'mobile' => $request->mobile, 'current_otp_created_time' => Carbon::now()->format('Y-m-d H:i:s')], 60 * 60 * 24);
                    $cookie_otp_details = Cookie::queue($request->mobile, json_encode(['otp' => $otp, 'mobile' => $request->mobile, 'current_otp_created_time' => Carbon::now()->format('Y-m-d H:i:s')]), 60 * 60 * 24);
//                    dd(Cookie::get($request->mobile));
//                    $otp_send = Cache::get('current_otp');

//                    $response->withCookie('mobile', $cookie_mobile, 60 * 60 * 24);
//                    $response->withCookie($request->mobile, $cookie_otp_details, 60 * 60 * 24);
                    $send = true;
                } else {
                    $cookie_otp_details = json_decode(Cookie::get($request->mobile), true);
                    $otp = $cookie_otp_details['otp'];
                    if ($type === 're-send') $send = true;
                    else if ($type === 'send-mail') $send = true;
                    else $send = false;
                }
                $cookieUser = json_decode(Cookie::get($request->mobile), true);
				$otp_send = $otp;

//                Cookie::queue('LAST_ACTIVITY', time());
                // dd($type, $send, $otp_send);
                if ($send) {
                    if($type === 'send-mail') {
                        // dd(['member_name' => $member_name, 'member_email' => $member_email, 'otp' => $otp], $member_email);
                        Mail::send('email.otp', ['member_name' => $member_name, 'member_email' => $member_email, 'otp' => $otp], function ($message) use ($member_email) {
                            $message->subject('OCC-GOLF APP');
                            $message->to($member_email);
                            $message->from($address = 'noreply@digifront.biz', $name = 'Digifront');
                        });
                    }
                    else {
                        // $url = 'https://fsonline.no/smsgateway.php?key=9kakk-anda4811-oiaei&avs=OCC Medlem&dest='.$request->mobile.'&msg='.$otp.' er ditt engangspassord.';
                        // $client = new \GuzzleHttp\Client();
                        // $response = $client->request('GET', $url);
                    }
                     //$url = 'http://dbpartner:y8er5HuLi@gw.mobilemediaservices.no/sms/gateway?destination_msisdn=47'.$request->mobile.'&price=0&originating_msisdn=Medlem OCC&message=Ditt engangspassord er : '.$otp;
                    //  $url = 'https://fsonline.no/smsgateway.php?key=9kakk-anda4811-oiaei&dest='.$request->mobile.'&msg=Dette er en test&avs=OCC Medlem'.$otp;
                     //'http://dbpartner:y8er5HuLi@gw.mobilemediaservices.no/sms/gateway?destination_msisdn=47'.$request->mobile.'&price=0&originating_msisdn=Medlem OCC&message=Ditt engangspassord er : '.$otp;
                }


                // if($response->getStatusCode() == 200)
                // {

                $validate = 'success';
                // }
                // else
                // {
                // 	return view('app',compact('parameter'));
                // }
                // $validate_otp = "";
                $validate_otp = "";
                $mobile = $request->mobile;

                $send_type = ($type == 'send-mail') ? 'mail' : 'sms';
                $tracking = AppTracking::where('date', date('Y-m-d'))->whereMemberId($member->OccID)->where('send_type', $send_type)->first();

                // dd($type, $send_type);
                if (!empty($tracking) && $tracking->send_type == $send_type) {
                    $tracking->count = $tracking->count + 1;
                    $tracking->code = $tracking->code . ', ' . $otp_send;

                    $tracking->save();
                }
                else {
                    $tracking = new AppTracking();
                    $tracking->member_id = $member->OccID;
                    $tracking->email = $member->email;
                    $tracking->phone = $member->phone_mobile;
                    $tracking->date = date('Y-m-d');
                    $tracking->count = 1;
                    $tracking->code = $otp_send;
                    $tracking->send_type = $send_type;

                    $tracking->save();
                }

//                dd($otp_send);
                return view('app', compact('validate', 'validate_otp', 'otp_send', 'mobile', 'parameter'));
            }
            else {
                $validate = 'check mobile';
                return redirect()->route('app', ['name' => 'front'])->with(['validate' => $validate]);
            }
        }
        else if (!empty($request->otp)) {
//            if (Session::get('LAST_ACTIVITY') && (time() - Session::get('LAST_ACTIVITY') > 60)) {
//
//                Session::forget('otp_send');
//            }
//            else {
//
//                Session::get('otp_send');
//            }
            $cookieUser = Cookie::get($request->typed_mobile);
            if($cookieUser !== null) $cookieUser = json_decode($cookieUser, true);
//            dd($cookieUser !== null , !empty($cookieUser['otp']) , $cookieUser['otp'] == $request->otp);
//            dd(!empty($otp_get) ,$otp_get == $request->otp, $request->otp, $otp_get, $request->typed_mobile);
//            dd($cookieUser, Cookie::get('validated'), Cookie::get('validated_otp'), Cookie::get('validated_member'));
            if ($cookieUser !== null && !empty($cookieUser['otp']) && $cookieUser['otp'] == $request->otp) {
                $memberdata = Members::wherePhoneMobile($request->typed_mobile)->first();
                $request->session()->put('member', $memberdata);

                $cookie_otp_send_success = Cookie::queue('otp_send_success', $cookieUser['otp'], 60 * 60 * 24 * 30);
                $cookie_member_id = Cookie::queue('member_id', $memberdata->MemberID, 60 * 60 * 24 * 30);
                $otp_send = Cookie::get('otp_send_success');
                $createLog = UserLog::create(['log_member_id' => $memberdata->MemberID]);

                $validate = 'success_otp';
                $page = 'otp_success_page';
                $response = new Response();

                if(Cookie::get('validated') === null) {
                    $cookie_validated = Cookie::queue('validated', 'true', 60 * 60 * 24 * 30);
                    $cookie_validated_otp = Cookie::queue(Cookie::make('validated_otp', $cookieUser['otp'], 60 * 60 * 24 * 30));
                    $cookie_validated_member = Cookie::queue(Cookie::make('validated_member', json_encode($memberdata->toArray()), 60 * 60 * 24 * 30));

                    $response->withCookie('validated', $cookie_validated, 60  * 60 * 24 * 30);
                    $response->withCookie('validated_otp', $cookie_validated_otp, 60  * 60 * 24 * 30);
                    $response->withCookie('validated_member', $cookie_validated_member, 60  * 60 * 24 * 30);
                }
                
//                $response = new Response();
//                $response->withCookie($cookie_validated, $cookie_validated_otp, $cookie_validated_member);
                return redirect('/app?name=front')->with( ['validate' => $validate, 'otp_send' => $otp_send, 'memberdata' => $memberdata, 'parameter' => $parameter, 'page' => $page, 'response' => $response]);
            }
            else {
                // $validate_otp = 'error';
                // $otp = "error";
                $member = '';
                $validate = 'otp not matched';
                return view('app', compact('validate', 'parameter'));
            }
        }
        else {
            return view('app', compact('parameter'));
        }
    }

    public function tracking()
    {
        $tracking_otps = AppTracking::leftJoin('members as m', 'm.OccID', 'member_id')
                                    ->orderBy('date', 'desc')
                                    ->get();

        $tracking_tickets = TicketSmsLog::leftJoin('members as m', function($join) {
                                    $join->on('m.MemberID', '=', 'send_by');
                                    $join->where('send_by_type', 'member');
                                })
                                ->leftJoin('users as u', function($join) {
                                    $join->on('u.id', '=', 'send_by');
                                    $join->where('send_by_type', 'admin');
                                })
                                ->orderBy('date_time', 'desc')->get();
                                
        return view('tracking', compact('tracking_otps', 'tracking_tickets'));
    }

    public function searchMembers(Request $request)
    {

        $sString = trim($request->member);
        if (!empty($sString)) :

            if (is_numeric($sString)) :
                $findMember = Members::whereIn('Active', [1])
                    ->where('OccID', 'LIKE', "$request->member%")
                    ->where('OccID', '<=', 99999)
                    ->whereNotIn('member_type', ['Passiv', 'Slettet'])
                    ->limit(5)
                    ->get();
            else :
                $findMember = Members::whereIn('Active', [1])
                    ->where('OccID', '<=', 99999)
                    ->whereNotIn('member_type', ['Passiv', 'Slettet'])
                    ->where(function ($q) use ($request) {
                        $q->where('Member_Fistname', 'LIKE', "$request->member%")
                            ->orWhere('Member_Lastname', 'LIKE', "$request->member%");
                    })
                    ->limit(5)
                    ->get();
                // ->where([
                // 	['Member_Fistname', 'LIKE', "$request->member%"],
                // 	['OccID', '<=', 99999]
                // ])
                // ->where('Member_Fistname', 'LIKE', "$request->member%")
                // ->where('OccID', '<=', 99999)
                // ->orWhere('Member_Lastname', 'LIKE', "$request->member%")

            endif;

            if ($findMember->isNotEmpty()) :
                return view('res.homeSearchMembers')
                    ->with('members', $findMember);
            else :
                echo '<div class="row"><div class="col-8 mx-auto"><span class="gc-help">Not found</span></div></div>';
            endif;
        endif;
    }

    public function getToList(Request $request)
    {
        $toList = Members::where('MemberID', $request->id)->limit(1)->get()->first();
        return view('res.toList')
            ->with('member', $toList);
    }

    public function registrationView(Request $request) {
        $request->session()->put('kiosk_mode', true);
        $clubs = club::select('ClubName as value', 'ClubName as text')
                        ->orderBy('ClubID', 'ASC')
                        ->orderBy('ClubName', 'ASC')
                        ->get();


        $guests_day = Reg::leftJoin('tickets as t', 't.guest_id', '=', 'registrations.reg_auto')
                            ->leftJoin('clubs as c', 'c.ClubID', '=', 'registrations.reg_club')
                            ->leftJoin('members as m', 'm.MemberID', 'registrations.reg_member_id')
                            ->where('status', 1)
                            ->where('reg_registration_type', 'Guest Play')
                            ->whereBetween('registrations.reg_time', [Carbon::now()->startOfDay()->format('Y-m-d H:i:s'), Carbon::now()->endOfDay()->format('Y-m-d H:i:s')])
                            ->orderBy('registrations.reg_time', 'DESC')
                            ->take(30)
                            ->get();

        $guests_week = Reg::leftJoin('tickets as t', 't.guest_id', '=', 'registrations.reg_auto')
                            ->leftJoin('clubs as c', 'c.ClubID', '=', 'registrations.reg_club')
                            ->leftJoin('members as m', 'm.MemberID', 'registrations.reg_member_id')
                            ->whereBetween('registrations.reg_time', [Carbon::now()->subDays(7)->startOfDay()->format('Y-m-d H:i:s'), Carbon::now()->endOfDay()->format('Y-m-d H:i:s')])
                            ->where('status', 1)
                            ->where('reg_registration_type', 'Guest Play')
                            ->orderBy('registrations.reg_time', 'DESC')
                            ->take(30)
                            ->get();

        $guests_month = Reg::leftJoin('tickets as t', 't.guest_id', '=', 'registrations.reg_auto')
                            ->leftJoin('clubs as c', 'c.ClubID', '=', 'registrations.reg_club')
                            ->leftJoin('members as m', 'm.MemberID', 'registrations.reg_member_id')
                            ->whereBetween('registrations.reg_time', [Carbon::now()->subDays(30)->startOfDay()->format('Y-m-d H:i:s'), Carbon::now()->endOfDay()->format('Y-m-d H:i:s')])
                            ->where('status', 1)
                            ->where('reg_registration_type', 'Guest Play')
                            ->orderBy('registrations.reg_time', 'DESC')
                            ->take(30)
                            ->get();

        $guests_pending = Reg::leftJoin('tickets as t', 't.guest_id', '=', 'registrations.reg_auto')
                            ->leftJoin('clubs as c', 'c.ClubID', '=', 'registrations.reg_club')
                            ->leftJoin('members as m', 'm.MemberID', 'registrations.reg_member_id')
                            ->whereBetween('registrations.reg_time', [Carbon::now()->startOfYear()->format('Y-m-d H:i:s'), Carbon::now()->endOfYear()->format('Y-m-d H:i:s')])
                            ->where('status', 0)
                            ->where('reg_registration_type', 'Guest Play')
                            ->orderBy('registrations.reg_time', 'DESC')
                            ->get();
                            
        return view('home', compact('clubs', 'guests_day', 'guests_week', 'guests_month', 'guests_pending'));
    }

    public function registrationSave(Request $request) {
        $guestPlayCtrl = new GuestPlayController();
        $return = $guestPlayCtrl->registerGuestInternal($request);
        if($return['type'] == 'validator') :
            return redirect()->back()->withErrors($return['validator'])->withInput();
        elseif($return['type'] == 'message'):
            return redirect()->back()->with('message', $return['message']);
        elseif($return['type'] == 'error'):
            return redirect()->back()->with('error', $return['message'])->withInput();
        endif;
    }

    /**
     * It will add form to add new guest when you click add guest button
     *
     * @param Request $request
     *
     * @return object
     */
    public function gustRegFormInReg(Request $request)
    {
        $toList = Members::where('MemberID', $request->id)->limit(1)->get()->first();
        $club = club::all();
        return view('res.gustRegFormInReg')
            ->with('member', $toList)
            ->with('unique', uniqid())
            ->with('club', $club);
    }

    /**
     * It will add form to add new guest when you click add guest button
     *
     * @param Request $request
     *
     * @return object
     */
    public function appGustRegFormInReg(Request $request)
    {
        $member = Members::where('MemberID', $request->id)->limit(1)->get()->first();
        $family = Members::where('MemberID', $request->family)->limit(1)->get()->first();
        $club = club::all();
        return view('res.appGuestRegFormInReg')
            ->with('member', $member)
            ->with('family', $family)
            ->with('unique', uniqid())
            ->with('club', $club);
    }

    public function appSaveTheNewGuest(Request $request)
    {
        return view('res.appUpdateGuestPlayer')
            ->with('unique', uniqid())
            ->with('req', (object)$request->all());
    }

    public function regNewMember(Request $request)
    {
        echo 'aweawe';
    }

    public function saveTheNewGuest(Request $request)
    {
        if(!empty($request->fistName) && !empty($request->lastName) && !empty($request->phone) && !empty($request->club) && !empty($request->hcp)) :
            return view('res.updateGuestPlayer')
                ->with('unique', uniqid())
                ->with('req', (object)$request->all());
        else :
            return response()->json(['error' => true, 'message' => 'Alle inndatafelt er obligatoriske.']);
        endif;
    }

    public function registerRegList(Request $request)
    {
        $json['error'] = true;

        if (is_object(json_decode($request->MemberID))) :
            $json['gust'] = $request->all();
            $data = json_decode($request->MemberID);

            if(!empty($data->fistName) && !empty($data->lastName) && !empty($data->phone) && !empty($data->club) && !empty($data->hcp)) :
                $reg = new Reg;
                $reg->reg_guest_member = $data->member;
                $reg->reg_phone = $data->phone;
                $reg->reg_fistname = $data->fistName;
                $reg->reg_lastname = $data->lastName;
                $reg->reg_club = $data->club;
                $reg->reg_hcp = $data->hcp;
                $reg->reg_guest_member = $request->reg;
                $reg->save();

                $json['reg'] = $request->reg;
                $json['error'] = false;
                $json['message'] = "Lagre vellykket.";
            else :
                $json['error'] = true;
                $json['message'] = "Alle inndatafelt er obligatoriske.";
            endif;
        else :
            $reg = new Reg;
            $member = Members::where('MemberID', $request->MemberID)->first();
            $reg->reg_member_id = $request->MemberID;

            $reg->reg_phone = $member->phone_mobile ?? '';
            $reg->reg_fistname = $member->Member_Fistname?? '';
            $reg->reg_lastname = $member->Member_Lastname?? '';

            $reg->reg_hcp = $request->hcp;
            $reg->save();

            $json['reg'] = $reg->reg_auto;
            $json['error'] = false;
            $json['message'] = "Lagre vellykket.";
        endif;

        // $updatemember = Members::where('MemberID', '=', $request->MemberID)
        // 	// (strlen($request->hcp) <= 3) ? $request->hcp . ',0' : str_replace(".", ",", $request->hcp);
        // 	// ->update(['HCP' => str_replace(',', '.', $request->hcp)]);
        // 	->update(['HCP' => $request->hcp,'new_hcp'=> $request->hcp]);

        return response()->json($json);
    }

    public function appRegisterRegList(Request $request)
    {
        $json['error'] = true;
        $json['reload'] = false;
        $json['type'] = ($request->type === 'guest') ? 'guest' : 'member';
        $json['round'] = '';
        $prev = null;
        $json['gust'] = $request->all();

        if($json['type'] === 'guest' && (empty($request->phone) || empty($request->fistName) || empty($request->lastName) ||  empty($request->club) ||  empty($request->hcp))) :
            $json['error'] = true;
            $json['message'] = "Alle inndatafelt er obligatoriske.";
            return response()->json($json);
        endif;
//        return response()->json([$json, $request->round]);
        if(!isset($request->round) || (isset($request->type) && !isset($request->round) && $request->type === 'guest')) {
            $occId = $request->member;
            if($request->type === 'guest') $occId = $request->family;
            $member = Members::where('MemberID', $occId)->first();

            $input['reg_member_id'] = $member->MemberID;
            $input['reg_fistname'] = $member->Member_Fistname ?? '';
            $input['reg_lastname'] = $member->Member_Lastname ?? '';
            $input['reg_phone'] = $member->phone_mobile ?? '';
            $reg = Reg::create($input);
            $reg = Reg::where('reg_auto', $reg->reg_auto)->first();

            $json['error'] = false;
            $json['message'] = "Lagre vellykket.";
            $json['regFamily'] = $reg;
            $json['round'] = $reg->reg_auto;
        }
        else {
            $reg = Reg::where('reg_auto', $request->round)->first();
            $json['regFamily'] = $reg;
            $json['round'] = $reg->reg_auto;
        }

        if((isset($json['regFamily']) && isset($request->round)) || (isset($json['regFamily']) && $request->type === 'guest')) {
            $regMember = $json['regFamily'];
            if(isset($request->member)) :
                $member = Members::where('MemberID', $request->member)->first();
                $input['reg_member_id'] = $request->member;
                $input['reg_phone'] = $member->phone_mobile;
                $input['reg_fistname'] = $member->Member_Fistname;
                $input['reg_lastname'] = $member->Member_Lastname;
                $input['reg_guest_member'] = $regMember->reg_auto;
                $reg = Reg::create($input);
                $reg = Reg::where('reg_auto', $reg->reg_auto)->first();

                $json['reg'] = $reg;
                $json['message'] = "Lagre vellykket.";
                $json['error'] = false;
            else :
                $input['reg_member_id'] = $request->member;
                $input['reg_phone'] = $request->phone;
                $input['reg_fistname'] = $request->fistName;
                $input['reg_lastname'] = $request->lastName;
                $input['reg_club'] = $request->club;
                $input['reg_hcp'] = $request->hcp;
                $input['reg_guest_member'] = $regMember->reg_auto;
                $reg = Reg::create($input);
                $reg = Reg::where('reg_auto', $reg->reg_auto)->first();

                $json['reg'] = $reg;
                $json['error'] = false;
                $json['message'] = "Lagre vellykket.";
            endif;
        }
//        else {
//            $json['error'] = true;
//        }

        /*$json['error'] = true;
        $prev = null;
        $json['gust'] = $request->all();
        $data = json_decode($request->MemberID, true);

//            return response()->json([$data, !empty($data)]);
        if(!empty($data)) {
            $regMember = Reg::where('reg_member_id', $data['family'])
                            ->where('reg_time', '>=', Carbon::now()->startOfDay()->format('Y-m-d H:i:s'))
                            ->where('reg_time', '<=', Carbon::now()->endOfDay()->format('Y-m-d H:i:s'))
                            ->first();
//            return response()->json([$data]);

            if(!isset($regMember)) {
                $reg = new Reg;
                $reg->reg_member_id = $data['family'];
                $reg->save();
                $regMember = $reg;

                $json['reg'] = $reg->reg_auto;
                $json['error'] = false;
            }
            if(isset($regMember)) {
                if(!isset($data['reg_member_id'])) :
                    $reg = new Reg;
                    $reg->reg_member_id = $data['member'];
                    $reg->reg_phone = $data['phone'];
                    $reg->reg_fistname = $data['fistName'];
                    $reg->reg_lastname = $data['lastName'];
                    $reg->reg_club = $data['club'];
                    $reg->reg_hcp = $data['hcp'];
                    $reg->reg_guest_member = $regMember->reg_auto;
                    $reg->save();

                    $json['reg'] = $reg->reg_auto;
                    $json['error'] = false;
                else:
                    Reg::where('reg_auto', $regMember->reg_auto)
                        ->update([
                            'reg_phone' => $data['phone'],
                            'reg_fistname' => $data['fistName'],
                            'reg_lastname' => $data['lastName'],
                            'reg_club' => $data['club'],
                            'reg_hcp' => $data['hcp'],
                        ]);

                    $json['reg'] = $regMember->reg_auto;
                    $json['error'] = false;
                endif;
            }
        }
        else {
            $json['error'] = false;
        }*/

        return response()->json($json);
    }

    /*public function appRegisterRegList(Request $request)
    {
        $json['error'] = true;
        $json['reload'] = false;
        $json['type'] = 'member';
        $json['round'] = '';
        $prev = null;
        $json['gust'] = $request->all();
//        $data = json_decode($request->data, true);
//        return response()->json([$json, $request->round]);

        if(!isset($request->round)) {
            $member = Members::where('MemberID', $request->family)->first();

            $input['reg_member_id'] = $member->MemberID;
            $input['reg_fistname'] = $member->Member_Fistname ?? '';
            $input['reg_lastname'] = $member->Member_Lastname ?? '';
            $input['reg_phone'] = $member->phone_mobile ?? '';
            $reg = Reg::create($input);
            $reg = Reg::where('reg_auto', $reg->reg_auto)->first();

            $json['error'] = false;
            $json['regFamily'] = $reg;
            $json['round'] = $reg->reg_auto;
        }
        else {
            $reg = Reg::where('reg_auto', $request->round)->first();
            $json['regFamily'] = $reg;
            $json['round'] = $reg->reg_auto;
        }
//        return response()->json([$json, $request->round]);
        if(isset($json['regFamily']) && $request->family !== $request->member) {
            $regMember = $json['regFamily'];
//            return response()->json([isset($request->member) , isset($request->family) , $request->family != $request->member , $request->type === 'family', isset($request->member) && isset($request->family) && $request->family != $request->member && $request->type === 'family']);

            if(isset($request->member) && isset($request->family) && $request->family !== $request->member && $request->type === 'family') :
                $member = Members::where('MemberID', $request->member)->first();
                $input['reg_member_id'] = $request->member;
                $input['reg_phone'] = $member->phone_mobile;
                $input['reg_fistname'] = $member->Member_Fistname;
                $input['reg_lastname'] = $member->Member_Lastname;
                $input['reg_guest_member'] = $regMember->reg_auto;
                $reg = Reg::create($input);
                $reg = Reg::where('reg_auto', $reg->reg_auto)->first();

                $json['reg'] = $reg;
                $json['error'] = false;
            else :
                $input['reg_member_id'] = $request->member;
                $input['reg_phone'] = $request->phone;
                $input['reg_fistname'] = $request->fistName;
                $input['reg_lastname'] = $request->lastName;
                $input['reg_club'] = $request->club;
                $input['reg_hcp'] = $request->hcp;
                $input['reg_guest_member'] = $regMember->reg_auto;
                $reg = Reg::create($input);
                $reg = Reg::where('reg_auto', $reg->reg_auto)->first();

                $json['reg'] = $reg;
                $json['error'] = false;
            endif;
        }
//        else {
//            $json['error'] = true;
//        }
        return response()->json($json);
    }*/

    /*public function appRegisterRegList(Request $request)
    {
        $json['error'] = true;
        $json['reload'] = false;
        $json['type'] = 'member';
        $prev = null;
        $json['gust'] = $request->all();
        $data = json_decode($request->data, true);

        if(isset($request->family)) {
            $regMember = Reg::where('reg_member_id', $request->family)
                            ->where('reg_time', '>=', Carbon::now()->startOfDay()->format('Y-m-d H:i:s'))
                            ->where('reg_time', '<=', Carbon::now()->endOfDay()->format('Y-m-d H:i:s'))
                            ->first();

            if(!isset($regMember)) {
                $member = Members::where('MemberID', $request->family)->first();
                $reg = new Reg;
                $reg->reg_member_id = $member->MemberID;
                $reg->reg_fistname = $member->Member_Fistname ?? '';
                $reg->reg_lastname = $member->Member_Lastname ?? '';
                $reg->reg_phone = $member->phone_mobile ?? '';
                $reg->save();
                $regMember = $reg;

                $json['reg'] = $reg;
                $json['reload'] = true;
                $json['error'] = false;
            }
            if(isset($regMember)) {
                if(isset($request->member)) :
                    if($request->family != $request->member) :
                        $member = Members::where('MemberID', $request->member)->first();
                        $reg = new Reg;
                        $reg->reg_member_id = $request->member;
                        $reg->reg_phone = $member->phone_mobile;
                        $reg->reg_fistname = $member->Member_Fistname;
                        $reg->reg_lastname = $member->Member_Lastname;
                        $reg->reg_guest_member = $regMember->reg_auto;
                        $reg->save();

                        $json['reg'] = $reg;
                        $json['error'] = false;
                    endif;
                else :
                    $reg = Reg::create([
                        'reg_phone' => $request->phone ?? null,
                        'reg_fistname' => $request->fistName ?? null,
                        'reg_lastname' => $request->lastName ?? null,
                        'reg_club' => $request->club ?? null,
                        'reg_hcp' => $request->hcp ?? null,
                        'reg_guest_member' => $regMember->reg_auto,
                    ]);
                    $reg = Reg::where('reg_auto', $reg->reg_auto)->first();
//                    $reg->reg_phone = $request->phone ?? null;
//                    $reg->reg_fistname = $request->fistName ?? null;
//                    $reg->reg_lastname = $request->lastName ?? null;
//                    $reg->reg_club = $request->club ?? null;
//                    $reg->reg_hcp = $request->hcp ?? null;
//                    $reg->reg_guest_member = $regMember->reg_auto;
//                    $reg->save();

                    $json['reg'] = $reg;
                    $json['error'] = false;
                    $json['type'] = 'guest';
                endif;
            }
        }
        else {
            $json['error'] = true;
        }
        return response()->json($json);
    }*/

    public function createNewMember(Request $request)
    {
    }

    public function createClub(Request $request)
    {
    }

    /*Registered Planned Round*/
    public function registerRound(Request $request)
    {
        if ($request->session()->has('member_id')) {
            $member = Members::where('MemberID', $request->session()->get('member_id'))->first();
            $memberHcp = HcpRegitar::where('OccId', $member->OccID)->whereDate('date', Carbon::now()->format('Y-m-d'))->count();

            $occGroup = substr($member->OccID, -3);
            $occStarting = str_replace($occGroup, '', $member->OccID);
            $occStarting = (int)($occStarting / 10) * 10;
            $family = [];
            for ($i = $occStarting; $i < $occStarting+10; $i++) $family[] = (int) $i.''.$occGroup;
            $familyMembers = Members::whereIn('OccID', $family)->where('Active', 1)->where('OccID', '!=', $member->OccID)->get();

            $clubs = club::all();
//            dd($member);
            return view('appViews.play.memberPlay', compact('member', 'familyMembers', 'clubs', 'memberHcp'));
        } else {
            return redirect()->route('app');
        }
    }

    /* Upload Member Profile Image */
    public function uploadMemberImage(Request $request) {
        if(Cookie::has('validated_member')) {
            $member = Cookie::get('validated_member');
            $member = json_decode($member, true);
            $member = Members::where('OccID', $member['OccID'])->first()->toArray();

            if(!isset($_POST["image"]))
                return false;
            else {
                $data = $_POST["image"];
                $image_array_1 = explode(";", $data);
                $image_array_2 = explode(",", $image_array_1[1]);
                $data = base64_decode($image_array_2[1]);

                $png_url = "member-".$member['OccID'].'-'.time().".png";
//                $folder_path = storage_path().'app/public/images/members/';
//                $path = $folder_path.$png_url;

//                file_put_contents($path, $data);
                Storage::disk('public')->put('/images/members/'.$png_url, $data);
                Members::where('OccID', $member['OccID'])->update(['image' => $png_url]);
                $mem = Members::where('OccID', $member['OccID'])->first();

                $exists = Storage::disk('public')->exists('/images/members/'.$member['image']);
                if ($exists) {
                    Storage::disk('public')->delete('/images/members/'.$member['image']);
                }

                $response = new Response();
                $cookie_validated_member = Cookie::queue(Cookie::make('validated_member', json_encode($mem->toArray()), 60 * 60 * 24 * 30));
                $response->withCookie('validated_member', $cookie_validated_member, 60  * 60 * 24 * 30);

                return response()->json(['response' => $png_url]);
            }
        }
        else {
            return false;
        }
    }

    public function getMemberImage($img, Request $request) {
        $exists = Storage::disk('public')->exists('/images/members/'.$img);
        if ($exists) {
            $file = Storage::disk('public')->get('/images/members/'.$img);
            return $file;
        }
        else return 'false';
    }
}
