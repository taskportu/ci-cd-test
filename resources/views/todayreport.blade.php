@extends('layout')
@section('home')
    @if(Session::has('kiosk_mode'))
    @include('reg_menu')
    @else
    @include('menu')
    @endif
    <div class="container">


        <div class="row mt-2">
            <div class="col-11">

            </div>
            <div class="col-1">
        <span data-right="next">
            <p class="text-left m-t=5 btn btn-primary btn-sm">
                <svg version="1.1" id="Capa_1"
                     xmlns="http://www.w3.org/2000/svg"
                     xmlns:xlink="http://www.w3.org/1999/xlink" x="0px"
                     y="0px"
                     width="10" height="10" fill="currentColor"
                     viewBox="0 0 292.359 292.359"
                     xml:space="preserve">
                <g>
                    <path d="M222.979,5.424C219.364,1.807,215.08,0,210.132,0c-4.949,0-9.233,1.807-12.848,5.424L69.378,133.331
                        c-3.615,3.617-5.424,7.898-5.424,12.847c0,4.949,1.809,9.233,5.424,12.847l127.906,127.907c3.614,3.617,7.898,5.428,12.848,5.428
                        c4.948,0,9.232-1.811,12.847-5.428c3.617-3.614,5.427-7.898,5.427-12.847V18.271C228.405,13.322,226.596,9.042,222.979,5.424z"/>
                </g>
            </p>
        </span>
                <span class="float-right" data-left="last">
        <p class="text-right btn btn-primary btn-sm"><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                                          xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                          width="10" height="10" fill="currentColor"
                                                          viewBox="0 0 292.359 292.359"
                                                          style="enable-background:new 0 0 292.359 292.359;"
                                                          xml:space="preserve">
<g>
	<path d="M222.979,133.331L95.073,5.424C91.456,1.807,87.178,0,82.226,0c-4.952,0-9.233,1.807-12.85,5.424
		c-3.617,3.617-5.424,7.898-5.424,12.847v255.813c0,4.948,1.807,9.232,5.424,12.847c3.621,3.617,7.902,5.428,12.85,5.428
		c4.949,0,9.23-1.811,12.847-5.428l127.906-127.907c3.614-3.613,5.428-7.897,5.428-12.847
		C228.407,141.229,226.594,136.948,222.979,133.331z"/>
