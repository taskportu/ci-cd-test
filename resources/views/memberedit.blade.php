@extends('layout')
@section('home')
@include('menu')
<div class="container">
    <div class="row text-left">
        <div class="card-body ">
            <div class="row rowsmargin">
                @if(Session::has('success'))
                    <div class="alert alert-success col-md-4 offset-md-5 text-center">
                        <strong>Updated!</strong>
                    </div>
                @endif
                </div>

                @if(Session::has('error'))
                <div class="form-group row mb-2">
                    <div class="alert alert-danger col-md-10 form-group row">
                        <strong>OccID All ready Insert</strong>
                    </div>
                </div>
                @endif
                <div class="class col-md-12">
                    <form method="post" action="{{ route('memberupdatess') }}">
                        {{-- @method('PUT') --}}
                        @csrf
                    <input type="hidden" value="{{ $members->MemberID }}" name="memberid">
                        <div class="col-md-6" style="float: left;">
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label
                                text-md-right">Member FistName</label>
                                <div class="col-md-6">
                                <input id="name2" value="{{ $members->Member_Fistname }}" type="text" class="form-control"
                                    name="MemberFistName" required >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="name" class="col-md-4 col-form-label
                                text-md-right">Member LastName</label>
                                <div class="col-md-6">
                                <input id="name" value="{{ $members->Member_Lastname }} " type="text" class="form-control"
                                    name="MemberLastName" required >
                                </div>
                            </div>


                            <div class="form-group row">
                                <label for="HCP" class="col-md-4 col-form-label
                                text-md-right">HCP Online</label>

                                <div class="col-md-6">
                                    <input id="password" type="text" class="form-control" value="{{ $members->HCP }} "
                                    name="HCP" required >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="handicap" class="col-md-4 col-form-label
                                text-md-right">HCP Teeplay</label>
                                <div class="col-md-6">
                                    <input value="{{ $members->handicap }}" id="handicap" type="text" class="form-control"
                                    name="handicap"   >
                                </div>
                            </div>
                            {{-- upgradte --}}

                            <div class="form-group row">
                                <label for="HCP" class="col-md-4 col-form-label
                                text-md-right">Address Line 1</label>
                                <div class="col-md-6">
                                    <input id="address1" value="{{ $members->address1 }} " type="text" class="form-control"
                                    name="address1"   >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="HCP" class="col-md-4 col-form-label
                                text-md-right">Address Line 2</label>
                                <div class="col-md-6">
                                    <input id="address2" value="{{ $members->address2 }} " type="text" class="form-control"
                                    name="address2"   >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="zipcode" class="col-md-4 col-form-label
                                text-md-right">Zip Code</label>
                                <div class="col-md-6">
                                    <input value="{{ $members->zipcode }}" id="zipcode" type="text" class="form-control"
                                    name="zipcode"   >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="HCP" class="col-md-4 col-form-label
                                text-md-right">City</label>
                                <div class="col-md-6">
                                    <input value="{{ $members->city }}" id="city" type="text" class="form-control"
                                    name="city"   >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="tel_privately" class="col-md-4 col-form-label
                                text-md-right">Tel Privat</label>
                                <div class="col-md-6">
                                    <input value="{{ $members->tel_privately }}" id="tel_privately" type="number" class="form-control"
                                    name="tel_privately"   >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="tel_jobs" class="col-md-4 col-form-label
                                text-md-right">Tel Work</label>
                                <div class="col-md-6">
                                    <input value="{{ $members->tel_jobs }}" id="tel_jobs" type="number" class="form-control"
                                    name="tel_jobs"   >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="phone_mobile" class="col-md-4 col-form-label
                                text-md-right">Tel Mobile</label>
                                <div class="col-md-6">
                                    <input value="{{ $members->phone_mobile }}"  id="phone_mobile" type="number" class="form-control"
                                    name="phone_mobile"   >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="HCP" class="col-md-4 col-form-label
                                text-md-right">Sex</label>
                                <div class="col-md-6">
                                    {{-- <input id="sex" type="text" class="form-control"
                                    name="sex"   > --}}
                                    <!--<select class="form-control" name="sex">-->
                                    <!--    <option >Select</option>-->
                                    <!--    <option {{ ($members->sex == "man") ? 'selected' : '' }} value="man">Man</option>-->
                                    <!--    <option {{ ($members->sex == "woman") ? 'selected' : '' }} value="woman">Woman</option>-->
                                    <!--</select>-->
                                     <select class="form-control" name="sex">
                                        <option >Select</option>
                                        <option {{ ($members->sex == "man" || $members->sex == "M" ) ? 'selected' : '' }} value="Man">Man</option>
                                        <option {{ ($members->sex == "woman" || $members->sex == "K") ? 'selected' : '' }} value="Women">Women</option>
                                    </select>
                                </div>
                            </div>

                            <!--<div class="form-group row">-->
                            <!--    <label for="stock_number" class="col-md-4 col-form-label -->
                            <!--    text-md-right">Stock Number</label>-->
                            <!--    <div class="col-md-6">-->
                            <!--        <input value="{{ $members->stock_number }}" id="stock_number" type="text" class="form-control" -->
                            <!--        name="stock_number"   >-->
                            <!--    </div>-->
                            <!--</div>-->

                        </div>
                        <div class="col-md-6" style="float: left;">

                            <div class="form-group row">
                                <label for="HCP" class="col-md-4 col-form-label
                                text-md-right">Member Type</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="member_type" id="member_type">

                                        <option >Select</option>

                                        <option {{ ($members->member_type == "AR" || $members->member_type == "A" ) ? 'selected' : '' }} value="AR">Aktive</option>

                                        <option {{ ($members->member_type == "AE" || $members->member_type == "ae") ? 'selected' : '' }} value="AE">Aktiv Evigvarende</option>

                                        <option {{ ($members->member_type == "AL" || $members->member_type == "A L" ||$members->member_type == "AC" || $members->member_type == "ac" ) ? 'selected' : '' }} value="AC">Aktiv Livsvarig</option>

                                        <option {{ ($members->member_type == "EJ" || $members->member_type == "ej" ) ? 'selected' : '' }} value="EJ">Eldre Junior</option>

                                        <option {{ ($members->member_type == "JU" || $members->member_type == "J" ) ? 'selected' : '' }} value="JU">Junior</option>

                                        <option {{ ($members->member_type == "PA" || $members->member_type == "P" ) ? 'selected' : '' }} value="PA">Passiv</option>

                                        <option {{ ($members->member_type == "SL" || $members->member_type == "S" ) ? 'selected' : '' }} value="SL">Slettet</option>

                                        <option {{ ($members->member_type == "AU" || $members->member_type == "AU" ) ? 'selected' : '' }} value="AU">Andel uten medlemskap</option>

                                        <option {{ ($members->member_type == "AV" || $members->member_type == "AV" ) ? 'selected' : '' }} value="AV">Andel venteliste</option>


                                    </select>
                                    <!--<input id="member_type" value=" "  type="text" class="form-control" -->
                                    <!--name="member_type"  >-->
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="OccID" class="col-md-4 col-form-label
                                text-md-right">OccID</label>
                                <div class="col-md-6">
                                    <input id="OccID" value="{{ $members->OccID }} " type="text" class="form-control"
                                    name="OccID" readonly required >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="HCP" class="col-md-4 col-form-label
                                text-md-right">Email</label>
                                <div class="col-md-6">
                                    <input value="{{ $members->email }}" id="email" type="email" class="form-control"
                                    name="email"   >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="HCP" class="col-md-4 col-form-label
                                text-md-right">Date of Birth</label>
                                <div class="col-md-6">
                                    <input value="{{ $members->date_of_birth }}" id="date_of_birth" type="date" class="form-control"
                                    name="date_of_birth"   >
                                    {{-- <div class="form-group">
                                        <div class='input-group date' id='datetimepicker1'>
                                            <input type='text' class="form-control" />
                                            <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span>
                                            </span>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="member_since" class="col-md-4 col-form-label
                                text-md-right">Member Since</label>
                                <div class="col-md-6">
                                    <input value="{{ $members->member_since }}" id="member_since" type="date" class="form-control"
                                    name="member_since"   >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="HCP" class="col-md-4 col-form-label
                                text-md-right">Resignation Date</label>
                                <div class="col-md-6">
                                    <input value="{{ $members->resignation_date }}" id="resignation_date" type="date" class="form-control"
                                    name="resignation_date"   >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="additional_info" class="col-md-4 col-form-label
                                text-md-right">Additional Info</label>
                                <div class="col-md-6">
                                    <!--<input value="{{ $members->additional_info }}" id="additional_info" type="text" class="form-control" -->
                                    <!--name="additional_info"   >-->
                                    <textarea name="additional_info" id="" cols="30" rows="3"value="{{ $members->additional_info }}">{{ $members->additional_info }}</textarea>
                                </div>
                            </div>
                            <!-- <div class="form-group row">-->
                            <!--    <label for="family_head" class="col-md-4 col-form-label -->
                            <!--    text-md-right">Family Head</label>-->
                            <!--    <div class="col-md-6">-->
                            <!--        <input value="{{ $members->family_head }}" id="family_head" type="text" class="form-control" -->
                            <!--        name="family_head"   >-->
                            <!--    </div>-->
                            <!--</div> -->


                            <div class="form-group row">
                                <label for="wardrobe" class="col-md-4 col-form-label
                                text-md-right">Wardrobe</label>
                                <div class="col-md-6">
                                    <input value="{{ $members->wardrobe }}" id="wardrobe" type="text" class="form-control"
                                    name="wardrobe"   >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="drinks_cabinet" class="col-md-4 col-form-label
                                text-md-right">Drinks Cabinet</label>
                                <div class="col-md-6">
                                    <input value="{{ $members->drinks_cabinet }}" id="drinks_cabinet" type="text" class="form-control"
                                    name="drinks_cabinet"   >
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="stick_cabinet" class="col-md-4 col-form-label
                                text-md-right">Stick Cabinet</label>
                                <div class="col-md-6">
                                    <input value="{{ $members->stick_cabinet }}" id="stick_cabinet" type="text" class="form-control"
                                    name="stick_cabinet"   >
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="charging_site" class="col-md-4 col-form-label
                                text-md-right">Charging Site</label>
                                <div class="col-md-6">
                                    <input value="{{ $members->charging_site }}" id="charging_site" type="text" class="form-control"
                                    name="charging_site"   >
                                </div>
                            </div>
                            {{-- <div class="form-group row">
                                <label for="HCP" class="col-md-4 col-form-label
                                text-md-right">
                                Playing Eligibility</label>
                                <div class="col-md-6">

                                    <label class="containerqq">
                                        <input {{ ($members->playing_eligibility == "yes") ? 'checked': '' }} type="radio" name="playing_eligibility"  value="yes">
                                        <span class="checkmark"></span>
                                        </label>
                                        <label class="containerqq">
                                        <input {{ ($members->playing_eligibility == "no") ? 'checked': '' }} type="radio" name="playing_eligibility" value="no">
                                        <span class="checkmark"></span>
                                    </label>
                                </div>
                            </div> --}}
                            <!--<div class="form-group row">-->
                            <!--    <label for="trolley_space" class="col-md-4 col-form-label -->
                            <!--    text-md-right">Trolley Space</label>-->
                            <!--    <div class="col-md-6">-->
                            <!--        <input value="{{ $members->trolley_space }}" id="trolley_space" type="text" class="form-control" -->
                            <!--        name="trolley_space"   >-->
                            <!--    </div>-->
                            <!--</div>-->
                            {{-- upgradtion end --}}
                            <div class="form-group row">
                                <label for="trolley_space" class="col-md-4 col-form-label
                                text-md-right">Trolley Space</label>
                                <div class="col-md-6">
                                    <input value="{{ $members->trolley_space }}" id="trolley_space" type="text" class="form-control"
                                    name="trolley_space"   >
                                </div>
                            </div>
                            <div class="form-group row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                    Update
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="col-md-6">

            </div>
        </div>
    </div>
 </div>

@endsection
@push('style')
    <style>
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
    <script src="{{ asset('/calendar/bootstrap-datepicker.js') }}"></script>
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
    </script>
@endpush
