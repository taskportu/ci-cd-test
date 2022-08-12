<div class="row">
    <div class="col-md-12">
        <div class="app-header">
            <h4>GJESTESPILL</h4>
        </div>
        <div class="col-12">
            @if(Session::has('error'))
            <div class="alert alert-danger alert-dismissible d-block fade show" role="alert">
                <strong>Sorry!</strong> {{Session::get('error')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @elseif(Session::has('message'))
            <div class="alert alert-success alert-dismissible d-block fade show" role="alert">
                {{Session::get('message')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
            {{-- <p class="front-site-info mb-3 mt-0">Trykk på den enkelte billetten for å benytte den i kiosken. Husk at du må være der sammen med gjesten som må ha med mobil for registrering. Alternativt kan du sende en billett til din gjest slik at de kan pre-registere seg og spare tid i kiosken. Dette bør gjøres samme dag som dere spiller.</p> --}}
        </div>
        <center>
            <div class="col-12" style="padding: 12px 0px 35px;">
                @if(isset($transfer_ticket))
                    {{-- <p class="font-weight-bold">Trykk på den enkelte billetten for å benytte den!</p> --}}
                    @if (empty($transfer_ticket->ticket_used) && empty($transfer_ticket->transfered_from))
                        @if($memberdata->member_type !== 'Passiv')
                            <div class="row">
                                <div class="col col-sm-8 offset-sm-2">
                                    <div class="pl-2 pr-2">
                                        <p class="text-danger">
                                            <strong>
                                                ALLE GJESTESPILL SKAL GODKJENNES I KIOSKEN MED MEDLEMMET TILSTEDE
                                            </strong>
                                        </p>
                                        <p>
                                            <strong>DU HAR TO ALTERNATIVER</strong>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="divider" style="border-bottom: 1px solid #000;margin-bottom: 15px;"></div>
                            <div class="row">
                                <div class="col col-sm-8 offset-sm-2">
                                    <div class="pl-2 pr-2">
                                        <p class="text-danger">
                                            <strong>
                                                Din gjest pre-registerer nødvendig informasjon selv!
                                            </strong>
                                        </p>
                                        <p class="">
                                            <strong>
                                                Spar tid å Kiosken ved å sende gjestespill billetten til din gjesten og be de pr-registrere seg.  Legge inn din gjest's mobilnummer og trykk send. Gjesten fyller selv ut skjema han får på mobilen. Dere går så sammen til Kiosken for  å få registrert runden hos en av klubbens ansatte.
                                            </strong>
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col col-sm-4 offset-sm-4">
                                    <div class="ml-3 mr-3 mb-2 mb-2">
                                        <div class="input-group">
                                            <input type="tel" class="form-control" id="phone_no" placeholder="Mobilnummer"
                                                   aria-describedby="phone_no_help">
                                            <div class="input-group-append">
                                                <label class="btn btn-primary" id="transfer_ticket" type="button">SEND</label>
                                            </div>
                                        </div>
                                        <div>
                                            {{-- <small id="phone_no_help" class="form-text text-muted float-left">Du kan videresende en gjestespill billett til en gjest. Gjest må ha mobil for å kunne spille da kvitteringen som sendes ut bare er digital.</small> --}}
                                            <span class="d-none errorDetails float-left"></span>
                                        </div>
                                        <div class="js-message"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col col-sm-8 offset-sm-2">
                                    <div class="pl-2 pr-2">
                                        <p>
                                            <strong>
                                                Din gjest må ha mobil for å kunne spille da kvitteringen som sendes ut fra kiosken er digital. Vi anbefaler ikke å sende flere billetter til samme gjest før de faktisk skal brukes. Billetten kan ikke hentes tilbake og er personlig ( kan ikke videresendes til andre igjen).
                                            </strong>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Tickket --}}
                        <div class="row @if($memberdata->member_type !== 'Passiv') mt-4 @endif">
                            <div class="col col-sm-8 offset-sm-2">
                                <div class="pl-2 pr-2">
                                    <p class="text-danger">
                                        <strong>
                                            Du er med din gjest i kiosken for registrering!
                                        </strong>
                                    </p>
                                    <p>
                                        <strong>
                                            Er du i Kiosken, sammen med din gjest, kan du foran den ansatte dokumentere at du bruker denne billetten for din gjest. Runden må så manuelt registreres av den ansatte i Kiosken. For at det skal gå raskere i Kiosken anbefaler vi at du sender den til gjesten, se over, og benytter dere av pre-registrering.
                                        </strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-sm-8 offset-sm-2 col-md-4 offset-md-4 ">
                                <div data-status="done" data-id="{{ $transfer_ticket->id }}" class=" not_used_ticket ticket_change_status1 green_free_ticket ml-2 mr-2">
                                    <img src="{{asset('images/Greenfee_guest.png')}}"
                                         class="img-fluid ml-auto mr-auto" style="" alt="{{$transfer_ticket->product}}">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col col-sm-8 offset-sm-2">
                                <div class="pl-2 pr-2">

                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col col-sm-8 offset-sm-2">
                                <div class="pl-2 pr-2">
                                    <p class="text-danger">
                                        <strong>
                                            Skal du ikke bruke billetten nå kan du trykke på
                                        </strong>
                                    </p>
                                    <label class="btn btn-danger" id="cancel_ticket" type="button">AVSLUTT</label>
                                </div>
                            </div>
                        </div>
                    @elseif (!empty($transfer_ticket->transfered_from))
                        <div class="col-sm-8 col-md-5 used_ticket green_free_ticket" style="background: url('./images/guest-play-big.jpg');background-size: contain;background-position: center;background-repeat: no-repeat;">
                           {{-- <img src="{{asset('images/Greenfee_guest.png')}}" class="img-fluid ml-auto mr-auto" style="" alt="{{$transfer_ticket->product}}"> --}}
                            {{--                                @if(empty($transfer_ticket->ticket_used))--}}
                            @if($transfer_ticket->ticket_used == 'deleted')
                            <span class="font-weight-bold d-block" style="position: absolute;bottom: 20%;right: 41%;background: rgba(255,255,255,0.5);">Deleted</span>
                            @endif
                            <span class="font-weight-bold d-block" style="position: absolute;bottom: 20%;right: 41%;background: rgba(255,255,255,0.5);">
                                {{ \Carbon\Carbon::parse($transfer_ticket->date_used)->format('d-m-Y') }}
                            </span>
                            @if(isset($transfer_ticket->transfered_phone))
                                <span class="font-weight-bold d-block" style="position: absolute;bottom: 0%;right: 41%;background: rgba(255,255,255,0.5);">{{$transfer_ticket->transfered_phone}}</span>
                            @endif
                        </div>
                    @else
                        <div class="alert alert-danger d-block">
                           No Ticket Found!
                        </div>
                    @endif
                @endif
            </div>
        </center>
    </div>
</div>

@push('script2')
    <script>
    $(document).ready(function () {
        $('#phone_no').keyup(function () {
            let phone = $('#phone_no').val();
            console.log(phone);
            if(phone === '' || phone === null || phone === undefined) {
                $('#phone_no').removeClass('error');
                $('.errorDetails').empty().addClass('d-none');
            }
            else {
                if(isNumber(phone) === false) {
                    $('#phone_no').addClass('error');
                    $('.errorDetails').empty().text('Phone Number should be number format.').removeClass('d-none');
                    return false;
                }
                else {
                    $('#phone_no').removeClass('error');
                    $('.errorDetails').empty().addClass('d-none');
                    return true;
                }
            }
        });

        $('#transfer_ticket').click(function () {
            let phone = $('#phone_no').val();
            let check_valid = requiredCheck();
            if(check_valid === true) {
                let data = {'_token' : '{{csrf_token()}}', phone};
                $.ajax({
                    type: 'post',
                    url: '{{route('sponsor.ticket.transfer')}}',
                    data,
                    success: function (response) {
                        console.log(response, response.status);
                        if(response.status === 200) {
                            $.confirm({
                                title: 'Beskjed',
                                content: response.message,
                                type: 'green',
                                typeAnimated: true,
                                buttons: {
                                    OK: {
                                        text: 'JA',
                                        btnClass: 'btn-green',
                                        width: 500,
                                        action: function () {
                                            window.location.replace("{{route('app', ['name' => 'greenfee'])}}");
                                        }
                                    },
                                }
                            });
                        }
                        else {
                            $.confirm({
                                title: 'Beskjed',
                                content: response.message,
                                type: 'red',
                                typeAnimated: true,
                                buttons: {
                                    OK: {
                                        text: 'JA',
                                        btnClass: 'btn-red',
                                        width: 500,
                                        action: function () {
                                            window.location.reload();
                                        }
                                    },
                                }
                            });
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        // console.log(textStatus, errorThrown);
                        $.confirm({
                            title: 'Beskjed',
                            content: 'Sorry Somthing went wrong.',
                            type: 'red',
                            typeAnimated: true,
                            buttons: {
                                OK: {
                                    text: 'JA',
                                    btnClass: 'btn-red',
                                    width: 500,
                                    action: function () {
                                        window.location.reload();
                                    }
                                },
                            }
                        });
                    }
                });
            }
        });

        $(document).on('click', '#cancel_ticket', function (e) {
            let tick_url = "{{ route('app', ['name' => 'greenfee']) }}";
            window.location.replace(tick_url);
        });

        $(document).on('click', '.ticket_change_status1', function (e) {
            e.preventDefault();
            var ticket_id = $(this).data('id');
            var status = $(this).data('status');
            var _token = "{{ csrf_token() }}";

            $.confirm({
                title: 'Er du sikker?',
                content: 'Ønsker du å benytte billetten?',
                type: 'red',
                typeAnimated: true,
                buttons: {
                    OK: {
                        text: 'JA',
                        btnClass: 'btn-red',
                        width: 500,
                        action: function () {
                            var data = $('#newmember').serialize();
                            var _token = "{{ csrf_token() }}";
                            console.log(data);
                            $.ajax({
                                url: "{{ route('ticket_change_status_app') }}",
                                method: "POST",
                                data: {status, ticket_id, _token},
                                success: function (res) {
                                    if (res.status == true) {
                                        let tick_url = "{{ route('app', ['name' => 'greenfee']) }}";
                                        window.location.replace(tick_url);
                                    }
                                }
                            });
                        }
                    },
                    cancelButton: {
                        text: 'NEI',
                        action: function () {

                        }
                    },
                }
            });
        });

        function requiredCheck() {
            let phone = $('#phone_no').val();
            if (phone === '' || phone === null || phone === undefined) {
                $('#phone_no').addClass('error');
                $('.errorDetails').empty().text('Phone Number is required.').removeClass('d-none');
                return false;
            }
            else {
                if(isNumber(phone) === false) {
                    $('#phone_no').addClass('error');
                    $('.errorDetails').empty().text('Phone Number should be number format.').removeClass('d-none');
                    return false;
                }
                else {
                    return true;
                }
            }
        }

        function isNumber(number) {
            var regex = /^(0|[0-9]\d*)$/;
            console.log(regex);
            return regex.test(number);
        }
    });
    </script>
@endpush
