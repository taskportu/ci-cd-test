<div class="row">
    <div class="col-md-12">
        <div class="app-header">
            <h4>PRO TIMER</h4>
        </div>
        <div class="col-12">
            <p class="front-site-info mb-3 mt-0">Her finner du individuelle billetter for Pro-timer. Disse kan benyttes av både deg og gjester og en billett gjelder for en sesjon med vår Pro.</p>
        </div>
        <center>
            <div class="col-12" style="PADDING: 12px;">
                @if(isset($tickets['Pro lessons']))
                    <p class="font-weight-bold">Trykk på den enkelte billetten for å benytte den!</p>
                    @foreach ($tickets['Pro lessons'] as $ticket)
                        @if($ticket->ticket_type !== 'season')
                            @if ($ticket->ticket_used === null || $ticket->ticket_used === '')
                                <div
                                    data-status="done"
                                    data-id="{{ $ticket->id }}"
                                    class="col-sm-8 col-md-5 not_used_ticket ticket_change_status pro_lessions_ticket">
                                    <img src="{{asset('images/Protime-billett-2021BtnBg.png')}}" class="img-fluid ml-auto mr-auto" style="" alt="{{$ticket->product}}">
                                </div>
                            @else
                                <div class="col-sm-8 col-md-5 used_ticket pro_lessions_ticket">
                                    <img src="{{asset('images/Protime-billett-2021BtnBg.png')}}" class="img-fluid ml-auto mr-auto" style="" alt="{{$ticket->product}}">
                                    <span class="font-weight-bold d-block" style="">{{ \Carbon\Carbon::parse($ticket->date_used)->format('d-m-Y') }}</span>
                                </div>
                            @endif
                        @endif
                    @endforeach
                @else
                @endif

{{--                @if(isset($tickets['Pro lessons']))--}}
{{--                    @foreach ($tickets['Pro lessons'] as $ticket)--}}
{{--                        @if (empty($ticket->ticket_used))--}}
{{--                            <div data-status="{{ $ticket->ticket_used }}" data-id="{{ $ticket->id }}"--}}
{{--                                 class="col-sm-8 col-md-5 not_used_ticket ticket_change_status pro_lessions_ticket">--}}
{{--                                --}}{{--<p class="text-center">--}}
{{--                                --}}{{--{{ $ticket->product .' '. date('Y', strtotime($ticket->date_purchase)) }}--}}
{{--                                --}}{{--</br>--}}
{{--                                --}}{{--</p>--}}
{{--                            </div>--}}
{{--                        @else--}}
{{--                            <div data-status="{{ $ticket->ticket_used }}" data-id="{{ $ticket->id }}" class="col-sm-8 col-md-5 used_ticket pro_lessions_ticket">--}}
{{--                                <p class="text-center">--}}
{{--                                    --}}{{--{{ $ticket->product .' '. date('Y', strtotime($ticket->date_purchase)) }}--}}
{{--                                    </br>--}}
{{--                                    </br>--}}
{{--                                    </br>--}}
{{--                                    <span class="font-weight-bold mt-1 d-block">{{ \Carbon\Carbon::parse($ticket->date_used)->format('d-m-Y') }}</span>--}}
{{--                                </p>--}}
{{--                            </div>--}}
{{--                        @endif--}}
{{--                    @endforeach--}}
{{--                @endif--}}
            </div>
        </center>
    </div>
</div>
