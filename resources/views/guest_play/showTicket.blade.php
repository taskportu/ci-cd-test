@extends('layout')
@section('home')
    <div class="container" id="appPage">
        <div class="row mt-5">
            <div class="col-12 col-sm-10 offset-sm-1">
                <div class="card-header bg-dark text-white">{{ strtoupper($header) }}</div>
                @if(isset($error))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Sorry!</strong> {{$error}}
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
                @if(Session::has('errors'))
                    @foreach($errors as $err)
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Sorry!</strong> {{$err}}.
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endforeach
                @endif
                <div class="js-messages"></div>
                @if(isset($ticket))
                    @if(!isset($ticket->ticket_used) && $type === 'ticket')
                        <div class="guest-play text-center">
                            @if(!isset($guest))
                                 <p class="front-site-info font-weight-bold text-center">Du har blitt invitert av {{ $member->Member_Fistname ?? '' }} {{ $member->Member_Lastname ?? '' }} til Oustøen Country Club. Du MÅ hente din billett i kiosken på klubbhuset FØR SPILL. Vennligst pre-registrere deg under og les klubbens retingslinjer for gjestespill før oppmøte.</p>
                            @else
                                <p class="front-site-info font-weight-bold text-center">Takk! Møt opp i kiosken sammen med medlemmet for å hente en digital bagtag FØR SPILL.</p>
                            @endif
                            <form class="mt-3" id="form-submit" action="" method="post">
{{--                                    <p class="text-left">Under finner du det vi har pre-registret.</p>--}}
                                @csrf
                                <div class="row mb-4">
                                    <div class="col-12 col-sm-6 mb-2">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Fornavn</span>
                                            </div>
                                            <input type="text" class="form-control" name="guestFName" @if(isset($guest->reg_fistname)) value="{{ $guest->reg_fistname }}" disabled @endif>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 mb-2">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Etternavn</span>
                                            </div>
                                            <input type="text" class="form-control" name="guestLName" @if(isset($guest->reg_fistname)) value="{{ $guest->reg_lastname }}" disabled @endif>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 mb-2">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Mobil</span>
                                            </div>
                                            <input type="text" class="form-control" name="mobile" value="{{ $transferred_phone_no }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 mb-2">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Klubb</span>
                                            </div>
                                            <select name="club" id="club" class="form-control"  @if(isset($guest->reg_club)) disabled @endif>
                                                <option value="">Select</option>
                                                @if($clubs->isNotEmpty())
                                                    @foreach($clubs as $club)
                                                        <option value="{{$club->value}}" @if(isset($guest->reg_club) && $guest->reg_club == $club->text) selected disabled @endif>{{$club->text}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 mb-2">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">HCP</span>
                                            </div>
                                            <input type="text" class="form-control" name="hcp" autocomplete="off" @if(isset($guest->reg_hcp)) value="{{ $guest->reg_hcp }}" disabled @endif>
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-6 mb-2">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">Gjest av</span>
                                            </div>
                                            <input type="text" class="form-control" value="{{ $member->Member_Fistname }} {{ $member->Member_Lastname ?? ''}}" readonly disabled>
                                            <input type="hidden" class="form-control" name="member" value="{{ $member->MemberID }}">
                                        </div>
                                    </div>
                                    <input type="hidden" name="payment" value="Voucher">
                                     @if(!isset($guest))
                                    <div class="col-12 col-sm-6 mb-2">
                                        <label class="btn btn-success d-block w-100 form-submit-btn">Pre-Registrer</label>
                                    </div>
                                    @endif
                                </div>
                            </form>
                            @if(!isset($guest))
                                <p class="front-site-info font-weight-bold text-center">Under er din ubrukte invitasjon. Fyll ut din pre-registrering over og vis denne invitasjon i Kiosken sammen med medlemmet. Du må ikke klikke på/bruke invitasjonen før du er i Kiosken, da mister du den.</p>
                            @endif
                            <div
                                data-reference="{{ $reference }}"
                                class="ml-auto mr-auto col-sm-8 col-md-5 @if (empty($ticket->ticket_used) && (!isset($guest))) not_used_ticket ticket_change_status @else used_ticket @endif green_free_ticket">
                                <div class="" style="background: url('../images/guest-play-big.jpg'); background-size: contain;background-position: center; background-repeat: no-repeat; height: 90px;">
                                    <img src="{{asset('images/Greenfee_guest.png')}}" class="img-fluid ml-auto mr-auto mt-1" style="" alt="{{$ticket->product}}">
                                    @if(!isset($ticket->date_used))
                                        <span class="font-weight-bold d-block" style="position: absolute;bottom: 40%;right: 38%;background: rgba(255,255,255,0.5);">
                                    {{ \Carbon\Carbon::parse($ticket->date_used)->format('d-m-Y') }}
                                </span>
                                    @endif
                                    @if(isset($guest))
                                        <span class="font-weight-bold d-block" style="position: absolute; bottom: 20%; right: 35%; background: rgba(255,255,255,0.5);">
                                    {{$guest->reg_fistname}} {{$guest->reg_lastname}}
                                </span>
                                    @endif
                                    <span class="font-weight-bold d-block" style="position: absolute; bottom: 0%; right: 31%; background: rgba(255,255,255,0.5);">
                                    Gjest av {{ $member->Member_Fistname ?? '' }} {{ $member->Member_Lastname ?? '' }}
                                </span>
                                </div>
                            </div>
                            <p class="font-weight-bold">
                                @if($used_count == 0)
                                    Dette blir din 1 runde. Etter dette kan du bare spille 2 ganger til denne sesongen.
                                @elseif($used_count == 1)
                                    Dette blir din 2 runde. Etter dette kan du bare spille 1 ganger til denne sesongen.
                                @elseif($used_count == 2)
                                    Dette blir din 3 runde. Etter denne runden har du ikke anledning til å spille flere runder denne sesongen.
                                @endif
                            </p>
                        </div>
                        <p class="font-weight-bold">Under finner du retningslinjer for spill på Oustøen.</p>
                        @include('guest_play.show_ticket_invitation_news')
                    @elseif(isset($ticket->ticket_used) && $type === 'ticket')
                        @if($ticket->ticket_used == 'deleted')
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                Denne gjestespill billetten er ikke lenger aktiv. Har du spørsmål ta kontakt med {{ $member->Member_Fistname }} {{ $member->Member_Lastname ?? '' }} som sendte deg denne.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @else
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                Denne gjestebilletten fra {{ $member->Member_Fistname }} {{ $member->Member_Lastname ?? '' }} er registert brukt {{ $ticket->date_used }}.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                    @endif
                @endif

                @if(isset($registration) && $type === 'proof-of-purchase')
                    <div class="guest-play text-center">
                        <p class="front-site-info font-weight-bold mb-2 mt-2 text-center ">Gyldig {{ \Carbon\Carbon::parse($registration->reg_time)->format('d-m-Y') }}. Dette er din gjestebillett. Vennligst vise denne melding til starter / marshal før start.</p>
                        <div
                            data-reference="{{ $reference }}"
                            class="ml-auto mr-auto col-sm-8 col-md-5 used_ticket green_free_ticket">
                            <div class="" style="background: url('../images/guest-play-big.jpg'); background-size: contain;background-position: center; background-repeat: no-repeat; height: 120px;">
                                {{-- <img src="{{asset('images/Greenfee_guest.png')}}" class="img-fluid ml-auto mr-auto mt-1" style="" alt="Greenfee"> --}}
                                @if(\Carbon\Carbon::now()->format('Y-m-d') > $registration->reg_time)
                                <div class="expired-div" style=""><span class="expired-text" style="">UTLØPT</span></div>
                                @endif

                                <div>
                                    @if(isset($registration->reg_time))
                                    <span class="font-weight-bold d-block" style="position: absolute;bottom: 60%; right: 0%; width: 100%; background: rgba(255,255,255,0.5);">
                                        {{ \Carbon\Carbon::parse($registration->reg_time)->format('d-m-Y') }}
                                    </span>
                                    @endif
                                    @if(isset($guest))
                                    <span class="font-weight-bold d-block" style="position: absolute;bottom: 40%; right: 0%; width: 100%; background: rgba(255,255,255,0.5);">
                                        {{$registration->reg_fistname}} {{$registration->reg_lastname}}
                                    </span>
                                    @endif
                                    <span class="font-weight-bold d-block" style="position: absolute; bottom: 20%; right: 0%; width: 100%; background: rgba(255,255,255,0.5);">
                                        Gjest av {{ $member->Member_Fistname ?? '' }} {{ $member->Member_Lastname ?? '' }}
                                    </span>
                                    @if($registration->member_type === 'Sponsor')
                                        <span class="font-weight-bold d-block" style="position: absolute; bottom: 0%; right: 0%; width: 100%; background: rgba(255,255,255,0.5);">SPONSOR BILLETT</span>
                                    @elseif ($registration->member_type === 'Passiv')
                                        <span class="font-weight-bold d-block" style="position: absolute; bottom: 0%; right: 0%; width: 100%; background: rgba(255,255,255,0.5);">PASSIV MEDLEM</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <p class="font-weight-bold">
                            @if($used_count == 1)
                                Dette er din 1 runde. Du kan spille 2 runder til som gjest denne sesongen.
                            @elseif($used_count == 2)
                                Dette er din 2 runde. Du kan spille en runde 1 runde til som gjest denne sesongen.
                            @elseif($used_count == 3)
                                Dette er din 3 runde. Dette er din siste runde du kan spille som gjest denne sesongen.
                            @endif
                        </p>
                    </div>
                    <p class="font-weight-bold">Under finner du retningslinjer for spill på Oustøen.</p>
                    @include('guest_play.show_ticket_invitation_news')
                @elseif(!isset($registration) && $type === 'proof-of-purchase')
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        Billett ikke funnet!
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@push('script2')
    <script>
        @if(isset($ticket))
            $('.ticket_change_status').on('click', function (e) {
                e.preventDefault();
                var reference = $(this).data('reference');
                var _token = "{{ csrf_token() }}";
                var url = "{{ route('showticket', ['type' => $type, 'reference' => $reference]) }}";

                $.confirm({
                    title: 'Er du helt sikker?',
                    content: 'Vil du bruke denne billetten?  Skal kun gjøres sammen med ansatte i kiosken.',
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                        OK: {
                            text: 'OK',
                            btnClass: 'btn-red',
                            width: 500,
                            action: function () {
                                $.ajax({
                                    url,
                                    method: "POST",
                                    data: {reference, _token},
                                    success: function (res) {
                                        if (res.status == true) {
                                            $.confirm({
                                                title: 'Melding',
                                                content: 'Billetten er nå brukt!',
                                                type: 'green',
                                                typeAnimated: true,
                                                buttons: {
                                                    OK: {
                                                        text: 'OK',
                                                        btnClass: 'btn-green',
                                                        width: 500,
                                                        action: function () {
                                                            window.location.reload();
                                                        }
                                                    },
                                                }
                                            })
                                        }
                                    }
                                });
                            }
                        },
                        cancelButton: {
                            text: 'NEI',
                            action: function () {}
                        },
                    }
                })
            });

            $('.form-submit-btn').on('click', function (e) {
                e.preventDefault();
                let data = $('#form-submit').serialize()+'&reference={{ $reference }}';
                let url = "{{ route('app.guest.play.register') }}";

                $.ajax({
                    url,
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data,
                    success: function (res) {
                        if (res.status == true) {
                            $.confirm({
                                title: 'Beskjed',
                                content: 'Din registrering er gjennomført. Registreringen gir ikke rett til å spille. Du må i fortsatt sammen med et medlem, få registreringen godkjent i kiosken.',
                                type: 'green',
                                typeAnimated: true,
                                buttons: {
                                    OK: {
                                        text: 'OK',
                                        btnClass: 'btn-green',
                                        width: 500,
                                        action: function () {
                                            window.location.reload();
                                        }
                                    },
                                }
                            });
                        }
                        else {
                            $.confirm({
                                title: 'Beskjed',
                                content: res.message,
                                type: 'red',
                                typeAnimated: true,
                                buttons: {
                                    OK: {
                                        text: 'OK',
                                        btnClass: 'btn-red',
                                        width: 500,
                                        action: function () {}
                                    },
                                }
                            });
                        }
                    }
                });
            });

            $('#member').on('keyup', function() {
                let search = $(this).val();
                $.ajax({
                    type:'POST',
                    headers: {
                        'X-CSRF-TOKEN':'{{ csrf_token() }}'
                    },
                    data: {search},
                    url:'{{ route('autocomplete.member.search') }}',
                    success:function(response) {
                        autocomplete(document.getElementById("member"), response, 'ajax');
                    }
                });
            });

            function autocomplete(inp, arr, type = '') {
                console.log(arr.length);
                console.log(arr);
                /*the autocomplete function takes two arguments,
                the text field element and an array of possible autocompleted values:*/
                var currentFocus;
                var element_id = inp.id;
                var searchWord = inp.value;
                searchWord = searchWord.toLowerCase();

                /*execute a function when someone writes in the text field:*/
                inp.addEventListener("keyup", function(e) {
                    var a, b, i, val = this.value;
                    /*close any already open lists of autocompleted values*/
                    closeAllLists();
                    if (!val) { return false;}
                    currentFocus = -1;
                    /*create a DIV element that will contain the items (values):*/
                    a = document.createElement("DIV");
                    a.setAttribute("id", this.id + "autocomplete-list");
                    a.setAttribute("class", "autocomplete-items");

                    /*append the DIV element as a child of the autocomplete container:*/
                    this.parentNode.appendChild(a);
                    /*for each item in the array...*/
                    for (i = 0; i < arr.length; i++) {
                        let in_value = arr[i]['value'];
                        let in_text = arr[i]['text'];

                        if(type == '') {
                            /*check if the item starts with the same letters as the text field value:*/
                            if (in_text.substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                                /*create a DIV element for each matching element:*/
                                b = document.createElement("DIV");
                                /*make the matching letters bold:*/
                                b.innerHTML = "<strong>" + in_text.substr(0, val.length) + "</strong>";
                                b.innerHTML += in_text.substr(val.length);
                                /*insert a input field that will hold the current array item's value:*/
                                b.innerHTML += "<input type='hidden' value='" + in_text + "'>";
                                /*execute a function when someone clicks on the item value (DIV element):*/
                                b.addEventListener("click", function(e) {
                                    /*insert the value for the autocomplete text field:*/
                                    inp.value = this.getElementsByTagName("input")[0].value;
                                    // inp.setAttribute('data-no', in_value);
                                    $('.'+element_id+'_hidden').val(in_value);
                                    /*close the list of autocompleted values,
                                    (or any other open lists of autocompleted values:*/
                                    closeAllLists();
                                });
                                a.appendChild(b);
                            }
                        }
                        else if(type == 'ajax') {
                            /*create a DIV element for each matching element:*/
                                b = document.createElement("DIV");

                                /*make the matching letters bold:*/
                                b.innerHTML = in_text;

                                /*insert a input field that will hold the current array item's value:*/
                                b.innerHTML += "<input type='hidden' value='" + in_text + "'>";
                                /*execute a function when someone clicks on the item value (DIV element):*/
                                b.addEventListener("click", function(e) {
                                    /*insert the value for the autocomplete text field:*/
                                    inp.value = this.getElementsByTagName("input")[0].value;
                                    // inp.setAttribute('data-no', in_value);
                                    $('.'+element_id+'_hidden').val(in_value);
                                    /*close the list of autocompleted values,
                                    (or any other open lists of autocompleted values:*/
                                    closeAllLists();
                                });
                                a.appendChild(b);
                        }

                    }
                });

                /*execute a function presses a key on the keyboard:*/
                inp.addEventListener("keydown", function(e) {
                    var x = document.getElementById(this.id + "autocomplete-list");
                    if (x) x = x.getElementsByTagName("div");
                    if (e.keyCode == 40) {
                        /*If the arrow DOWN key is pressed,
                        increase the currentFocus variable:*/
                        currentFocus++;
                        /*and and make the current item more visible:*/
                        addActive(x);
                    } else if (e.keyCode == 38) { //up
                        /*If the arrow UP key is pressed,
                        decrease the currentFocus variable:*/
                        currentFocus--;
                        /*and and make the current item more visible:*/
                        addActive(x);
                    } else if (e.keyCode == 13) {
                        /*If the ENTER key is pressed, prevent the form from being submitted,*/
                        e.preventDefault();
                        if (currentFocus > -1) {
                            /*and simulate a click on the "active" item:*/
                            if (x) x[currentFocus].click();
                        }
                    }
                });

                function addActive(x) {
                    /*a function to classify an item as "active":*/
                    if (!x) return false;
                    /*start by removing the "active" class on all items:*/
                    removeActive(x);
                    if (currentFocus >= x.length) currentFocus = 0;
                    if (currentFocus < 0) currentFocus = (x.length - 1);
                    /*add class "autocomplete-active":*/
                    x[currentFocus].classList.add("autocomplete-active");
                }

                function removeActive(x) {
                    /*a function to remove the "active" class from all autocomplete items:*/
                    for (var i = 0; i < x.length; i++) {
                        x[i].classList.remove("autocomplete-active");
                    }
                }

                function closeAllLists(elmnt) {
                    /*close all autocomplete lists in the document,
                    except the one passed as an argument:*/
                    var x = document.getElementsByClassName("autocomplete-items");
                    for (var i = 0; i < x.length; i++) {
                        if (elmnt != x[i] && elmnt != inp) {
                            x[i].parentNode.removeChild(x[i]);
                        }
                    }
                }

                /*execute a function when someone clicks in the document:*/
                document.addEventListener("click", function (e) {
                    closeAllLists(e.target);
                });
            }
        @endif
    </script>
@endpush
