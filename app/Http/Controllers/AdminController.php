<?php

namespace App\Http\Controllers;

use DB;
use PDF;
use File;
use Mail;
use Image;
use Config;
use Artisan;
use App\Reg;
use App\club;
use Exporter;
use Campaigns;
use App\Traits;
use App\Members;
use App\UserLog;
use App\NewsInfo;
use Carbon\Carbon;
use App\information;
use App\Models\Ticket;
use GuzzleHttp\Client;
use App\MemberChangesLog;
use App\Models\HcpRegitar;
use Illuminate\Http\Request;
use App\Models\TicketHistory;
use Ixudra\Curl\Facades\Curl;
use Illuminate\Support\Collection;
use Artisaninweb\SoapWrapper\SoapWrapper;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use charlieuki\ReceiptPrinter\ReceiptPrinter as ReceiptPrinter;

class AdminController extends Controller
{
    public function test($id)
    {
        return $id;
    }

    public function ticket_change_status(Request $request)
    {
        $ticket = Ticket::find($request->ticket_id);

        if($ticket->ticket_type !== 'season') {
            if($request->status === 'trash') $ticket->ticket_used = 'deleted';
            else if($request->status === 'done') $ticket->ticket_used = 'used';
            else if($request->status === 'inactive') $ticket->ticket_used = 'hold';
            else if($request->status === '' || $request->status === null) $ticket->ticket_used = null;
        }
        else {
            if($request->status === 'trash') $ticket->ticket_used = 'deleted';
            else {
                if($ticket->ticket_type == 'Ferry') {
                    if($request->status === 'done') $ticket->ticket_used = 'used';
                    else if($request->status === 'inactive') $ticket->ticket_used = 'hold';
                    else if($request->status === '' || $request->status === null) $ticket->ticket_used = null;
                }
            }
        }

        if($request->status === 'inactive' || $request->status === null || $request->status === '') $ticket->date_used = null;
        else $ticket->date_used = Carbon::now()->format('Y-m-d');

        $ticket->save();

        if($request->status !== '' || $request->status !== null){
            $old_ticket = Ticket::where('id',$request->ticket_id)->first();

            $ticket_history = new TicketHistory;
            $ticket_history->occid = $old_ticket->occid;
            $ticket_history->date_purchase = $old_ticket->date_purchase;
            $ticket_history->product = $old_ticket->product;
            $ticket_history->ticket_count = $old_ticket->ticket_count;
            $ticket_history->ticket_used = $old_ticket->ticket_used;
            if($ticket->ticket_used === 'hold' || $ticket->ticket_used === null) $ticket_history->date_used = null;
            else $ticket_history->date_used = $old_ticket->date_used;
            $ticket_history->ticket_type = $old_ticket->ticket_type;
            $ticket_history->active = Carbon::now()->format('Y-m-d');
            $ticket_history->save();
        }

        return response()->json([
            'status' => true,
//            'ticket' => $ticket
        ]);
    }

    public function ticket_save(Request $request)
    {
        // return $request;
        for ($i=1; $i <= $request->ticket_count; $i++) {
            $ticket = new Ticket;
            $ticket->occid = $request->occid;
            $ticket->date_purchase = date('Y-m-d');
            $ticket->product = $request->product;
            $ticket->ticket_count = $request->ticket_count;
            if($request->product != 'Pro lessons' || $request->product != 'Greenfee') {
                if($request->product == 'Buggy') {
                    $ticket->ticket_type = 'season';
                    $ticket->ticket_used = 'used';
                }
                else {
                    $ticket->ticket_type = $request->ticket_type;
                    $ticket->ticket_used = (isset($request->ticket_type)) ? 'used' : null;
                }
            }
            $ticket->save();
        }

        return response()->json([
            'success' => true
        ]);
    }

    public function search_ticket_member(Request $request)
    {
        // return $request;
        if (!empty($request->searchkey)) :

            $findMember = Members::where('Member_Fistname', 'LIKE', "$request->searchkey%")
                ->orWhere('Member_Lastname', 'LIKE', "$request->searchkey%")
                ->orWhere('OccID', 'LIKE', "%$request->searchkey%")
                ->limit(10)
                ->get();
            if ($findMember->isNotEmpty()) :
                return view('ticket_find_display_member')
                    ->with('members', $findMember);
            else :
                echo '<div class="row"><div class="col-8 mx-auto"><span class="gc-help">Not found</span></div></div>';
            endif;
        endif;
    }

    public function purchases()
    {
        $statuses = ['', 'used', 'hold', 'deleted'];
        $tickets = Ticket::selECT(DB::raw('product, ticket_type, ticket_used,  COUNT(product) as ticket_count'))
                        ->whereBetween('date_purchase', [Carbon::now()->startOfYear()->format('Y-m-d'), Carbon::now()->endOfYear()->format('Y-m-d')])
                        ->groupBy(['product', 'ticket_type', 'ticket_used'])
                        ->get()
                        ->groupBy(['product', 'ticket_type', 'ticket_used'])
                        ->toArray();
        $ticketsOfTypeCount = Ticket::selECT(DB::raw('product, COUNT(product) as product_count, ticket_type'))
                                    ->whereBetween('date_purchase', [Carbon::now()->startOfYear()->format('Y-m-d'), Carbon::now()->endOfYear()->format('Y-m-d')])
                                    ->groupBy(['product', 'ticket_type'])
                                    ->get()
                                    ->groupBy(['product', 'ticket_type'])
                                    ->toArray();
        // dd($tickets);
        $ticketsTotalCount = Ticket::selECT(DB::raw('ticket_used,  COUNT(IFNULL(ticket_used, 1)) as status_count'))
                                    ->whereBetween('date_purchase', [Carbon::now()->startOfYear()->format('Y-m-d'), Carbon::now()->endOfYear()->format('Y-m-d')])
                                    ->groupBy(['ticket_used'])
                                    ->get()
                                    ->groupBy(['ticket_used'])
                                    ->toArray();
//        dd($statuses, $tickets, $ticketsOfTypeCount, $ticketsTotalCount);

        /*$tickets = Ticket::groupBy('product')->pluck('product');
        $ticket_count = array();
        $used_count = array();
        $un_use_count = array();
        foreach ($tickets as $tic => $ticket) {
            $count = Ticket::where('product', $ticket)->orderBy('product','ASC')->get()->count();
            $used = Ticket::where('product', $ticket)->where('ticket_used','used')->orderBy('product','ASC')->get()->count();

            $un_used = Ticket::where('product', $ticket)->whereNull('ticket_used')->orderBy('product','ASC')->get()->count();
            $un_use_count [$ticket] = $un_used;
            $used_count [$ticket] = $used;
            $ticket_count[$ticket] = $count;

        }
        $used_total = array_sum($used_count);
        $un_use_total = array_sum($un_use_count);
        $ticket_total = array_sum($ticket_count);*/
        return view('purchases',compact('tickets', 'ticketsTotalCount', 'statuses', 'ticketsOfTypeCount'));
//        return view('purchases',compact('used_total','ticket_total','un_use_total','un_use_count','used_count','ticket_count','tickets'));
    }

    public function ticket()
    {
        return view('ticket');
    }

    public function add_ticket($id)
    {
        $members = Members::where('MemberID', $id)->first();
        $member_tickets = Ticket::where('occid', $members->MemberID)
                                ->where('date_purchase', '>=', Carbon::now()->startOfYear()->format('Y-m-d'))
                                ->where('date_purchase', '<=', Carbon::now()->endOfYear()->format('Y-m-d'))
                                ->orWhere('transfered_from', $members->MemberID)
                                ->where(function($where) {
                                    $where->whereNull('ticket_used');
                                    $where->orWhere('ticket_used', '!=', 'deleted');
                                })
                                ->get()
                                ->groupBy('ticket_type')
                                ->toArray();

        // $transfered_tickets = Ticket::where('transfered_from', $members->MemberID)
        //                         ->where('date_purchase', '>=', Carbon::now()->startOfYear()->format('Y-m-d'))
        //                         ->where('date_purchase', '<=', Carbon::now()->endOfYear()->format('Y-m-d'))
        //                         ->where(function($where) {
        //                             $where->whereNull('ticket_used');
        //                             $where->orWhere('ticket_used', '!=', 'deleted');
        //                         })
        //                         ->get()
        //                         ->toArray();
                                
        $member_tickets_tables = Ticket::where('occid',$members->MemberID)
                                ->where('date_purchase', '>=', Carbon::now()->startOfYear()->format('Y-m-d'))
                                ->where('date_purchase', '<=', Carbon::now()->endOfYear()->format('Y-m-d'))
                                ->orWhere('transfered_from', $members->MemberID)
                                ->orderBy(\DB::raw("COALESCE(date_used, '".Carbon::now()->startOfYear()->format('Y-m-d')."')"), 'DESC')
                                ->orderBy('product','ASC')
                                ->paginate(10);
                                // dd($member_tickets_tables->toArray());
        return view('add_ticket',compact('members','member_tickets','member_tickets_tables'));
    }

    public function campaign()
    {
        $cha = array('!', '#', '$', '%', '&', '(', ')', '*', '+', ',', '-', '.', '/', ':', ';', '<', '=', '>', '?', '[', "]", '^', '_', '`', '{', '|', '}', '~', '¡', '¢', '£', '¤', '¥', '¦', '§', '¨', '©', 'ª', '«', '¬', '®', '¯', '°', '±', '²', '³', '´', 'µ', '¶', '·', '¸', '¹', 'º', '»', '¼', '½', '¾', '¿', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', '×', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'Þ', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', '÷', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'þ', 'ÿ');

        $utf = array('%21', '%23', '%24', '%25', '%26', '%28', '%29', '%2a', '%2b', '%2c', '%2d', '%2e', '%2f', '%3a', '%3b', '%3c', '%3d', '%3e', '%3f', '%5b', '%5d', '%5e', '%5f', '%60', '%7b', '%7c', '%7d', '%7e', '%c2%a1', '%c2%a2', '%c2%a3', '%c2%a4', '%c2%a5', '%c2%a6', '%c2%a7', '%c2%a8', '%c2%a9', '%c2%aa', '%c2%ab', '%c2%ac', '%c2%ae', '%c2%af', '%c2%b0', '%c2%b1', '%c2%b2', '%c2%b3', '%c2%b4', '%c2%b5', '%c2%b6', '%c2%b7', '%c2%b8', '%c2%b9', '%c2%ba', '%c2%bb', '%c2%bc', '%c2%bd', '%c2%be', '%c2%bf', '%c3%80', '%c3%81', '%c3%82', '%c3%83', '%c3%84', '%c3%85', '%c3%86', '%c3%87', '%c3%88', '%c3%89', '%c3%8a', '%c3%8b', '%c3%8c', '%c3%8d', '%c3%8e', '%c3%8f', '%c3%90', '%c3%91', '%c3%92', '%c3%93', '%c3%94', '%c3%95', '%c3%96', '%c3%97', '%c3%98', '%c3%99', '%c3%9a', '%c3%9b', '%c3%9c', '%c3%9d', '%c3%9e', '%c3%9f', '%c3%a0', '%c3%a1', '%c3%a2', '%c3%a3', '%c3%a4', '%c3%a5', '%c3%a6', '%c3%a7', '%c3%a8', '%c3%a9', '%c3%aa', '%c3%ab', '%c3%ac', '%c3%ad', '%c3%ae', '%c3%af', '%c3%b0', '%c3%b1', '%c3%b2', '%c3%b3', '%c3%b4', '%c3%b5', '%c3%b6', '%c3%b7', '%c3%b8', '%c3%b9', '%c3%ba', '%c3%bb', '%c3%bc', '%c3%bd', '%c3%be', '%c3%bf');
        // $ids = array('10439','10680');
        $members = Members::get();
        // return $members;
        $refreshtoken = Curl::to('https://accounts.zoho.eu/oauth/v2/token?client_id=1000.1YXS76ZSU7T05KEB0E2EO5J9SUF52R&grant_type=authorization_code&client_secret=c1134f8e0ad2a325fd0dce8b298dac5c3f1cbe4c8e&redirect_uri=http://occ.local/admin&code=1000.b6cd301d1520e1b9bc7cae3ff6b2eb14.6e470ee6737637eef6c0db0bbc8bd49f')
            ->post();
        // return $refreshtoken;

        // $refreshtoken = json_decode($refreshtoken);
        $accesstoken = Curl::to('https://accounts.zoho.eu/oauth/v2/token?client_id=1000.1YXS76ZSU7T05KEB0E2EO5J9SUF52R&grant_type=refresh_token&client_secret=c1134f8e0ad2a325fd0dce8b298dac5c3f1cbe4c8e&refresh_token=1000.23a03a7eb131587a1b430d1c53abe164.cd2c78fbb110614edc600a7943902622')
            ->post();

        $accesstoken = json_decode($accesstoken);


        $maillist = Curl::to('https://campaigns.zoho.eu/api/v1.1/getmailinglists?resfmt=JSON')
            ->withHeader('Authorization:Zoho-oauthtoken ' . $accesstoken->access_token)
            ->get();
        // $maillist = json_decode($maillist);
        // echo '<pre>';
        // print_r($maillist);
        // echo '</pre>';
        // foreach ($members as $member) {
        //     // echo $member->email;
        // $adduser = Curl::to('https://campaigns.zoho.eu/api/v1.1/json/listsubscribe?resfmt=JSON&listkey=96f1a2e34b3b071e2c4c6286194d1efdcbad3f9c5f6454d4&contactinfo=%7BFirst+Name%3Amathula%2CLast+Name%3Amathu%2CContact+Email%3Amathula@portu.no%2COccID%3A111%7D')
        // ->withHeaders(array('Authorization'=>'Zoho-oauthtoken '.$accesstoken->access_token,'Content-Type'=>' application/x-www-form-urlencoded'))
        // ->post();
        // }
        for ($i = 1200; $i < count($members); $i++) {
            //    echo $members[$i]->email;
            //    $adduser = Curl::to('https://campaigns.zoho.eu/api/v1.1/addlistsubscribersinbulk?listkey=96f1a2e34b3b071e2c4c6286194d1efdcbad3f9c5f6454d4&resfmt=JSON&emailids='.$members[$i]->email)
            //     ->withHeaders(array('Authorization'=>'Zoho-oauthtoken '.$accesstoken->access_token,'Content-Type'=>' application/x-www-form-urlencoded'))
            //     ->post();
            $fname = ($members[$i]->Member_Fistname != null) ? str_replace(' ', '+', $members[$i]->Member_Fistname) : "-";
            $lname = ($members[$i]->Member_Lastname != null) ? str_replace(' ', '+', $members[$i]->Member_Lastname) : "-";
            $status = ($members[$i]->member_type != null) ? str_replace(' ', '+', $members[$i]->member_type) : "-";
            $mobile = ($members[$i]->phone_mobile != null) ? $members[$i]->phone_mobile : "-";

            for ($x = 0; $x < count($cha); $x++) {
                $fname = str_replace($cha[$x], $utf[$x], $fname);
                $lname = str_replace($cha[$x], $utf[$x], $lname);
            }
            // $fname = str_replace('Æ', '%C3%86', $fname);
            // $lname = str_replace('Æ', '%C3%86', $lname);
            // $fname = str_replace('Ø', '%C3%98', $fname);
            // $lname = str_replace('Ø', '%C3%98', $lname);
            // $fname = str_replace('Å', '%C3%85', $fname);
            // $lname = str_replace('Å', '%C3%85', $lname);
            // $fname = str_replace('æ', '%C3%A6', $fname);
            // $lname = str_replace('æ', '%C3%A6', $lname);
            // $fname = str_replace('ø', '%C3%B8', $fname);
            // $lname = str_replace('ø', '%C3%B8', $lname);
            // $fname = str_replace('å', '%C3%A5', $fname);
            // $lname = str_replace('å', '%C3%A5', $lname);
            // $fname = str_replace('Ã', '%C3%8F', $fname);
            // $lname = str_replace('Ã', '%C3%8F', $lname);
            // $fname = str_replace('-', '2d', $fname);
            // $lname = str_replace('-', '2d', $lname);
            // $fname = str_replace('¿½', '%C2%BF%C2%BD', $fname);
            // $lname = str_replace('¿½', '%C3%8F%C2%BD', $lname);
            // $fname = str_replace('é', '%C3%A9', $fname);
            // $lname = str_replace('é', '%C3%A9', $lname);
            // $fname = str_replace('Ã', '%C3%83', $fname);
            // $lname = str_replace('Ã', '%C3%83', $lname);
            // $fname = str_replace('ü', '%C3%9C', $fname);
            // $lname = str_replace('ü', '%C3%9C', $lname);
            // $fname = str_replace('ï', '%C3%8F', $fname);
            // $lname = str_replace('ï', '%C3%8F', $lname);
            // $fname = str_replace('/', '2f', $fname);
            // $lname = str_replace('/', '2f', $lname);
            // $lname = mb_convert_encoding($lname, "UTF-8", "auto");
            // $lname = iconv(mb_detect_encoding($lname, mb_detect_order(), true), "UTF-8", $lname);
            // $lname = utf8_encode($lname);
            // echo '<pre>';
            //     echo $lname;
            // echo '<pre>';
            // return $lname;

            $adduser = Curl::to('https://campaigns.zoho.eu/api/v1.1/json/listsubscribe?resfmt=JSON&listkey=96f1a2e34b3b071ed93877410c169ea81185630859ca1fd0&contactinfo=%7BFirstName%3A' . $fname . '%2CLastName%3A' . $lname . '%2CContact+Email%3A' . $members[$i]->email . '%2COccID%3A' . $members[$i]->OccID . '%2CMemberType%3A' . $status . '%2CMobile%3A' . $mobile . '%7D')
                ->withHeaders(array('Authorization' => 'Zoho-oauthtoken ' . $accesstoken->access_token, 'Content-Type' => ' application/x-www-form-urlencoded'))
                ->post();
            if ($i == 1300) {
                break;
            }
        }
        // https://campaigns.zoho.com/api/v1.1/json/listsubscribe?resfmt=JSON&listkey=[listkey]&contactinfo=%7BFirst+Name%3Amac%2CLast+Name%3ALast+Name%2CContact+Email%3Ajai%40zoho.com%7D&sources=[sourceName]

        return $adduser;
    }

