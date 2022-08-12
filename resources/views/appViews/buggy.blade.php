<div class="row">
    <div class="col-md-12">
        <div class="app-header">
            <h4>BUGGY</h4>
        </div>
        @if($memberdata->member_type !== 'Sponsor' && $memberdata->member_type !== 'Passiv')
            <div class="col-12">
                <p class="front-site-info mb-3 mt-0">Her finner du enkelt billetter eller ditt sesongkort på buggy. </br>Sesongkort er personlig og kan ikke overdras til andre.</p>
            </div>
            <center>
                <div class="col-12" style="PADDING: 12px;">
                    @if(isset($tickets['Buggy']))
                        @foreach ($tickets['Buggy'] as $ticket)
                            <div class="col-sm-8 col-md-5 not_used_ticket seasonal_ticket buggy_ticket">
                                <img src="{{asset('images/Buggy2021.png')}}" class="img-fluid ml-auto mr-auto" style="height: auto; margin-top: -10px;" alt="{{$ticket->product}}">
                                <span class="font-weight-bold d-block" style="">{{ $memberdata->Member_Fistname }} {{$memberdata->Member_Lastname ?? ''}}</span>
                            </div>
                        @endforeach
                    @endif
                </div>
            </center>
        @else
            <div class="row">
                <div class="col-12">
                    <div class="alert alert-danger text-danger d-block ml-3 mr-3" role="alert">
                        You don't have access to this page.
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
{{-- @else
    <div class="alert alert-danger">
        You don't have access to this page.
    </div>
@endif --}}
