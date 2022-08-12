
<div class="row">
    <div class="col-12">
        <div class="app-header">
            <h4>INNSTILLINGER</h4>
        </div>
    </div>
</div>
@if ($memberdata->OccID == '10948' ||$memberdata->OccID == '10664' || $memberdata->OccID == '10947')
    <div hidden id="hcp_message_updated" class="alert alert-success col-md-4  mt-2 text-center">
        <strong>Updated!</strong>
    </div>

    <div class="row">
        <div class="col-12">
            <p class="front-site-info mb-2 mt-0 pl-2">Her kan du gjøre noen innstillinger i forhold til bruken av denne appen.</p>
        </div>
    </div>


    <input type="hidden" class="manual_occid" id="manual_occid" value="{{ $memberdata->OccID }}">
    <div class="card ml-2 mr-2 mb-5" style="border: 2px solid #002a71;">
      <div class="card-header text-white font-wiight-bold" style="background: #002a71;">HCP beregning</div>
      <div class="card-body">
        <div class="row">
            <div class="col-12 col-sm-6">
                <div class="inputGroup22">
                    <input id="radio1"
                           {{ ($memberdata->app_hcp_status == 'online' && !empty($memberdata->app_hcp_status)  ? 'checked' : '' ) }}  name="radio"
                           type="radio" class="hcp_status" data-hcp="online"/>
                    <label for="radio1">Online HCP</label>
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="inputGroup22">
                    <input id="radio2" class="hcp_status" data-hcp="manual" name="radio"
                           {{ (!empty($memberdata->app_hcp_status) && $memberdata->app_hcp_status == 'manual'  ? 'checked' : '' ) }} type="radio"/>
                    <label for="radio2">Manuelt HCP</label>
                </div>
            </div>
        </div>
        <p class="front-site-info mb-0 mt-0">Her kan du velge om du vil manuelt kunne oppdatere ditt HCP som vises på medlemskortet eller om du ønsker å benytte deg av online beregning av HCP</p>
      </div>
    </div>


    <div class="card ml-2 mr-2 mb-5" style="border: 2px solid #002a71;">
      <div class="card-header text-white font-wiight-bold" style="background: #002a71;">SMS informasjon</div>
      <div class="card-body">
        <div class="row">
            <div class="col-12 col-sm-6">
                <div class="inputGroup22">
                    <input
                        id="radio3"
                        @if($memberdata->sms_news_letter == 1) checked @endif
                        name="smsradio"
                        type="radio"
                        class="sms_status"
                        data-sms="on"/>
                    <label for="radio3">PÅ</label>
                </div>
            </div>
            <div class="col-12 col-sm-6">
                <div class="inputGroup22">
                    <input
                        id="radio4"
                        @if($memberdata->sms_news_letter == 0) checked @endif
                        name="smsradio"
                        type="radio"
                        class="sms_status"
                        data-sms="off"/>
                    <label for="radio4">AV</label>
                </div>
            </div>
        </div>
        <p class="front-site-info mb-0 mt-0">Her kan du skru av eller på om du ønsker å motta viktig informasjon fra oss i fremtiden via SMS. E-post vil bli sendt som vanlig og påvirker ikke av denne innstillingen.</p>
      </div>
    </div>

    {{--<div class="col-12  form2">
        <center>
            <table class="table table-borderless">
                <tr>
                    <th style="TEXT-ALIGN: center;padding-top: 10%; font-family: OSWOLD; FONT-SIZE: larger;">HCP beregning</th>
                    <td>
                        <div class="inputGroup22">
                            <input id="radio1"
                                   {{ ($memberdata->app_hcp_status == 'online' && !empty($memberdata->app_hcp_status)  ? 'checked' : '' ) }}  name="radio"
                                   type="radio" class="hcp_status" data-hcp="online"/>
                            <label for="radio1">Online HCP</label>
                        </div>
                        <div class="inputGroup22">
                            <input id="radio2" class="hcp_status" data-hcp="manual" name="radio"
                                   {{ (!empty($memberdata->app_hcp_status) && $memberdata->app_hcp_status == 'manual'  ? 'checked' : '' ) }} type="radio"/>
                            <label for="radio2">Manuelt HCP</label>
                        </div> --}}
                        {{-- <select name="hcp_type" id="hcp_type">
<option {{ ($memberdata->app_hcp_status == 'online') ? 'selected' : '' }}           value="online">Online</option>
                            <option {{ ($memberdata->app_hcp_status == 'manual') ? 'selected' : '' }} value="manual">Manual</option>
                        </select>
                        <span id="selected_message" hidden>SELECTED</span> --}}{{--

                    </td>
                </tr>
            </table>
        </center>
    </div>

    <div class="col-12  form2">
        <center>
            <table class="table table-borderless">
                <tr>
                    <th style="text-align: center; padding-top: 10%; font-family: OSWOLD; font-size: larger;">SMS informasjon</th>
                    <td>
                        <div class="inputGroup22">
                            <input
                                id="radio3"
                                @if($memberdata->sms_news_letter == 1) checked @endif
                                name="smsradio"
                                type="radio"
                                class="sms_status"
                                data-sms="on"/>
                            <label for="radio3">PÅ</label>
                        </div>
                        <div class="inputGroup22">
                            <input
                                id="radio4"
                                @if($memberdata->sms_news_letter == 0) checked @endif
                                name="smsradio"
                                type="radio"
                                class="sms_status"
                                data-sms="off"/>
                            <label for="radio4">AV</label>
                        </div>
                    </td>
                </tr>
            </table> --}}
        </center>
    </div>
