<ul class="nav nav-tabs" id="myTab" role="tablist">
    <li class="nav-item" role="presentation">
        <a class="nav-link active" id="pending-tab" data-toggle="tab" href="#pending" role="tab"
        aria-controls="pending" aria-selected="true">Pending Registration</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="day-tab" data-toggle="tab" href="#day" role="tab"
        aria-controls="day" aria-selected="true">Day</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="week-tab" data-toggle="tab" href="#week" role="tab" aria-controls="week"
        aria-selected="false">Week</a>
    </li>
    <li class="nav-item" role="presentation">
        <a class="nav-link" id="month-tab" data-toggle="tab" href="#month" role="tab"
        aria-controls="month" aria-selected="false">Month</a>
    </li>
</ul>
<div class="tab-content" id="myTabContent">

    {{-- Pending Registration --}}
    <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
        @if($guests_pending->isNotEmpty())
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td><strong>Name</strong></td>
                        <td><strong>Mobile</strong></td>
                        <td><strong>Club</strong></td>
                        <td><strong>HCP</strong></td>
                        <td><strong>Member</strong></td>
                        <td><strong>Payment</strong></td>
                        <td><strong>By</strong></td>
                        <td style="width: 11%"><strong>Date</strong></td>
                        <td style="width: 18%"><strong></strong></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($guests_pending as $guest)
                    <tr>
                        <td>{{$guest->reg_fistname}} {{$guest->reg_lastname ?? ''}}</td>
                        <td @if(isset($guest->phone_member_id)) data-toggle="tooltip" data-placement="bottom" title="Member ID : {{$guest->phone_occ_id ?? ''}}, Name : {{$guest->phone_first_name ?? ''}} {{$guest->phone_first_name ?? ''}}, Membership Type : {{$guest->phone_member_type ?? ''}}" style="background: #e1d976" @endif>{{$guest->reg_phone}}</td>
                        <td>{{$guest->reg_club}}</td>
                        <td>{{$guest->reg_hcp}}</td>
                        <td><span class="mem-name">{{$guest->Member_Fistname}} {{$guest->Member_Lastname ?? ''}}</span><span>@if($guest->member_type === 'Sponsor') (S) @elseif($guest->member_type === 'Passiv') (P) @endif</span></td>
                        <td>{{$guest->reg_payment_type}}</td>
                        <td>@if($guest->created_by == 'Manual Admin') A @elseif($guest->created_by == 'Manual Kiosk') K @elseif($guest->created_by == 'Mobile Phone') P @endif</td>
                        <td>
                            @if(isset($guest->date_of_play))
                                {{\Carbon\Carbon::createFromFormat('Y-m-d', $guest->date_of_play)->format('d-m-Y')}} (F)
                            @else
                                {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $guest->reg_time)->format('d-m-Y')}}
                            @endif
                        </td>
                        <td>
                            <label class="btn btn-sm btn-info float-right @if($guest->reg_payment_type !== 'Not Paid') playnow @else disabled @endif" @if($guest->reg_payment_type !== 'Not Paid') data-guest="{{ $guest->reg_auto }}" @endif>Play Now</label>

                            <label type="button" data-reg = "{{ $guest->reg_auto }}" class="edit-guest-play btn btn-sm btn-primary float-right mr-2" data-toggle="modal" data-target="#reg-edit-modal">Edit</label>

                            <label class="btn btn-sm btn-danger mr-2 float-right delete-reg" data-guest="{{ $guest->reg_auto }}">
                                <svg style="margin-bottom: 3px;" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                    <path
                                        d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                    <path fill-rule="evenodd"
                                          d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                </svg>
                            </label>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="alert alert-danger">
            Sorry!!! No Data Found.
        </div>
        @endif
    </div>

    {{-- Day --}}
    <div class="tab-pane fade" id="day" role="tabpanel" aria-labelledby="day-tab">
        @if($guests_day->isNotEmpty())
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td><strong>Name</strong></td>
                        <td><strong>Mobile</strong></td>
                        <td><strong>Club</strong></td>
                        <td><strong>HCP</strong></td>
                        <td><strong>Member</strong></td>
                        <td><strong>Payment</strong></td>
                        <td><strong>By</strong></td>
                        <td><strong>Date</strong></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($guests_day as $guest)
                    <tr>
                        <td>{{$guest->reg_fistname}} {{$guest->reg_lastname ?? ''}}</td>
                        <td @if(isset($guest->phone_member_id)) data-toggle="tooltip" data-placement="bottom" title="Member ID : {{$guest->phone_occ_id ?? ''}}, Name : {{$guest->phone_first_name ?? ''}} {{$guest->phone_first_name ?? ''}}, Membership Type : {{$guest->phone_member_type ?? ''}}" style="background: #e1d976" @endif>{{$guest->reg_phone}}</td>
                        <td>{{$guest->reg_club}}</td>
                        <td>{{$guest->reg_hcp}}</td>
                        <td><span class="mem-name">{{$guest->Member_Fistname}} {{$guest->Member_Lastname ?? ''}}</span><span>@if($guest->member_type === 'Sponsor') (S) @elseif($guest->member_type === 'Passiv') (P) @endif</span></td>
                        <td>{{$guest->reg_payment_type}}</td>
                        <td>@if($guest->created_by == 'Manual Admin') A @elseif($guest->created_by == 'Manual Kiosk') K @elseif($guest->created_by == 'Mobile Phone') P @endif</td>
                        <td>
                            @if(isset($guest->date_of_play))
                                {{\Carbon\Carbon::createFromFormat('Y-m-d', $guest->date_of_play)->format('d-m-Y')}} (F)
                            @else
                                {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $guest->reg_time)->format('d-m-Y')}}
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="alert alert-danger">
            Sorry!!! No Data Found.
        </div>
        @endif
    </div>

    {{-- Week --}}
    <div class="tab-pane fade" id="week" role="tabpanel" aria-labelledby="week-tab">
        @if($guests_week->isNotEmpty())
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td><strong>Name</strong></td>
                        <td><strong>Mobile</strong></td>
                        <td><strong>Club</strong></td>
                        <td><strong>HCP</strong></td>
                        <td><strong>Member</strong></td>
                        <td><strong>Payment</strong></td>
                        <td><strong>By</strong></td>
                        <td><strong>Date</strong></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($guests_week as $guest)
                    <tr>
                        <td>{{$guest->reg_fistname}} {{$guest->reg_lastname ?? ''}}</td>
                        <td @if(isset($guest->phone_member_id)) data-toggle="tooltip" data-placement="bottom" title="Member ID : {{$guest->phone_occ_id ?? ''}}, Name : {{$guest->phone_first_name ?? ''}} {{$guest->phone_first_name ?? ''}}, Membership Type : {{$guest->phone_member_type ?? ''}}" style="background: #e1d976" @endif>{{$guest->reg_phone}}</td>
                        <td>{{$guest->reg_club}}</td>
                        <td>{{$guest->reg_hcp}}</td>
                        <td><span class="mem-name">{{$guest->Member_Fistname}} {{$guest->Member_Lastname ?? ''}}</span><span>@if($guest->member_type === 'Sponsor') (S) @elseif($guest->member_type === 'Passiv') (P) @endif</span></td>
                        <td>{{$guest->reg_payment_type}}</td>
                        <td>@if($guest->created_by == 'Manual Admin') A @elseif($guest->created_by == 'Manual Kiosk') K @elseif($guest->created_by == 'Mobile Phone') P @endif</td>
                        <td>
                            @if(isset($guest->date_of_play))
                                {{\Carbon\Carbon::createFromFormat('Y-m-d', $guest->date_of_play)->format('d-m-Y')}} (F)
                            @else
                                {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $guest->reg_time)->format('d-m-Y')}}
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="alert alert-danger">
            Sorry!!! No Data Found.
        </div>
        @endif
    </div>

    {{-- Month --}}
    <div class="tab-pane fade" id="month" role="tabpanel" aria-labelledby="month-tab">
        @if($guests_month->isNotEmpty())
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <td><strong>Name</strong></td>
                        <td><strong>Mobile</strong></td>
                        <td><strong>Club</strong></td>
                        <td><strong>HCP</strong></td>
                        <td><strong>Member</strong></td>
                        <td><strong>Payment</strong></td>
                        <td><strong>By</strong></td>
                        <td><strong>Date</strong></td>
                    </tr>
                </thead>
                <tbody>
                    @foreach($guests_month as $guest)
                    <tr>
                        <td>{{$guest->reg_fistname}} {{$guest->reg_lastname ?? ''}}</td>
                        <td @if(isset($guest->phone_member_id)) data-toggle="tooltip" data-placement="bottom" title="Member ID : {{$guest->phone_occ_id ?? ''}}, Name : {{$guest->phone_first_name ?? ''}} {{$guest->phone_first_name ?? ''}}, Membership Type : {{$guest->phone_member_type ?? ''}}" style="background: #e1d976" @endif>{{$guest->reg_phone}}</td>
                        <td>{{$guest->reg_club}}</td>
                        <td>{{$guest->reg_hcp}}</td>
                        <td><span class="mem-name">{{$guest->Member_Fistname}} {{$guest->Member_Lastname ?? ''}}</span><span>@if($guest->member_type === 'Sponsor') (S) @elseif($guest->member_type === 'Passiv') (P) @endif</span></td>
                        <td>{{$guest->reg_payment_type}}</td>
                        <td>@if($guest->created_by == 'Manual Admin') A @elseif($guest->created_by == 'Manual Kiosk') K @elseif($guest->created_by == 'Mobile Phone') P @endif</td>
                        <td>
                            @if(isset($guest->date_of_play))
                                {{\Carbon\Carbon::createFromFormat('Y-m-d', $guest->date_of_play)->format('d-m-Y')}} (F)
                            @else
                                {{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $guest->reg_time)->format('d-m-Y')}}
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="alert alert-danger">
            Sorry!!! No Data Found.
        </div>
        @endif
    </div>

</div>
