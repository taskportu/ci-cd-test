@extends('layout')
@section('home')
    @include('menu')
    <div class="container">
        {{-- <h3 class="text-center">Status</h3> --}}
        <div class="row mt-5">
            <div class="col-12 col-sm-8 offset-sm-2">
                <div class="card-header bg-dark text-white">Upcoming Birthdays</div>
                <div class="js-messages"></div>
                @if(!empty($birthdays))
                    <div class="table-responsive mb-4">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th><strong>Name</strong></th>
                                <th style="width: 20% !important;"><strong>Birthday</strong></th>
                                <th style="width: 5% !important;"><strong>Age</strong></th>
                                <th><strong>Email</strong></th>
                                <td><strong>Phone</strong></td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($birthdays as $key => $birthday)
                                <tr @if($birthday->round == 1) style="background:#ffc1078c;" @endif>
                                    <td><a href="{{route('memberedits', $birthday->MemberID )}}">{{ $birthday->Member_Fistname }} {{ $birthday->Member_Lastname }}</a></td>
                                    <td>
                                        {{ \Carbon\Carbon::createFromFormat('Y-m-d', $birthday->date_of_birth)->format('d-m-Y') }}
{{--                                        {{ $birthday->date_of_birth }}--}}
                                    </td>
                                    <td>{{((int)explode('.', $birthday->age)[0])*-1}}</td>
                                    <td><a href="mailto: {{$birthday->email}}">{{$birthday->email}}</a></td>
                                    <td>{{ $birthday->phone_mobile }}</td>
                                </tr>
                            @endforeach
{{--                            {{dd($birthdays)}}--}}
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