    public function singleprint(Request $request)
    {


        return response()->json([
            'success' => $request->occid,
        ]);
    }

    public function multi(Request $request)
    {
        // return count($request->fields);
        // return implode(",",$request->fields);
        // $fields = implode("`,`",$request->fields);
        // $fields =  "`".$fields."`";
        $members = Members::whereIn('OccID', $request->row)->get();
        $tab = '';
        $count = 0;
        $inner = '';
        $fields = $request->fields;
        //    if(in_array("Member_Fistname", $request->fields))
        //    {
        //         deleteElement('Member_Fistname',  $request->fields);
        //    }
        foreach ($members as $value) {

            if (in_array("OccID", $request->fields) && in_array("Member_Lastname", $request->fields)) {
                $inner .= $value['OccID'] . ' <br>';
            }
            if (in_array("Member_Fistname", $request->fields) && in_array("Member_Lastname", $request->fields)) {
                $inner .= $value['Member_Fistname'] . ' ' . $value['Member_Lastname'] . '<br>';
            } elseif (in_array("Member_Fistname", $request->fields)) {
                $inner .= $value['Member_Fistname'] . '<br>';
            } elseif (in_array("Member_Lastname", $request->fields)) {
                $inner .= $value['Member_Lastname'] . '<br>';
            }

            if (in_array("address1", $request->fields) && in_array("address2", $request->fields)) {
                $inner .=  $value['address1'] . ' ' . $value['address2'] . '<br>';
            } elseif (in_array("address1", $request->fields)) {
                $inner .=  $value['address1'] . '<br>';
            } elseif (in_array("address2", $request->fields)) {
                $inner .=  $value['address2'] . '<br>';
            }
            if (in_array("city", $request->fields) && in_array("zipcode", $request->fields)) {
                $inner .=  $value['zipcode'] . ' ' . $value['city'] . '<br>';
            } elseif (in_array("city", $request->fields)) {
                $inner .=  $value['city'] . '<br>';
            } elseif (in_array("zipcode", $request->fields)) {
                $inner .=  $value['zipcode'] . '<br>';
            }


            for ($i = 0; $i < count($request->fields); $i++) {
                if ($request->fields[$i] != "Member_Fistname" && $request->fields[$i] != "Member_Lastname" && $request->fields[$i] != "city" && $request->fields[$i] != "zipcode" && $request->fields[$i] != "OccID" && $request->fields[$i] != "address1" && $request->fields[$i] != "address2") {
                    $inner .= $value[$request->fields[$i]] . '<br>';
                }

                // $inner .= '<tr><td>'.$value[$request->fields[$i]].'</td></tr>';
            }


            // if(in_array("city", $request->fields) && in_array("zipcode", $request->fields) )
            // {
            //     $inner .= '<tr><td>'.$value['city'].' ' . $value['zipcode'].'</td></tr>';
            // }
            // elseif(in_array("city", $request->fields))
            // {
            //     $inner .= '<tr><td>'.$value['city'].'</td></tr>';
            // }
            // elseif( in_array("zipcode", $request->fields) )
            // {
            //     $inner .= '<tr><td>'. $value['zipcode'].'</td></tr>';
            // }
            // $inner .= '</table>';

            // if ($count % 3 == 0) {

            //     $tab .= '</tr><tr >';
            // }

            $tab .= '<div class="col-4" style="border: solid;
            font-size: 23px;    height: 5cm;
            width: 7cm; padding-top: 6px">' . $inner . '</div>';

            $count++;
            $inner = '';
        }
        // $tab .= '</table>';
        // return $tab;
        return response()->json([
            'success' => true,
            'members' => $tab
        ]);
    }

    public function single_print(Request $request)
    {
        $mems = Members::get();

        // dobdate
        $txtfrom = (!empty($request->selected_data['dobfrom'])) ? $request->selected_data['dobfrom'] : '';
        $txtto = (!empty($request->selected_data['dobto'])) ? $request->selected_data['dobto'] : '';
        $dobfrom = date('Y-m-d', strtotime($txtfrom));
        $dobto = date('Y-m-d', strtotime($txtto));

        // member since
        $membersfrom = (!empty($request->selected_data['membersincefrom'])) ? $request->selected_data['membersincefrom'] : '';
        $membersto = (!empty($request->selected_data['membersinceto'])) ? $request->selected_data['membersinceto'] : '';
        $members_sincefrom = date('Y-m-d', strtotime($membersfrom));
        $members_sinceto = date('Y-m-d', strtotime($membersto));

        // registration date
        $registrationtxtfrom = (!empty($request->selected_data['dobfrom'])) ? $request->selected_data['dobfrom'] : '';
        $registrationtxtto = (!empty($request->selected_data['dobto'])) ? $request->selected_data['dobto'] : '';
        $registrationdobfrom = date('Y-m-d', strtotime($registrationtxtfrom));
        $registrationdobto = date('Y-m-d', strtotime($registrationtxtto));

        // family head

        // Email yes
        $emailyes = (empty($request->selected_data['email'])) ? null : (($request->selected_data['email'] == 'yes')  ? "yes" : null);

        // Email no
        $emailno = (empty($request->selected_data['email'])) ? null : (($request->selected_data['email'] == 'no')  ? "no" : null);

        // family head yes
        $familyhead = (empty($request->selected_data['familyhead'])) ? null : (($request->selected_data['familyhead'] == 'yes')  ? "10" : null);

        // family head no
        $familyheadno = (empty($request->selected_data['familyhead'])) ? null : (($request->selected_data['familyhead'] == 'no')  ? "10" : null);

        $members = Members::when(!empty($request->selected_data['member_type']), function ($query) use ($request) {
            return $query->where('member_type', $request->selected_data['member_type']);
        })

            ->when(!empty($request->selected_data['occidfrom']), function ($query2) use ($request) {
                return $query2->whereBetween('OccID', [$request->selected_data['occidfrom'], $request->selected_data['occidto']]);
            })
            ->when(!empty($request->selected_data['hcpfrom']), function ($query2) use ($request) {
                return $query2->whereBetween('new_hcp', [$request->selected_data['hcpfrom'], $request->selected_data['hcpto']]);
            })
            ->when(!empty($request->selected_data['dobfrom']), function ($query2) use ($dobfrom, $dobto, $request) {
                return $query2->whereBetween('date_of_birth', [$dobfrom, $dobto]);
            })
            ->when(!empty($request->selected_data['membersincefrom']), function ($query2) use ($members_sincefrom, $members_sinceto, $request) {
                return $query2->whereBetween('member_since', [$members_sincefrom, $members_sinceto]);
            })
            ->when(!empty($request->selected_data['registrationfrom']), function ($query2) use ($registrationdobfrom, $registrationdobto, $request) {
                return $query2->whereBetween('resignation_date', [$registrationdobfrom, $registrationdobto]);
            })
            ->when(!empty($request->selected_data['sex']), function ($query2) use ($request) {
                return $query2->where('sex', $request->selected_data['sex']);
            })
            ->when((!empty($emailyes)), function ($query2) use ($request) {
                return $query2->whereNotNull('email');
            })
            ->when((!empty($emailno)), function ($query2) use ($request) {
                return $query2->whereNull('email');
            })
            ->when(!empty($familyhead), function ($query2) use ($request, $familyhead) {
                // return $query2->where("OccID", "LIKE", "{$familyhead}%");
                return $query2->where("OccID", "LIKE", "{$familyhead}%");
            })
            ->when(!empty($familyheadno), function ($query2) use ($request, $familyheadno) {
                // return $query2->where("OccID", "LIKE", "{$familyhead}%");
                return $query2->where("OccID", "NOT LIKE", "{$familyheadno}%");
            })
            ->when(!empty($request->selected_data['share_type']), function ($query2) use ($request, $familyheadno) {
                // return $query2->where("OccID", "LIKE", "{$familyhead}%");
                return $query2->where("share_type", $request->selected_data['share_type']);
            })
            ->when(!empty($request->selected_data['sharenofrom']), function ($query2) use ($request) {
                return $query2->whereBetween('share_number', [$request->selected_data['sharenofrom'], $request->selected_data['sharenoto']]);
            })

            ->get($request->select_col);

        $output = '
            <table class="table" cellspacing="0" id="printed_table">
                <thead>
                    <tr>
                        <th> <input type="checkbox" id="select_all_checkbox" class="nowarp checkall"></th>
                    ';
        foreach ($request->select_col as $select_col) {
            // return $select_col;
            if ($select_col == 'OccID') {

                $output .= '
                    <th class="nowarp">Member ID</th>
                ';
            }
            if ($select_col == 'Member_Fistname') {

                $output .= '
                    <th class="nowarp">Member Firstname</th>
                ';
            }
            if ($select_col == 'Member_Lastname') {

                $output .= '
                    <th class="nowarp">Member Lastname</th>
                ';
            }
            if ($select_col == 'HCP') {

                $output .= '
                    <th class="nowarp">HCP</th>
                ';
            }
            if ($select_col == 'member_type') {

                $output .= '
                    <th class="nowarp">Member Type</th>
                ';
            }
            if ($select_col == 'share_type') {

                $output .= '
                    <th class="nowarp">Share Type</th>
                ';
            }
            if ($select_col == 'share_number') {

                $output .= '
                    <th class="nowarp">Share Number</th>
                ';
            }
            if ($select_col == 'address1') {

                $output .= '
                    <th class="nowarp">Address 1</th>
                ';
            }
            if ($select_col == 'address2') {

                $output .= '
                    <th class="nowarp">Address 2</th>
                ';
            }
            if ($select_col == 'city') {

                $output .= '
                    <th class="nowarp">City</th>
                ';
            }
            if ($select_col == 'zipcode') {

                $output .= '
                    <th class="nowarp">Zipcode</th>
                ';
            }
            if ($select_col == 'tel_privately') {

                $output .= '
                    <th class="nowarp">Tel Privat</th>
                ';
            }
            if ($select_col == 'tel_jobs') {

                $output .= '
                    <th class="nowarp">Tel Jobs</th>
                ';
            }
            if ($select_col == 'phone_mobile') {

                $output .= '
                    <th class="nowarp">Tel Mobile</th>
                ';
            }

            if ($select_col == 'sex') {

                $output .= '
                    <th class="nowarp">Sex</th>
                ';
            }
            if ($select_col == 'handicap') {

                $output .= '
                    <th class="nowarp">Handicap</th>
                ';
            }
            if ($select_col == 'stock_number') {

                $output .= '
                    <th class="nowarp">Stock Number</th>
                ';
            }
            if ($select_col == 'playing_eligibility') {

                $output .= '
                    <th class="nowarp">Playing Eligibility</th>
                ';
            }
            if ($select_col == 'date_of_birth') {

                $output .= '
                    <th class="nowarp">Date of Birth</th>
                ';
            }
            if ($select_col == 'email') {

                $output .= '
                    <th class="nowarp">Email</th>
                ';
            }
            if ($select_col == 'member_since') {

                $output .= '
                    <th class="nowarp">Member Since</th>
                ';
            }
            if ($select_col == 'resignation_date') {

                $output .= '
                    <th class="nowarp">Resignation Date</th>
                ';
            }
            if ($select_col == 'additional_info') {

                $output .= '
                    <th class="nowarp">Additional Info</th>
                ';
            }
            if ($select_col == 'family_head') {

                $output .= '
                    <th class="nowarp">Family Head</th>
                ';
            }
            if ($select_col == 'family_head_name') {

                $output .= '
                    <th class="nowarp">Family Head Name</th>
                ';
            }
            if ($select_col == 'family_head_no') {

                $output .= '
                    <th class="nowarp">Family Head No</th>
                ';
            }
            if ($select_col == 'shareholder_name') {

                $output .= '
                    <th class="nowarp">Shareholder Name</th>
                ';
            }
            if ($select_col == 'shareholder_member_no') {

                $output .= '
                    <th class="nowarp">Shareholder Member No</th>
                ';
            }
            if ($select_col == 'wardrobe') {

                $output .= '
                    <th class="nowarp">Wardrobe</th>
                ';
            }
            if ($select_col == 'drinks_cabinet') {

                $output .= '
                    <th class="nowarp">Drinks Cabinet</th>
                ';
            }
            if ($select_col == 'stick_cabinet') {

                $output .= '
                    <th class="nowarp">Stick Cabinet</th>
                ';
            }
            if ($select_col == 'car') {

                $output .= '
                    <th class="nowarp">Car</th>
                ';
            }
            if ($select_col == 'charging_site') {

                $output .= '
                    <th class="nowarp">Charging Site</th>
                ';
            }
            if ($select_col == 'trolley_space') {

                $output .= '
                    <th class="nowarp">Trolley Space</th>
                ';
            }
        }
        // return $output;
        $output .= '


            </tr>
                </thead>
            <tbody>

        ';

        $result = [];
        $array_value = [];
        for ($c = 0; $c < count($request->select_col); $c++) {
            foreach ($members as $member) {

                $result[] = [$request->select_col[$c] => $member[$request->select_col[$c]]];
            }
        }
        $td = count($request->select_col);
        $id = 1;
        for ($c = 0; $c < count($request->select_col); $c++) {
            foreach ($members as $key => $value) {
                // $id = $key-1;
                // return $value->OccID;
                $output .= '<tr>';
                $output .= '<td><input type="checkbox" name="multiprint[]" class="multiprint select_box" id="checl' . $id . '" value="' . $value->OccID . '"></td>

                    ';
                for ($t = 0; $t < $td; $t++) {
                    // return $value[$request->select_col[$t]];
                    $output .= '

                    <td data-column="' . $request->select_col[$t] . '">' . $value[$request->select_col[$t]] . '</td>

                    ';
                    array_push($array_value, $value[$request->select_col[$t]]);
                }

                // $output .= ' <td><input type="checkbox" name="multiprint[]" id="checl'.$id.'" value="'.$value->OccID.'"></td></tr>';
                $output .= '<tr>';
                $id++;
                unset($array_value);
                $array_value = [];
            }
            break;
        }
        // $output .= $members->links();
        // $members = new Members();
        // $members = $members->getAll();
        $rename_columns = array();
        foreach ($request->select_col as $column_name) {
            if ($column_name == 'OccID') {

                $rename_columns[] = 'Member ID';
            }
            if ($column_name == 'Member_Fistname') {

                $rename_columns[] = 'Member Firstname';
            }
            if ($column_name == 'Member_Lastname') {

                $rename_columns[] = 'Member Lastname';
            }
            if ($column_name == 'HCP') {

                $rename_columns[] = 'HCP';
            }
            if ($column_name == 'member_type') {

                $rename_columns[] = 'Member Type';
            }
            if ($column_name == 'share_type') {

                $rename_columns[] = 'Share Type';
            }
            if ($column_name == 'share_number') {

                $rename_columns[] = 'Share Number';
            }
            if ($column_name == 'address1') {

                $rename_columns[] = 'Address 1';
            }
            if ($column_name == 'address2') {

                $rename_columns[] = 'Address 2';
            }
            if ($column_name == 'city') {

                $rename_columns[] = 'City';
            }
            if ($column_name == 'zipcode') {

                $rename_columns[] = 'Zipcode';
            }
            if ($column_name == 'tel_privately') {

                $rename_columns[] = 'Tel Privat';
            }
            if ($column_name == 'tel_jobs') {

                $rename_columns[] = 'Tel Jobs';
            }
            if ($column_name == 'phone_mobile') {

                $rename_columns[] = 'Tel Mobile';
            }
            if ($column_name == 'sex') {

                $rename_columns[] = 'Sex';
            }
            if ($column_name == 'handicap') {

                $rename_columns[] = 'Handicap';
            }
            if ($column_name == 'stock_number') {

                $rename_columns[] = 'Stock Number';
            }
            if ($column_name == 'playing_eligibility') {

                $rename_columns[] = 'Playing Eligibility';
            }
            if ($column_name == 'date_of_birth') {

                $rename_columns[] = 'Date of Birth';
            }
            if ($column_name == 'email') {

                $rename_columns[] = 'Email';
            }
            if ($column_name == 'member_since') {

                $rename_columns[] = 'Member Since';
            }
            if ($column_name == 'resignation_date') {

                $rename_columns[] = 'Resignation Date';
            }
            if ($column_name == 'additional_info') {

                $rename_columns[] = 'Additional Info';
            }
            if ($column_name == 'family_head') {

                $rename_columns[] = 'Family Head';
            }
            if ($column_name == 'family_head_name') {

                $rename_columns[] = 'Family Head Name';
            }
            if ($column_name == 'family_head_no') {

                $rename_columns[] = 'Family Head No';
            }
            if ($column_name == 'shareholder_name') {

                $rename_columns[] = 'Shareholder Name';
            }
            if ($column_name == 'shareholder_member_no') {

                $rename_columns[] = 'Shareholder Member No';
            }
            if ($column_name == 'wardrobe') {

                $rename_columns[] = 'Wardrobe';
            }
            if ($column_name == 'drinks_cabinet') {

                $rename_columns[] = 'Drinks Cabinet';
            }
            if ($column_name == 'stick_cabinet') {

                $rename_columns[] = 'Stick Cabinet';
            }
            if ($column_name == 'car') {

                $rename_columns[] = 'Car';
            }
            if ($column_name == 'charging_site') {

                $rename_columns[] = 'Charging Site';
            }
            if ($column_name == 'trolley_space') {

                $rename_columns[] = 'Trolley Space';
            }
        }
        $column_names['column_name'] = $rename_columns;
        $data = new collection();
        foreach ($column_names as  $column_name) {
            // return $column_name;
            $data[0] = (object) $column_name;
        }
        $data = $data->merge($members);
        $excel = Exporter::make('Excel');
        // return $data;
        $excel->load($data);
        $filename = 'Members.xlsx';
        $savefile = public_path('/excel/' . $filename);
        $excel->save($savefile);

        return response()->json([
            'print' => $output,
            'excel' => '/excel/' . $filename
        ]);
    }

