@extends('layout')
@section('home')
@include('menu')
<div class="container">
    {{-- <h3 class="text-center">Status</h3> --}}
    <div class="row mt-5">
        <div class="col-12 col-sm-12 ">
            <div class="card mb-4" style="border-color: #002a71; border-width: 2px; border-radius: 6px;">
                <div class="card-header bg-dark text-white">
                    Guest Play Pre-Registration
                    <a href="{{ route('send.test.sms') }}" class="btn btn-sm btn-primary float-right">SMS Test</a>
                </div>
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
                    <form class="" action="" method="post">
                        @csrf
                        <div class="row mb-0">
                            <div class="col-12 col-sm-3">
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">First Name</span>
                                    </div>
                                    <input type="text" class="form-control" name="guestFName">
                                </div>
                            </div>
                            <div class="col-12 col-sm-3">
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Last Name</span>
                                    </div>
                                    <input type="text" class="form-control" name="guestLName">
                                </div>
                            </div>
                            <div class="col-12 col-sm-3">
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Mobile</span>
                                    </div>
                                    <input type="text" class="form-control" name="mobile">
                                </div>
                            </div>
                            <div class="col-12 col-sm-3">
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Club</span>
                                    </div>
                                    <select name="club" id="club" class="form-control">
                                        <option value="">Select</option>
                                        @if($clubs->isNotEmpty())
                                            @foreach($clubs as $club)
                                                <option value="{{$club->value}}">{{$club->text}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-3">
                                <div class="input-group mb-4 mb-sm-0 mb-md-0 mb-lg-0">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">HCP</span>
                                    </div>
                                    <input type="text" class="form-control" name="hcp" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-12 col-sm-3">
                                <div class="input-group  mb-4 mb-sm-0 mb-md-0 mb-lg-0 autocomplete">
                                    <div style="display: inline-flex;">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Guest of</span>
                                        </div>
                                        <input id="member" class="form-control" type="text" autocomplete="off">
                                        <input class="member_hidden" name="member" type="hidden">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-3">
                                <div class="input-group  mb-4 mb-sm-0 mb-md-0 mb-lg-0">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Payment</span>
                                    </div>
                                    <select name="payment" id="payment" class="form-control">
                                        <option value="Cash">Cash</option>
                                        <option value="Voucher">Voucher</option>
                                        <option value="Not Paid" selected>Not Paid</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-sm-3">
                                <button type="submit" class="btn btn-success d-block w-100">Pre-Registrer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @include('guest_play.register-list')
        </div>
    </div>
</div>

<div class="modal fade" id="reg-edit-modal" tabindex="-1" aria-labelledby="reg-edit-modal-Label" aria-hidden="true">

</div>
@endsection
@push('style')
    <style>
        #ui-datepicker-div {
            z-index: 1052 !important;
        }

        .mem-name {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            display: inline-block;
            max-width: 200px;
        }
    </style>
@endpush
@push('script2')
    <script>
        $('.member-select').selectpicker();

        $(document).ready(function() {
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

            /* Club Auto Complete */
            /*$('#club').on('keyup', function() {
                let search = $(this).val();

                $.ajax({
                    type:'POST',
                    headers: {
                        'X-CSRF-TOKEN':'{{ csrf_token() }}'
                    },
                    data: {search},
                    url:'{{ route('autocomplete.club.search') }}',
                    success:function(response) {
                        console.log(response);
                        autocomplete(document.getElementById("club"), response, 'ajax');
                    }
                });
            });*/

            $('.playnow').on('click', function() {
                let guest = $(this).data('guest');
                $.ajax({
                    type:'POST',
                    headers: {
                        'X-CSRF-TOKEN':'{{ csrf_token() }}'
                    },
                    data: {'guest' : guest},
                    url:'{{ route('guestplay.play.now') }}',
                    success:function(response) {
                        if (response.status == true) {
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
                                            window.location.reload();
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
                                        action: function () {}
                                    },
                                }
                            });
                        }
                    }
                });
            });

            $('.delete-reg').on('click', function() {
                let guest = $(this).data('guest');
                $.confirm({
                    title: 'Are you Sure!!!',
                    content: 'Do you want to DELETE the Pre-Registration?',
                    type: 'red',
                    typeAnimated: true,
                    buttons: {
                        tryAgain: {
                            text: 'Yes',
                            btnClass: 'btn-red',
                            action: function () {
                                $.ajax({
                                    type:'POST',
                                    headers: {
                                        'X-CSRF-TOKEN':'{{ csrf_token() }}'
                                    },
                                    data: {'guest' : guest},
                                    url:'{{ route('guestplay.delete') }}',
                                    success:function(response) {
                                        if (response.status == true) {
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
                                                            window.location.reload();
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
                                                        action: function () {}
                                                    },
                                                }
                                            });
                                        }
                                    }
                                });
                            }
                        },
                        close: function () {
                        }
                    }
                });
            });

        });

        $('.edit-guest-play').on('click', function() {
            let reg = $(this).data();
            $.ajax({
                type:'POST',
                headers: {
                    'X-CSRF-TOKEN':'{{ csrf_token() }}'
                },
                data: {reg},
                url:'{{ route('guest.play.edit') }}',
                success:function(response) {
                    $("#reg-edit-modal").html(response);
                    $("#reg-edit-modal").modal('show');
                }
            });
        });

        function closeModal() {
            location.reload();
        }

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
    </script>
@endpush
