@extends('layout')
@section('home')
<div class="container">
    <div class="row text-left mt-5 mb-5">
        <div class="col rowsmargin">
            @if(Session::has('success'))
            <div class="alert alert-success col-md-4 offset-md-5 text-center" style="display:none">
                <strong>Saved!</strong>
            </div>
            @endif
            @if(Session::has('error'))
                <div class="alert alert-danger col-md-10 form-group row" style="display:none">
                    <strong>OccID All ready Insert</strong>
                </div>
            @endif
        </div>

        <div class="class col-md-12">
            @if(isset($member) && $member->signup_status == 'pending')
            <form method="POST" id="newmember">
                @csrf
                <div class="row">
                    <div class="col-md-6" style="float: left;">
                        <div class="card">
                            <h5 class="card-header h5" style="background-color: #007bff;color: white;font-size: 1.29rem;">Basic</h5>
                            <div class="card-body card-body-panel">
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label
                                    text-md-right require_label">Member FirstName</label>
                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control"
                                        name="MemberFistName" @if(isset($member->Member_Fistname)) value="{{ $member->Member_Fistname }}" @endif readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label
                                    text-md-right require_label">Member LastName</label>
                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control"
                                        name="MemberLastName" @if(isset($member->Member_Lastname)) value="{{ $member->Member_Lastname }}" @endif readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="OccID" class="col-md-4 col-form-label
                                    text-md-right require_label">OccID</label>
                                    <div class="col-md-3">
                                        <input id="OccID" type="text" class="form-control number_only"
                                        name="OccID" maxlength = "5" minlength="5" autocomplete="off" @if(isset($member->OccID)) value="{{ $member->OccID }}" @endif readonly>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="HCP" class="col-md-4 col-form-label
                                    text-md-right">HCP Online</label>
                                    <div class="col-md-3">
                                        <input id="password" type="text" class="form-control hcp-validation"
                                        name="HCP" @if(isset($member->HCP)) value = "{{ $member->HCP }}" @endif>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="handicap" class="col-md-4 col-form-label
                                    text-md-right">HCP Manual</label>
                                    <div class="col-md-3">
                                        <input id="handicap" type="text" class="form-control  hcp-validation"
                                        name="handicap" @if(isset($member->handicap)) value = "{{ $member->handicap }}" @endif>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="share_type" class="col-md-4 col-form-label
                                    text-md-right ">Share Type</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="share_type" id="share_type" >
                                            <option value=" " >Select</option>
                                            @foreach(config('settings.share_type') as $key => $share)
                                                <option value="{{ $key }}" @if(isset($member->share_type) && $key == $member->share_type) selected @endif>{{ $share }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="shre_number" class="col-md-4 col-form-label
                                    text-md-right">Share Number</label>
                                    <div class="col-md-3">
                                        <input id="share_number" type="text" class="form-control  number_only" name="share_number" @if(isset($member->share_number)) value = "{{ $member->share_number }}" @endif>
                                    </div>
                                </div>
                                <div class="form-group row share_from_div">
                                    <label for="share_from" class="col-md-4 col-form-label
                                    text-md-right">Share From</label>
                                    <div class="col-md-5">
                                        <input id="share_from" type="date" class="form-control"
                                        name="share_from" @if(isset($member->share_from)) value = "{{ $member->share_from }}" @endif>
                                    </div>
                                </div>
                                <div class="form-group row share_name_div">
                                    <label for="share_name" class="col-md-4 col-form-label
                                    text-md-right">Share Name</label>
                                    <div class="col-md-5">
                                        <input id="share_name" type="text" class="form-control" name="share_name" @if(isset($member->share_name)) value = "{{ $member->share_name }}" @endif>
                                    </div>
                                </div>
                                <div class="form-group row share_to_div">
                                    <label for="share_to" class="col-md-4 col-form-label
                                    text-md-right">Share To</label>
                                    <div class="col-md-5">
                                        <input id="share_to" type="date" class="form-control"
                                        name="share_to" @if(isset($member->share_to)) value = "{{ $member->share_to }}" @endif>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- upgradte --}}
                        <div class="card" style="margin-top: 10px; margin-bottom: 10px;">
                            <h5 class="card-header h5" style="background-color: #007bff;color: white;font-size: 1.29rem;">Contact</h5>
                            <div class="card-body card-body-panel">
                                <div class="form-group row">
                                    <label for="address1" class="col-md-4 col-form-label
                                    text-md-right">Address Line 1</label>
                                    <div class="col-md-6">
                                        <input id="address1" type="text" class="form-control"
                                        name="address1" @if(isset($member->address1)) value = "{{ $member->address1 }}" @endif>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="address2" class="col-md-4 col-form-label
                                    text-md-right">Address Line 2</label>
                                    <div class="col-md-6">
                                        <input id="address2" type="text" class="form-control"
                                        name="address2" @if(isset($member->address2)) value = "{{ $member->address2 }}" @endif>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="city" class="col-md-4 col-form-label
                                    text-md-right">City</label>
                                    <div class="col-md-5">
                                        <input id="city" type="text" class="form-control"
                                        name="city" @if(isset($member->city)) value = "{{ $member->city }}" @endif>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="zipcode" class="col-md-4 col-form-label
                                    text-md-right">Zip Code</label>
                                    <div class="col-md-3">
                                        <input id="zipcode" type="text" class="form-control number_only"
                                        name="zipcode" @if(isset($member->zipcode)) value = "{{ $member->zipcode }}" @endif>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label
                                    text-md-right">Email</label>
                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control"
                                        name="email" @if(isset($member->email)) value = "{{ $member->email }}" @endif>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email_billing" class="col-md-4 col-form-label
                                    text-md-right">Email Invoice</label>
                                    <div class="col-md-6">
                                        <input id="email_billing" type="email" class="form-control" name="email_billing" @if(isset($member->email_billing)) value = "{{ $member->email_billing }}" @endif>
                                        <small class="errInputMessage d-none"></small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tel_privately" class="col-md-4 col-form-label
                                    text-md-right">Tel Privat</label>
                                    <div class="col-md-4">
                                        <input id="tel_privately" type="text" class="form-control number_only"
                                        name="tel_privately" @if(isset($member->tel_privately)) value = "{{ $member->tel_privately }}" @endif>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tel_jobs" class="col-md-4 col-form-label
                                    text-md-right">Tel Work</label>
                                    <div class="col-md-4">
                                        <input id="tel_jobs" type="text" class="form-control number_only"
                                        name="tel_jobs" @if(isset($member->tel_jobs)) value = "{{ $member->tel_jobs }}" @endif>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="phone_mobile" class="col-md-4 col-form-label
                                    text-md-right">Tel Mobile</label>
                                    <div class="col-md-4">
                                        <input id="phone_mobile" type="text" class="form-control number_only"
                                        name="phone_mobile" @if(isset($member->phone_mobile)) value = "{{ $member->phone_mobile }}" @endif>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="sms_news_letter" class="col-md-4 col-form-label
                                    text-md-right">Use SMS</label>
                                    <div class="col-md-4">
                                        <label class="switch" for="sms_news_letter">
                                            <input type="checkbox" id="sms_news_letter" name="sms_news_letter" value="1" @if(isset($member->sms_news_letter) && $member->sms_news_letter == 1) checked @endif>
                                            <span class="slider round"></span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" style="float: left;">
                        <div class="row">
                            <div class="col">
                                <div class="card" >
                                    <h5 class="card-header h5" style="background-color: #007bff;color: white;font-size: 1.29rem;">Member</h5>
                                    <div class="card-body card-body-panel card-height" >
                                        <div class="form-group row">
                                            <label for="sex" class="col-md-4 col-form-label
                                            text-md-right">Sex</label>
                                            <div class="col-md-3">
                                                <select class="form-control" name="sex">
                                                    <option >Select</option>
                                                    @foreach(config('settings.gender') as $key => $gender)
                                                        <option value="{{ $key }}" @if(isset($member->sex) && $member->sex == $key) selected @endif>{{ $gender }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="date_of_birth" class="col-md-4 col-form-label
                                            text-md-right">Date of Birth</label>
                                            <div class="col-md-5">
                                                <input id="date_of_birth" type="date" class="form-control"
                                                name="date_of_birth" @if(isset($member->date_of_birth)) value = "{{ $member->date_of_birth }}" @endif>
                                            </div>
                                        </div>
<!--                                        <div class="form-group row">
                                            <label for="member_since" class="col-md-4 col-form-label
                                            text-md-right">Member Since</label>
                                            <div class="col-md-5">
                                                <input id="member_since" type="date" class="form-control"
                                                name="member_since" @if(isset($member->member_since)) value = "{{ $member->member_since }}" @endif>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="resignation_date" class="col-md-4 col-form-label
                                            text-md-right">Registration Date</label>
                                            <div class="col-md-5">
                                                <input id="resignation_date" type="date" class="form-control"
                                                name="resignation_date" value="{{date('Y-m-d')}}" @if(isset($member->resignation_date)) value = "{{ $member->resignation_date }}" @endif>
                                            </div>
                                        </div>-->
                                        <div class="form-group row">
                                            <label for="additional_info" class="col-md-4 col-form-label
                                            text-md-right">Additional Info</label>
                                            <div class="col-md-6">
                                                <textarea name="additional_info" id="" cols="30" rows="3">@if(isset($member->additional_info)) {{ $member->additional_info }} @endif</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
<!--                        <div class="row">
                            <div class="col">
                                <div class="card" style="margin-top: 10px;">
                                    <h5 class="card-header h5" style="background-color: #007bff;color: white;font-size: 1.29rem;">Facilities</h5>
                                    <div class="card-body card-body-panel" style="height: 470px;">
                                        <div class="form-group row">
                                            <label for="wardrobe" class="col-md-4 col-form-label
                                            text-md-right">Wardrobe</label>
                                            <div class="col-md-2">
                                                <input id="wardrobe" type="text" class="form-control"
                                                name="wardrobe" @if(isset($member->wardrobe)) value = "{{ $member->wardrobe }}" @endif>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="drinks_cabinet" class="col-md-4 col-form-label
                                            text-md-right">Drinks Cabinet</label>
                                            <div class="col-md-2">
                                                <input id="drinks_cabinet" type="text" class="form-control"
                                                name="drinks_cabinet" @if(isset($member->drinks_cabinet)) value = "{{ $member->drinks_cabinet }}" @endif>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="stick_cabinet" class="col-md-4 col-form-label
                                            text-md-right">Stick Cabinet</label>
                                            <div class="col-md-2">
                                                <input id="stick_cabinet" type="text" class="form-control"
                                                name="stick_cabinet" @if(isset($member->stick_cabinet)) value = "{{ $member->stick_cabinet }}" @endif>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="charging_site" class="col-md-4 col-form-label
                                            text-md-right">Charging Site</label>
                                            <div class="col-md-2">
                                                <input id="charging_site" type="text" class="form-control"
                                                name="charging_site" @if(isset($member->charging_site)) value = "{{ $member->charging_site }}" @endif>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="trolley_space" class="col-md-4 col-form-label
                                            text-md-right">Trolley Space</label>
                                            <div class="col-md-2">
                                                <input id="trolley_space" type="text" class="form-control"
                                                name="trolley_space" @if(isset($member->trolley_space)) value = "{{ $member->trolley_space }}" @endif>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>-->

                        {{-- upgradtion end --}}
                        {{-- {{ dd(
                            [
                                $member->signup_status,
                                isset($member->signup_status),
                                (isset($member->signup_status) && $member->signup_status != "admin approve"),
                                (isset($member->signup_status) && $member->signup_status != "declined")
                            ]
                        ) }} --}}

                        <div class="row" id="btn-section">
                            <div class="center col-12">
                                <button type="submit" class="btn btn-primary float-right submit-btn mr-1" style="margin-top: 10px;font-size: 1.2rem; height: 45px;" value="start">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            @elseif(isset($member) && $member->signup_status == 'declined')
                <div class="alert alert-danger">
                    Innholdet i dette skjemaet er oppdatert av OCC Admin og kan ikke lenger endres. </br>Ta kontakt med Administrasjone hvis du har spørsmål.
                </div>
            @elseif(isset($member) && (!isset($member->signup_status)))
                <div class="alert alert-success">
                    Innholdet i dette skjemaet er oppdatert av OCC Admin og kan ikke lenger endres. </br>Ta kontakt med Administrasjone hvis du har spørsmål.
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
@push('style')
    <style>
        @media (min-width: 320px) and (max-width: 480px) {
            .card-height{
                height:auto !important;
            }
        }
        .card-height{
            height: 412px;
        }
        .require_label:after {
            content:"*";
            color:red;
        }
        .card-body-panel{
            background-color: #007bff05 !important;
        }
        .rowsmargin{
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
@push('script2')
   <script>
        $(document).on('click','input[name="playing_eligibility"]',function () {
            var th = $(this).val();
            if(th == "yes")
            {
                $('.checkmark').removeAttr('style');
                $('.containerqq:hover input ~ .checkmark').css('background-color','#0da74e');
            }
            else
            {
                $('.checkmark').removeAttr('style');
                $('.containerqq:hover input ~ .checkmark').css({'background-color':'#f13f0f'});
            }

        });

        $('#OccID').change(function() {
            let occid = $(this).val();
            let last = occid.slice(-3);
            let first = occid.replace(last, '');
            if(first != 10) {
                $('.share_from_div').hide();
                $('.share_name_div').hide();
                $('.share_to_div').hide();
            }
            else {
                $('.share_from_div').show();
                $('.share_name_div').show();
                $('.share_to_div').show();
            }
        });

        $('.submit-btn').click(function(e)
        {
            e.preventDefault();
            let url = "{{ route('new.member.signup.view', $reference) }}";
            let data = $('#newmember').serialize();
            formSubmit(url, "POST", data);
        });

        function formSubmit(url, type="POST", data) {
            $.ajax({
                url: url,
                method: type,
                data:data,
                dataType: "json",
                success:function(res){
                    if(res.success)
                    {
                        $.confirm({
                            title: res.alert_title,
                            content: res.alert_message,
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
                    else
                    {
                        $.confirm({
                            title: res.alert_title,
                            content: res.alert_message,
                            type: 'red',
                            typeAnimated: true,
                            buttons: {
                                OK: {
                                    text: 'OK',
                                    btnClass: 'btn-red',
                                    width: 500,
                                    action: function () {
                                        window.location.reload();
                                    }
                                },
                            }
                        });
                    }
                }
            });
        }
    </script>
@endpush