    public function hcp_calcuation(Request $request)
    {

        // return $request->cal_hcp;

        $hcp = HcpRegitar::orderBy('id', 'desc')->where('OccID', $request->OccID)->first();
        $unique_hcp = Members::where('OccID', $request->OccID)->first();
        $hc2 = HcpRegitar::where('OccID', $request->OccID)->sum('cal_hcp');
        $unique1_hcp = str_replace(",", ".", $unique_hcp['HCP']);


        if (7 >= $hcp['round_palyed']) {

            $default_hcp = (!empty($hcp['round_palyed']) ? ($hcp['round_palyed'] + 1) : 1);
            // return $default_hcp;

            $total = (8 - $default_hcp) * $unique1_hcp;
            // return $total;
            $total_cal = ($total + $request->cal_hcp + (!empty($hc2) ? $hc2 : 0)) / 8;
            // return (strlen($total_cal) <= 3) ? $total_cal . ',0' : str_replace(".", ",", $total_cal);
            return response()->json([
                'result' => (strlen($total_cal) <= 3) ? $total_cal . ',0' : str_replace(".", ",", $total_cal)
            ]);
        } else {

            return response()->json([
                'message' => 'Your round is cmpleated'
            ]);
        }
    }

    public function hcp_save(Request $request)
    {
//         return $request;
        $hcp_day = HcpRegitar::where('OccID', $request->OccID)->where('hcp_status', '1')->where('date', $request->date)->get();
        // if ($request->day_count <= 2) {
        $hcp = HcpRegitar::orderBy('id', 'desc')->where('OccID', $request->OccID)->where('hcp_status', '1')->first();
        $unique_hcp = Members::where('OccID', $request->OccID)->first();
        $hc2 = HcpRegitar::where('OccID', $request->OccID)->where('hcp_status', '1')->sum('cal_hcp');
        $unique1_hcp = str_replace(",", ".", $unique_hcp['HCP']);

        if (7 >= $hcp['round_palyed']) {
            $default_hcp = (!empty($hcp['round_palyed']) ? ($hcp['round_palyed'] + 1) : 1);

            $total = (8 - $default_hcp) * $unique1_hcp;

            $total_cal = ($total + $request->cal_hcp + (!empty($hc2) ? $hc2 : 0)) / 8;
            $new_total = (string) number_format($total_cal, 1);

            $last = HcpRegitar::orderBy('id', 'desc')->where('OccID', $request->OccID)->where('hcp_status', '1')->first();
            $count = (!empty($last) ? $last->round_palyed : 0);
            $round_palyed =  $count + 1;

            $hcpreg = new HcpRegitar;
            $hcpreg->OccID = $request->OccID;
            $hcpreg->hcp = str_replace(".", ",", $new_total);

            $hcpreg->date = $request->date;
            $hcpreg->round_palyed = $round_palyed;
            $hcpreg->cal_hcp = $request->cal_hcp;
            $hcpreg->club = $request->club;
            $hcpreg->hcp_status = '1';
            $hcpreg->coursepar = $request->coursepar;
            $hcpreg->strokesgiven = $request->strokesgiven;
            $hcpreg->actualstrokes = $request->actualstrokes;

            $hcpreg->save();
            $count = HcpRegitar::where('OccID', $request->OccID)->count();

            $new_hcp = str_replace(".", ",", $new_total);
            $member = Members::where('OccID', $request->OccID)->first()->toArray();

            if ($member['email'] != '') {

                // if ($request->old_hcp != $request->hcp) {

                $member_name = $member['Member_Fistname'] . ' ' . $member['Member_Lastname'];
                $member_email = $member['email'];
//                Mail::send('email.hcpupdate', ['member_name' => $member_name, 'member_email' => $member_email, 'old_hcp' => $request->old_hcp, 'new_hcp' => $new_hcp], function ($message) use ($member_email) {
//
//                    // $message->from('noreply@digifront.biz', 'HCP Update');
//                    $message->subject('OCC-GOLF APP');
//                    $message->to($member_email);
//                });
            }
            DB::table('members')
                ->where('OccID', $request->OccID)
                ->update([
                    'new_hcp' => $new_hcp,
                    'new_club' => $request->club,
                    'counted' => $count
                ]);
            // }
            return response()->json([
                // 'success' => true,
                'message' => ($request->old_hcp != $request->hcp) ? true  : false,
                'fullname' => $member['Member_Fistname'] . ' ' . $member['Member_Lastname'],
                'hcp' => $new_hcp,
                'daycount'=> count($hcp_day)
            ]);
        } else {
            // return 'elseee';
            $ids = array();
            $bestids = array();
            $bestids1 = array();
            $dbhcp = array();
            $hcp_datess = HcpRegitar::where('OccID', $request->OccID)->where('hcp_status', '1')
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
                if ($hcp_sum['cal_hcp'] <= $request->cal_hcp) {
                    $bestids[] = $hcp_sum['cal_hcp'];
                    // $bestids1[] = $hcp_sum['id'];
                } else {
                    unset($bestids);
                }
                if ($hcp_sum['cal_hcp'] >= $request->cal_hcp) {
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
            $total_cals = ($cal_sums + $request->cal_hcp) / 8;


            if (!empty($total_cal_above)) {
                $total_cal = (string) number_format($total_cal_above, 1);
            } else {
                $total_cal = (string) number_format($total_cals, 1);
            }


            // $total_cal = !empty($total_cals) ? $total_cals : $total_cal_above;
            $last = HcpRegitar::orderBy('id', 'desc')->where('OccID', $request->OccID)->where('hcp_status', '1')->first();
            $count = (!empty($last) ? $last->round_palyed : 0);
            $round_palyed =  $count + 1;

            $hcpreg = new HcpRegitar;
            $hcpreg->OccID = $request->OccID;
            $hcpreg->hcp = str_replace(".", ",", $total_cal);
            $hcpreg->date = $request->date;
            $hcpreg->round_palyed = $round_palyed;
            $hcpreg->cal_hcp = $request->cal_hcp;
            $hcpreg->club = $request->club;
            $hcpreg->hcp_status = '1';
            $hcpreg->coursepar = $request->coursepar;
            $hcpreg->strokesgiven = $request->strokesgiven;
            $hcpreg->actualstrokes = $request->actualstrokes;
            $hcpreg->save();
            $count = HcpRegitar::where('OccID', $request->OccID)->where('hcp_status', '1')->count();


            // $new_hcp = (strlen($total_cal) <= 3) ? $total_cal . ',0' : str_replace(".", ",", $total_cal);
            $new_hcp = str_replace(".", ",", $total_cal);
            $member = Members::where('OccID', $request->OccID)->first()->toArray();

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
                ->where('OccID', $request->OccID)
                ->update([
                    'new_hcp' => $new_hcp,
                    'new_club' => $request->club,
                    'counted' => $count
                ]);

            return response()->json([
                // 'success' => true,
                'message' => ($request->old_hcp != $request->hcp) ? true  : false,
                'fullname' => $member['Member_Fistname'] . ' ' . $member['Member_Lastname'],
                'hcp' => $new_hcp,
                'daycount'=> count($hcp_day)

            ]);
        }

    }

    public function round_played_check(Request $request)
    {

        $roundplayed = HcpRegitar::where('OccID', $request->OccID)->where('round_palyed', $request->roundplayed)->where('hcp_status', '1')->first();
        return $roundplayed;
    }

    public function gustRegFormInReg(Request $request)
    {
        $hcp_day = HcpRegitar::where('OccID', $request->OccID)->where('hcp_status', '1')->where('date', $request->date)->get();

        // return $request;
        $hcpregitars = HcpRegitar::where('OccID', $request->member_id)->where('hcp_status', '1')->get();


        $last = HcpRegitar::orderBy('id', 'desc')->where('OccID', $request->member_id)->where('hcp_status', '1')->first();
        $last1 = Members::where('OccID', $request->member_id)->first();

        // return $hcpregitars;
        $clublist = HcpRegitar::where('OccID', $last1->MemberID)->where('hcp_status', '1')->first();
        $clublist_all = club::get();
        $club_sel = HcpRegitar::where('OccID', $request->member_id)->where('hcp_status', '1')->latest('id')->first();
        $select = '';
        $played = 1;

        $select .= '<select class="form-control" id="round_played" name="club">';
        // if (empty($hcpregitars[0])) {
        $select .= '<option value="OCC Golf">OCC Golf</option>';
        foreach ($clublist_all as $clublist) {
            $selected = (($clublist->ClubName  == $club_sel['club']) ? 'selected' : '');
            $select .= '<option  value="' . $clublist->ClubName . '" ' . $selected . '>' . $clublist->ClubName . '</option>';
            $played++;
        }
        // if (!empty($clublist->club)) {
        //     $select .= '<option selected value="' . $clublist->club . '" >' . $clublist->club . '</option>';
        // }

        $select .= '</select>';


        return response()->json([
            'select' => $select,
            'hcp' => (!empty($last) ? $last->hcp : $last1->HCP),
            'round_palyed' => (!empty($last->round_palyed) ? $last->round_palyed : 0)

        ]);
    }

    public function report_search_get_data(Request $request)
    {
        // return $request->selected_data['sharetype'];
        $mems = Members::get();

        // dobdate
        $txtfrom = (!empty($request->selected_data['dobfrom'])) ? $request->selected_data['dobfrom'] : '';
        $txtto = (!empty($request->selected_data['dobto'])) ? $request->selected_data['dobto'] : '';
        $dobfrom = date('Y-m-d', strtotime($txtfrom));
        $dobto = date('Y-m-d', strtotime($txtto));

        // member since
        $membersfrom = (!empty($request->selected_data['membersincefrom'])) ? $request->selected_data['membersincefrom'] : '';
        $membersto = (!empty($request->selected_data['membersinceto'])) ? $request->selected_data['membersinceto'] : '';
        $members_sincefrom = date('Y-m-d', strtotime($membersfrom));
        $members_sinceto = date('Y-m-d', strtotime($membersto));

        // registration date
        $registrationtxtfrom = (!empty($request->selected_data['registrationfrom'])) ? $request->selected_data['registrationfrom'] : '';
        $registrationtxtto = (!empty($request->selected_data['registrationto'])) ? $request->selected_data['registrationto'] : '';
        $registrationdobfrom = date('Y-m-d', strtotime($registrationtxtfrom));
        $registrationdobto = date('Y-m-d', strtotime($registrationtxtto));

        // family head

        // Email yes
        $emailyes = (empty($request->selected_data['email'])) ? null : (($request->selected_data['email'] == 'yes')  ? "yes" : null);

        // Email no
        $emailno = (empty($request->selected_data['email'])) ? null : (($request->selected_data['email'] == 'no')  ? "no" : null);

        // family head yes
        $familyhead = (empty($request->selected_data['familyhead'])) ? null : (($request->selected_data['familyhead'] == 'yes')  ? "10" : null);

        // family head no
        $familyheadno = (empty($request->selected_data['familyhead'])) ? null : (($request->selected_data['familyhead'] == 'no')  ? "10" : null);

        // $email2 = (!empty($email) ? $email : $email1);

        // return $familyhead;

        $members = Members::when(!empty($request->selected_data['member_type']), function ($query) use ($request) {
            return $query->where('member_type', $request->selected_data['member_type']);
        })

            ->when(!empty($request->selected_data['occidfrom']), function ($query2) use ($request) {
                return $query2->whereBetween('OccID', [$request->selected_data['occidfrom'], $request->selected_data['occidto']]);
            })
            ->when(!empty($request->selected_data['hcpfrom']), function ($query2) use ($request) {
                return $query2->whereBetween('HCP', [$request->selected_data['hcpfrom'], $request->selected_data['hcpto']]);
            })
            ->when(!empty($request->selected_data['dobfrom']), function ($query2) use ($dobfrom, $dobto, $request) {
                return $query2->whereBetween('date_of_birth', [$dobfrom, $dobto]);
            })
            ->when(!empty($request->selected_data['membersincefrom']), function ($query2) use ($members_sincefrom, $members_sinceto, $request) {
                return $query2->whereBetween('member_since', [$members_sincefrom, $members_sinceto]);
            })
            ->when(!empty($request->selected_data['registrationfrom']), function ($query2) use ($registrationdobfrom, $registrationdobto, $request) {
                return $query2->whereBetween('resignation_date', [$registrationdobfrom, $registrationdobto]);
            })
            ->when(!empty($request->selected_data['sex']), function ($query2) use ($request) {
                return $query2->where('sex', $request->selected_data['sex']);
            })
            ->when((!empty($emailyes)), function ($query2) use ($request) {
                return $query2->whereNotNull('email');
            })
            ->when((!empty($emailno)), function ($query2) use ($request) {
                return $query2->whereNull('email');
            })
            ->when(!empty($familyhead), function ($query2) use ($request, $familyhead) {
                // return $query2->where("OccID", "LIKE", "{$familyhead}%");
                return $query2->where("OccID", "LIKE", "{$familyhead}%");
            })
            ->when(!empty($familyheadno), function ($query2) use ($request, $familyheadno) {
                // return $query2->where("OccID", "LIKE", "{$familyhead}%");
                return $query2->where("OccID", "NOT LIKE", "{$familyheadno}%");
            })
            ->when(!empty($request->selected_data['share_type']), function ($query2) use ($request) {
                // return $query2->where("OccID", "LIKE", "{$familyhead}%");
                return $query2->where("share_type", $request->selected_data['share_type']);
            })
            ->when(!empty($request->selected_data['sharenofrom']), function ($query2) use ($request) {
                return $query2->whereBetween('share_number', [$request->selected_data['sharenofrom'], $request->selected_data['sharenoto']]);
            })

            ->get($request->select_col);

        // return $request->select_col;

        $output = '
            <table class="table" cellspacing="0" id="printed_table">
                <thead>
                    <tr>
                    ';
        foreach ($request->select_col as $select_col) {
            // return $select_col;
            if ($select_col == 'OccID') {

                $output .= '
                    <th class="nowarp">Member ID</th>
                ';
            }
            if ($select_col == 'Member_Fistname') {

                $output .= '
                    <th class="nowarp">Member Firstname</th>
                ';
            }
            if ($select_col == 'Member_Lastname') {

                $output .= '
                    <th class="nowarp">Member Lastname</th>
                ';
            }
            if ($select_col == 'HCP') {

                $output .= '
                    <th class="nowarp">HCP</th>
                ';
            }
            if ($select_col == 'member_type') {

                $output .= '
                    <th class="nowarp">Member Type</th>
                ';
            }
            if ($select_col == 'share_type') {

                $output .= '
                    <th class="nowarp">Share Type</th>
                ';
            }
            if ($select_col == 'share_number') {

                $output .= '
                    <th class="nowarp">Share Number</th>
                ';
            }
            if ($select_col == 'address1') {

                $output .= '
                    <th class="nowarp">Address 1</th>
                ';
            }
            if ($select_col == 'address2') {

                $output .= '
                    <th class="nowarp">Address 2</th>
                ';
            }
            if ($select_col == 'city') {

                $output .= '
                    <th class="nowarp">City</th>
                ';
            }
            if ($select_col == 'zipcode') {

                $output .= '
                    <th class="nowarp">Zipcode</th>
                ';
            }
            if ($select_col == 'tel_privately') {

                $output .= '
                    <th class="nowarp">Tel Privat</th>
                ';
            }
            if ($select_col == 'tel_jobs') {

                $output .= '
                    <th class="nowarp">Tel Jobs</th>
                ';
            }
            if ($select_col == 'phone_mobile') {

                $output .= '
                    <th class="nowarp">Tel Mobile</th>
                ';
            }

            if ($select_col == 'sex') {

                $output .= '
                    <th class="nowarp">Sex</th>
                ';
            }
            if ($select_col == 'handicap') {

                $output .= '
                    <th class="nowarp">Handicap</th>
                ';
            }
            if ($select_col == 'stock_number') {

                $output .= '
                    <th class="nowarp">Stock Number</th>
                ';
            }
            if ($select_col == 'playing_eligibility') {

                $output .= '
                    <th class="nowarp">Playing Eligibility</th>
                ';
            }
            if ($select_col == 'date_of_birth') {

                $output .= '
                    <th class="nowarp">Date of Birth</th>
                ';
            }
            if ($select_col == 'email') {

                $output .= '
                    <th class="nowarp">Email</th>
                ';
            }
            if ($select_col == 'member_since') {

                $output .= '
                    <th class="nowarp">Member Since</th>
                ';
            }
            if ($select_col == 'resignation_date') {

                $output .= '
                    <th class="nowarp">Resignation Date</th>
                ';
            }
            if ($select_col == 'additional_info') {

                $output .= '
                    <th class="nowarp">Additional Info</th>
                ';
            }
            if ($select_col == 'family_head') {

                $output .= '
                    <th class="nowarp">Family Head</th>
                ';
            }
            if ($select_col == 'family_head_name') {

                $output .= '
                    <th class="nowarp">Family Head Name</th>
                ';
            }
            if ($select_col == 'family_head_no') {

                $output .= '
                    <th class="nowarp">Family Head No</th>
                ';
            }
            if ($select_col == 'shareholder_name') {

                $output .= '
                    <th class="nowarp">Shareholder Name</th>
                ';
            }
            if ($select_col == 'shareholder_member_no') {

                $output .= '
                    <th class="nowarp">Shareholder Member No</th>
                ';
            }
            if ($select_col == 'wardrobe') {

                $output .= '
                    <th class="nowarp">Wardrobe</th>
                ';
            }
            if ($select_col == 'drinks_cabinet') {

                $output .= '
                    <th class="nowarp">Drinks Cabinet</th>
                ';
            }
            if ($select_col == 'stick_cabinet') {

                $output .= '
                    <th class="nowarp">Stick Cabinet</th>
                ';
            }
            if ($select_col == 'car') {

                $output .= '
                    <th class="nowarp">Car</th>
                ';
            }
            if ($select_col == 'charging_site') {

                $output .= '
                    <th class="nowarp">Charging Site</th>
                ';
            }
            if ($select_col == 'trolley_space') {

                $output .= '
                    <th class="nowarp">Trolley Space</th>
                ';
            }
        }
        // return $output;
        $output .= '
            </tr>
                </thead>
            <tbody>
        ';

        $result = [];
        for ($c = 0; $c < count($request->select_col); $c++) {
            foreach ($members as $member) {

                $result[] = [$request->select_col[$c] => $member[$request->select_col[$c]]];
            }
        }
        $td = count($request->select_col);
        for ($c = 0; $c < count($request->select_col); $c++) {
            foreach ($members as $value) {
                $output .= '<tr>';
                for ($t = 0; $t < $td; $t++) {
                    // return $value[$request->select_col[$t]];


                    $output .= '

                        <td>' . $value[$request->select_col[$t]] . '</td>

                    ';
                }

                $output .= '</tr>';
            }
            break;
        }
        // $output .= $members->links();
        // $members = new Members();
        // $members = $members->getAll();
        $rename_columns = array();
        foreach ($request->select_col as $column_name) {
            if ($column_name == 'OccID') {

                $rename_columns[] = 'Member ID';
            }
            if ($column_name == 'Member_Fistname') {

                $rename_columns[] = 'Member Firstname';
            }
            if ($column_name == 'Member_Lastname') {

                $rename_columns[] = 'Member Lastname';
            }
            if ($column_name == 'HCP') {

                $rename_columns[] = 'HCP';
            }
            if ($column_name == 'member_type') {

                $rename_columns[] = 'Member Type';
            }
            if ($column_name == 'share_type') {

                $rename_columns[] = 'Share Type';
            }
            if ($column_name == 'share_number') {

                $rename_columns[] = 'Share Number';
            }
            if ($column_name == 'address1') {

                $rename_columns[] = 'Address 1';
            }
            if ($column_name == 'address2') {

                $rename_columns[] = 'Address 2';
            }
            if ($column_name == 'city') {

                $rename_columns[] = 'City';
            }
            if ($column_name == 'zipcode') {

                $rename_columns[] = 'Zipcode';
            }
            if ($column_name == 'tel_privately') {

                $rename_columns[] = 'Tel Privat';
            }
            if ($column_name == 'tel_jobs') {

                $rename_columns[] = 'Tel Jobs';
            }
            if ($column_name == 'phone_mobile') {

                $rename_columns[] = 'Tel Mobile';
            }
            if ($column_name == 'sex') {

                $rename_columns[] = 'Sex';
            }
            if ($column_name == 'handicap') {

                $rename_columns[] = 'Handicap';
            }
            if ($column_name == 'stock_number') {

                $rename_columns[] = 'Stock Number';
            }
            if ($column_name == 'playing_eligibility') {

                $rename_columns[] = 'Playing Eligibility';
            }
            if ($column_name == 'date_of_birth') {

                $rename_columns[] = 'Date of Birth';
            }
            if ($column_name == 'email') {


                $rename_columns[] = 'Email';
            }
            if ($column_name == 'member_since') {

                $rename_columns[] = 'Member Since';
            }
            if ($column_name == 'resignation_date') {

                $rename_columns[] = 'Resignation Date';
            }
            if ($column_name == 'additional_info') {

                $rename_columns[] = 'Additional Info';
            }
            if ($column_name == 'family_head') {

                $rename_columns[] = 'Family Head';
            }
            if ($column_name == 'family_head_name') {

                $rename_columns[] = 'Family Head Name';
            }
            if ($column_name == 'family_head_no') {

                $rename_columns[] = 'Family Head No';
            }
            if ($column_name == 'shareholder_name') {

                $rename_columns[] = 'Shareholder Name';
            }
            if ($column_name == 'shareholder_member_no') {

                $rename_columns[] = 'Shareholder Member No';
            }
            if ($column_name == 'wardrobe') {

                $rename_columns[] = 'Wardrobe';
            }
            if ($column_name == 'drinks_cabinet') {

                $rename_columns[] = 'Drinks Cabinet';
            }
            if ($column_name == 'stick_cabinet') {

                $rename_columns[] = 'Stick Cabinet';
            }
            if ($column_name == 'car') {

                $rename_columns[] = 'Car';
            }
            if ($column_name == 'charging_site') {

                $rename_columns[] = 'Charging Site';
            }
            if ($column_name == 'trolley_space') {

                $rename_columns[] = 'Trolley Space';
            }
        }
        $column_names['column_name'] = $rename_columns;
        $data = new collection();
        foreach ($column_names as  $column_name) {
            // return $column_name;
            $data[0] = (object) $column_name;
        }
        $data = $data->merge($members);
        $excel = Exporter::make('Excel');
        // return $data;
        $excel->load($data);
        $excel->setChunk(1000);
        $filename = 'Members.xlsx';
        $savefile = public_path('/excel/' . $filename);
        $excel->save($savefile);

        return response()->json([
            'print' => $output,
            'excel' => '/excel/' . $filename
        ]);
    }

    public function exportdata()
    {

        $qry = "select column_name from information_schema.columns where table_name = 'members' and table_schema = 'portu_occ-golf' ";

        $data = DB::select($qry);

        $result = array();
        foreach ($data as $row => $columns) {
            foreach ($columns as $row2 => $column2) {
                $result[$row2][$row] = $column2;
            }
        }

        $column_names['column_name'] = array('MemberID', 'OccID', 'Member Fistname', 'Member Lastname', 'HCP', 'Active', 'Member Type', 'Share Type', 'Share Number', 'Address 1', 'Address 2', 'Zipcode', 'Email', 'Tel Pprivately', 'Tel Jobs', 'Phone Mobile', 'Sex', 'Handcap', 'Stock Number', 'Playing Eligibility', 'Date of Birth', 'Member Since', 'Resignation Date', 'Additional Info', 'Family Head', 'Family Head Name', 'Family Head No', 'Shareholder Name', 'Shareholder Member No', 'Wardrobe', 'Drinks Cabinet', 'Stick Cabinet', 'Car', 'Charging Site', 'Trolley Space');

        // $test['column_name'] = array($column_names);
        // dd($column_names);

        // dd($column_names);

        // $members = DB::table('members')->get();
        // $members = DB::select('select * from members');

        $members = new Members();
        $members = $members->getAll();
        $data = new collection();
        foreach ($column_names as  $column_name) {
            $data[0] = (object) $column_name;
        }
        $data = $data->merge($members);

        $excel = Exporter::make('Excel');
        $excel->setValignment('middle');
        $excel->load($data);
        $filename = 'Members.xlsx';
        $savefile = public_path('/excel/' . $filename);
        // $excel->save($savefile);

        return $excel->stream('test.xlsx');
    }

    public function report_search()
    {
        return view('report_search');
    }

    public function memberupdatess(Request $request)
    {

        $cha = array('!', '#', '$', '%', '&', '(', ')', '*', '+', ',', '-', '.', '/', ':', ';', '<', '=', '>', '?', '[', "]", '^', '_', '`', '{', '|', '}', '~', '¡', '¢', '£', '¤', '¥', '¦', '§', '¨', '©', 'ª', '«', '¬', '®', '¯', '°', '±', '²', '³', '´', 'µ', '¶', '·', '¸', '¹', 'º', '»', '¼', '½', '¾', '¿', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', '×', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'Þ', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', '÷', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'þ', 'ÿ');

        $utf = array('%21', '%23', '%24', '%25', '%26', '%28', '%29', '%2a', '%2b', '%2c', '%2d', '%2e', '%2f', '%3a', '%3b', '%3c', '%3d', '%3e', '%3f', '%5b', '%5d', '%5e', '%5f', '%60', '%7b', '%7c', '%7d', '%7e', '%c2%a1', '%c2%a2', '%c2%a3', '%c2%a4', '%c2%a5', '%c2%a6', '%c2%a7', '%c2%a8', '%c2%a9', '%c2%aa', '%c2%ab', '%c2%ac', '%c2%ae', '%c2%af', '%c2%b0', '%c2%b1', '%c2%b2', '%c2%b3', '%c2%b4', '%c2%b5', '%c2%b6', '%c2%b7', '%c2%b8', '%c2%b9', '%c2%ba', '%c2%bb', '%c2%bc', '%c2%bd', '%c2%be', '%c2%bf', '%c3%80', '%c3%81', '%c3%82', '%c3%83', '%c3%84', '%c3%85', '%c3%86', '%c3%87', '%c3%88', '%c3%89', '%c3%8a', '%c3%8b', '%c3%8c', '%c3%8d', '%c3%8e', '%c3%8f', '%c3%90', '%c3%91', '%c3%92', '%c3%93', '%c3%94', '%c3%95', '%c3%96', '%c3%97', '%c3%98', '%c3%99', '%c3%9a', '%c3%9b', '%c3%9c', '%c3%9d', '%c3%9e', '%c3%9f', '%c3%a0', '%c3%a1', '%c3%a2', '%c3%a3', '%c3%a4', '%c3%a5', '%c3%a6', '%c3%a7', '%c3%a8', '%c3%a9', '%c3%aa', '%c3%ab', '%c3%ac', '%c3%ad', '%c3%ae', '%c3%af', '%c3%b0', '%c3%b1', '%c3%b2', '%c3%b3', '%c3%b4', '%c3%b5', '%c3%b6', '%c3%b7', '%c3%b8', '%c3%b9', '%c3%ba', '%c3%bb', '%c3%bc', '%c3%bd', '%c3%be', '%c3%bf');


        $mem = Members::where('MemberID', $request->memberid)->first();
        // return $members;
        $refreshtoken = Curl::to('https://accounts.zoho.eu/oauth/v2/token?client_id=1000.1YXS76ZSU7T05KEB0E2EO5J9SUF52R&grant_type=authorization_code&client_secret=c1134f8e0ad2a325fd0dce8b298dac5c3f1cbe4c8e&redirect_uri=http://occ.local/admin&code=1000.b6cd301d1520e1b9bc7cae3ff6b2eb14.6e470ee6737637eef6c0db0bbc8bd49f')
            ->post();

        $accesstoken = Curl::to('https://accounts.zoho.eu/oauth/v2/token?client_id=1000.1YXS76ZSU7T05KEB0E2EO5J9SUF52R&grant_type=refresh_token&client_secret=c1134f8e0ad2a325fd0dce8b298dac5c3f1cbe4c8e&refresh_token=1000.23a03a7eb131587a1b430d1c53abe164.cd2c78fbb110614edc600a7943902622')
            ->post();

        $accesstoken = json_decode($accesstoken);



        $maillist = Curl::to('https://campaigns.zoho.eu/api/v1.1/getmailinglists?resfmt=JSON')
            ->withHeader('Authorization:Zoho-oauthtoken ' . $accesstoken->access_token)
            ->get();

        $tmp_mail_input = null;
        $tmp_billing_mail_input = null;
        if(isset($request->email)) $tmp_mail_input = $request->email;
        else {
            if(isset($request->email_billing)) $tmp_mail_input = $request->email_billing;
        }
        if(isset($request->email_billing)) $tmp_billing_mail_input = $request->email_billing;
        else {
            if(isset($request->email)) $tmp_billing_mail_input = $request->email;
        }


        $fname = ($request->Member_Fistname != null) ? str_replace(' ', '+', $request->Member_Fistname) : "-";
        $lname = ($request->Member_Lastname != null) ? str_replace(' ', '+', $request->Member_Lastname) : "-";
        // $status = ($request->member_type == 'Select') ? '-' : $request->member_type;
        $status = ($request->member_type == 'Select') ? '-' : str_replace(' ', '+', $request->member_type);
        $email = ($request->email != null) ? $request->email : '-';
        $mobile = ($request->phone_mobile != null) ? $request->phone_mobile : "-";


        if ($email != $mem->email) {

            $donotmail = Curl::to('https://campaigns.zoho.eu/api/v1.1/json/contactdonotmail?resfmt=JSON&contactinfo=%7BContact+Email%3A' . $mem->email . '%7D')
                ->withHeaders(array('Authorization' => 'Zoho-oauthtoken ' . $accesstoken->access_token, 'Content-Type' => ' application/x-www-form-urlencoded'))
                ->post();
        }
        // return $email;

        for ($x = 0; $x < count($cha); $x++) {
            $fname = str_replace($cha[$x], $utf[$x], $fname);
            $lname = str_replace($cha[$x], $utf[$x], $lname);
        }


        /*$adduser = Curl::to('https://campaigns.zoho.eu/api/v1.1/json/listsubscribe?resfmt=JSON&listkey=96f1a2e34b3b071ed93877410c169ea81185630859ca1fd0&contactinfo=%7BFirstName%3A' . $fname . '%2CLastName%3A' . $lname . '%2CContact+Email%3A' . $email . '%2COccID%3A' . $request->OccID . '%2CMemberType%3A' . $status . '%2CMobile%3A' . $mobile . '%7D')
            ->withHeaders(array('Authorization' => 'Zoho-oauthtoken ' . $accesstoken->access_token, 'Content-Type' => ' application/x-www-form-urlencoded'))
            ->post();*/
//        dd($adduser);


        // return $request;
        // return strlen($request->HCP);
        // return (strlen($request->HCP) <= 3) ? $request->HCP . ',0' : str_replace(".", ",", $request->HCP);
        // return str_replace(',', ',', $request->HCP);
        // $hcp = ;
        $new_hcp = '';
        $new_handicap = '';
        if (strpos($request->HCP, ',') !== false) {
            // echo 'true';
            $new_hcp = $request->HCP;
        } else {
            $new_hcp = (strlen($request->HCP) <= 3) ? $request->HCP . ',0' : str_replace(".", ",", $request->HCP);
        }
        if (strpos($request->handicap, ',') !== false) {
            // echo 'true';
            $new_handicap = $request->handicap;
        } else {
            $new_handicap = (strlen($request->handicap) <= 3) ? $request->handicap . ',0' : str_replace(".", ",", $request->handicap);
        }

        if ($request->hidden_hcp != $request->HCP) {
            $updateData = [
                    'Member_Fistname' => $request->Member_Fistname,
                    'Member_Lastname' => $request->Member_Lastname,
                    'OccID' => $request->OccID,
                    // 'HCP' => str_replace(',', ',', $request->HCP), //str_replace('').'.0';
                    'HCP' => $new_hcp, //str_replace('').'.0';
                    'new_hcp' => $new_hcp, //str_replace('').'.0';
                    'member_type' => ($request->member_type == 'Select') ? null : $request->member_type,
                    'address1' => $request->address1,
                    'address2' => $request->address2,
                    'zipcode' => $request->zipcode,
                    'city' => $request->city,
                    'email' => $tmp_mail_input,
                    'email_billing' => $tmp_billing_mail_input,
                    'tel_privately' => $request->tel_privately,
                    'tel_jobs' => $request->tel_jobs,
                    'phone_mobile' => $request->phone_mobile,
                    'sms_news_letter' => (isset($request->sms_news_letter)) ? 1 : 0,
                    'sex' => ($request->sex == 'Select') ? null : $request->sex,
                    'handicap' => $new_handicap,
                    'stock_number' => $request->stock_number,
                    'playing_eligibility' => $request->playing_eligibility,
                    'date_of_birth' => $request->date_of_birth,
                    'member_since' => $request->member_since,
                    'resignation_date' => $request->resignation_date,
                    'additional_info' => $request->additional_info,
                    'family_head' => $request->family_head,
                    'family_head_name' => $request->family_head_name,
                    'family_head_no' => $request->family_head_no,
                    'shareholder_name' => $request->shareholder_name,
                    'shareholder_member_no' => $request->shareholder_member_no,
                    'wardrobe' => $request->wardrobe,
                    'drinks_cabinet' => $request->drinks_cabinet,
                    'stick_cabinet' => $request->stick_cabinet,
                    'car' => $request->car,
                    'charging_site' => $request->charging_site,
                    'trolley_space' => $request->trolley_space,
                    'share_type' => ($request->share_type == 'Select') ? '' : $request->share_type,
                    'share_number' => $request->share_number,
                ];

                if(!isset($mem->share_from) && isset($request->share_from))
                    $updateData['share_from'] = $request->share_from;
                if(!isset($mem->share_name) && isset($request->share_name))
                    $updateData['share_name'] = $request->share_name;
                if(!isset($mem->share_to) && isset($request->share_to))
                    $updateData['share_to'] = $request->share_to;

            DB::table('members')
                ->where('MemberID', $request->memberid)
                ->update($updateData);
            $member = Members::where('OccID', $request->OccID)->first()->toArray();
            $hcpreg = HcpRegitar::where('OccID', $request->OccID)->get();

            if ($member['email'] != '') {

                $member_name = $member['Member_Fistname'] . ' ' . $member['Member_Lastname'];
                $member_email = $member['email'];
                Mail::send('email.resethcp', ['member_name' => $member_name, 'member_email' => $member_email, 'hcp' => $hcpreg], function ($message) use ($member_email) {


                    $message->subject('OCC-GOLF APP');
                    $message->to($member_email);
                });
            }
            // $hcpreg = HcpRegitar::where('OccID', $request->OccID)->delete();
            DB::table('hcp_regitars')
                ->where('OccID', $request->OccID)
                ->update([
                    'hcp_status' => '0'
                ]);
            DB::table('members')
                ->where('OccID', $request->OccID)
                ->update([
                    'new_hcp' => $new_hcp,
                    'new_club' => 'OCC Golf',
                    'counted' => '0'
                ]);
            return response()->json([
                'success' => true,
//                'adduser' => $adduser
            ]);
        }
        else {
            $updateData = [
                    'Member_Fistname' => $request->Member_Fistname,
                    'Member_Lastname' => $request->Member_Lastname,
                    'OccID' => $request->OccID,
                    // 'HCP' => str_replace(',', ',', $request->HCP), //str_replace('').'.0';
                    'HCP' => $new_hcp, //str_replace('').'.0';
                    'new_hcp' => $new_hcp, //str_replace('').'.0';
                    'member_type' => ($request->member_type == 'Select') ? null : $request->member_type,
                    'address1' => $request->address1,
                    'address2' => $request->address2,
                    'zipcode' => $request->zipcode,
                    'city' => $request->city,
                    'email' => $tmp_mail_input,
                    'email_billing' => $tmp_billing_mail_input,
                    'tel_privately' => $request->tel_privately,
                    'tel_jobs' => $request->tel_jobs,
                    'phone_mobile' => $request->phone_mobile,
                    'sms_news_letter' => (isset($request->sms_news_letter)) ? 1 : 0,
                    'sex' => ($request->sex == 'Select') ? null : $request->sex,
                    'handicap' => $new_handicap,
                    'stock_number' => $request->stock_number,
                    'playing_eligibility' => $request->playing_eligibility,
                    'date_of_birth' => $request->date_of_birth,
                    'member_since' => $request->member_since,
                    'resignation_date' => $request->resignation_date,
                    'additional_info' => $request->additional_info,
                    'family_head' => $request->family_head,
                    'family_head_name' => $request->faamily_head_name,
                    'family_head_no' => $request->family_head_no,
                    'shareholder_name' => $request->shareholder_name,
                    'shareholder_member_no' => $request->shareholder_member_no,
                    'wardrobe' => $request->wardrobe,
                    'drinks_cabinet' => $request->drinks_cabinet,
                    'stick_cabinet' => $request->stick_cabinet,
                    'car' => $request->car,
                    'charging_site' => $request->charging_site,
                    'trolley_space' => $request->trolley_space,
                    'share_type' => $request->share_type,
                    'share_number' => $request->share_number,
                ];
                if(!isset($mem->share_from) && isset($request->share_from))
                    $updateData['share_from'] = $request->share_from;
                if(!isset($mem->share_name) && isset($request->share_name))
                    $updateData['share_name'] = $request->share_name;
                if(!isset($mem->share_to) && isset($request->share_to))
                    $updateData['share_to'] = $request->share_to;
            DB::table('members')
                ->where('MemberID', $request->memberid)
                ->update($updateData);
            $member = Members::where('OccID', $request->OccID)->first()->toArray();
            $hcpreg = HcpRegitar::where('OccID', $request->OccID)->get();

            // if ($member['email'] != '') {

            //     $member_name = $member['Member_Fistname'] . ' ' . $member['Member_Lastname'];
            //     $member_email = $member['email'];
            //     Mail::send('email.resethcp', ['member_name' => $member_name, 'member_email' => $member_email, 'hcp' => $hcpreg], function ($message) use ($member_email) {


            //         $message->subject('OCC-GOLF APP');
            //         $message->to($member_email);
            //     });
            // }
            $hcpreg = HcpRegitar::where('OccID', $request->OccID)->delete();
            DB::table('members')
                ->where('OccID', $request->OccID)
                ->update([
                    'new_hcp' => $new_hcp,
                    'new_club' => 'OCC Golf',
                    'counted' => '0'
                ]);

            if($mem->member_type !== $request->member_type) {
                $this->member_update_log($mem->MemberID, 'member_type', $mem->member_type, $request->member_type);
            }
            if(isset($request->log_note) && !empty($request->log_note)) {
                $this->member_update_log($mem->MemberID, 'notes', null, $request->log_note);
            }
            if((isset($request->share_type) && ($mem->share_type !== $request->share_type) && ($request->share_type !== 'Select')) || (isset($mem->share_type) && !isset($request->share_type))) {
                $this->member_update_log($mem->MemberID, 'share_type', $mem->share_type, $request->share_type);
            }
            if((isset($request->share_number) && ($mem->share_number !== $request->share_number)) || (isset($mem->share_number) && !isset($request->share_number))) {
                $this->member_update_log($mem->MemberID, 'share_number', $mem->share_number, $request->share_number);
            }
            if((isset($tmp_mail_input) && ($mem->email !== $tmp_mail_input)) || (isset($mem->email) && !isset($tmp_mail_input))) {
                $this->member_update_log($mem->MemberID, 'email', $mem->email, $tmp_mail_input);
            }
            /*Phone Numbers*/
            if((isset($request->tel_privately) && ($mem->tel_privately !== $request->tel_privately)) || (isset($mem->tel_privately) && !isset($request->tel_privately))) {
                $this->member_update_log($mem->MemberID, 'tel_privately', $mem->tel_privately, $request->tel_privately);
            }
            if((isset($request->tel_jobs) && ($mem->tel_jobs !== $request->tel_jobs)) || (isset($mem->tel_jobs) && !isset($request->tel_jobs))) {
                $this->member_update_log($mem->MemberID, 'tel_jobs', $mem->tel_jobs, $request->tel_jobs);
            }
            if((isset($request->phone_mobile) && ($mem->phone_mobile !== $request->phone_mobile)) || (isset($mem->phone_mobile) && !isset($request->phone_mobile))) {
                $this->member_update_log($mem->MemberID, 'phone_mobile', $mem->phone_mobile, $request->phone_mobile);
            }
            /*Facilities*/
            if((isset($request->wardrobe) && ($mem->wardrobe !== $request->wardrobe)) || (isset($mem->wardrobe) && !isset($request->wardrobe))) {
                $this->member_update_log($mem->MemberID, 'wardrobe', $mem->wardrobe, $request->wardrobe);
            }
            if((isset($request->drinks_cabinet) && ($mem->drinks_cabinet !== $request->drinks_cabinet)) || (isset($mem->drinks_cabinet) && !isset($request->drinks_cabinet))) {
                $this->member_update_log($mem->MemberID, 'drinks_cabinet', $mem->drinks_cabinet, $request->drinks_cabinet);
            }
            if((isset($request->trolley_space) && ($mem->trolley_space !== $request->trolley_space)) || (isset($mem->trolley_space) && !isset($request->trolley_space))) {
                $this->member_update_log($mem->MemberID, 'trolley_space', $mem->trolley_space, $request->trolley_space);
            }
            if((isset($request->charging_site) && ($mem->charging_site !== $request->charging_site)) || (isset($mem->charging_site) && !isset($request->charging_site))) {
                $this->member_update_log($mem->MemberID, 'charging_site', $mem->charging_site, $request->charging_site);
            }
            if((isset($request->stick_cabinet) && ($mem->stick_cabinet !== $request->stick_cabinet)) || (isset($mem->stick_cabinet) && !isset($request->stick_cabinet))) {
                $this->member_update_log($mem->MemberID, 'stick_cabinet', $mem->stick_cabinet, $request->stick_cabinet);
            }


            return response()->json([
                'success' => true,
//                'adduser' => $adduser
            ]);
        }

        // $Members = Members::where('MemberID',$request->memberid);
        // //$Members->MemberName = $request->MemberFistName.' '.$request->MemberLastName;
        // $Members->Member_Fistname=$request->MemberFistName;
        // $Members->Member_Lastname=$request->MemberLastName;
        // $Members->OccID =$request->OccID;
        // $Members->HCP = str_replace(',', '.', $request->HCP);//str_replace('').'.0';
        // //upgration code
        // $Members->member_type=$request->member_type;
        // $Members->address1=$request->address1;
        // $Members->address2=$request->address2;
        // $Members->zipcode=$request->zipcode;
        // $Members->city=$request->city;
        // $Members->email=$request->email;
        // $Members->tel_privately=$request->tel_privately;
        // $Members->tel_jobs=$request->tel_jobs;
        // $Members->phone_mobile=$request->phone_mobile;
        // $Members->sex=$request->sex;
        // $Members->handicap=$request->handicap;
        // $Members->stock_number=$request->stock_number;
        // $Members->playing_eligibility=$request->playing_eligibility;
        // $Members->date_of_birth=$request->date_of_birth;
        // $Members->member_since=$request->member_since;
        // $Members->resignation_date=$request->resignation_date;
        // $Members->additional_info=$request->additional_info;
        // $Members->family_head=$request->family_head;
        // $Members->family_head_name=$request->family_head_name;
        // $Members->family_head_no=$request->family_head_no;
        // $Members->shareholder_name=$request->shareholder_name;
        // $Members->shareholder_member_no=$request->shareholder_member_no;
        // $Members->wardrobe=$request->wardrobe;
        // $Members->drinks_cabinet=$request->drinks_cabinet;
        // $Members->stick_cabinet=$request->stick_cabinet;
        // $Members->car =$request->car ;
        // $Members->charging_site=$request->charging_site;
        // $Members->trolley_space=$request->trolley_space;

        // $Members->save();

    }

    public function memberedits($id)
    {
        $members = Members::where('MemberID', $id)->first();
        $getchild = substr($members->OccID, -3);
        $getallchilds = Members::where('OccID', "LIKE", "%{$getchild}")->whereNull('signup_status')->orderBy('OccID', 'asc')->get();

        /* Member Changes Log */
        $logs = MemberChangesLog::select('m.MemberID', 'm.OccID', 'm.Member_Fistname', 'm.Member_Lastname', 'member_changes_logs.*')
                                ->join('members as m', 'm.MemberID',  '=', 'log_member_id')
                                ->where('m.MemberID', $members->MemberID)
                                ->orderBy('log_timestamp', 'DESC')
                                ->get();
        // return $getallchilds;
        return view('member_info', compact('members', 'getallchilds', 'logs'));
    }
    //edit end

    public function adminpage(Request $request)
    {
        $request->session()->forget('kiosk_mode');
        $status1 = array();
        $member_status = Members::groupBy('member_type')->pluck('member_type');
        $total_email_count = Members::distinct()->count('email');
        $newsInfo = NewsInfo::first();
        $count = array();
        $email_counts = array();
        foreach ($member_status as $key => $value) {
            $member_status_count = Members::where('member_type', $value)->where('OccID', "NOT LIKE", "%_999")->get()->count();
            $email_count = Members::where('member_type', $value)->distinct()->count('email');
            if ($value == 'Aktiv Livsvarig') {
                $count[] = $member_status_count;
            }
//            if ($value == 'Aktiv Evigvarende') {
//                $count[] = $member_status_count;
//            }
            if ($value == 'Aktive') {
                $count[] = $member_status_count;
            }
            if ($value == 'Eldre Junior') {
                $count[] = $member_status_count;
            }
            if ($value == 'Junior') {
                $count[] = $member_status_count;
            }
            if ($value == 'Midlertidig Medlem') {
                $count[] = $member_status_count;
            }
//            if ($value == 'Andel venteliste') {
//                $count[] = $member_status_count;
//            }
            $status1[$value] = $member_status_count;
            $email_counts[$value] = $email_count;
        }
        $sum = array_sum($count);
        $status1['Total Sum'] = $sum;
        // $email_counts['Total Sum'] = $total_email_count;
        $email_counts['Total Sum'] = '';
        $b = array();
        $b = array(
            'Aktiv Livsvarig',
            'Aktive', 'Eldre Junior',
            'Junior',
            'Midlertidig Medlem',
            'Total Sum',
            'Aktiv Evigvarende',
            'Andel uten medlemskap',
            'Andel venteliste',
            'Aktiv Uten Spillerett',
            'Sponsor',
            'Passiv',
            'Slettet'
        );
        foreach ($b as $index) {
            // return $b;
            if (!empty($status1[$index])) {

                $status[$index] = $status1[$index];
            }
            else {
                $status[$index] = 0;
            }
        }
        // return $status;
        return view('admin', compact('status', 'sum', 'email_counts', 'newsInfo'));
    }

    public function reportdata(Request $request)
    {
        return view('report');
    }

    public function nowreport(Request $request)
    {
        $database = Reg::whereDate('reg_time', date('y-m-d'))
                        ->leftJoin('members', 'members.MemberID', '=', 'registrations.reg_member_id')
                        ->whereNull('reg_guest_member')
                        ->where('status', 1)
                        // ->whereNull('reg_registration_type')
                        ->orderBy('reg_auto', 'desc')
                        ->limit(75)
                        ->get();
                        // dd($database->toArray());
        return view('nowreport')->with('report', $database);
    }

    public function todayreport(Request $request)
    {
        $today = Carbon::now()->format('Y-m-d');
        $playerCount['visited'] = Reg::whereDate('reg_time', $today)
                                        ->where('status', 1)
                                        ->where(function ($where) {
                                            $where->whereNotNull('reg_member_id');
                                            $where->whereNull('reg_registration_type');
                                        })
                                        ->count();

        $playerCount['not_visited'] = Reg::whereDate('reg_time', $today)
                                        ->where('status', 1)
                                        ->where(function ($where) {
                                            $where->where('reg_registration_type', 'Guest Play');
                                            $where->orWhereNull('reg_member_id');
                                        })
                                        ->count();
        // dd($playerCount,  $today);
        $allyear = Reg::where(function($where) use($today) {
                            $where->whereDate('reg_time', $today);
                            $where->whereNull('reg_guest_member');
                            $where->whereNull('reg_registration_type');
                            $where->where('status', 1);
                        })
                        ->orWhere(function($where) use($today) {
                            $where->whereDate('reg_time', $today);
                            $where->whereNull('reg_guest_member');
                            $where->where('reg_registration_type', 'Guest Play');
                            $where->where('status', 1);
                        })   
                        ->leftJoin('members', 'members.MemberID', '=', 'registrations.reg_member_id')
                        ->groupBy(DB::raw('reg_registration_type, reg_phone, COALESCE(reg_guest_member),reg_member_id'))
                        ->orderBy('reg_auto','desc')
                        ->orderBy('Member_Lastname')
                        ->get();
        // dd($allyear->toArray());
        return view('todayreport')->with(compact('playerCount', 'allyear'));
    }

    public function month(Request $request)
    {
        $startMonth = Carbon::now()->subDays(30)->format('Y-m-d H:i:s');
        $endMonth = Carbon::now()->format('Y-m-d H:i:s');

        $playerCount['visited'] = Reg::whereBetween('reg_time', [$startMonth, $endMonth])
                                    ->where('status', 1)
                                    ->where(function ($where) {
                                        $where->whereNotNull('reg_member_id');
                                        $where->whereNull('reg_registration_type');
                                    })
                                    ->count();

        $playerCount['not_visited'] = Reg::whereBetween('reg_time',[$startMonth, $endMonth])
                                        ->where('status', 1)
                                        ->where(function ($where) {
                                            $where->where('reg_registration_type', 'Guest Play');
                                            $where->orWhereNull('reg_member_id');
                                        })
                                        ->count();

        $allyear = Reg::where(function($where) use($startMonth, $endMonth) {
                            $where->whereBetween('reg_time', [$startMonth, $endMonth]);
                            $where->where('status', 1);
                            $where->whereNull('reg_guest_member');
                            $where->whereNull('reg_registration_type');
                        })
                        ->orWhere(function($where) use($startMonth, $endMonth) {
                            $where->whereBetween('reg_time', [$startMonth, $endMonth]);
                            $where->where('status', 1);
                            $where->whereNull('reg_guest_member');
                            $where->whereNotNull('reg_registration_type');
                        })
                        ->leftJoin('members', 'members.MemberID','=', 'registrations.reg_member_id')
                        ->groupBy(DB::raw('reg_registration_type, reg_phone, COALESCE(reg_guest_member),reg_member_id'))
                        ->orderBy('reg_auto','DESC')
                        ->orderBy('Member_Lastname')
                        ->get();
                        // dd($allyear->groupBy('MemberID')->toArray());
                        // dd($allyear->toArray());

        return view('monthreport')->with(compact('playerCount', 'allyear'));
    }

    public function week(Request $request)
    {
        $date = Carbon::now()->format('Y-m-d H:i:s');
        $date_chek = Carbon::now()->subDays(7)->format('Y-m-d H:i:s');

        $playerCount['visited'] = Reg::whereBetween('reg_time', [$date_chek, $date])
                                    ->where('status', 1)
                                    ->where(function ($where) {
                                        $where->whereNotNull('reg_member_id');
                                        $where->whereNull('reg_registration_type');
                                    })
                                    ->count();

        $playerCount['not_visited'] = Reg::whereBetween('reg_time', [$date_chek, $date])
                                    ->where('status', 1)
                                    ->where(function ($where) {
                                        $where->WhereNull('reg_member_id');
                                        $where->orWhere('reg_registration_type', 'Guest Play');
                                    })
                                    ->count();

        $allyear = Reg::where(function($where) use($date_chek, $date) {
                            $where->where('status', 1);
                            $where->whereBetween('reg_time', [$date_chek, $date]);
                            $where->whereNull('reg_guest_member');
                            $where->whereNull('reg_registration_type');
                        })
                        ->orWhere(function($where) use($date_chek, $date) {
                            $where->where('status', 1);
                            $where->whereBetween('reg_time', [$date_chek, $date]);
                            $where->whereNull('reg_guest_member');
                            $where->whereNotNull('reg_registration_type');
                        })
                        // ->where(function($where) {
                        //     $where->whereNull('reg_guest_member');
                        //     $where->whereNull('reg_registration_type');
                        // })
                        // ->orWhere(function($where) {
                        //     $where->whereNull('reg_guest_member');
                        //     $where->whereNotNull('reg_registration_type');
                        // })
                        ->leftJoin('members', 'members.MemberID', '=', 'registrations.reg_member_id')
                        ->groupBy(DB::raw('reg_registration_type, reg_phone, COALESCE(reg_guest_member),reg_member_id'))
                        ->orderBy('reg_auto','DESC')
                        ->orderBy('Member_Lastname')
                        ->get();


                                    // dd($allyear, $playerCount, [$date_chek, $date]);

        return view('weekreport')->with(compact('playerCount', 'allyear'));
    }

    public function member(Request $request)
    {
        $membername    = Members::whereNull('signup_status')->orderBy('MemberID', 'DESC')->get();
        $pendingMember = null;
        if(isset($request->m))
            $pendingMember = Members::where('signup_token', $request->m)->where('signup_status', 'pending')->first();
        $memberSignup    = Members::orderBy('signup_date', 'DESC')
            ->get()
            ->groupBy('signup_status')
            ->toArray();
        return view('member')->with(compact('membername', 'memberSignup', 'pendingMember'));
    }

    public function club(Request $request)
    {
        return view('reportclub');
    }

    public function addclub(Request $request)
    {
        $database    =    club::where('ClubName', '=', $request->ClubName)->get();
        if (!$database->isNotEmpty()) :
            $reg = new club;
            $reg->ClubName = $request->ClubName;
            $reg->save();
            // return redirect()->back()->with('success', ['successfully']);
            return response()->json([
                'success' => true
            ]);

        else :
            return response()->json([
                'error' => true
            ]);
        endif;
    }

    public function reportmember(Request $request)
    {
        return view('reportmember');
    }

    public function guestreport(Request $request)
    {





        /*$guestname = Reg::whereNull('reg_member_id')
								->whereYear('created_at', date('Y'))
								->select('*',DB::raw('count("reg_fistname") as counts'))
								->groupBy('reg_fistname')
								->groupBy('reg_lastname')
								->orderBy('counts','desc')
								->get();*/
        /*$phone = Reg::whereNull('reg_member_id')
								->whereNotNull('reg_phone')
								->whereYear('created_at', date('Y'))
								->select('*',DB::raw('count("reg_phone") as counts'))
								->groupBy('reg_phone')
								//->orderBy('counts','desc')
								->orderBy('reg_fistname')
								->get();
				*/

        $phone =    $gest  = Reg::where(function ($where) {
                                    $where->whereNull('reg_member_id');
                                    $where->orwhere('reg_registration_type', 'Guest Play');
                                })
                                ->where('status', 1)
                                ->whereYear('reg_time', date('Y'))
                                ->select('*', DB::raw('count("reg_fistname,reg_phone") as counts'))
                               // ->distinct('reg_phone')
                               // ->groupBy('reg_phone')
                                ->groupBy(['reg_phone', 'reg_fistname'])
                               // ->groupBy('reg_lastname')
                                ->orderBy('reg_fistname')
                                ->get();


        /*foreach($phone as $service){
              	$notphone = Reg::where('reg_fistname','=',utf8_encode(substr($service->reg_fistname, 0,4)))
			 		  	 ->where('reg_lastname','=',utf8_encode(substr($service->reg_lastname, 0,4)))
						->groupBy('reg_club')
						 ->get();
					'DISTINCT name'
                }

				//return dd($notphone);






			//$servicePage);
			/*$nophonnumer = Reg::whereNull('reg_member_id')
								->whereNotNull('reg_phone')
								->whereYear('created_at', date('Y'))
								->select('*',DB::raw('count("reg_fistname") as counts'))
								->groupBy('reg_phone')
								->orderBy('counts','desc')
								->get(); */
        //$findlatter = Res::where()



        //return dd($phone);

        return view('guest')->with(compact('phone'));
    }

    public function check_member(Request $request)
    {
        $Members = Members::where('OccID', '=', $request->OccID)
            ->first();
        $check_group = substr($request->OccID, -3);
        $all_mems = Members::pluck('OccID', 'MemberID');
        $mem_all = array();
        foreach ($all_mems as $key => $all_mem) {
            $check_group_db = substr($all_mem, -3);
            if ($check_group == $check_group_db) {
                array_push($mem_all, $key);
            }
        }
        $first_names = Members::whereIn('MemberID', $mem_all)->get()->toArray();
        // $last_names = Members::whereIn('MemberID',$mem_all)->get('Member_Lastname')->toArray();
        $names = array();
        foreach ($first_names as $key => $value) {
            $names[] = $value['Member_Fistname'] . ' ' . $value['Member_Lastname'];
        }
        if (!empty($Members)) :
            return response()->json([
                'success' => true,
                'message' => 'alert',
                'first_names' => $names,
                // 'last_names' =>$last_names

            ]);
        else :
            return response()->json([
                'success' => false,
                'message' => 'submit'
            ]);
        endif;
        // return $Members;
    }

    public function addmemberdata(Request $request)
    {
        $dataUnique = [];
        $data = [
            'Member_Fistname' => $request->MemberFistName,
            'Member_Lastname' => $request->MemberLastName,
            'OccID' => $request->OccID,
            'HCP' => (strlen($request->HCP) <= 3) ? $request->HCP . ',0' : str_replace(".", ",", $request->HCP),
        ];
            $tmp_mail_input = null;
            $tmp_billing_mail_input = null;
            if(isset($request->email)) $tmp_mail_input = $request->email;
            else {
                if(isset($request->email_billing)) $tmp_mail_input = $request->email_billing;
            }
            if(isset($request->email_billing)) $tmp_billing_mail_input = $request->email_billing;
            else {
                if(isset($request->email)) $tmp_billing_mail_input = $request->email;
            }

        $data['member_type'] = ($request->member_type == 'Select') ? null : $request->member_type;
        $data['address1'] = $request->address1;
        $data['address2'] = $request->address2;
        $data['zipcode'] = $request->zipcode;
        $data['city'] = $request->city;

        $data['email'] = $tmp_mail_input;
        $data['email_billing'] = $tmp_billing_mail_input;

        $data['tel_privately'] = $request->tel_privately;
        $data['tel_jobs'] = $request->tel_jobs;
        $data['phone_mobile'] = $request->phone_mobile;
        $data['sms_news_letter'] = (isset($request->sms_news_letter)) ? 1 : 0;
        $data['sex'] = ($request->sex == 'Select') ? null : $request->sex;
        $data['handicap'] = $request->handicap;
        $data['stock_number'] = $request->stock_number;
        $data['playing_eligibility'] = $request->playing_eligibility;
        $data['date_of_birth'] = $request->date_of_birth;
        $data['member_since'] = $request->member_since;
        $data['resignation_date'] = $request->resignation_date;
        $data['additional_info'] = $request->additional_info;
        $data['family_head'] = $request->family_head;
        $data['family_head_name'] = $request->family_head_name;
        $data['family_head_no'] = $request->family_head_no;
        $data['shareholder_name'] = $request->shareholder_name;
        $data['shareholder_member_no'] = $request->shareholder_member_no;
        $data['wardrobe'] = $request->wardrobe;
        $data['drinks_cabinet'] = $request->drinks_cabinet;
        $data['stick_cabinet'] = $request->stick_cabinet;
        $data['car'] = $request->car;
        $data['charging_site'] = $request->charging_site;
        $data['trolley_space'] = $request->trolley_space;
        $data['share_type'] = $request->share_type;
        $data['share_number'] = $request->share_number;
        $data['share_from'] = $request->share_from;
        $data['share_name'] = $request->share_name;
        $data['share_to'] = $request->share_to;

        if(isset($request->m)) {
            $signnedupMember = Members::where('signup_token', $request->m)->whereNotNull('signup_status')->first();
            if(!isset($signnedupMember)) {
                return response()->json([
                    'success' => false,
                    'alert_title' => 'Error!',
                    'alert_message' => 'Signnedup Member Not Found.',
                    'redirect' => true,
                ]);
            }
            else {
                $dataUnique['signup_token'] = $signnedupMember->signup_token;
                if($request->submit == 'save'){
                    $data['signup_status'] = 'pending';
                }
                elseif($request->submit == 'add') {
                    $data['signup_status'] = null;
                    $data['resignation_date'] = Carbon::now()->format('Y-m-d H:i:s');
                }
                elseif($request->submit == 'declined') {
                    $data = [];
                    $data['signup_status'] = 'declined';
                    $data['signup_date'] = Carbon::now()->format('Y-m-d H:i:s');
                }
            }
        }
        else {
            if($request->submit == 'save'){
                $dataUnique['signup_token'] = $this->createMemberSignupReference(20);
                $data['signup_status'] = 'pending';
                $data['signup_date'] = Carbon::now()->format('Y-m-d H:i:s');
            }
            elseif($request->submit == 'add') {
                $data['signup_status'] = null;
                $data['resignation_date'] = Carbon::now()->format('Y-m-d H:i:s');
            }
        }

        if($request->submit == 'save') {
            Members::updateOrCreate($dataUnique, $data);
            return response()->json([
                'success' => true,
                'alert_title' => 'Success',
                'alert_message' => 'Member saved as pending Successfully.',
                'redirect' => true,
            ]);
        }
        elseif($request->submit == 'declined') {
            Members::updateOrCreate($dataUnique, $data);
            return response()->json([
                'success' => true,
                'alert_title' => 'Declined',
                'alert_message' => 'Member DECLINED Successfully.',
                'redirect' => true,
                'redirect_url' => route('member.add.view'),
            ]);
        }
        elseif($request->submit == 'add') {
            if(!isset($request->OccID)) {
                return response()->json([
                    'success' => false,
                    'alert_title' => 'Error!',
                    'alert_message' => 'OccId is Required.',
                    'redirect' => false,
                ]);
            }
            if(!isset($request->member_type)) {
                return response()->json([
                    'success' => false,
                    'alert_title' => 'Error!',
                    'alert_message' => 'Member Type is Required.',
                    'redirect' => false,
                ]);
            }
            if(!isset($request->HCP)) {
                return response()->json([
                    'success' => false,
                    'alert_title' => 'Error!',
                    'alert_message' => 'HCP Online is Required.',
                    'redirect' => false,
                ]);
            }

            $this->makeOccOld($request->OccID);
            if(!empty($dataUnique)) Members::updateOrCreate($dataUnique, $data);
            else Members::create($data);

            $cha = array('!', '#', '$', '%', '&', '(', ')', '*', '+', ',', '-', '.', '/', ':', ';', '<', '=', '>', '?', '[', "]", '^', '_', '`', '{', '|', '}', '~', '¡', '¢', '£', '¤', '¥', '¦', '§', '¨', '©', 'ª', '«', '¬', '®', '¯', '°', '±', '²', '³', '´', 'µ', '¶', '·', '¸', '¹', 'º', '»', '¼', '½', '¾', '¿', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ð', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', '×', 'Ø', 'Ù', 'Ú', 'Û', 'Ü', 'Ý', 'Þ', 'ß', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ð', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', '÷', 'ø', 'ù', 'ú', 'û', 'ü', 'ý', 'þ', 'ÿ');

            $utf = array('%21', '%23', '%24', '%25', '%26', '%28', '%29', '%2a', '%2b', '%2c', '%2d', '%2e', '%2f', '%3a', '%3b', '%3c', '%3d', '%3e', '%3f', '%5b', '%5d', '%5e', '%5f', '%60', '%7b', '%7c', '%7d', '%7e', '%c2%a1', '%c2%a2', '%c2%a3', '%c2%a4', '%c2%a5', '%c2%a6', '%c2%a7', '%c2%a8', '%c2%a9', '%c2%aa', '%c2%ab', '%c2%ac', '%c2%ae', '%c2%af', '%c2%b0', '%c2%b1', '%c2%b2', '%c2%b3', '%c2%b4', '%c2%b5', '%c2%b6', '%c2%b7', '%c2%b8', '%c2%b9', '%c2%ba', '%c2%bb', '%c2%bc', '%c2%bd', '%c2%be', '%c2%bf', '%c3%80', '%c3%81', '%c3%82', '%c3%83', '%c3%84', '%c3%85', '%c3%86', '%c3%87', '%c3%88', '%c3%89', '%c3%8a', '%c3%8b', '%c3%8c', '%c3%8d', '%c3%8e', '%c3%8f', '%c3%90', '%c3%91', '%c3%92', '%c3%93', '%c3%94', '%c3%95', '%c3%96', '%c3%97', '%c3%98', '%c3%99', '%c3%9a', '%c3%9b', '%c3%9c', '%c3%9d', '%c3%9e', '%c3%9f', '%c3%a0', '%c3%a1', '%c3%a2', '%c3%a3', '%c3%a4', '%c3%a5', '%c3%a6', '%c3%a7', '%c3%a8', '%c3%a9', '%c3%aa', '%c3%ab', '%c3%ac', '%c3%ad', '%c3%ae', '%c3%af', '%c3%b0', '%c3%b1', '%c3%b2', '%c3%b3', '%c3%b4', '%c3%b5', '%c3%b6', '%c3%b7', '%c3%b8', '%c3%b9', '%c3%ba', '%c3%bb', '%c3%bc', '%c3%bd', '%c3%be', '%c3%bf');
            // return $members;
            $refreshtoken = Curl::to('https://accounts.zoho.eu/oauth/v2/token?client_id=1000.1YXS76ZSU7T05KEB0E2EO5J9SUF52R&grant_type=authorization_code&client_secret=c1134f8e0ad2a325fd0dce8b298dac5c3f1cbe4c8e&redirect_uri=http://occ.local/admin&code=1000.b6cd301d1520e1b9bc7cae3ff6b2eb14.6e470ee6737637eef6c0db0bbc8bd49f')
                ->post();

            $accesstoken = Curl::to('https://accounts.zoho.eu/oauth/v2/token?client_id=1000.1YXS76ZSU7T05KEB0E2EO5J9SUF52R&grant_type=refresh_token&client_secret=c1134f8e0ad2a325fd0dce8b298dac5c3f1cbe4c8e&refresh_token=1000.23a03a7eb131587a1b430d1c53abe164.cd2c78fbb110614edc600a7943902622')
                ->post();

            $accesstoken = json_decode($accesstoken);


            $maillist = Curl::to('https://campaigns.zoho.eu/api/v1.1/getmailinglists?resfmt=JSON')
                ->withHeader('Authorization:Zoho-oauthtoken ' . $accesstoken->access_token)
                ->get();


            $fname = ($request->MemberFistName != null) ? str_replace(' ', '+', $request->MemberFistName) : "-";
            $lname = ($request->MemberLastName != null) ? str_replace(' ', '+', $request->MemberLastName) : "-";
            $status = ($request->member_type == 'Select') ? '-' : str_replace(' ', '+', $request->member_type);

            // $status = ($request->member_type == 'Select') ? '-' : $request->member_type;
            $email = ($request->email != null) ? $request->email : '-';
            for ($x = 0; $x < count($cha); $x++) {
                $fname = str_replace($cha[$x], $utf[$x], $fname);
                $lname = str_replace($cha[$x], $utf[$x], $lname);
            }



            // $adduseremail = Curl::to('https://campaigns.zoho.eu/api/v1.1/addlistsubscribersinbulk?listkey=96f1a2e34b3b071e2c4c6286194d1efdcbad3f9c5f6454d4&resfmt=JSON&emailids='.$email)
            // ->withHeaders(array('Authorization'=>'Zoho-oauthtoken '.$accesstoken->access_token,'Content-Type'=>' application/x-www-form-urlencoded'))
            // ->post();

            /*$adduser = Curl::to('https://campaigns.zoho.eu/api/v1.1/json/listsubscribe?resfmt=JSON&listkey=96f1a2e34b3b071ed93877410c169ea81185630859ca1fd0&contactinfo=%7BFirstName%3A' . $fname . '%2CLastName%3A' . $lname . '%2CContact+Email%3A' . $email . '%2COccID%3A' . $request->OccID . '%2CMemberType%3A' . $status . '%7D')
                ->withHeaders(array('Authorization' => 'Zoho-oauthtoken ' . $accesstoken->access_token, 'Content-Type' => ' application/x-www-form-urlencoded'))
                ->post();*/

            return response()->json([
                'success' => true,
                'alert_title' => 'Success',
                'alert_message' => 'Member registered Successfully.',
                'redirect' => true,
                'redirect_url' => route('member.add.view'),
            ]);
        }
    }

    public function makeOccOld($occId) {
        $check_group = substr($occId, -3);
        $check_group_lead = substr($occId, 0, 2);
        if ($check_group_lead == "10") {
            $all_mems = Members::whereNull('signup_status')->pluck('OccID', 'MemberID');
            foreach ($all_mems as $key => $all_mem) {
                $check_group_db = substr($all_mem, -3);
                if ($check_group == $check_group_db) {
                    $old_mem = Members::where('MemberID', $key)->first();
                    // return str_replace($check_group_db,"00",$all_mem).$check_group_db;
                    $mem_up = Members::where('MemberID', $key)
                        ->update([
                            'OccID' => str_replace($check_group_db, "00", $all_mem) . $check_group_db,
                            'member_type' => 'Slettet',
                            'expire_date' => date('Y-m-d')

            ]);
                    $hcpregitars = HcpRegitar::where('OccID', $all_mem)
                        ->update([
                            'OccID' => str_replace($check_group_db, "00", $all_mem) . $check_group_db,

                        ]);

                    /* Member Changes Log */
                    $this->member_update_log($key, 'OccID', $old_mem->OccID,
                        str_replace($check_group_db, "00", $all_mem) . $check_group_db
                    );
                    $this->member_update_log($key, 'member_type', $old_mem->member_type, 'Slettet');
                }
            }
        }
    }

    public function activity(Request $request)
    {
        return view('activity');
    }

    public function find_replay_edit_member(Request $request)
    {
        if (!empty($request->data)) :

            $findMember = Members::whereNull('signup_status')
                ->where(function($where) use($request) {
                    $where->where('Member_Fistname', 'LIKE', "$request->data%");
                    $where->orWhere('Member_Lastname', 'LIKE', "$request->data%");
                    $where->orWhere('OccID', 'LIKE', "%$request->data%");
                })
                ->limit(10)
                ->get();
            if ($findMember->isNotEmpty()) :
                return view('find_edit_display_member')
                    ->with('members', $findMember);
            else :
                echo '<div class="row"><div class="col-8 mx-auto"><span class="gc-help">Not found</span></div></div>';
            endif;
        endif;
    }

    public function autocomplete_member(Request $request)
    {
        if (!empty($request->search)) :
            $findMember = Members::select('MemberID as value', DB::raw('concat(Member_Fistname, " ", Member_Lastname) as text'))
                ->whereNull('signup_status')
                ->where(function($where) use($request) {
                    $where->where('Member_Fistname', 'LIKE', $request->search."%");
                    $where->orWhere('Member_Lastname', 'LIKE', $request->search."%");
                    $where->orWhere('OccID', 'LIKE', $request->search."%");
                })
                ->whereNotIn('member_type', ['Slettet'])
                ->orderBy('Member_Fistname', 'ASC')
                ->orderBy('Member_Lastname', 'ASC')
                ->limit(15)
                ->get()
                ->toArray();
            return response()->json($findMember);
        endif;
    }

    public function autocomplete_club(Request $request)
    {
        if (!empty($request->search)) :
            $findClub = Club::select('ClubName as value', 'ClubName as text')
                ->where('ClubName', 'LIKE', "%$request->search%")
                ->orderBy('ClubName', 'ASC')
                ->limit(15)
                ->get()
                ->toArray();
            return response()->json($findClub);
        endif;
    }

    public function addactivity(Request $request)
    {

        $reg = new information;
        $reg->Name          = $request->Name;
        $reg->Date          =  date('y-m-d');
        $reg->Temp          = $request->Temp;
        $reg->Weather      = $request->Weather;
        $reg->Activity      = $request->Activity;
        $reg->Hotel      = $request->Hotel;
        $reg->Comment      = $request->comment;
        $reg->Restaurant  = $request->Restaurant;
        $reg->RestRevenue = $request->RestRevenue;
        $reg->HotelOcc     = $request->HotelOcc;
        $reg->HotelRevenue = $request->HotelRevenue;
        $reg->save();
        return redirect()->back()->with('success', ['successfully']);
    }

    public function editreportmember(Request $request)
    {
        return view('find_edit_member');
    }

    public function findinformation(Request $request)
    {
        $information = information::whereDate('Date', date($request->data))
            ->get();
        if ($information->isNotEmpty()) :
            return view('todayinformation')->with(compact('information', 'information'));
        else :
            echo '<div class="row"><div class="col-8 mx-auto" style="background-color: #ff000052"><span class="gc-help">Not found
				  </span></div></div>';
        endif;
    }

    public function findclubmember(Request $request)
    {
        if (!empty($request->data)) :
            $findMember = club::where('ClubName', 'LIKE', "$request->data%")
                ->limit(10)
                ->get();
            if ($findMember->isNotEmpty()) :
                return view('find_display_member')
                    ->with('members', $findMember);
            else :
                echo '<div class="row"><div class="col-8 mx-auto"><span class="gc-help">Not found</span></div></div>';
            endif;
        endif;
    }

    public function report_deletemember(Request $request)
    {
        Members::where('MemberID', $request->data)->delete();
        return true;
    }

    public function report_deleteclub(Request $request)
    {
        club::where('ClubID', $request->data)->delete();
        return true;
    }

    public function report_find_edit_replay_member(Request $request)
    {

        if (!empty($request->fistname) and ($request->lastname) and ($request->data)) :

            Members::where('MemberID', $request->data)
                ->update([
                    'Member_Fistname' => $request->fistname,
                    'Member_Lastname' => $request->lastname,
                    'HCP' => str_replace(',', '.', $request->hcp)
                ]);
            return true;
        else :
            return false;
        endif;
    }

    public function activemember(Request $request)
    {
        $data = $request->status == 'inactive' ? 1 : 0;
        Members::where('MemberID', $request->data)
            ->update(['Active' => $data]);

        $data = $request->status == 'inactive' ? 'Aktive' : 'Passiv';
        $mem = Members::where('MemberID', $request->data)
            ->update(['member_type' => $data]);


        return $mem;

        return true;
    }

    public function todaylest_and_next(Request $request)
    {

        $currendate = 'Date ' . date($request->data);
        $data =  Reg::whereDate('created_at', date($request->data))->get();
        if ($data->isNotEmpty()) :
            $playerCount = Reg::whereDate('created_at', date($request->data))
                ->select(
                    DB::raw('SUM(!ISNULL(reg_member_id)) AS visited'),
                    DB::raw('SUM(ISNULL(reg_member_id)) AS not_visited')
                )
                ->get()
                ->first();
            $allyear = Reg::whereDate('created_at', date($request->data))
                ->whereNull('reg_guest_member')
                ->leftJoin('members', 'members.MemberID', '=', 'registrations.reg_member_id')
                ->groupBy(DB::raw('COALESCE(reg_guest_member),reg_member_id'))
                //->orderBy('reg_auto','desc')
                ->orderBy('Member_Lastname')
                ->get();
            //return dd($allyear);
            return view('lastnext')
                ->with(compact('playerCount', 'allyear', 'currendate'));

        else :
            $currendate = 'Today';
            $playerCount = Reg::whereDate('created_at', date('y-m-d'))
                ->select(
                    DB::raw('SUM(!ISNULL(reg_member_id)) AS visited'),
                    DB::raw('SUM(ISNULL(reg_member_id)) AS not_visited')
                )
                ->get()
                ->first();
            $allyear = Reg::whereDate('created_at', date('y-m-d'))
                ->whereNull('reg_guest_member')
                ->leftJoin('members', 'members.MemberID', '=', 'registrations.reg_member_id')
                ->groupBy(DB::raw('COALESCE(reg_guest_member),reg_member_id'))
                //->orderBy('reg_auto','desc')
                ->orderBy('Member_Lastname')
                ->get();
            return view('lastnext')
                ->with(compact('playerCount', 'allyear', 'currendate'));
        endif;


        //return dd($request->data);*/
    }

    public function edit_cludupdate_membername(Request $request)
    {

        club::where('ClubID', $request->data)
            ->update(['ClubName' => $request->name]);
        return true;
    }

    /**
     * Member Update Log Internal Function
     *
     * @param int $member_id    Member Id (not Occ ID)
     * @param string    $field      Field name of member table
     * @param string    $old        Old value of member table field value
     * @param string    $new        New value of member table field value
     * @return boolean
     * @author Anushan
     */
    public function member_update_log(int $member_id, string $field, $old, $new): bool
    {
        if(!empty($member_id) && !empty($field)) {
            MemberChangesLog::create([
                'log_member_id' => $member_id,
                'log_field' => $field,
                'log_old' => $old ?? null,
                'log_new' => $new ?? null,
            ]);
            return true;
        }
        else return false;
    }

     /*public function experthcpcsv()
     {
         $members = Members::get();
         $membersexcels = DB::table('hcpimp')->get();
         foreach ($membersexcels as $membersexcel) {

             foreach ($members as $member) {
                 if ($membersexcel->occid == $member->OccID) {
                     DB::table('members')
                         ->where('OccID', $member->OccID)
                         ->update([
                             'new_hcp' => $membersexcel->hcp,


                         ]);
                 }
             }
         }

         return 'oksd';
     }

     public function expertcsv()
     {
         $members = Members::get();
         $membersexcels = DB::table('membersexcel')->get();
         // return $membersexcels;
         foreach ($membersexcels as $membersexcel) {

             foreach ($members as $member) {
                 if ($membersexcel->OccID != $member->OccID) {

                     // DB::table('members')
                         // ->where('OccID', $member->OccID)
                         ->insert([
                             'Member_Fistname' => $membersexcel->Member_Fistname,
                             'Member_Lastname' => $membersexcel->Member_Lastname,
                             // 'OccID' => $membersexcel->OccID,
                             // 'HCP' => str_replace(',', ',', $membersexcel->HCP), //str_replace('').'.0';
                             'member_type' => $membersexcel->member_type,
                             'address1' => $membersexcel->address1,
                             'address2' => $membersexcel->address2,
                             'zipcode' => $membersexcel->zipcode,
                             'city' => $membersexcel->city,
                             'email' => $membersexcel->email,
                             // 'tel_privately' => isset($membersexcel->tel_privately) ? $membersexcel->tel_privately : null,
                             // 'tel_jobs' => isset($membersexcel->tel_jobs) ? $membersexcel->tel_jobs : null,
                             'phone_mobile' => trim($membersexcel->phone_mobile),
                             'sex' => $membersexcel->sex,
                             'handicap' => $membersexcel->handicap,
                             // 'stock_number' => $membersexcel->stock_number,
                             // 'playing_eligibility' => isset($membersexcel->playing_eligibility) ? $membersexcel->playing_eligibility : null,
                             'date_of_birth' => date('Y-m-d', strtotime($membersexcel->date_of_birth)),
                             'member_since' => date('Y-m-d', strtotime($membersexcel->member_since)),
                             // 'resignation_date' => date('Y-m-d', strtotime($membersexcel->resignation_date)),
                             'additional_info' => $membersexcel->additional_info,
                             // 'family_head' => $membersexcel->family_head,
                             // 'family_head_name' => $membersexcel->family_head_name,
                             // 'family_head_no' => $membersexcel->family_head_no,
                             // 'shareholder_name' => $membersexcel->shareholder_name,
                             // 'shareholder_member_no' => $membersexcel->shareholder_member_no,
                             'wardrobe' => $membersexcel->wardrobe,
                             'drinks_cabinet' => $membersexcel->drinks_cabinet,
                             'stick_cabinet' => $membersexcel->stick_cabinet,
                             // 'car' => $membersexcel->car,
                             'charging_site' => $membersexcel->charging_site,
                             'trolley_space' => $membersexcel->trolley_space,
                             'share_type'=>$membersexcel->share_type,
                             'share_number'=>$membersexcel->share_number,
                         ]);
                 }
             }
         }
         return 'membersexcel';
     }*/

    /**
     *
     * News Info View Function
     *
     * @param Request $request
     *
     * @author A
     * */
    public function newsInfo(Request $request)
    {
        $newsInfo = NewsInfo::get();
        return view('newsInfo', compact('newsInfo'));
    }

    public function saveNewsInfo($id, Request $request) {
        $json['error'] = true;
        $json['message'] = 'Sorry!!! Couldn\'t create the News.';

        if($id > 0 && $id <= 5) {
            $create = NewsInfo::updateOrCreate(['id' => $id], ['header' => $request->header, 'body' => $request->news, 'status' => (isset($request->status)) ? 1 : 0]);
            if($create) {
                $json['error'] = false;
                $json['message'] = 'News created successfully!';
                $json['news'] = $create;
            }
        }

        return response()->json($json);
    }

    /**
     * List Number of users loggedin in by date
     *
     * @param Request $request
     *
     * @author A
     * @return object
     */
    protected function memberUserStats(Request $request)
    {
        $stats = UserLog::select(DB::raw('COUNT(log_member_id) as member_count'), DB::raw('DATE(log_time) as date'))->orderBy('date', 'DESC')->groupBy('date')->get()->toArray();
        return view('memberLoggedInStats', compact('stats'));
    }

    /*public function insertFerry()
    {
        $members = Members::all();
        foreach($members as $mem) {
            if($mem->MemberID !== 1033 && $mem->MemberID !== 1489 && $mem->MemberID !== 1096) {
                Ticket::create([
                    'occid' => $mem->MemberID,
                    'date_purchase' => Carbon::now()->format('Y-m-d'),
                    'product' => 'Ferry',
                    'ticket_count' => '1',
                    'ticket_used' => 'used',
                    'active' => '1',
                    'ticket_type' => 'season',
                ]);
            }
        }
    }*/

    public function additionalInfo() {
        $members = Members::whereNoTNull('additional_info')->get();
        foreach ($members as $mem) {
            MemberChangesLog::create([
                'log_member_id' => $mem->MemberID,
                'log_field' => 'notes',
                'log_new' => $mem->additional_info,
            ]);
        }
    }

    public function upcomingBirthDay(Request $request) {
        $birthdays = Members::select(DB::raw(
            'MemberID, Member_Fistname, Member_Lastname, email, date_of_birth, phone_mobile,
            DAY(date_of_birth) as day, MONTH(date_of_birth) as month, YEAR(date_of_birth) as year,
            DATE_FORMAT(date_of_birth, "%m-%d") as day_month,
            DATEDIFF(date_of_birth, DATE_FORMAT(NOW(), "%y-%m-%d")) / 365.25 as age,
            IF(DATE_FORMAT(NOW(), "%m") >= MONTH(date_of_birth), CONCAT(DATE_FORMAT(NOW(), "%Y"), "-", DATE_FORMAT(date_of_birth, "%m-%d")), CONCAT(DATE_FORMAT((NOW() + INTERVAL +1 YEAR), "%Y"), "-", DATE_FORMAT(date_of_birth, "%m-%d"))) as test,
            DATE_FORMAT((date_of_birth + INTERVAL + ROUND(DATEDIFF(DATE_FORMAT(NOW(), "%y-%m-%d"), date_of_birth) / 365.25) YEAR), "%Y-%m-%d") as dob_range,
            IF((DATE_FORMAT(date_of_birth, "%d") % 10) = 0, 1, 0) as round'
        ))
            ->whereNotIn('member_type', ['Passiv', 'Slettet'])
            ->whereNotNull('date_of_birth')
//            ->whereRaw("(DATE_FORMAT(date_of_birth, '%m-%d') >= DATE_FORMAT(NOW(), '%m-%d')) AND (DATE_FORMAT(date_of_birth, '%m-%d') <= DATE_FORMAT((NOW() + INTERVAL +30 DAY), '%m-%d'))")
            ->whereRaw("(DATE_FORMAT((date_of_birth + INTERVAL + ROUND(DATEDIFF(DATE_FORMAT(NOW(), '%y-%m-%d'), date_of_birth) / 365.25) YEAR), '%Y-%m-%d') >= DATE_FORMAT(NOW(), '%Y-%m-%d')) AND (DATE_FORMAT((date_of_birth + INTERVAL + ROUND(DATEDIFF(DATE_FORMAT(NOW(), '%y-%m-%d'), date_of_birth) / 365.25) YEAR), '%Y-%m-%d') <= DATE_FORMAT((NOW() + INTERVAL +30 DAY), '%Y-%m-%d'))")
            ->orderBy('dob_range', 'ASC')
            ->get();


//        dd($birthdays);

        return view('upcomingBirthDays', compact('birthdays'));
    }

    public function memberProfile($id, $pdf = false,  Request $request) {
        $member = Members::where('MemberID', $id)->first();
        return view('memberProfile', compact('member', 'pdf'));
    }

    public function memberPdf($id, Request $request) {
        // retreive all records from db
        $member = Members::where('MemberID', $id)->first();
        $img = explode('.', $member->image);
        $type = $img[count($img)-1];
        $in = $this->encode_img_base64( $member->image, $type);

        // share data to view
        $pdf = PDF::loadView('memberProfile', ['member' => $member, 'image' => $in])->setOptions(['defaultFont' => 'sans-serif']);

        // download PDF file with download method
//        return $pdf->download('invoice.pdf');
        return $pdf->stream();
    }

    function encode_img_base64( $img_path = false, $img_type = 'png' ){
        if( $img_path ){
            $img_path = Storage::disk('public')->get('images/members/'.$img_path);
            $img_path = base64_encode($img_path);
            $img_src = "data:image/".$img_type.";base64,".$img_path;
            return $img_src;
//            dd($img_path);
            //convert image into Binary data
//            $img_data = fopen ( $img_path, 'rb' );
//            $img_data = $img_path;
//            $img_size = filesize ( $img_path );
//            dd($img_size);
//            $binary_image = fread ( $img_data, $img_size );
//            fclose ( $img_data );

            //Build the src string to place inside your img tag

            return $img_src;
        }

        return false;
    }

    public function getToken($length){    
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";

        for($i=0; $i<$length; $i++){
            $token .= $codeAlphabet[mt_rand(0,strlen($codeAlphabet)-1)];
        }
        $token = Carbon::now()->format('Ymd').$toekn.Carbon::now()->format('His');
        return $token;
    }

    public function createMemberSignupReference($length) {
        $token = $this->getToken($length);
        $exist = Members::where('signup_token', $token)->count();
        if($exist > 0) $this->createMemberSignupReference($length);

        return $token;
    }

    public function newMemberSignupView(Request $request, $reference) {
        $member = Members::where('signup_token', $reference)->first();
        if($member) :
            return view('member_signup', compact('reference', 'member'));
        else :
            abort(404);
        endif;
    }

    public function newMemberSignup(Request $request, $reference)
    {
        $Members = Members::where('signup_token', $reference)->first();
        if (isset($Members)) :
            $tmp_mail_input = null;
            $tmp_billing_mail_input = null;
            if(isset($request->email)) $tmp_mail_input = $request->email;
            else {
                if(isset($request->email_billing)) $tmp_mail_input = $request->email_billing;
            }
            if(isset($request->email_billing)) $tmp_billing_mail_input = $request->email_billing;
            else {
                if(isset($request->email)) $tmp_billing_mail_input = $request->email;
            }

            $data['address1'] = $request->address1;
            $data['address2'] = $request->address2;
            $data['zipcode'] = $request->zipcode;
            $data['city'] = $request->city;
            $data['email'] = $tmp_mail_input;
            $data['email_billing'] = $tmp_billing_mail_input;
            $data['tel_privately'] = $request->tel_privately;
            $data['tel_jobs'] = $request->tel_jobs;
            $data['phone_mobile'] = $request->phone_mobile;
            $data['sms_news_letter'] = (isset($request->sms_news_letter)) ? 1 : 0;
            $data['sex'] = ($request->sex == 'Select') ? null : $request->sex;
            $data['handicap'] = $request->handicap;
            $data['stock_number'] = $request->stock_number;
            $data['playing_eligibility'] = $request->playing_eligibility;
            $data['date_of_birth'] = $request->date_of_birth;
            $data['member_since'] = $request->member_since;
            $data['resignation_date'] = $request->resignation_date;
            $data['additional_info'] = $request->additional_info;
            $data['family_head'] = $request->family_head;
            $data['family_head_name'] = $request->family_head_name;
            $data['family_head_no'] = $request->family_head_no;
            $data['shareholder_name'] = $request->shareholder_name;
            $data['shareholder_member_no'] = $request->shareholder_member_no;
            $data['wardrobe'] = $request->wardrobe;
            $data['drinks_cabinet'] = $request->drinks_cabinet;
            $data['stick_cabinet'] = $request->stick_cabinet;
            $data['car'] = $request->car;
            $data['charging_site'] = $request->charging_site;
            $data['trolley_space'] = $request->trolley_space;
            $data['share_type'] = $request->share_type;
            $data['share_number'] = $request->share_number;
            $data['share_from'] = $request->share_from;
            $data['share_name'] = $request->share_name;
            $data['share_to'] = $request->share_to;
            $data['signup_token'] = $reference;
            $data['signup_member_filled'] = 1;

            $update = Members::where('signup_token', $reference)->update($data);

            $returnData = [];
            if($update) :
                $returnData['success'] = true;
                $returnData['alert_title'] = 'Success';
                $returnData['alert_message'] = 'Details Saved Successfully...';
                else :
                $returnData['success'] = false;
                $returnData['alert_title'] = 'Error!';
                $returnData['alert_message'] = 'Sorry Something went wrong! Couldn\'t save the details.';
                endif;
        else :
            $returnData['success'] = false;
            $returnData['alert_title'] = 'Error!';
            $returnData['alert_message'] = 'Sorry invalid reference!';
        endif;
        return response()->json($returnData);
    }

    /*function encode_img_base64( $img_path = false, $img_type = 'png' ){
        if( $img_path ){
            $img_path = Storage::disk('public')->get('images/members/'.$img_path);
            // $img_path = Storage::disk('public')->get('images/members/'.$img_path);
           dd($img_path);


           $file = File::get($img_path);
           $type = File::mimeType($img_path);

           $response = Response::make($file, 200);
           $response->header("Content-Type", $type);
           dd($response, 'res');
           $x = Image::make($img_path)->response();
           dd('$x', $x);
           return $x;

           dd($response);
           return $response;
            return $img_path;
           dd($img_path);
            convert image into Binary data
            $img_data = fopen ( $img_path, 'rb' );
           $img_data = $img_path;
           $img_size = filesize ( $img_path );
           dd($img_size);
           $binary_image = fread ( $img_data, $img_size );
           fclose ( $img_data );

            //Build the src string to place inside your img tag
            $img_src = "data:image/".$img_type.";base64,".str_replace ("n", "", base64_encode($binary_image));

            return $img_src;
        }

        return false;
    }*/
}
