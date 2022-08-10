@extends('layout')
@section('home')
    @if(Session::has('kiosk_mode'))
    @include('reg_menu')
    @else
    @include('menu')
    @endif
    <style>
        .voo {
            background-color: #ffffb2 !important;
        }
    </style>
    <div class="container">
        <h3 class="text-center">Now</h3>
        <div class="rows mt-4">

            <table class="table">
                <thead>
                <tr>
                    <th scope="col">MemberID</th>
                    <th scope="col">Name</th>
                    <th scope="col">Time</th>
                </tr>
                </thead>
                <tbody>
                @php
                    $count = $report->count();
                @endphp
                @if($report->isNotEmpty())
                    @foreach($report as $key => $m)
                        @php
                            $dateStart = \Carbon\Carbon::now()->endOfDay()->format('Y-m-d H:i:s');
                            $dateEnd = \Carbon\Carbon::now()->startOfDay()->format('Y-m-d H:i:s');
                            $guest = App\Reg::select('registrations.*', 'm.OccID')
                                            ->leftJoin('members as m', 'm.MemberID', '=', 'registrations.reg_member_id')
                                            ->whereBetween('reg_time', [$dateEnd, $dateStart])
                                            ->where('status', 1)
                                            ->where(function($where) use($m, $dateEnd, $dateStart) {
                                                $where->whereIn('reg_guest_member', function($query) use ($m) {
                                                    $query->select('reg_auto')
                                                        ->from('registrations')
                                                        ->where('reg_auto',$m->reg_auto);
                                                });
                                                // $where->orWhere('reg_auto', function($query) use ($m) {
                                                //     $query->select('reg_auto')
                                                //         ->from('registrations as r')
                                                //         ->join('tickets as t', 't.guest_id', '=', 'r.reg_auto')
                                                //         ->whereColumn('registrations.reg_auto', 'r.reg_auto');
                                                // });
                                            })
                                            ->orderBy('reg_registration_type', 'ASC')
                                            ->orderBy('reg_time', 'ASC')
                                            ->get();
                                            // dd($guest->toArray(), $report->toArray(), $m->reg_guest_member, $m);
                        @endphp
                        @if($m->reg_registration_type === 'Guest Play')
                            <tr bgcolor="#ffffb2">
                                <td>Guest</td>
                                <td>{{ $m->reg_fistname }} {{ $m->reg_lastname }}</td>
                                <td>{{ date('H:i', strtotime($m->reg_time)) }}</td>
                            </tr>
                        @else
                            <tr>
                                <td>{{ $m->OccID }}</td>
                                <td>{{ $m->Member_Fistname }} {{ $m->Member_Lastname }}</td>
                                <td>{{ date('H:i', strtotime($m->reg_time)) }}</td>
                            </tr>
                        @endif
                        @if($guest->isNotEmpty() && is_null($m->reg_registration_type))
                            @foreach($guest as $g)
                                @php $count++ @endphp
                                @if(isset($g->OccID) && is_null($g->reg_registration_type))
                                <tr>
                                    <td
                                        data-toggle="tooltip"
                                        data-html="true"
                                        data-placement="top"
                                        title="Club -{{$g->reg_club}} <br> HCP - {{$g->reg_hcp}} <br> Tlf - {{$g->reg_phone}}">
                                        {{$g->OccID}}
                                    </td>
                                    <td data-toggle="tooltip" data-html="true" data-placement="top"
                                        title="Club -{{$g->reg_club}} <br> HCP - {{$g->reg_hcp}} <br> Tlf - {{$g->reg_phone}}">
                                        {{ucfirst( $g->reg_fistname)}} {{ucfirst($g->reg_lastname)}}
                                    </td>
                                    <td data-toggle="tooltip" data-html="true" data-placement="top"
                                        title="Club -{{$g->reg_club}} <br> HCP - {{$g->reg_hcp}} <br> Tlf - {{$g->reg_phone}}">
                                        {{ date('H:i', strtotime($g->reg_time)) }}
                                    </td>
                                </tr>
                                @else
                                    <tr class="voo">
                                        <td
                                            data-toggle="tooltip"
                                            data-html="true"
                                            data-placement="top"
                                            title="Club -{{$g->reg_club}} <br> HCP - {{$g->reg_hcp}} <br> Tlf - {{$g->reg_phone}}">
                                            Guest
                                        </td>
                                        <td data-toggle="tooltip" data-html="true" data-placement="top"
                                            title="Club -{{$g->reg_club}} <br> HCP - {{$g->reg_hcp}} <br> Tlf - {{$g->reg_phone}}">
                                            {{ucfirst( $g->reg_fistname)}} {{ucfirst($g->reg_lastname)}}
                                        </td>
                                        <td data-toggle="tooltip" data-html="true" data-placement="top"
                                            title="Club -{{$g->reg_club}} <br> HCP - {{$g->reg_hcp}} <br> Tlf - {{$g->reg_phone}}">
                                            {{ date('H:i', strtotime($g->reg_time)) }}
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif

                        @if($count == 75)
                            @php break; @endphp
                        @endif
                    @endforeach
                @endif
                </tbody>
            </table>
        </div>
    </div>

@endsection
