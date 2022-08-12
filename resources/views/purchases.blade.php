@extends('layout')
@section('home')
    @include('menu')
    <style>
        #voo {
            background-color: #ffffb2;
        }
    </style>
    <div class="container">
        <div class="rows mt-4">
            <table id="purchase-table" class="table table-bordered table-responsive">
                <thead style="text-align: center;">
                <tr>
                    <th scope="col">Tickets</th>
                    <th scope="col">Count</th>
                    @foreach($statuses as $status)
                        @if($status == '')
                            <th scope="col">Inactive</th>
                        @else
                            <th scope="col">{{ucfirst($status)}}</th>
                        @endif
                    @endforeach
                </tr>
                </thead>
                <tbody style="text-align: center;">
                @php
                    $total = 0;
                @endphp
                @foreach ($tickets as $product => $ticketTmp)
                    @foreach($ticketTmp as $type =>$ticket)
                        <tr>
                            @if($type === 'season')
                                <td scope="col">{{$product}} (S)</td>
                                <th scope="col">{{$ticketsOfTypeCount[$product]['season'][0]['product_count']}}</th>
                                @php
                                    $total += $ticketsOfTypeCount[$product]['season'][0]['product_count'];
                                @endphp
                            @else
                                <td scope="col">{{$product}}</td>
                                <th scope="col">{{$ticketsOfTypeCount[$product][''][0]['product_count']}}</th>
                                @php
                                    $total += $ticketsOfTypeCount[$product][''][0]['product_count'];
                                @endphp
                            @endif
                            @foreach($statuses as $status)
                                @if($status == '')
                                    <td scope="col">{{$ticket[''][0]['ticket_count'] ?? ' - '}}</td>
                                @else
                                    <td scope="col">{{$ticket[$status][0]['ticket_count'] ?? ' - '}}</td>
                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                @endforeach
<!--                <tr>
                    <th>TOTAL</th>
                    <th>{{$total}}</th>
                    {{--@foreach($statuses as $status)
                        @if($status == '')
                            <th scope="col">{{$ticketsTotalCount[''][0]['status_count'] ?? ' - '}}</th>
                        @else
                            <th scope="col">{{$ticketsTotalCount[$status][0]['status_count'] ?? ' - '}}</th>
                        @endif
                    @endforeach--}}
                </tr>-->
                </tbody>
            </table>
        </div>
    </div>
@endsection

