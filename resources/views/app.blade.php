@extends('layout')
@section('home')
    @push('link')
        <style>
            .label {
                cursor: pointer;
            }

            .progress {
                display: none;
                margin-bottom: 1rem;
            }

            .alert {
                display: none;
            }

            .img-container img {
                max-width: 100%;
            }
        </style>
        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
       <link rel="stylesheet" href="/app_calender/style.css">     --}}
    @endpush
    {{-- @push('link')
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    @endpush
    @push('script2')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    @endpush --}}
    <div class="container-fluid" id="appPage">
        <div class="row">
            <div class="col-12 ">
                <div class="container">
                    @if((!empty($validate) && $validate == "success_otp") || (Cookie::has('validated_otp') && Cookie::get('validated') === 'true'))
                        <div class="nav-menu">
                            @include('appViews.menu')
                        </div>
                    @endif

                    <div class="row mb-2">
                        @if ($parameter != "card")
                            @if(((!empty($validate) && $validate == "success_otp") || (Cookie::has('validated_otp') && Cookie::get('validated') === 'true')) && ($parameter === 'front' ||  $parameter === ''))
                                <div class="col-12">
                                    <div class="upStyle" style="background: #fff;">
                                        <div class="row">
                                            <div class="col-12 p-3 banner">
                                                <div class="">
                                                    <center>
                                                        <img class="img-fluid" src="{{asset('images/banner.jpg')}}">
                                                    </center>
                                                </div>
                                            </div>
                                            <div id="installContainer"
                                                 style="position: absolute; display: block; right: 4%; top: 3%; z-index: 1;"
                                                 class="d-none">
                                                <button style="border-radius: 5px;" class="btn btn-primary add-button"
                                                        id="buttonInstall">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                         fill="currentColor" class="bi bi-download" viewBox="0 0 16 16">
                                                        <path
                                                            d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                                                        <path
                                                            d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                                                    </svg>
                                                </button>
                                            </div>
                                            @if (isset($newsInfo) && isset($newsInfo->header) && isset($newsInfo->body))
                                                <div class="col-12 p-3 banner">
                                                    <div class="update_form" style="border: 2px solid #000;">
                                                        <div class="app-header mb-0">
                                                            <h4 class="pl-3">{{$newsInfo->header}}</h4>
                                                        </div>
                                                        <div class="card-body">
                                                            <p class="mb-0 text-justify">
                                                                {{$newsInfo->body}}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if($memberdata->member_type !== 'Sponsor' && $memberdata->member_type !== 'Passiv')
                                            <a class="btn btn-primary mb-3 ml-auto mr-auto d-table"
                                               href="{{route('app', ['name' => 'play'])}}">Registrer dagens spill!</a>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="homeFrame">
                                        <iframe class="tournamentFrame" id="tournamentFrameOne"
                                                src="https://occ.no/posts/banestatus/" width="100%"
                                                title="TERMINLISTE"></iframe>
                                    </div>
                                </div>
                            @endif
                            @if(isset($validate) && $validate == 'success')
                                <div class="col-12 p-3 banner">
                                    <div class="">
                                        <center>
                                            <img class="img-fluid" src="{{asset('images/banner.jpg')}}">
                                        </center>
                                    </div>
                                </div>
                                <div class="col-12 p-3">
                                    <div class="text-center mt-3" style="margin-bottom: -30px;">
                                        <b>Legg inn engangspassordet vi har sendt deg på SMS</b>
                                    </div>
                                </div>
                            @endif
                        @endif

                        <div class="col-12">
                            @if((!empty($validate) && $validate == "success_otp") || (Cookie::has('validated_otp') && Cookie::get('validated') === 'true'))
                                @if ($parameter == "front"  || $parameter == "")
                                @elseif ($parameter == "info")
                                    @include('appViews.info')
                                @endif

                                <form id="update_form"
                                      style="@if($parameter !== "play2" && $parameter !== "info")border: 2px solid;@endif">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <center>
                                                @if ($parameter == "front"  || $parameter == "")
                                                    <label class="col-sm-12 col-form-label pt-4">
                                                        Velg <a href="{{url('/')}}/app?name=card">KORT </a> i menyen for
                                                        å få frem ditt medlemskort.

                                                    </label>
                                                    <label class="col-sm-12 col-form-label pb-4">
                                                        For å endre ditt <a href="{{url('/')}}/app?name=hcp">HCP </a>
                                                        gjøres det under Handikap i menyen.
                                                    </label>

                                                @elseif ($parameter == "card")
                                                    <div class="app-header">
                                                        <h4>DITT MEDLEMSKORT</h4>
                                                    </div>

                                                    <div class="col-12 p-1 logo_img">
                                                        <img class="img-fluid"
                                                             src="{{asset('images/Medlemskort-2021.png')}}">
                                                    </div>

                                                    <div class="col-12  form">
                                                        <table class="table table-borderless">
                                                            <tbody>
                                                                <tr>
                                                                    <th>Name</th>
                                                                    <td>{{!empty($memberdata)?$memberdata->Member_Fistname . ' '. $memberdata->Member_Lastname:null}}</td>
                                                                </tr>
                                                                <tr>
                                                                    <th>Member Since</th>
                                                                    <td>{{!empty($memberdata->member_since)?date('m-Y', strtotime($memberdata->member_since)):null}}</td>
                                                                </tr>
                                                                <tr class="handicap">
                                                                    @if ($memberdata->app_hcp_status == 'manual')
                                                                        <th>Current HCP</th>
                                                                        <td>{{!empty($memberdata)?$memberdata->handicap:null}}</td>
                                                                    @else
                                                                        <th>Current HCP</th>
                                                                        <td>{{!empty($memberdata->new_hcp)?$memberdata->new_hcp:$memberdata->HCP}}</td>
                                                                    @endif
                                                                </tr>
                                                            </tbody>
                                                        </table>

                                                    </div>
                                                    <div class="col-12 p-1 logo_img">
                                                        <b>ANY COURTESIES EXTENDED TO OUR MEMBER
                                                            WILL BE HIGHLY APPRECIATED </b>
                                                    </div>
                                            </center>

                                            @elseif ($parameter == "hcp")
                                                @include('appViews.hcp')
                                            @elseif ($parameter == "ferry")
                                                @include('appViews.ferry')
                                            @elseif ($parameter == "greenfee")
                                                @include('appViews.greenFree')
                                            @elseif ($parameter == "buggy")
                                                @include('appViews.buggy')
                                            @elseif ($parameter == "pro-lessons")
                                                @include('appViews.proLessions')
                                            @elseif ($parameter == "play")
                                                <div class="round-reg" style="border-top: 2px solid #000;">
                                                    @include('appViews.play.memberPlay', ['member' => $memberdata ?? [], 'familyMembers' => $memberPlayRegData['familyMembers'] ?? [], 'clubs' => $memberPlayRegData['clubs'] ?? [], 'todayRegistration' => $memberPlayRegData['todayRegistration'] ?? [], 'playedMembers' => []])
                                                </div>
                                            @elseif ($parameter == "play2")
                                                @include('appViews.tournament')
                                            @elseif ($parameter == "group")
                                            @elseif ($parameter == "mine-fasiliteter")
                                                @include('appViews.myFacilities')
                                            @elseif ($parameter == "min-kontaktinfo")
                                                @include('appViews.minKontaktinfo')
                                            @elseif ($parameter == "setup")
                                                @include('appViews.setup')
                                            @elseif ($parameter == "ticket")
                                                @include('appViews.transfer_ticket')
                                            @elseif ($parameter == "pay")
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="app-header">
                                                            <h4>STATUS RESTAURANTREGNING</h4>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <p class="mb-3 text-center mt-0">
                                                            <strong>Kommer snart!</strong>
                                                        </p>
                                                    </div>
                                                    <div class="col-12">
                                                        <p class="front-site-info mb-3 mt-0 p-3">
                                                            Denne informasjon er hentet fra vår kasse og oppdateres
                                                            løpende. Beløp over kr. 10 000,- blir fakturert ut til våre
                                                            medlemmer fortløpende. Hvis du ønsker å betale ned på denne
                                                            konto kan det gjøres i kassen eller å ta kontakt med <a
                                                                href="mailto:occ@occ.no">occ@occ.no</a> får å betale
                                                            inn.<br><br><strong>Restsaldo betales ikke tilbake.</strong>
                                                        </p>
                                                    </div>
                                                </div>
                                                @endif

                                                </center>
                                        </div>
                                    </div>
                        </div>
                        </form>
                        @if($parameter == "min-kontaktinfo" && $memberdata->member_type !== 'Sponsor' && $memberdata->member_type !== 'Passiv')
                            <div class="col-sm-12">
                                <p class="front-site-info mb-3">
                                    <span class="text-danger">*</span>
                                    Om du finner feil eller ønsker å oppdatere med korrekt informasjon vennligst sende
                                    en e-post til
                                    <a href="mailto:occ@occ.no">occ@occ.no</a>.
                                </p>
                            </div>
                        @elseif($parameter == "hcp")
                            <div class="col-12"></div>
                        @elseif($parameter == "greenfee")
                            <div class="col-12">
                                <p class="handicap-info mb-3 mt-3"><span class="text-danger mr-2">*</span>Kun
                                    forhåndsbestilte billetter vises her. Det er ikke mulig å bestille flere etter at
                                    sesongen har startet.</p>
                            </div>
                        @elseif($parameter == "pro-lessons")
                            <div class="col-12">
                                <p class="handicap-info mb-3 mt-3"><span class="text-danger mr-2">*</span>Nye enkle
                                    billetter kan forhåndsbestilles på <a href="mailto:occ@occ.no">occ@occ.no</a> og
                                    koster kr. 1000,- / stk.</p>
                            </div>
                        @elseif($parameter == "buggy" && $memberdata->member_type !== 'Sponsor' && $memberdata->member_type !== 'Passiv')
                            <div class="col-12">
                                <p class="handicap-info mb-3 mt-3"><span class="text-danger mr-2">*</span>Nye enkle
                                    billetter kan forhåndsbestilles på <a href="mailto:occ@occ.no">occ@occ.no</a> og
                                    koster kr. 450,- / stk.</p>
                            </div>
                        @elseif($parameter == "ferry")
                            <div class="col-12"></div>
                        @endif

                        @else
                            @if ((empty($validate) || ($validate != "success" && $validate != "success_otp" && !Cookie::has('validated_otp'))) && empty($otp_send))
                                <center>

                                    <form action="{{route('validate_otp')}}" method="post">
                                        @if (!empty($validate) && $validate == "success")
                                            <div class="alert alert-success col-md-12 offset-md-5 text-center">
                                                <strong>Suksess!</strong>
                                            </div>
                    </div>
                    @elseif(!empty($validate) && $validate == "check mobile")
                        <div class="form-group row mb-2">
                            <div class="alert alert-danger col-md-12 form-group row">
                                <strong>Fant ikke ditt mobilnummer</strong>
                            </div>
                        </div>
                    @elseif(!empty($validate) && $validate == "otp not matched")
                        <div class="form-group row mb-2">
                            <div class="alert alert-danger col-md-12 form-group row">
                                <strong>FEIL: Engangspassordet stemmer ikke - prøv igjen</strong>
                            </div>
                        </div>
                    @endif
                    @csrf

                    <div class="form-group row mb-0">
                        <div class="col-12 p-3 banner">
                            <div class="">
                                <center>
                                    <img class="img-fluid" src="{{asset('images/banner.jpg')}}">
                                </center>
                            </div>
                        </div>

                        <div class="col-sm-2"></div>

                        <div class="col-sm-8" style="border: solid">
                            <div class="col-sm-12">
                                <br>
                                <b style="font-size: large;"> Skriv inn ditt mobilnummer:</b>
                                <br>
                                <br>
                            </div>
                            <div class="col-sm-6">
                                <input type="tel" pattern="\d*" style="width: 72%;text-align: center;font-size: larger;"
                                       class="form-control hcp-validation" id="mobile" value=""
                                       name="mobile" placeholder="">
                                <br>
                            </div>
                            <div class="col-sm-6">
                                <input type="submit" value="Send engangspassord på SMS" style="width: auto;"
                                       class="btn btn-primary col-sm-12 ">
                            </div>
                            <br>
                            <br>
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-sm-2"></div>
                        <div class="col-sm-8" style="border: solid #212529 3px; margin-top: 25px;">
                            <p class="front-site-info mb-3">
                                Denne appen er kun for medlemmer av OCC.
                            </p>
                            <p class="front-site-info mb-3">
                                For informasjon om klubben, medlemskap og bane besøk oss på <a href="https://www.occ.no"
                                                                                               target="_blank">www.occ.no</a>
                            </p>
                        </div>
                    </div>
                    </form>
                    {{-- {{!empty($validate)?$validate:null}} --}}

                    </center>
                    @endif
                    {{-- {{$validate}} --}}
                    {{--                    {{dd(!empty($validate) ,  $validate == "success" , $validate=="error"  , !empty($otp_send))}}--}}
                    @if (!empty($validate) &&  ($validate == "success" || $validate=="error")  && !empty($otp_send))
                        <center>

                            <form action="{{route('validate_otp')}}" method="post">
                                @if (!empty($validate) && $validate == "success")
                                    {{-- <div class="alert alert-success col-md-12  text-center">
                                            <strong>Success!</strong>
                                        </div>
                                    </div>  --}}
                                @elseif(!empty($validate) && $validate == "check mobile")
                                    <div class="form-group row mb-2">
                                        <div class="alert alert-danger col-md-12 form-group row">
                                            <strong>Fant ikke ditt mobilnummer</strong>
                                        </div>
                                    </div>
                                @elseif(!empty($validate) && $validate == "otp not matched")
                                    <div class="form-group row mb-2">
                                        <div class="alert alert-danger col-md-12 form-group row">
                                            <strong>FEIL: Engangspassordet stemmer ikke - prøv igjen</strong>
                                        </div>
                                    </div>
                                @endif
                                @if ((!empty($validate) && $validate == "success_otp") || (Cookie::has('validated_otp') && Cookie::get('validated') === 'true'))
                                    <div class="alert alert-success col-md-4  text-center">
                                        <strong>Suksess!</strong>
                                    </div>
                </div>
                @elseif(!empty($validate) && $validate == "otp not matched")
                    <div class="form-group row mb-2">
                        <div class="alert alert-danger col-md-10 form-group row">
                            <strong>Vennligst sjekk SMS</strong>
                        </div>
                    </div>
                @endif
                @csrf
                <div class="form-group row col-12 p-3">
                    <div class="col-sm-2"></div>

                    <div class="col-sm-8" style="border: solid">
                        <div class="col-sm-12" style="text-align: center">
                            <br>
                            <b style="font-size: large;"> Engangspassordet er gyldig en dag</b>
                            {{--                            {{dd(Cookie::get('current_otp'))}}--}}
                            <br>
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <input type="tel" style="width: 60%;text-align: center;font-size: larger;" pattern="\d*"
                                   class="form-control hcp-validation" id="otp" value=""
                                   name="otp" placeholder="">
                            <input type="hidden" name="typed_mobile" value="{{!empty($mobile)? $mobile:null}}">
                            <br>
                        </div>
                        <div class="col-sm-6">
                            <input style="width: 60%;" type="submit" value="Bekreft" class="btn btn-primary col-sm-12 ">
                            <br>
                            <small>
                                Hvis du trenger å få det på nytt klikk <a href="#" id="resend-link">her</a>. <br>
                                Hvis du ønsker et nytt klikk <a href="#" id="new-otp-link">her</a>. <br>
                                Det kommer ikke noe, send meg passordet på e-post klikk <a href="#"
                                                                                           id="send-email-link">her</a>.
                            </small>
                        </div>
                        <br>
                        <br>
                        {{-- <span class="help-block alert-primary">
                            <strong>{{ !empty($validate)? $validate:null }}</strong>
                        </span> --}}
                    </div>
                </div>


                </form>

                <form id="re-send" method="POST" action="{{ route('validate_otp', ['type' => 're-send']) }}"
                      class="d-none">
                    @csrf
                    <input type="hidden" name="mobile" value="{{$mobile}}">
                    <button id="re-send-btn" class="d-none">submit</button>
                </form>

                <form id="new-otp" method="POST" action="{{ route('validate_otp', ['type' => 'new-otp']) }}"
                      class="d-none">
                    @csrf
                    <input type="hidden" name="mobile" value="{{$mobile}}">
                    <button id="new-otp-btn" class="d-none">submit</button>
                </form>

                <form id="send-mail" method="POST" action="{{ route('validate_otp', ['type' => 'send-mail']) }}"
                      class="d-none">
                    @csrf
                    <input type="hidden" name="mobile" value="{{$mobile}}">
                    <button id="send-mail-btn" class="d-none">submit</button>
                </form>


                </center>
                @endif
                @endif

            </div>
            {{-- </div> --}}
            {{-- </div> --}}

        </div>
        <div class="row mb-3">
            <div class="col-12 dsm">
            </div>
        </div>


    </div>


    </div>
    </div>
    </div>

