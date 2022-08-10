@extends('layout')
@section('home')
    @if(Session::has('kiosk_mode'))
    @include('reg_menu')
    @else
    @include('menu')
    @endif
    <div class="container">
        <h3 class="text-center">Week</h3>

        <table class="table" border="0">
            <thead>
            </thead>
            <tbody>
            <tr>
                <td>Players Total :</td>
                <td>{{$total = $playerCount['visited'] + $playerCount['not_visited'] }}</td>
            </tr>

            <tr>
                <td>Guests Week :</td>
                <td>{{ $playerCount['not_visited'] }}</td>
            </tr>
            <tr>
                <td>Members Week :</td>
                <td>{{ $playerCount['visited'] }}</td>
            </tr>
            </tbody>
        </table>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th align="right">MemberID</th>
                <th>Name</th>
                <th align="right">TimesPlayed</th>
            </tr>
            </thead>
            <tbody>
                @foreach($allyear as $m)
                    @php
                        $date = Carbon\Carbon::now()->format('Y-m-d H:m:i');
                        $date_chek	=	Carbon\Carbon::now()->subDays(7)->format('Y-m-d H:m:i');
                    @endphp

                    @if(empty($m->reg_registration_type))
                        @php
                            $guest = App\Reg::select('registrations.*', 'm.OccID')
                                            ->whereBetween('reg_time', [$date_chek, $date])
                                            ->where('status', 1)
                                            ->leftJoin('members as m', 'm.MemberID', '=', 'registrations.reg_member_id')
                                            ->where(function($where) use($m, $date, $date_chek) {
                                                $where->whereIn('reg_guest_member', function($query) use ($m, $date, $date_chek) {
                                                    $query->select('reg_auto')
                                                        ->from('registrations')
                                                        ->where('reg_member_id',$m->reg_member_id)
                                                        ->whereBetween('reg_time', [$date_chek, $date]);
                                                });
                                                // $where->orWhere('reg_auto', function($query) use ($m) {
                                                //     $query->select('reg_auto')
                                                //         ->from('registrations as r')
                                                //         ->join('tickets as t', 't.guest_id', '=', 'r.reg_auto')
                                                //         ->whereColumn('registrations.reg_auto', 'r.reg_auto');
                                                // });
                                            })
                                            ->groupBy(DB::raw('COALESCE(reg_member_id), reg_phone'))
                                            ->get();
                            // dd($guest->toArray());
                        @endphp
                        @if(!empty($m->reg_member_id) && empty($m->reg_registration_type))
                            @php
                                $count = App\Reg::where('reg_member_id',$m->reg_member_id)
                                        ->where('status', 1)
                                        ->whereNull('reg_registration_type')
                                        ->whereBetween('reg_time', [$date_chek, $date])
                                        ->select(DB::raw('count("reg_member_id") as counts'))
                                        ->groupBy('reg_member_id')
                                        ->first();
                            @endphp
                        @endif
                        <tr>
                            <td>{{empty($m->OccID)?'Guest':$m->OccID}}</td>
                            <td>{{ empty($m->reg_fistname)?$m->Member_Fistname.' '.$m->Member_Lastname:$m->reg_fistname.' '. $m->reg_lastname}}</td>
                            <td>@if(!empty($count->counts)){{ $count->counts ?? '' }}@endif</td>
                        </tr>

                        @if($guest->isNotEmpty())
                            @foreach($guest as $g)
                                @php
                                    if($g->reg_registration_type === 'Guest Play') : 
                                        $count = App\Reg::where('reg_phone',$g->reg_phone)
                                                    ->where('status', 1)
                                                    ->whereBetween('reg_time', [$date_chek, $date])
                                                    ->select(DB::raw('count("reg_phone") as counts'))
                                                    ->groupBy('reg_phone')
                                                    ->first();
                                    else : 
                                        $count = App\Reg::where('reg_fistname',$g->reg_fistname)
                                                    ->where('reg_lastname',$g->reg_lastname)
                                                    ->where('status', 1)
                                                    ->whereBetween('reg_time', [$date_chek, $date])
                                                    ->select(DB::raw('count("reg_fistname") as counts'))
                                                    ->groupBy('reg_phone')
                                                    ->first();
                                    endif;
                                    // dd($count);
                                @endphp
                                @if(empty($g->reg_registration_type))
                                    <tr>
                                        <td data-toggle="tooltip" data-html="true" data-placement="top"
                                            title="Club -{{$g->reg_club}} <br> HCP - {{$g->reg_hcp}} <br> Tlf - {{$g->reg_phone}}">
                                            {{$g->OccID}}
                                        </td>
                                        <td data-toggle="tooltip" data-html="true" data-placement="top"
                                            title="Club -{{$g->reg_club}} <br> HCP - {{$g->reg_hcp}} <br> Tlf - {{$g->reg_phone}}">{{ucfirst( $g->reg_fistname)}} {{ucfirst($g->reg_lastname)}}  </td>
                                        <td data-toggle="tooltip" data-html="true" data-placement="top"
                                            title="Club -{{$g->reg_club}} <br> HCP - {{$g->reg_hcp}} <br> Tlf - {{$g->reg_phone}}">@if(!empty($count->counts)){{ $count->counts ?? '' }}@endif</td>
                                    </tr>
                                {{-- @else
                                    <tr bgcolor="#ffffb2">
                                        <td data-toggle="tooltip" data-html="true" data-placement="top"
                                            title="Club -{{$g->reg_club}} <br> HCP - {{$g->reg_hcp}} <br> Tlf - {{$g->reg_phone}}">
                                            Guest
                                        </td>
                                        <td data-toggle="tooltip" data-html="true" data-placement="top"
                                            title="Club -{{$g->reg_club}} <br> HCP - {{$g->reg_hcp}} <br> Tlf - {{$g->reg_phone}}">{{ucfirst( $g->reg_fistname)}} {{ucfirst($g->reg_lastname)}}  </td>
                                        <td data-toggle="tooltip" data-html="true" data-placement="top"
                                            title="Club -{{$g->reg_club}} <br> HCP - {{$g->reg_hcp}} <br> Tlf - {{$g->reg_phone}}">@if(!empty($count->counts)){{ $count->counts ?? '' }}@endif</td>
                                    </tr> --}}
                                @endif
                            @endforeach
                        @endif
                    @else
                        @php
                            $count = App\Reg::where('reg_phone',$m->reg_phone)
                                            ->where('status', 1)
                                            ->whereBetween('reg_time', [$date_chek, $date])
                                            ->select(DB::raw('count("reg_phone") as counts'))
                                            ->groupBy('reg_phone')
                                            ->first();
                        @endphp
                        <tr bgcolor="#ffffb2">
                            <td data-toggle="tooltip" data-html="true" data-placement="top"
                                title="Club -{{$m->reg_club}} <br> HCP - {{$m->reg_hcp}} <br> Tlf - {{$m->reg_phone}}">
                                Guest
                            </td>
                            <td data-toggle="tooltip" data-html="true" data-placement="top"
                                title="Club -{{$m->reg_club}} <br> HCP - {{$m->reg_hcp}} <br> Tlf - {{$m->reg_phone}}">{{ucfirst( $m->reg_fistname)}} {{ucfirst($m->reg_lastname)}}  </td>
                            <td data-toggle="tooltip" data-html="true" data-placement="top"
                                title="Club -{{$m->reg_club}} <br> HCP - {{$m->reg_hcp}} <br> Tlf - {{$m->reg_phone}}">@if(!empty($count->counts)){{ $count->counts ?? '' }}@endif</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
