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
            <p class="front-site-info mb-3 mt-0">Trykk på den enkelte billetten for å benytte den i kiosken. Husk at du må være der sammen med gjesten som må ha med mobil for registrering. Alternativt kan du sende en billett til din gjest slik at de kan pre-registere seg og spare tid i kiosken. Dette bør gjøres samme dag som dere spiller.</p>
        </div>
        <center>
            <div class="col-12" style="PADDING: 12px;">
                @if(isset($tickets['Greenfee']))
{{--                    <p class="font-weight-bold">Trykk på den enkelte billetten for å benytte den!</p>--}}
                    {{-- Sending Tickets --}}
                    <div class="row">
                        <div class="col col-sm-8 offset-sm-2">
                            <div class="pl-2 pr-2">
                                <p class="text-danger">
                                    <strong>
                                        HER ER DINE GJESTEBILLETTER
                                    </strong>
                                </p>
<!--                                <p class="">
                                    <strong>
                                        Send en invitasjon til din gjest ved å legge inn mobilnummer og trykk SEND. Møtt opp i kiosken sammen med din gjest for å hente en digital bagtag FØR SPILL.
                                    </strong>
                                </p>-->
                            </div>
                        </div>
                    </div>
<!--                    <div class="row">
                        <div class="col col-sm-4 offset-sm-4">
                            <div class="ml-3 mr-3 mb-2 mb-2">
                                <div class="input-group">
                                    <input type="tel" class="form-control" id="phone_no" placeholder="Mobilnummer"
                                           aria-describedby="phone_no_help" autocomplete="off">
                                    <div class="input-group-append">
                                        <label class="btn btn-primary" id="transfer_ticket" type="button">SEND</label>
                                    </div>
                                </div>
                                <div>-->
                                    {{-- <small id="phone_no_help" class="form-text text-muted float-left">Du kan videresende en gjestespill billett til en gjest. Gjest må ha mobil for å kunne spille da kvitteringen som sendes ut bare er digital.</small> --}}
<!--                                    <span class="d-none errorDetails float-left"></span>
                                </div>
                                <div class="js-message"></div>
                            </div>
                        </div>
                    </div>-->
<!--                    <div class="row">
                        <div class="col col-sm-8 offset-sm-2">
                            <div class="pl-2 pr-2">
                                <p>
                                    <strong>
                                        Din gjest må ha mobil for å kunne spille da kvitteringen som sendes ut fra kiosken er digital. Vi anbefaler ikke å sende flere billetter til samme gjest før de faktisk skal brukes. Billetten kan ikke hentes tilbake og er personlig ( kan ikke videresendes til andre igjen).
                                    </strong>
                                </p>
                            </div>
                        </div>
                    </div>-->
                    {{-- Sending Tickets End --}}

                    <div class="row">
                        <div class="col col-sm-8 offset-sm-2">
                            <ul class="nav nav-pills nav-fill" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="btn btn-outline-primary nav-link mr-3 active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">AKTIVE</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="btn btn-outline-primary nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">BRUKTE</a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                {{-- Active Tickets --}}
                                <div class="tab-pane p-4 active" id="home" role="tabpanel" aria-labelledby="home-tab">
{{--                                    {{dd(!empty($tickets['Greenfee'][""]))}}--}}
                                    @if(!empty($tickets['Greenfee'][""]))
                                        @foreach ($tickets['Greenfee'][""] as $ticket)
                                            <div
                                                data-status="done"
                                                data-id="{{ $ticket->id }}"
                                                class="col-sm-8 col-md-5 not_used_ticket ticket_change_status1 pro_time_ticket green_free_ticket">
                                                <img src="{{asset('images/Greenfee_guest.png')}}"
                                                     class="img-fluid ml-auto mr-auto" style="" alt="{{$ticket->product}}">
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="tab-pane p-4" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                                    @if(!empty($tickets['Greenfee']["used"]))
                                        @foreach ($tickets['Greenfee']["used"] as $ticket)
                                            @if (!empty($ticket->transfered_from))
                                                <div class="col-sm-8 col-md-5 used_ticket green_free_ticket" style="background: url('./images/guest-play-big.jpg');background-size: contain;background-position: center;background-repeat: no-repeat;">
                                                    @if($ticket->ticket_used == 'deleted')
                                                        <span class="font-weight-bold d-block" style="position: absolute;bottom: 40%;right: 0%; width: 100%; background: rgba(255,255,255,0.5);">Deleted</span>
                                                    @endif
                                                    @if(isset($ticket->date_used))
                                                    <span class="font-weight-bold d-block" style="position: absolute;bottom: 20%;right: 0%; width: 100%; background: rgba(255,255,255,0.5);">
                                                        {{ \Carbon\Carbon::parse($ticket->date_used)->format('d-m-Y') }}
                                                    </span>
                                                    @endif
                                                    @if(isset($ticket->transfered_phone))
                                                        <span class="font-weight-bold d-block" style="position: absolute;bottom: 0%;right: 0%; width: 100%; background: rgba(255,255,255,0.5);">{{$ticket->transfered_phone}}</span>
                                                    @endif
                                                </div>
                                            @else
                                                <div class="col-sm-8 col-md-5 used_ticket green_free_ticket" style="background: url('./images/guest-play-big.jpg');background-size: contain;background-position: center;background-repeat: no-repeat;">
                                                    <span class="font-weight-bold d-block" style="position: absolute;bottom: 20%; right: 0%; width: 100%; background: rgba(255,255,255,0.5);">{{ \Carbon\Carbon::parse($ticket->date_used)->format('d-m-Y') }}</span>
                                                    <span class="font-weight-bold d-block" style="position: absolute;bottom: 0%; right: 0%; width: 100%; background: rgba(255,255,255,0.5);">KIOSK</span>
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>


                @endif
            </div>
        </center>
    </div>
</div>

{{-- <div class="row">
    <div class="col col-sm-4 offset-sm-4">
        <div class="ml-3 mr-3 mb-5">
            <div class="input-group">
                <input type="tel" class="form-control" id="phone_no" placeholder="Mobilnummer"
                       aria-describedby="phone_no_help">
                <div class="input-group-append">
                    <label class="btn btn-primary" id="transfer_ticket" type="button">Send</label>
                </div>
            </div>
            <div>
                <small id="phone_no_help" class="form-text text-muted float-left">Du kan videresende en gjestespill billett til en gjest. Gjest må ha mobil for å kunne spille da kvitteringen som sendes ut bare er digital.</small>
                <span class="d-none errorDetails float-left"></span>
            </div>
            <div class="js-message"></div>
        </div>
    </div>
</div> --}}

@push('link')
    <style>
        .form-control.error {
            border-color: #5b0000;
        }
        .form-control.error:focus {
             box-shadow: 0 0 0 0.2rem rgba(203, 77, 75, 0.45);
        }
        .errorDetails {
            background: #580400;
            border-radius: 4px;
            text-align: left;
            color: #fff;
            padding: 0px 6px 2px;
            margin-top: 2px;
        }
    </style>
@endpush
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

        $(document).on('click', '.ticket_change_status1', function (e) {
            var ticket_id = $(this).data('id');
            var status = $(this).data('status');
            let tick_url = "{{ route('app', ['name' => 'ticket']) }}&ticket="+ticket_id;
            window.location.replace(tick_url);
        });
    </script>
@endpush
