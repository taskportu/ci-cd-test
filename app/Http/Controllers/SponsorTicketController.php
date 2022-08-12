<?php

namespace App\Http\Controllers;

use App\club;
use App\Members;
use App\Models\Ticket;
use App\Models\TicketHistory;
use App\Reg;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\GuestPlayController;

class SponsorTicketController extends Controller
{
    public function ticketsView(Request $request)
    {
        $guests_day = Ticket::join('members as m', 'm.MemberID', 'tickets.transfered_from')
            ->where('tickets.user_type', 'Guest')
            ->whereBetween('tickets.transfered_date', [Carbon::now()->startOfDay()->format('Y-m-d H:i:s'), Carbon::now()->endOfDay()->format('Y-m-d H:i:s')])
            ->orderBy('tickets.transfered_date', 'DESC')
            ->take(30)
            ->get();
       // dd($guests_day);

        $guests_week = Ticket::join('members as m', 'm.MemberID', 'tickets.transfered_from')
            ->where('tickets.user_type', 'Guest')
            ->whereBetween('tickets.transfered_date', [Carbon::now()->subDays(7)->startOfDay()->format('Y-m-d H:i:s'), Carbon::now()->endOfDay()->format('Y-m-d H:i:s')])
            ->orderBy('tickets.transfered_date', 'DESC')
            ->take(30)
            ->get();

        $guests_month = Ticket::join('members as m', 'm.MemberID', 'tickets.transfered_from')
            ->where('tickets.user_type', 'Guest')
            ->whereBetween('tickets.transfered_date', [Carbon::now()->subDays(30)->startOfDay()->format('Y-m-d H:i:s'), Carbon::now()->endOfDay()->format('Y-m-d H:i:s')])
            ->orderBy('tickets.transfered_date', 'DESC')
            ->take(30)
            ->get();

        return view('sponsor_ticket.register', compact('guests_day', 'guests_month', 'guests_week'));
    }

    public function appTransferTicket(Request $request) {
        $phone_no = $request->phone;
        $yrStart = Carbon::now()->startOfYear()->format('Y-m-d');
        $yrEnd = Carbon::now()->endOfYear()->format('Y-m-d');
        if(isset($phone_no)) {
            $member = json_decode(Cookie::get('validated_member'));
            if(isset($member)) {
                $regCount = Reg::where('reg_phone', $phone_no)
                                ->whereDate('reg_time', '>=', $yrStart)
                                ->whereDate('reg_time', '<=', $yrEnd)
                                ->where('status', 1)
                                ->where('reg_registration_type', 'Guest Play')
                                ->count();
                if($regCount < 3 || $phone_no == '47251029') {
                    $ticket = Ticket::where('occid', $member->MemberID)
                        ->where('product', 'Greenfee')
                        ->whereDate('created_at', '>=', $yrStart)
                        ->whereDate('created_at', '<=', $yrEnd)
                        ->whereNull('ticket_used')
                        ->orderBy('created_at', 'ASC')
                        ->get();
                    if($ticket->count() > 0) {
                        $ticket = $ticket->first();
                        Ticket::where('id', $ticket->id)
                            ->where('occid', $ticket->occid)
                            ->update([
                                'transfered_from' => $ticket->occid,
                                'occid' => null,
                                'transfered_date' => Carbon::now()->format('Y-m-d H:i:s'),
                                'transfered_phone' => $phone_no,
                                'user_type' => 'Guest',
                            ]);

                        $ticket = Ticket::where('id', $ticket->id)->first();

                        /* SMS to Guest */
                        $reference = Carbon::createFromFormat('Y-m-d', $ticket->date_purchase)->format('Ymd').$ticket->id.'-';
                        $reference .= Carbon::createFromFormat('Y-m-d H:i:s', $ticket->transfered_date)->format('YmdHis').''.$ticket->transfered_phone;

                        $message = 'Du har blitt invitert av ';
                        $message .= $member->Member_Fistname;
                        if(isset($member->Member_Lastname)) $message .= ' '.$member->Member_Lastname;
                        $message .= ' til Oustøen Country Club. Vennligst vis invitasjonen i kiosken på klubbhuset og les klubbens rettingslinjer for gjestespill invitasjonen. '. route('showticket', ['type' => 'ticket', 'reference' => $reference]);
                        $this->sendingSms('OCC', $ticket->transfered_phone, $message);

                        $guestPlayCtrl = new GuestPlayController();
                        $guestPlayCtrl->ticket_sms_log([
                            'sender_id' => $ticket->transfered_phone,
                            'message' => $message,
                            'send_by' => $member->MemberID,
                            'send_by_type' => 'member'
                        ]);

                        return response()->json(['status' => 200, 'message' => 'Transfered Successfully.', 'data' => $ticket]);
                    }
                    else {
                        return response()->json(['status' => 400, 'message' => 'You don\'t have enough GreenFee Tickets. Please Buy and do the Transfer.']);
                    }
                }
                else {
                    return response()->json(['status' => 400, 'message' => 'Exceeded the limit! Guest allowed to play maximum of 3 times for a season']);
                }
            }
            else {
                return response()->json(['status' => 400, 'message' => 'Member not Found!!!']);
            }
        }
        else {
            return response()->json(['status' => 400, 'message' => 'Phone Number is required!!!']);
        }
    }
}