</g></p>
        </span>
            </div>
        </div>
        <div id="replay_last_next">
        </div>
        <div id="alreadytoday">
            <h3 class="text-center">Today</h3>
            <table class="table" border="0">
                <thead>
                </thead>
                <tbody>
                <tr>
                    <td>Players Total :</td>
                    <td>{{$total = $playerCount['visited'] + $playerCount['not_visited'] }}</td>
                </tr>
                <tr>
                    <td>Guests today :</td>
                    <td>{{ $playerCount['not_visited'] }}</td>
                </tr>
                <tr>
                    <td>Members today :</td>
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
                    {{-- {{ dd($allyear) }} --}}
                    @foreach($allyear as $m)
                        @php
                            $dateStart = \Carbon\Carbon::now()->startOfDay()->format('Y-m-d H:i:s');
                            $dateEnd = \Carbon\Carbon::now()->endOfDay()->format('Y-m-d H:i:s');
                        @endphp
                        @if(empty($m->reg_registration_type))
                            @php
                                $guest = App\Reg::select('registrations.*', 'm.OccID')
                                                ->leftJoin('members as m', 'm.MemberID', '=', 'registrations.reg_member_id')
                                                ->whereBetween('reg_time', [$dateStart, $dateEnd])
                                                ->where('status',1)
                                                ->where(function($where) use($m) {
                                                    $where->whereIn('reg_guest_member', function($query) use($m) {
                                                        $query->select('reg_auto')
                                                            ->from('registrations')
                                                            ->whereDate('reg_time',date('y-m-d'))
                                                            ->where('reg_member_id',$m->reg_member_id);
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
                                                // dd($guest->toArray(), $allyear);
                            @endphp
                            @if(!empty($m->reg_member_id) && empty($m->reg_registration_type))
                                @php
                                    $count = App\Reg::where('reg_member_id',$m->reg_member_id)
                                            ->whereNull('reg_registration_type')
                                            ->where('status', 1)
                                            ->whereBetween('reg_time', [$dateStart, $dateEnd])
                                            ->select(DB::raw('count("reg_member_id") as counts'))
                                            ->groupBy('reg_member_id')
                                            ->first();
                                        // dd($count);
                                @endphp
                            @endif
                            <tr>
                                <td>{{empty($m->OccID)?'Guest':$m->OccID}}</td>
                                <td>{{ empty($m->reg_fistname)?$m->Member_Fistname.' '.$m->Member_Lastname:$m->reg_fistname.' '. $m->reg_lastname}}</td>
                                <td>@if(!empty($count)){{ $count->counts }}@endif</td>
                            </tr>

                            @if($guest->isNotEmpty())
                                @foreach($guest as $g)
                                    @php
                                        if($g->reg_registration_type === 'Guest Play') : 
                                            $count = App\Reg::where('reg_phone',$g->reg_phone)
                                                        ->whereBetween('reg_time', [$dateStart, $dateEnd])
                                                        ->where('status', 1)
                                                        ->select(DB::raw('count("reg_phone") as counts'))
                                                        ->groupBy('reg_phone')
                                                        ->first();
                                        else : 
                                            $count = App\Reg::where('reg_fistname',$g->reg_fistname)
                                                        ->where('reg_lastname',$g->reg_lastname)
                                                        ->whereBetween('reg_time', [$dateStart, $dateEnd])
                                                        ->where('status', 1)
                                                        ->select(DB::raw('count("reg_fistname") as counts'))
                                                        ->groupBy('reg_phone')
                                                        ->first();
                                        endif;
                                    @endphp
                                    @if($g->reg_registration_type !== 'Guest Play')
                                        <tr>
                                            <td data-toggle="tooltip" data-html="true" data-placement="top"
                                                title="Club -{{$g->reg_club}} <br> HCP - {{$g->reg_hcp}} <br> Tlf - {{$g->reg_phone}}">
                                                {{$g->OccID}}
                                            </td>
                                            <td data-toggle="tooltip" data-html="true" data-placement="top"
                                                title="Club -{{$g->reg_club}} <br> HCP - {{$g->reg_hcp}} <br> Tlf - {{$g->reg_phone}}">{{ucfirst( $g->reg_fistname)}} {{ucfirst($g->reg_lastname)}} </td>
                                            <td data-toggle="tooltip" data-html="true" data-placement="top"
                                                title="Club -{{$g->reg_club}} <br> HCP - {{$g->reg_hcp}} <br> Tlf - {{$g->reg_phone}}">@if(!empty($count)){{ $count->counts }}@endif</td>
                                        </tr>
                                    {{-- @else
                                        <tr bgcolor="#ffffb2">
                                            <td data-toggle="tooltip" data-html="true" data-placement="top"
                                                title="Club -{{$g->reg_club}} <br> HCP - {{$g->reg_hcp}} <br> Tlf - {{$g->reg_phone}}">
                                                Guest
                                            </td>
                                            <td data-toggle="tooltip" data-html="true" data-placement="top"
                                                title="Club -{{$g->reg_club}} <br> HCP - {{$g->reg_hcp}} <br> Tlf - {{$g->reg_phone}}">{{ucfirst( $g->reg_fistname)}} {{ucfirst($g->reg_lastname)}} </td>
                                            <td data-toggle="tooltip" data-html="true" data-placement="top"
                                                title="Club -{{$g->reg_club}} <br> HCP - {{$g->reg_hcp}} <br> Tlf - {{$g->reg_phone}}">@if(!empty($count)){{ $count->counts }}@endif</td>
                                        </tr> --}}
                                    @endif
                                @endforeach
                            @endif
                        @else
                            @php
                                $count = App\Reg::where('reg_phone',$m->reg_phone)
                                                ->whereBetween('reg_time', [$dateStart, $dateEnd])
                                                ->where('status', 1)
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
                                    title="Club -{{$m->reg_club}} <br> HCP - {{$m->reg_hcp}} <br> Tlf - {{$m->reg_phone}}">{{ucfirst( $m->reg_fistname)}} {{ucfirst($m->reg_lastname)}} </td>
                                <td data-toggle="tooltip" data-html="true" data-placement="top"
                                    title="Club -{{$m->reg_club}} <br> HCP - {{$m->reg_hcp}} <br> Tlf - {{$m->reg_phone}}">@if(!empty($count)){{ $count->counts }}@endif</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>

            </table>

        </div>

    </div>
@endsection
