
<div class="row">
    <div class="col-12">
        <div class="app-header mb-2">
            <h4>FERGETIDER</h4>
        </div>
    </div>
</div>

{{--<div class="row">
    <div class=".col-sm-4 ml-auto mr-auto">
        <img class="img-fluid" src="../images/Ferge2021.png">
    </div>
</div>--}}
<div class="row">
    <div class="col-md-12">
        {{--<p class="front-site-info mb-0 text-center mt-0">Her finner du ditt sesongkort på fergen. Sesongkort er personlig og kan ikke overdras til andre.</p>--}}
        <center>
            <div class="col-12" style="padding: 12px;">
                @php
                  $seasonal = false; $regular = false; $reg2 = false;
                @endphp
                
                @if(isset($tickets['Ferry']))
                    <p class="front-site-info show-seasonal d-none mb-3 mt-0">Her finner du ditt sesongkort for fergen.  Sesongkortet gjelder for deg som medlem og dine gjester.</p>
                    @foreach ($tickets['Ferry'] as $ticket)
                        @if($ticket->ticket_type === 'season')
                            @php
                                if($seasonal === false) $seasonal = true;
                            @endphp
                            <div class="col-sm-8 col-md-5 seasonal_ticket ferry_ticket">
                                <img src="{{asset('images/Ferge2021.png')}}" class="img-fluid ml-auto mr-auto" style="height: auto; margin-top: -10px;" alt="{{$ticket->product}}">
                                <span class="d-block" style="">{{ $memberdata->Member_Fistname }} {{$memberdata->Member_Lastname ?? ''}}</span>
                            </div>
                        @endif
                    @endforeach
                @endif

                {{-- @if($seasonal = true) --}}
                <div class="row mb-3">
                    <div class="col-12 col-sm-6 mb-4">
                        <div class="card">
                            <div class="card-header">
                                <b>Snarøya til OCC</b>
                            </div>
                            <div class="card-body">
                                <ul style="text-align: left;">
                                    <li>09:00</li>
                                    <li>10:00</li>
                                    <li>11:00</li>
                                    <li>12:00</li>
                                    <li>14:00</li>
                                    <li>15:00</li>
                                    <li>16:00</li>
                                    <li>17:00</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6">
                        <div class="card right-card">
                            <div class="card-header">
                                <b>OCC til Snarøya</b>
                            </div>
                            <div class="card-body">
                                <ul style="text-align: left;">
                                    <li>08:45 - NB må bestilles dagen før</li>
                                    <li>09:45 - NB må bestilles senest</li>
                                    <li>0830</li>
                                    <li>10:45</li>
                                    <li>11:45</li>
                                    <li>13:45</li>
                                    <li>14:45</li>
                                    <li>15:45</li>
                                    <li>16:45</li>
                                    <li>17:45</li>
                                    <li>19:00 - NB avtal avgang</li>
                                    <li>21:00 - NB avtal avgang</li>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>
                {{-- @endif --}}

                @if(isset($tickets['Ferry']))
                    <p class="front-site-info show-regular d-none mb-3 mt-0">Her finner du individuelle billetter for bruk på fergen. Disse kan benyttes for gjester eller andre som ikke er medlem eller skal spille på banen. Fergebillett er inkludert i alle medlemskap og for greenfee spillere.</p>
                    <p class="mb-3 mt-0 show-regular-click d-none">Trykk på den enkelte billetten for å benytte den!</p>
                    @foreach ($tickets['Ferry'] as $ticket)
                        @if($ticket->ticket_type !== 'season')
                            @if ($ticket->ticket_used === null || $ticket->ticket_used === '')
                                @php
                                    if($regular === false) $regular = true;
                                @endphp
                                <div
                                    data-status="done"
                                    data-id="{{ $ticket->id }}"
                                    class="col-sm-8 col-md-5 not_used_ticket ticket_change_status ferry_ticket">
                                    @if($ticket->ticket_type === 'season')
                                        <img src="{{asset('images/Ferge2021.png')}}" class="img-fluid ml-auto mr-auto" style="height: auto; margin-top: -10px;" alt="{{$ticket->product}}">
                                    @else
                                        <img src="{{asset('images/Ferge2021BtnBg.png')}}" class="img-fluid ml-auto mr-auto" style="" alt="{{$ticket->product}}">
                                    @endif
                                </div>
                            @else
                                <div class="col-sm-8 col-md-5 used_ticket ferry_ticket">
                                    <img src="{{asset('images/Ferge2021BtnBg.png')}}" class="img-fluid ml-auto mr-auto" style="" alt="{{$ticket->product}}">
                                    <span class="font-weight-bold d-block" style="">{{ \Carbon\Carbon::parse($ticket->date_used)->format('d-m-Y') }}</span>
                                </div>
                            @endif
                        @endif
                    @endforeach
                @endif
            </div>
        </center>
    </div>
</div>
@if($seasonal === true)
    <script>
        $('.show-seasonal').removeClass('d-none');
    </script>
@endif
@if($regular === true)
    <script>
        $('.show-regular').removeClass('d-none');
        $('.show-regular-click').removeClass('d-none');
    </script>
@endif
