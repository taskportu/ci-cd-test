@extends('layout')
@section('home')
    @include('menu')
    <div class="container">
        <div class="row text-left">
            <div class="card-body " style="padding: 0px">
                <center>
                    <div class="alert alert-success col-md-8 text-center" style="display:none">
                        <strong>Saved!</strong>
                    </div>
                    <form method="POST" id="ticket_save">
                        @csrf

                        <div class="col-md-8">
                            <div class="card">
                                <h5 class="card-header h5" style="background-color: #007bff;color: white;font-size: 1.29rem;">Add Ticket Details</h5>
                                <div class="card-body card-body-panel">
                                    <div class="form-group row">
                                        <a href="{{route('memberedits', $members->MemberID)}}" class="btn btn-success float-left">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-arrow-left" viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                      d="M15 8a.5.5 0 0 0-.5-.5H2.707l3.147-3.146a.5.5 0 1 0-.708-.708l-4 4a.5.5 0 0 0 0 .708l4 4a.5.5 0 0 0 .708-.708L2.707 8.5H14.5A.5.5 0 0 0 15 8z"/>
                                            </svg>
                                            Member Info
                                        </a>
                                    </div>
                                    <div class="form-group row">
                                        <label for="occid" class="col-md-4 col-form-label text-md-right require_label">OccID</label>

                                        <div class="col-md-2">
                                            <input id="" type="text" class="form-control " value="{{ $members->OccID }}"
                                                   name="" required readonly>
                                            <input id="occid" type="hidden" class="form-control "
                                                   name="occid" value="{{ $members->MemberID }}" required readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="name" class="col-md-4 col-form-label text-md-right require_label">Member</label>
                                        <div class="col-md-3">
                                            <label for="Member_Fistname" class="col-form-label">
                                                <b style="position: absolute;top: 0px;left: 15px;">First Name</b>
                                            </label>
                                            <input id="name" type="text" class="form-control" value="{{ $members->Member_Fistname }}"
                                                   name="name" required readonly>
                                        </div>
                                        <div class="col-md-3">
                                            <label for="Member_Fistname" class="col-form-label">
                                                <b style="position: absolute;top: 0px;left: 15px;">Last Name</b>
                                            </label>
                                            <input id="name" type="text" class="form-control" value="{{ $members->Member_Lastname }}"
                                                   name="name" required readonly>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="name" class="col-md-3 col-form-label text-md-right require_label">Active Tickets</label>
                                        <div class="col-md-8">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th style="white-space: nowrap">Type</th>
                                                    <th style="white-space: nowrap">Purchases</th>
                                                    <th colspan="3"></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @if(!empty($member_tickets[""]))
                                                    @foreach ($member_tickets[""] as $member_ticket)
                                                        {{--                                                        {{dd($member_ticket)}}--}}
                                                        @if($member_ticket['ticket_used'] != 'delete' && $member_ticket['ticket_used'] != 'used')
                                                            <tr>
                                                                <td style="white-space: nowrap">{{ $member_ticket['product'] }}</td>
                                                                <td style="white-space: nowrap">{{ \Carbon\Carbon::parse($member_ticket['date_purchase'])->format('d-m-Y').' ' }}{{ !empty($member_ticket['ticket_type']) ? '(S)': '' }} </td>
                                                                @if(!isset($member_ticket['transfered_from']))
                                                                <td>
                                                                    {{-- @if($member_ticket->ticket_type)
                                                                        <button type="button" data-id={{ $member_ticket->id }} data-status="{{ $member_ticket->ticket_used }}" id="" class="btn btn-secondary btn-sm"  >
                                                                            <span class="glyphicon glyphicon-off"></span>
                                                                        </button>
                                                                    @else --}}
                                                                    <button
                                                                        data-id='{{ $member_ticket['id'] }}'
                                                                        data-status="{{ ($member_ticket['ticket_used'] === 'hold') ? '' : 'inactive' }}"
                                                                        class="btn {{ ($member_ticket['ticket_used'] === 'hold') ? 'btn-primary' : 'btn-dark' }} btn-sm ticket_used mr-1">
                                                                        @if($member_ticket['ticket_used'] === null || $member_ticket['ticket_used'] === '')
                                                                            <svg style="margin-bottom: 3px;" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                                                 fill="currentColor" class="bi bi-pause-circle-fill" viewBox="0 0 16 16">
                                                                                <path
                                                                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.25 5C5.56 5 5 5.56 5 6.25v3.5a1.25 1.25 0 1 0 2.5 0v-3.5C7.5 5.56 6.94 5 6.25 5zm3.5 0c-.69 0-1.25.56-1.25 1.25v3.5a1.25 1.25 0 1 0 2.5 0v-3.5C11 5.56 10.44 5 9.75 5z"/>
                                                                            </svg>
                                                                        @elseif($member_ticket['ticket_used'] === 'hold')
                                                                            <svg style="margin-bottom: 3px;" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                                                 fill="currentColor" class="bi bi-play-circle-fill" viewBox="0 0 16 16">
                                                                                <path
                                                                                    d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM6.79 5.093A.5.5 0 0 0 6 5.5v5a.5.5 0 0 0 .79.407l3.5-2.5a.5.5 0 0 0 0-.814l-3.5-2.5z"/>
                                                                            </svg>
                                                                        @endif
                                                                    </button>
                                                                </td>
                                                                <td>
                                                                    @if($member_ticket['ticket_type'] !== 'season')
                                                                        <button
                                                                            data-id='{{ $member_ticket['id'] }}'
                                                                            @if($member_ticket['ticket_used'] === null || $member_ticket['ticket_used'] === '') data-status="done"
                                                                            @else disabled @endif
                                                                            class="btn btn-success btn-sm ticket_used">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-power" viewBox="0 0 16 16">
                                                                                <path d="M7.5 1v7h1V1h-1z"/>
                                                                                <path d="M3 8.812a4.999 4.999 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812z"/>
                                                                            </svg>
                                                                        </button>
                                                                    @else
                                                                        <button
                                                                            class="btn btn-success btn-sm" disabled>
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-power" viewBox="0 0 16 16">
                                                                                <path d="M7.5 1v7h1V1h-1z"/>
                                                                                <path d="M3 8.812a4.999 4.999 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812z"/>
                                                                            </svg>
                                                                        </button>
                                                                    @endif
                                                                </td>
                                                                <td>
                                                                    <button
                                                                        data-id='{{ $member_ticket['id'] }}'
                                                                        data-status="trash"
                                                                        class="btn btn-danger btn-sm delete_ticket">
                                                                        <svg style="margin-bottom: 3px;" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                                             fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                                            <path
                                                                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                                            <path fill-rule="evenodd"
                                                                                  d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                                        </svg>
                                                                    </button>
                                                                </td>
                                                                @else
                                                                    <td colspan="2">
                                                                        {{ $member_ticket['transfered_phone'] }}
                                                                        </br>
                                                                        ({{ \Carbon\Carbon::parse($member_ticket['transfered_date'])->format('d-m-Y') }})
                                                                    </td>
                                                                    <td>
                                                                        <button
                                                                            data-id='{{ $member_ticket['id'] }}'
                                                                            data-status="trash"
                                                                            class="btn btn-danger btn-sm delete_ticket">
                                                                            <svg style="margin-bottom: 3px;" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                                                 fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                                                <path
                                                                                    d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                                                <path fill-rule="evenodd"
                                                                                      d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                                            </svg>
                                                                        </button>
                                                                    </td>
                                                                @endif
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                @endif
                                                @if(!empty($member_tickets["season"]))
                                                    @foreach ($member_tickets["season"] as $member_ticket)
                                                        <tr>
                                                            <td style="white-space: nowrap">{{ $member_ticket['product'] }}</td>
                                                            <td style="white-space: nowrap">{{ \Carbon\Carbon::parse($member_ticket['date_purchase'])->format('d-m-Y').' ' }}{{ !empty($member_ticket['ticket_type']) ? '(S)': '' }} </td>
                                                            <td></td>
                                                            <td>
                                                                <button class="btn btn-success btn-sm" disabled>
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-power" viewBox="0 0 16 16">
                                                                        <path d="M7.5 1v7h1V1h-1z"/>
                                                                        <path d="M3 8.812a4.999 4.999 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812z"/>
                                                                    </svg>
                                                                </button>
                                                            </td>
                                                            <td>
                                                                <button
                                                                    data-id='{{ $member_ticket['id'] }}'
                                                                    data-status="trash"
                                                                    class="btn btn-danger btn-sm delete_ticket">
                                                                    <svg style="margin-bottom: 3px;" xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                                         fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                                                        <path
                                                                            d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                                                        <path fill-rule="evenodd"
                                                                              d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4L4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                                                    </svg>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                @endif
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                    <div class="form-group row">
                                        <label for="product" class="col-md-4 col-form-label text-md-right require_label ">Product</label>
                                        <div class="col-md-3">
                                            <select class="form-control" name="product" id="product" required>
                                                <option value=" ">Select</option>
                                                <option value="Ferry">Ferry</option>
                                                <option value="Greenfee">Greenfee</option>
                                                <option value="Pro lessons">Pro lessons</option>
                                                <option value="Buggy">Buggy</option>
                                            </select>
                                        </div>
                                        <div class="col-md-3">
                                            <div style="float: left;">
                                                <label for="ticket_count" class="col-form-label text-md-right require_label">Count</label>
                                            </div>
                                            <div>
                                                <input id="ticket_count" style="float:left;width: 87px;" type="number" class="form-control"
                                                       name="ticket_count" required min="1">
                                                <input type="checkbox" style="margin-left: 5px;" class="form-check-input" value="season" name="ticket_type" id="ticket_type">
                                            </div>
                                        </div>
                                    </div>
                                    {{-- <div class="form-group row">
                                        <label for="ticket_count" class="col-md-4 col-form-label
                                        text-md-right require_label">Count</label>
                                        <div class="col-md-6">
                                            <input id="ticket_count" type="text" class="form-control"
                                            name="ticket_count" required >
                                        </div>
                                    </div> --}}
                                    <div class="form-group row">
                                        <div class="col-md-6"></div>
                                        <div class="col-md-6" style="text-align: right;">
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 ">
                                    <div class="col-md-1"></div>
                                    <div class="col-md-10">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Type</th>
                                                    <th style="width: 17%;">Purchases</th>
                                                    <th style="width: 20%;">Status</th>
                                                    <th style="width: 17%;">Used</th>
                                                    <th style="width: 25%;">Transferd</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($member_tickets_tables as $member_tickets_table)
                                                    <tr>
                                                        <td>
                                                            {{ $member_tickets_table->product }} {{ ($member_tickets_table->ticket_type == 'season') ? '(S)' : '' }}
                                                        </td>
                                                        <td>
                                                            {{ \Carbon\Carbon::parse($member_tickets_table->date_purchase)->format('d-m-Y') }}
                                                        </td>
                                                        <td>
                                                            {{ strtoupper($member_tickets_table->ticket_used) }}
                                                        </td>
                                                        <td>
                                                            @if($member_tickets_table->ticket_type == 'season')
                                                            {{ \Carbon\Carbon::parse($member_tickets_table->date_purchase)->format('d-m-Y')}}
                                                            @else
                                                            {{ (isset($member_tickets_table->ticket_used)) ? \Carbon\Carbon::parse($member_tickets_table->date_used)->format('d-m-Y'): '' }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @isset($member_tickets_table->transfered_phone)
                                                            {{$member_tickets_table->transfered_phone}}
                                                            <br>
                                                            <span style="font-size: 12px;">
                                                                ({{ \Carbon\Carbon::parse($member_tickets_table->transfered_date)->format('d-m-Y') }})
                                                            </span>
                                                            @endisset
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-2">{{ $member_tickets_tables->links()}}</div>
                                </div>
                            </div>
                        </div>
                    </form>
                </center>
            </div>
        </div>
    </div>

@endsection
@push('script2')
    <script>
        $(document).on('click', '.ticket_used', function (e) {
            e.preventDefault();
            let ticket_id = $(this).attr('data-id');
            let status = $(this).attr('data-status');
            let _token = "{{ csrf_token() }}";
            changeStatus(status, ticket_id, _token);
        });

        $(document).on('click', '.delete_ticket', function (e) {
            let ticket_id = $(this).data('id');
            let status = $(this).data('status');
            let _token = "{{ csrf_token() }}";
            console.log(ticket_id, status, _token);
            $.confirm({
                title: 'Are you Sure!!!',
                content: 'Do you want to DELETE the Ticket?',
                type: 'red',
                typeAnimated: true,
                buttons: {
                    tryAgain: {
                        text: 'Yes',
                        btnClass: 'btn-red',
                        action: function () {
                            // console.log(ticket_id, status, _token);
                            changeStatus(status, ticket_id, _token);
                        }
                    },
                    close: function () {
                    }
                }
            });
        });

        function changeStatus(status, ticket_id, token) {
            $.ajax({
                url: "{{ route('ticket_change_status') }}",
                method: "POST",
                data: {status, ticket_id, _token: token},
                success: function (res) {
                    if (res) {
                        // console.log(res);
                        window.location.reload();
                    }
                }
            });
        }

        $(document).on('submit', '#ticket_save', function (e) {
            e.preventDefault();
            var _token = "{{ csrf_token() }}";
            var product = $('#product').val();
            var count = $('#ticket_count').val();
            if (product == " ") {
                alert('Please Select Product');
            } else {
                $.ajax({
                    url: "{{ route('ticket_save') }}",
                    method: "POST",
                    data: $(this).serialize(),
                    success: function (res) {
                        // console.log(res);
                        if (res) {
                            $('.alert-success').removeAttr('style');
                            window.location.reload();
                        }

                    }
                });
            }

        });

        $('#product').on('change', function () {
            let product = $(this).val();
            if (product == 'Pro lessons' || product == 'Greenfee') {
                $('#ticket_type').hide();
            } else {
                $('#ticket_type').show();
            }
        });
    </script>
@endpush

@push('style')
    <style>
        .btn-secondary {
            cursor: not-allowed !important;
        }

        .btn span.glyphicon {
            opacity: 1 !important;
        }

        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        @media (min-width: 320px) and (max-width: 480px) {
            .card-height {
                height: auto !important;
            }
        }

        .card-height {
            height: 412px;
        }

        .require_label:after {
            content: "*";
            color: red;
        }

        .card-body-panel {
            background-color: #007bff05 !important;
        }

        .rowsmargin {
            margin-top: 20px;
        }

        .well {
            min-height: 20px;
            padding: 19px;
            margin-bottom: 20px;
            background-color: #f5f5f5;
            border: 1px solid #e3e3e3;
            border-radius: 4px;
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .05);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .05)
        }

        .well blockquote {
            border-color: #ddd;
            border-color: rgba(0, 0, 0, .15)
        }

        .well-lg {
            padding: 24px;
            border-radius: 6px
        }

        .well-sm {
            padding: 9px;
            border-radius: 3px
        }

        .btn span.glyphicon {
            opacity: 0;
        }

        .btn.active span.glyphicon {
            opacity: 1;
        }

        .input-group-addon {
            padding: 6px 12px;
            font-size: 14px;
            /* font-weight: 400; */
            line-height: 1;
            color: #555;
            text-align: center;
            background-color: #eee;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        /* The container */
        .containerqq {
            /* display: block; */
            position: relative;
            padding-left: 35px;
            margin-bottom: 12px;
            margin-left: 13px;
            cursor: pointer;
            font-size: 17px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;

        }

        /* Hide the browser's default checkbox */
        .containerqq input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        /* Create a custom checkbox */
        .checkmark {
            position: absolute;
            top: 0;
            left: 0;
            height: 33px;
            width: 36px;
            background-color: #eee;
        }

        /* On mouse-over, add a grey background color */
        .containerqq:hover input ~ .checkmark {
            background-color: #ccc;
        }

        /* When the checkbox is checked, add a blue background */
        .containerqq input:checked ~ .checkmark {
            background-color: #2196F3;
        }

        /* Create the checkmark/indicator (hidden when not checked) */
        .checkmark:after {
            content: "";
            position: absolute;
            display: none;
        }

        /* Show the checkmark when checked */
        .containerqq input:checked ~ .checkmark:after {
            display: block;
        }

        /* Style the checkmark/indicator */
        .containerqq .checkmark:after {
            left: 15px;
            top: 7px;
            width: 7px;
            height: 16px;
            border: solid white;
            border-width: 0 3px 3px 0;
            -webkit-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            transform: rotate(45deg);
        }
    </style>
@endpush