@endif

@push('script2')
    <script>
        $(document).on('click', '.hcp_status', function (e) {
            var manual_occid = $('.manual_occid').val();
            var hcp_status = $(this).attr('data-hcp');
            var _token = "{{ csrf_token() }}";
            $.ajax({
                url: "{{ route('update_hcp_status') }}",
                method: "POST",
                dataType: "json",
                data: {manual_occid: manual_occid, hcp_status: hcp_status, _token: _token},
                success: function (res) {
                    console.log(res);
                    if (res.success) {
                        $('#hcp_message_updated').removeAttr('hidden');
                    }
                }
            });
        });

        $(document).on('click', '.sms_status', function (e) {
            var manual_occid = $('.manual_occid').val();
            var sms_status = $(this).attr('data-sms');
            var _token = "{{ csrf_token() }}";
            $.ajax({
                url: "{{ route('update_hcp_status') }}",
                method: "POST",
                dataType: "json",
                data: {manual_occid: manual_occid, sms_status: sms_status, _token: _token, type: 'sms'},
                success: function (res) {
                    console.log(res);
                    if (res.success) {
                        $('#hcp_message_updated').removeAttr('hidden');
                    }
                }
            });
        });
    </script>
@endpush

@push('link')
    <style>
        /* Radio button for manual online */
        .inputGroup22 {
            background-color: #d5d9e0;
            display: block;
            margin: 10px 0;
            position: relative;
        }

        .inputGroup22 label {
            padding: 12px 30px;
            width: auto;
            display: block;
            text-align: left;
            color: #3C454C;
            cursor: pointer;
            position: relative;
            z-index: 2;
            -webkit-transition: color 200ms ease-in;
            transition: color 200ms ease-in;
            overflow: hidden;
        }

        .inputGroup22 label:before {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            content: '';
            background-color: #002a71 !important;
            position: absolute;
            left: 50%;
            top: 50%;
            -webkit-transform: translate(-50%, -50%) scale3d(1, 1, 1);
            transform: translate(-50%, -50%) scale3d(1, 1, 1);
            -webkit-transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1);
            transition: all 300ms cubic-bezier(0.4, 0, 0.2, 1);
            opacity: 0;
            z-index: -1;
        }

        .inputGroup22 label:after {
            width: 32px;
            height: 32px;
            content: '';
            border: 2px solid #D1D7DC;
            background-color: #fff;
            background-image: url("data:image/svg+xml,%3Csvg width='32' height='32' viewBox='0 0 32 32' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M5.414 11L4 12.414l5.414 5.414L20.828 6.414 19.414 5l-10 10z' fill='%23fff' fill-rule='nonzero'/%3E%3C/svg%3E ");
            background-repeat: no-repeat;
            background-position: 2px 3px;
            border-radius: 50%;
            z-index: 2;
            position: absolute;
            right: 30px;
            top: 50%;
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%);
            cursor: pointer;
            -webkit-transition: all 200ms ease-in;
            transition: all 200ms ease-in;
        }

        .inputGroup22 input:checked ~ label {
            color: #fff;
        }

        .inputGroup22 input:checked ~ label:before {
            -webkit-transform: translate(-50%, -50%) scale3d(56, 56, 1);
            transform: translate(-50%, -50%) scale3d(56, 56, 1);
            opacity: 1;
        }

        .inputGroup22 input:checked ~ label:after {
            background-color: #000000;
            border-color: #08ff3f;
        }

        .inputGroup22 input {
            width: 32px;
            height: 32px;
            -webkit-box-ordinal-group: 2;
            order: 1;
            z-index: 2;
            position: absolute;
            right: 30px;
            top: 50%;
            -webkit-transform: translateY(-50%);
            transform: translateY(-50%);
            cursor: pointer;
            visibility: hidden;
        }

        .form22 {
            padding: 0 16px;
            max-width: 550px;
            margin: 50px auto;
            font-size: 18px;
            font-weight: 600;
            line-height: 36px;
        }
    </style>
@endpush