@endsection
@push('script2')
    <script>
        window.addEventListener("DOMContentLoaded", function () {
            var form = document.getElementById("re-send");
            document.getElementById("resend-link").addEventListener("click", function () {
                form.submit();
            });

            var form_new_otp = document.getElementById("new-otp");
            document.getElementById("new-otp-link").addEventListener("click", function () {
                form_new_otp.submit();
            });

            var form_send_mail = document.getElementById("send-mail");
            document.getElementById("send-email-link").addEventListener("click", function () {
                form_send_mail.submit();
            });
        });

        window.addEventListener("DOMContentLoaded", function () {
        });
    </script>
    <script>
        $(document).on('click', '.ticket_change_status', function (e) {
            e.preventDefault();
            var ticket_id = $(this).data('id');
            var status = $(this).data('status');
            var _token = "{{ csrf_token() }}";

            $.confirm({
                title: 'Er du sikker?',
                content: 'Ønsker du å benytte billetten?',
                type: 'red',
                typeAnimated: true,
                // autoClose: 'cancelAction|8000',
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
                                        window.location.reload();
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
            })
            // $.ajax({
            //     url: "{{ route('ticket_change_status_app') }}",
            //     method: "POST",
            //     data: {status, ticket_id, _token},
            //     success: function (res) {
            //         if (res.status == true) {
            //             window.location.reload();
            //         }
            //     }
            // });
        });
        $(function () {
            select = $('#hcp_type').val();
            if (select == 'manual') {
                $('.hcp').attr('hidden', true);
                $('.handicap').removeAttr('hidden');
                $('.colmun_online').attr('hidden', true);
            } else if (select == 'online') {
                $('.handicap').attr('hidden', true);
                $('.hcp').removeAttr('hidden');
                $('.colmun_online').removeAttr('hidden');
            }
        });
        $(document).on('change', '#card_hcp_type', function (e) {
            e.preventDefault();
            var select = $(this).val();
            console.log(select);
            if (select == 'manual') {

                $('.hcp').attr('hidden', true);
                $('.handicap').removeAttr('hidden');

            } else if (select == 'online') {
                $('.handicap').attr('hidden', true);
                $('.hcp').removeAttr('hidden');
                $('#selected_message').removeAttr('hidden');
            }
        });
        $(function () {
            // $("#datepicker").datepicker('setDate', 'today');
            // $('#datepicker').datepicker().datepicker('setDate', 'today');
            $("#datepicker").datepicker({
                dateFormat: "dd-MM-yy",
                minDate: -30,
                maxDate: new Date()
            });
        });


        $(document).on('change', '#hcp_type', function (e) {
            e.preventDefault();
            var select = $(this).val();
            // console.log(select);
            if (select == 'manual') {
                $('.hcp').attr('hidden', true);
                $('.handicap').removeAttr('hidden');
                $('.colmun_online').attr('hidden', true);
                $('#selected_message').removeAttr('hidden');
            } else if (select == 'online') {
                $('.handicap').attr('hidden', true);
                $('.hcp').removeAttr('hidden');
                $('.colmun_online').removeAttr('hidden');
                $('#selected_message').removeAttr('hidden');
            }
            var manual_occid = $('.manual_occid').val();
            // console.log(manual_occid);
            $.ajax({
                url: "{{ route('update_hcp_status') }}",
                method: "POST",
                dataType: "json",
                data: {manual_occid: manual_occid},
                success: function (res) {
                    console.log(res.new_online_hcp);

                }
            });

        });
        $(document).on('click', '#hcp_update_manunal', function (e) {
            e.preventDefault();
            $('#hcp_update_manunal').attr('disabled', true);
            $('#hcp_update_manunal').removeAttr('id');
            var manual_occid = $('#manual_occid').val();
            var manuval_hcp = $('#hcp_manual_occid').val();
            var online_hcp = $('#hcp_online_occid').val();
            var club = $('#club').val();
            var date = $('#datepicker').val();
            var hcp_type = $('#hcp_type').val();
            var _token = "{{ csrf_token() }}";
            $.ajax({
                url: "{{ route('hcp_manuval_update') }}",
                method: "POST",
                dataType: "json",
                data: {
                    hcp_type: hcp_type,
                    club: club,
                    date: date,
                    online_hcp: online_hcp,
                    hcp_type: hcp_type,
                    manuval_hcp: manuval_hcp,
                    _token: _token,
                    manual_occid: manual_occid
                },
                success: function (res) {
                    // console.log(res, 'res');
                    // console.log(res.new_online_hcp);
                    if (res.success) {
                        $('#message_updated').removeAttr('hidden');
                        $('#hcp_manual_occid').val(res.new_manuval_hcp);
                        $('#hcp_online_occid').val('');
                        $('#hcp_manual_occid').val('');
                        $('#hcpscroe').val(res.new_online_hcp);
                        $('.update_hcp_button').attr('id', 'hcp_update_manunal');
                        $('.update_hcp_button').removeAttr('disabled');
                    }
                }
            });
        })
    </script>

    {{-- Upload Image Js --}}
    <script>
        window.addEventListener('DOMContentLoaded', function () {
            var avatar = document.getElementById('avatar');
            var image = document.getElementById('image');
            var input = document.getElementById('input');
            var $progress = $('.progress');
            var $progressBar = $('.progress-bar');
            var $alert = $('.alert');
            var $modal = $('#modal');
            var cropper;

            $('[data-toggle="tooltip"]').tooltip();

            input.addEventListener('change', function (e) {
                var files = e.target.files;
                var done = function (url) {
                    input.value = '';
                    image.src = url;
                    $alert.hide();
                    $modal.modal('show');
                };
                var reader;
                var file;
                var url;

                if (files && files.length > 0) {
                    file = files[0];

                    if (URL) {
                        done(URL.createObjectURL(file));
                    } else if (FileReader) {
                        reader = new FileReader();
                        reader.onload = function (e) {
                            done(reader.result);
                        };
                        reader.readAsDataURL(file);
                    }
                }
            });

            $modal.on('shown.bs.modal', function () {
                cropper = new Cropper(image, {
                    aspectRatio: 1,
                    viewMode: 6,
                });
            }).on('hidden.bs.modal', function () {
                cropper.destroy();
                cropper = null;
            });

            document.getElementById('crop').addEventListener('click', function () {
                var initialAvatarURL;
                var canvas;

                $modal.modal('hide');

                if (cropper) {
                    canvas = cropper.getCroppedCanvas({
                        width: 160,
                        height: 160,
                    });
                    initialAvatarURL = avatar.src;
                    avatar.src = canvas.toDataURL();
                    $progress.show();
                    $alert.removeClass('alert-success alert-warning');
                    canvas.toBlob(function (blob) {
                        var formData = new FormData();
                        formData.append('avatar', blob, 'avatar.jpg');

                        var reader = new FileReader();
                        reader.readAsDataURL(blob);
                        reader.onloadend = function() {
                            var base64data = reader.result;

                            console.log(formData);
                            $.ajax('{{route('change.profile.image')}}', {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                data: {image: base64data, '_token' : '{{csrf_token()}}'},
                                // processData: false,
                                // contentType: false,

                                /*xhr: function () {
                                    var xhr = new XMLHttpRequest();
                                    console.log(xhr);

                                    xhr.upload.onprogress = function (e) {
                                        var percent = '0';
                                        var percentage = '0%';

                                        if (e.lengthComputable) {
                                            percent = Math.round((e.loaded / e.total) * 100);
                                            percentage = percent + '%';
                                            $progressBar.width(percentage).attr('aria-valuenow', percent).text(percentage);
                                        }
                                    };

                                    return xhr;
                                },*/

                                success: function (data) {
                                    let img = "{{url('app/get-profile-img')}}/"+data.response;
                                    // console.log(data);
                                    $modal.modal('hide');
                                    $('#uploaded_image').attr('src', img);
                                    //alert("success upload image");
                                },

                                error: function () {
                                    avatar.src = initialAvatarURL;
                                    $alert.show().addClass('alert-warning').text('Upload error');
                                },

                                complete: function () {
                                    $progress.hide();
                                },
                            });
                        }
                    });
                }
            });
        });
    </script>
@endpush
