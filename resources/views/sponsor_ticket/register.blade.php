@extends('layout')
@section('home')
    @include('menu')
    <div class="container">
        {{-- <h3 class="text-center">Status</h3> --}}
        <div class="row mt-5">
            <div class="col-12 col-sm-12 ">

                <div class="card mb-4" style="border-color: #002a71; border-width: 2px; border-radius: 6px;">
                    <div class="card-header bg-dark text-white">Sponsor Ticket</div>
                    <div class="card-body">
                        @if(Session::has('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Sorry!</strong> {{Session::get('error')}}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @elseif(Session::has('message'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{Session::get('message')}}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        {{--                {{dd(Session::get('errors'), $errors->all())}}--}}
                        @if(Session::has('errors'))
                            @foreach($errors->all() as $err)
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>Sorry!</strong> {{$err}}.
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endforeach
                        @endif
                        <div class="js-messages"></div>

                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" id="day-tab" data-toggle="tab" href="#day" role="tab"
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
                                <div class="tab-pane fade show active" id="day" role="tabpanel" aria-labelledby="day-tab">
                                    @if($guests_day->isNotEmpty())
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <td><strong>Mobile</strong></td>
                                                    <td><strong>Member</strong></td>
                                                    <td><strong>Used/Unused</strong></td>
                                                    <td><strong>Used Date</strong></td>
                                                    <td><strong>Transferred Date</strong></td>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($guests_day as $guest)
                                                    <tr>
                                                        <td>{{$guest->transfered_phone}}</td>
                                                        <td>{{$guest->Member_Fistname}} {{$guest->Member_Lastname ?? ''}}</td>
                                                        <td>{{($guest->ticket_used === 'used') ? 'Used' : 'Un used'}}</td>
                                                        <td>@if(isset($guest->date_used)){{\Carbon\Carbon::createFromFormat('Y-m-d', $guest->date_used)->format('d-m-Y')}}@endif</td>
                                                        <td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $guest->transfered_date)->format('d-m-Y')}}</td>
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
                                <div class="tab-pane fade" id="week" role="tabpanel" aria-labelledby="week-tab">
                                    @if($guests_week->isNotEmpty())
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <td><strong>Mobile</strong></td>
                                                    <td><strong>Member</strong></td>
                                                    <td><strong>Used/Unused</strong></td>
                                                    <td><strong>Used Date</strong></td>
                                                    <td><strong>Transferred Date</strong></td>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($guests_week as $guest)
                                                    <tr>
                                                        <td>{{$guest->transfered_phone}}</td>
                                                        <td>{{$guest->Member_Fistname}} {{$guest->Member_Lastname ?? ''}}</td>
                                                        <td>{{($guest->ticket_used === 'used') ? 'Used' : 'Un used'}}</td>
                                                        <td>@if(isset($guest->date_used)){{\Carbon\Carbon::createFromFormat('Y-m-d', $guest->date_used)->format('d-m-Y')}}@endif</td>
                                                        <td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $guest->transfered_date)->format('d-m-Y')}}</td>
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
                                <div class="tab-pane fade" id="month" role="tabpanel" aria-labelledby="month-tab">
                                    @if($guests_month->isNotEmpty())
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                <tr>
                                                    <td><strong>Mobile</strong></td>
                                                    <td><strong>Member</strong></td>
                                                    <td><strong>Used/Unused</strong></td>
                                                    <td><strong>Used Date</strong></td>
                                                    <td><strong>Transferred Date</strong></td>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($guests_month as $guest)
                                                    <tr>
                                                        <td>{{$guest->transfered_phone}}</td>
                                                        <td>{{$guest->Member_Fistname}} {{$guest->Member_Lastname ?? ''}}</td>
                                                        <td>{{($guest->ticket_used === 'used') ? 'Used' : 'Un used'}}</td>
                                                        <td>@if(isset($guest->date_used)){{\Carbon\Carbon::createFromFormat('Y-m-d', $guest->date_used)->format('d-m-Y')}}@endif</td>
                                                        <td>{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $guest->transfered_date)->format('d-m-Y')}}</td>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('script2')
    <script>

    </script>
@endpush
