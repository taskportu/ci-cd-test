<?php

namespace App\Http\Controllers;

use DB;
use App\Reg;
use App\club;
use App\Members;
use Carbon\Carbon;
use App\GuestPlay;
use App\TicketSmsLog;
use App\Models\Ticket;
use Illuminate\Http\Request;
use App\Models\TicketHistory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class GuestPlayController extends Controller
{
    public function findMember(Request $request) {
        return view('guest_play.find_member');
    }

    public function find_replay_edit_member(Request $request)
    {
        if (!empty($request->data)) :
            $findMember = Members::where('Member_Fistname', 'LIKE', "$request->data%")
                ->orWhere('Member_Lastname', 'LIKE', "$request->data%")
                ->orWhere('OccID', 'LIKE', "%$request->data%")
                ->limit(10)
                ->get();
            if ($findMember->isNotEmpty()) :
                return view('guest_play.find_display_member')
                    ->with('members', $findMember);
            else :
                echo '<div class="row"><div class="col-8 mx-auto"><span class="gc-help">Not found</span></div></div>';
            endif;
        endif;
    }

    public function registerGuestView(Request $request)
    {
        $clubs = club::select('ClubName as value', 'ClubName as text')
                        ->orderBy('ClubID', 'ASC')
                        ->orderBy('ClubName', 'ASC')
                        ->get();

        $guests_day = Reg::select('registrations.*', 'm.*', 'c.*', 'pm.MemberID as phone_member_id', 'pm.OccID as phone_occ_id', 'pm.Member_Fistname as phone_first_name', 'pm.Member_Lastname as phone_last_name', 'pm.member_type as phone_member_type')
                            ->leftJoin('tickets as t', 't.guest_id', '=', 'registrations.reg_auto')
                            ->leftJoin('clubs as c', 'c.ClubID', '=', 'registrations.reg_club')
                            ->leftJoin('members as m', 'm.MemberID', 'registrations.reg_member_id')
                            ->leftJoin('members as pm', function($join) {
                                $join->on('pm.phone_mobile', '=', 'registrations.reg_phone');
                                $join->where('pm.member_type', '!=', 'Slettet');
                            })
                            ->where('status', 1)
                            ->where('reg_registration_type', 'Guest Play')
                            ->whereBetween('registrations.reg_time', [Carbon::now()->startOfDay()->format('Y-m-d H:i:s'), Carbon::now()->endOfDay()->format('Y-m-d H:i:s')])
                            ->orderBy('registrations.reg_time', 'DESC')
                            ->take(30)
                            ->get();

        $guests_week = Reg::select('registrations.*', 'm.*', 'c.*', 'pm.MemberID as phone_member_id', 'pm.OccID as phone_occ_id', 'pm.Member_Fistname as phone_first_name', 'pm.Member_Lastname as phone_last_name', 'pm.member_type as phone_member_type')
                            ->leftJoin('tickets as t', 't.guest_id', '=', 'registrations.reg_auto')
                            ->leftJoin('clubs as c', 'c.ClubID', '=', 'registrations.reg_club')
                            ->leftJoin('members as m', 'm.MemberID', 'registrations.reg_member_id')
                            ->leftJoin('members as pm', function($join) {
                                $join->on('pm.phone_mobile', '=', 'registrations.reg_phone');
                                $join->where('pm.member_type', '!=', 'Slettet');
                            })
                            ->whereBetween('registrations.reg_time', [Carbon::now()->subDays(7)->startOfDay()->format('Y-m-d H:i:s'), Carbon::now()->endOfDay()->format('Y-m-d H:i:s')])
                            ->where('status', 1)
                            ->where('reg_registration_type', 'Guest Play')
                            ->orderBy('registrations.reg_time', 'DESC')
                            ->take(30)
                            ->get();

        $guests_month = Reg::select('registrations.*', 'm.*', 'c.*', 'pm.MemberID as phone_member_id', 'pm.OccID as phone_occ_id', 'pm.Member_Fistname as phone_first_name', 'pm.Member_Lastname as phone_last_name', 'pm.member_type as phone_member_type')
                            ->leftJoin('tickets as t', 't.guest_id', '=', 'registrations.reg_auto')
                            ->leftJoin('clubs as c', 'c.ClubID', '=', 'registrations.reg_club')
                            ->leftJoin('members as m', 'm.MemberID', 'registrations.reg_member_id')
                            ->leftJoin('members as pm', function($join) {
                                $join->on('pm.phone_mobile', '=', 'registrations.reg_phone');
                                $join->where('pm.member_type', '!=', 'Slettet');
                            })
                            ->whereBetween('registrations.reg_time', [Carbon::now()->subDays(30)->startOfDay()->format('Y-m-d H:i:s'), Carbon::now()->endOfDay()->format('Y-m-d H:i:s')])
                            ->where('status', 1)
                            ->where('reg_registration_type', 'Guest Play')
                            ->orderBy('registrations.reg_time', 'DESC')
                            ->take(30)
                            ->get();

        $guests_pending = Reg::select('registrations.*', 'm.*', 'c.*', 'pm.MemberID as phone_member_id', 'pm.OccID as phone_occ_id', 'pm.Member_Fistname as phone_first_name', 'pm.Member_Lastname as phone_last_name', 'pm.member_type as phone_member_type')
                            ->leftJoin('tickets as t', 't.guest_id', '=', 'registrations.reg_auto')
                            ->leftJoin('clubs as c', 'c.ClubID', '=', 'registrations.reg_club')
                            ->leftJoin('members as m', 'm.MemberID', 'registrations.reg_member_id')
                            ->leftJoin('members as pm', function($join) {
                                $join->on('pm.phone_mobile', '=', 'registrations.reg_phone');
                                $join->where('pm.member_type', '!=', 'Slettet');
                            })
                            ->whereBetween('registrations.reg_time', [Carbon::now()->startOfYear()->format('Y-m-d H:i:s'), Carbon::now()->endOfYear()->format('Y-m-d H:i:s')])
                            ->where('status', 0)
                            ->where('reg_registration_type', 'Guest Play')
                            ->orderBy('registrations.reg_time', 'DESC')
                            ->get();
        return view('guest_play.register',compact('clubs', 'guests_day', 'guests_week', 'guests_month', 'guests_pending'));
    }

    public function registerGuest(Request $request)
    {
        $startYear = Carbon::now()->startOfYear();
        $endYear = Carbon::now()->endOfYear();
        $startDay = Carbon::now()->startOfDay()->format('Y-m-d H:i:s');
        $endDay = Carbon::now()->endOfDay()->format('Y-m-d H:i:s');

        $regCount = Reg::where('reg_phone', $request->mobile)
                                ->whereDate('reg_time', '>=', $startYear)
                                ->whereDate('reg_time', '<=', $endYear)
                                ->where('status', 1)
                                ->where('reg_registration_type', 'Guest Play')
                                ->count();
        if($regCount < 3 || $request->mobile == '47251029') :
            $regCountToday = Reg::where('reg_phone', $request->mobile)
                                ->whereDate('reg_time', '>=', $startDay)
                                ->whereDate('reg_time', '<=', $endDay)
                                ->where('status', 1)
                                ->where('reg_registration_type', 'Guest Play')
                                ->count();
            if($regCountToday < 2 || $request->mobile == '47251029') :
                $return = $this->registerGuestInternal($request);
            else :
                return redirect()->back()->with('error', 'Exceeded the daily limit! Guest allowed to play maximum of 2 times per Day.')->withInput();
            endif;
        else :
            return redirect()->back()->with('error', 'Exceeded the limit! Guest allowed to play maximum of 3 times for a season.')->withInput();
        endif;

        if($return['type'] == 'validator') :
            return redirect()->back()->withErrors($return['validator'])->withInput();
        elseif($return['type'] == 'message'):
            return redirect()->back()->with('message', $return['message']);
        elseif($return['type'] == 'error'):
            return redirect()->back()->with('error', $return['message'])->withInput();
        endif;
    }

    public function registerGuestApp(Request $request)
    {
        $startYear = Carbon::now()->startOfYear();
        $endYear = Carbon::now()->endOfYear();
        $startDay = Carbon::now()->startOfDay()->format('Y-m-d H:i:s');
        $endDay = Carbon::now()->endOfDay()->format('Y-m-d H:i:s');
        $regCount = Reg::where('reg_phone', $request->mobile)
                                ->whereDate('reg_time', '>=', $startYear)
                                ->whereDate('reg_time', '<=', $endYear)
                                ->where('status', 1)
                                ->where('reg_registration_type', 'Guest Play')
                                ->count();
        if($regCount < 3 || $request->mobile == '47251029') :
            $regCountToday = Reg::where('reg_phone', $request->mobile)
                                ->whereDate('reg_time', '>=', $startDay)
                                ->whereDate('reg_time', '<=', $endDay)
                                ->where('status', 1)
                                ->where('reg_registration_type', 'Guest Play')
                                ->count();
            if($regCount < 2 || $request->mobile == '47251029') :
                $return = $this->registerGuestInternal($request);
                return response()->json($return);
            else :
                return response()->json(['status' => false, 'message' => 'Overskredet den daglige grensen! Gjester har lov til å spille maksimalt 2 ganger per dag.']);
            endif;
        else :
            return response()->json(['status' => false, 'message' => 'Overskredet grensen! Gjester har lov til å spille maksimalt 3 ganger for en sesong.']);
        endif;
    }

    public function registerGuestInternal(Request $request)
    {
        $startYear = Carbon::now()->startOfYear()->format('Y-m-d');
        $endYear = Carbon::now()->endOfYear()->format('Y-m-d');
        $startDay = Carbon::now()->startOfDay()->format('Y-m-d H:i:s');
        $endDay = Carbon::now()->endOfDay()->format('Y-m-d H:i:s');
        $reference = $request->reference;
        $request_mobile = str_replace(' ', '', $request->mobile);

        $member = Members::where('MemberID', $request->member)->first();
        if($member) :
            if(isset($request->reference)) :
                $ref_arr = explode('-', $reference);

                $purchased_date = substr($ref_arr[0], 0, 8);
                $ticket_id = str_replace($purchased_date, '', $ref_arr[0]);

                $transferred_date = substr($ref_arr[1],0, 14);
                $transferred_phone_no = str_replace($transferred_date, '', $ref_arr[1]);

                $transferred_date = Carbon::createFromFormat('YmdHis', $transferred_date)->format('Y-m-d H:i:s');
                $purchased_date = Carbon::createFromFormat('Ymd', $purchased_date)->format('Y-m-d');

                $ticket = Ticket::where('user_type', 'Guest')
                                ->where('id', $ticket_id)
                                ->where('product', 'Greenfee')
                                ->where('transfered_phone', $transferred_phone_no)
                                ->where('date_purchase', $purchased_date)
                                ->where('transfered_date', $transferred_date)
                                ->first();

                $inputs['reg_fistname'] = $request->guestFName;
                $inputs['reg_lastname'] = $request->guestLName;
                $inputs['reg_club'] = $request->club;
                $inputs['reg_hcp'] = $request->hcp;
                $inputs['reg_phone'] = $request_mobile;
                $inputs['reg_payment_type'] = $request->payment;
                $inputs['created_by'] = 'Mobile Phone';
                $validator = Validator::make($inputs, Reg::createValidations());
                if ($validator->fails()) {
                    return [
                        'status' => false,
                        'message' => 'All Input fields are required.',
                    ];
                }
                else {
                    $inputs['reg_member_id'] = $member->MemberID;
                    $inputs['reg_registration_type'] = 'Guest Play';
                    $inputs['status'] = 0;
                    $inputs['reg_time'] = Carbon::now()->format('Y-m-d H:i:s');

                    $guest = Reg::create($inputs);
                    if($guest) {
                        if(isset($ticket))
                            $ticket->update(['guest_id' => $guest->reg_auto]);

                        return [
                            'status' => true,
                            'message' => 'Din registrering er gjennimført.'
                        ];
                    }
                    else {
                        return [
                            'status' => false,
                            'message' => 'Sorry, Couldn\'t able to register.'
                        ];
                    }
                }
            else :
                $inputs['reg_fistname'] = $request->guestFName;
                $inputs['reg_lastname'] = $request->guestLName;
                $inputs['reg_club'] = $request->club;
                $inputs['reg_hcp'] = $request->hcp;
                $inputs['reg_phone'] = $request_mobile;
                $inputs['reg_payment_type'] = $request->payment;
                if(isset($request->in_type))
                    $inputs['created_by'] = 'Manual Kiosk';
                else
                    $inputs['created_by'] = 'Manual Admin';
                $validator = Validator::make($inputs, Reg::createValidations('manual'));
                if ($validator->fails()) {
                    return [
                        'status' => false,
                        'type' => 'validator',
                        'validator' => $validator,
                    ];
                }
                else {
                    $inputs['reg_member_id'] = $member->MemberID;
                    $inputs['reg_registration_type'] = 'Guest Play';
                    $inputs['status'] = 0;
                    $inputs['reg_time'] = Carbon::now()->format('Y-m-d H:i:s');

                    $guest = Reg::create($inputs);
                    if($guest) {
                        return [
                            'status' => false,
                            'type' => 'message',
                            'message' => 'Successfully created the Guest Play.'
                        ];
                    }
                    else {
                        return [
                            'status' => false,
                            'type' => 'error',
                            'message' => 'Sorry, Couldn\'t able to create the Guest.'
                        ];
                    }
                }
            endif;
        else :
            return [
                'status' => false,
                'type' => 'error',
                'message' => 'Member not Found'
            ];
        endif;
    }

    public function playNow(Request $request) {
        $guest_id = $request->guest;
        $startYear = Carbon::now()->startOfYear()->format('Y-m-d');
        $endYear = Carbon::now()->endOfYear()->format('Y-m-d');
        $startDay = Carbon::now()->startOfDay()->format('Y-m-d H:i:s');
        $endDay = Carbon::now()->endOfDay()->format('Y-m-d H:i:s');

        $reg = Reg::where('reg_auto', $guest_id)->first();
        if($reg) :
            $regCount = Reg::where('reg_phone', $reg->reg_phone)
                                ->whereDate('reg_time', '>=', $startYear)
                                ->whereDate('reg_time', '<=', $endYear)
                                ->where('status', 1)
                                ->where('reg_registration_type', 'Guest Play')
                                ->count();
            if($regCount < 3 || $reg->reg_phone == '47251029') :
                $regCountToday = Reg::where('reg_phone', $reg->reg_phone)
                                ->whereDate('reg_time', '>=', $startDay)
                                ->whereDate('reg_time', '<=', $endDay)
                                ->where('status', 1)
                                ->where('reg_registration_type', 'Guest Play')
                                ->count();
                if($regCountToday < 2 || $reg->reg_phone == '47251029') :
                    $ticket = Ticket::where('user_type', 'Guest')
                            ->where('guest_id', $reg->reg_auto)
                            ->where('product', 'Greenfee')
                            ->first();
                    if($ticket) :
                        $ticket->update([
                            'ticket_used' => 'used',
                            'date_used' => Carbon::now()->format('Y-m-d'),
                        ]);
                    endif;
                    $reg_date = Carbon::now()->format('Y-m-d H:i:s');
                    if(isset($reg->date_of_play)) $reg_date = $reg->date_of_play." 00:00:00";
                        $reg->update([
                        'reg_time' => $reg_date,
                        'status' => 1,
                    ]);
                    $member = Members::where('MemberID', $reg->reg_member_id)->first();

                    /* SMS to Guest */
                    $reference = Carbon::createFromFormat('Y-m-d H:i:s', $reg->reg_time)->format('Ymd').$reg->reg_auto.'-';
                    $reference .= Carbon::createFromFormat('Y-m-d H:i:s', $reg->reg_time)->format('YmdHis').''.$reg->reg_phone;

                    $message = "Gyldig ";
                    $message .= Carbon::createFromFormat('Y-m-d H:i:s', $reg->reg_time)->format('d-m-Y');
                    $message .= ". Dette er din gjestebillett. Vennligst vise denne melding til starter / marshal før start. Klubbens rettingslinjer for gjestespill finner du under. ";
                    $message .= route('showticket', ['type' => 'proof-of-purchase', 'reference' => $reference]);

                    if((isset($reg->date_of_play) && $reg->date_of_play > Carbon::now()->subDay()->format('Y-m-d')) || (!isset($reg->date_of_play)))
                        $this->sendingSms('OCC', $reg->reg_phone, $message);

                    $this->ticket_sms_log([
                        'sender_id' => $reg->reg_phone,
                        'message' => $message,
                        'send_by' => auth()->user()->id,
                        'send_by_type' => 'admin'
                    ]);

                    return response()->json(['status' => true, 'message' => 'Successfully updated.']);
                else :
                    return response()->json([
                        'status' => false,
                        'message' => 'Exceeded the daily limit! Guest allowed to play maximum of 2 times per Day.'
                    ]);
                endif;
            else :
                return response()->json([
                    'status' => false,
                    'message' => 'Exceeded the limit! Guest allowed to play maximum of 3 times for a season.'
                ]);
            endif;
        else :
            return response()->json(['status' => false, 'message' => 'Guest Play not Found.']);
        endif;
    }

    public function deletePreRegistration(Request $request) {
        $guest_id = $request->guest;
        $reg = Reg::where('reg_auto', $guest_id)->first();
        if($reg) :
            Reg::where('reg_auto', $reg->reg_auto)->delete();
            return response()->json(['status' => true, 'message' => 'Pre-Registration Deleted Successfully..']);
        else :
            return response()->json(['status' => false, 'message' => 'Pre-Registration not Found.']);
        endif;
    }

    public function guestPlayEditView(Request $request) {
        $reg = $request->reg;
        $registration = Reg::where('reg_auto', $reg['reg'])->first();
        if($registration) {
            $member = Members::where('MemberID', $registration->reg_member_id)->first();
            $clubs = club::select('ClubName as value', 'ClubName as text')
                        ->orderBy('ClubName')->get();

            return view('guest_play.reg_edit', compact('registration', 'member', 'clubs'));
        }
        else {
            return response()->json(['status' => false, 'message' => 'Registration not found!']);
        }
    }

    public function registerGuestUpdate(Request $request) {
        $reg = $request->reg;
        $registration = Reg::where('reg_auto', $reg)->first();
        $inputs['reg_fistname'] = $request->guestFName;
        $inputs['reg_lastname'] = $request->guestLName;
        $inputs['reg_club'] = $request->club;
        $inputs['reg_hcp'] = $request->hcp;
        if(isset($request->payment))
            $inputs['reg_payment_type'] = $request->payment;

        if($registration) {
            $validator = Validator::make($inputs , Reg::updateValidations());
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            else {
                if(isset($request->date_of_play)) :
                    $date_of_play = Carbon::createFromFormat('Y-m-d', $request->date_of_play)->format('Y-m-d');
                    if(Carbon::now()->format('Y-m-d') >= $date_of_play) :
                        $inputs['date_of_play'] = $request->date_of_play;
                    else:
                        return redirect()->back()->with('error', 'Date Should be less than or equal to Today Date.');
                    endif;
                endif;
                $registration->update($inputs);
                return redirect()->back()->with('message', 'Updated Successfully.');
            }
        }
        else {
            return redirect()->back()->with('error', 'Registration not found!');
        }
    }

    public function showTicket(Request $request, $type, $reference) {
        $ref_arr = explode('-', $reference);

        $purchased_date = substr($ref_arr[0], 0, 8);
        $ticket_id = str_replace($purchased_date, '', $ref_arr[0]);

        $transferred_date = substr($ref_arr[1],0, 14);
        $transferred_phone_no = str_replace($transferred_date, '', $ref_arr[1]);

        $transferred_date = Carbon::createFromFormat('YmdHis', $transferred_date)->format('Y-m-d H:i:s');
        $purchased_date = Carbon::createFromFormat('Ymd', $purchased_date)->format('Y-m-d');

        $yrStart = Carbon::now()->startOfYear()->format('Y-m-d');
        $yrEnd = Carbon::now()->endOfYear()->format('Y-m-d');
        if($type === 'ticket') {
            $header = "GJESTSPILL INVITASJON";
            $ticket = Ticket::where('user_type', 'Guest')
                        ->where('id', $ticket_id)
                        ->where('product', 'Greenfee')
                        ->where('transfered_phone', $transferred_phone_no)
                        ->where('date_purchase', $purchased_date)
                        ->where('transfered_date', $transferred_date)
                        ->first();
            if($ticket) {
                $guest = null;
                if(isset($ticket->guest_id)) {
                    $guest = Reg::where('reg_auto', $ticket->guest_id)->first();
                    $header = "GJESTSPILL PRE-REGISTRERING";
                }

                $used_count = Reg::where('reg_phone', $ticket->transfered_phone)
                                    ->where('reg_registration_type', 'Guest Play')
                                    ->where('status', 1)
                                    ->whereDate('reg_time', '>=', $yrStart)
                                    ->whereDate('reg_time', '<=', $yrEnd)
                                    ->count();
                $member = Members::where('MemberID', $ticket->transfered_from)->first();

                $clubs = club::select('ClubName as value', 'ClubName as text')
                            ->orderBy('ClubID', 'ASC')
                            ->orderBy('ClubName', 'ASC')
                            ->get();
                return view('guest_play.showTicket', compact('ticket', 'used_count', 'member', 'guest', 'reference', 'type', 'clubs', 'transferred_phone_no', 'header'));
            }
            else {
                $error = 'Ticket Not Found with your Reference.';
                return view('guest_play.showTicket', compact('error', 'type', 'header'));
            }
        }
        else if($type === 'proof-of-purchase') {
            $header = "GJESTPILL BILLETT";
            $registration = Reg::select('registrations.*', 'm.MemberID', 'm.OccID', 'm.Member_Fistname', 'm.Member_Lastname', 'm.member_type')
                        ->leftJoin('members as m', 'm.MemberID', '=', 'reg_member_id')
                        ->where('reg_auto', $ticket_id)
                        ->where('reg_time', $transferred_date)
                        ->where('reg_phone', $transferred_phone_no)
                        // ->where('status', 1)
                        ->first();

            if($registration) {
                $used_count = Reg::where('reg_phone', $registration->reg_phone)
                                    ->where('reg_registration_type', 'Guest Play')
                                    ->where('status', 1)
                                    ->whereDate('reg_time', '>=', $yrStart)
                                    ->whereDate('reg_time', '<=', $yrEnd)
                                    ->count();

                $member = Members::where('MemberID', $registration->reg_member_id)->first();
                return view('guest_play.showTicket', compact('registration', 'used_count', 'member', 'reference', 'type', 'transferred_phone_no', 'header'));
            }
            else {
                return view('guest_play.showTicket', compact('registration', 'reference', 'type', 'transferred_phone_no', 'header'));
            }
        }
    }

    public function ticket_change_status(Request $request, $type, $reference) {
        $ref_arr = explode('-', $reference);

        $purchased_date = substr($ref_arr[0], 0, 8);
        $ticket_id = str_replace($purchased_date, '', $ref_arr[0]);

        $transferred_date = substr($ref_arr[1],0, 14);
        $transferred_phone_no = str_replace($transferred_date, '', $ref_arr[1]);

        $transferred_date = Carbon::createFromFormat('YmdHis', $transferred_date)->format('Y-m-d H:i:s');
        $purchased_date = Carbon::createFromFormat('Ymd', $purchased_date)->format('Y-m-d');

        $ticket = Ticket::where('user_type', 'Guest')
            ->where('id', $ticket_id)
            ->where('product', 'Greenfee')
            ->where('transfered_phone', $transferred_phone_no)
            ->where('date_purchase', $purchased_date)
            ->where('transfered_date', $transferred_date)
            ->first();

        if($ticket->user_type === 'Guest' && $ticket->ticket_used != 'used') :
            $ticket->ticket_used = 'used';
            $ticket->date_used = Carbon::now()->format('Y-m-d');
            $ticket->save();

            $new_ticket = Ticket::where('id', $ticket->id)->first();

            $ticket_history = new TicketHistory;
            $ticket_history->occid = $new_ticket->occid;
            $ticket_history->date_purchase = $new_ticket->date_purchase;
            $ticket_history->product = $new_ticket->product;
            $ticket_history->ticket_count = $new_ticket->ticket_count;
            $ticket_history->ticket_used = $new_ticket->ticket_used;
            $ticket_history->date_used = $new_ticket->date_used;
            $ticket_history->active = Carbon::now()->format('Y-m-d');
            $ticket_history->ticket_type = $new_ticket->ticket_type;
            $ticket_history->user_type = $new_ticket->user_type;
            $ticket_history->guest_id = $new_ticket->guest_id;
            $ticket_history->transfered_from = $new_ticket->transfered_from;
            $ticket_history->transfered_date = $new_ticket->transfered_date;
            $ticket_history->transfered_phone = $new_ticket->transfered_phone;
            $ticket_history->save();

            return response()->json(['status' => true, 'message' => 'Ticket used successfully.']);
        else:
            return redirect()->back()->with(['error' => 'Guest Ticket Not Found.']);
        endif;
    }

    public function ticket_sms_log($data) {
        $log = TicketSmsLog::create($data);
        return $log;
    }

    public function sendTestMessage() {
        $this->sendingSms('OCC', '48150702', 'OCC SMS Test');
        // $this->sendingSms('OCC', '92062344', 'OCC SMS Test');
        return redirect()->back()->with('message', 'SMS Sent.');
    }

    public function passivTick() {
        $mem = Members::where('member_type', 'Passiv')->get();
        foreach ($mem as $m) {
            // for ($i=1; $i <= 3; $i++) {
            //     $ticket = new Ticket;
            //     $ticket->occid = $m->MemberID;
            //     $ticket->date_purchase = Carbon::now()->format('Y-m-d');
            //     $ticket->product = 'Greenfee';
            //     $ticket->ticket_count = 3;
            //     $ticket->save();
            // }
        }
    }

}
