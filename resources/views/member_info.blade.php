@extends('layout')
@section('home')
@include('menu')

<!------ Include the above in your HEAD tag ---------->
{{-- @if(Session::has('success')) --}}
<div id="message_updated" class="alert alert-success col-md-4 offset-md-4 mt-2 text-center" hidden>
    <strong>Updated!</strong>
</div>
{{-- @endif  --}}
{{-- </div>  --}}

@if(Session::has('error'))
<div class="form-group row mb-2">
    <div class="alert alert-danger col-md-10 form-group row">
        <strong>OccID All ready Insert</strong>
    </div>
</div>
@endif
@push('style')
<style>
    .nav-tabs .nav-link.active {
        background-color: #0c4684 !important;
    }

    .nav-tabs {
        border-bottom: 1px solid #000000;
    }


    .nav-tabs .nav-item.show .nav-link, .nav-tabs .nav-link.active {
        /* color: #000000; */
        background-color: #fff;
        border-color: #bae1ff #000000 #000;
        color: aliceblue !important;
    }

    .sm_border {
        border: 2px solid #143e6d;
    }

    #voo {
        background-color: #ffffb2;
    }

    .log_tbl table th {
        width: auto;
    }
</style>

@endpush
<section id="tabs" class="project-tab">
    @php
        $userImage = false;
        if(isset($members->image) && !empty($members->image)) {
            $exist = Storage::disk('public')->exists('/images/members/'.$members->image);
            $userImage = route('get.profile.image', $members->image);
            if($exist === false) $userImage = false;
            //dd($userImage);
        }
    @endphp
    <div class="container">
        <br>
        <div class="row" style="background: #041425;">
            <div class="col-sm-1 sm_border">
                <input type="text" value="{{ $members->OccID }}" readonly
                       class="form-control-plaintext searchfilter" data-column="OccID" placeholder="Member ID"
                       style="color: #ffffff !important;">
            </div>
            <div class="col-sm-2 sm_border">
                <input type="text" value="{{ $members->Member_Fistname }}" readonly
                       class="form-control-plaintext searchfilter" data-column="Member_Fistname"
                       placeholder="Firstname" style="color: #ffffff !important;">
            </div>
            <div class="col-sm-2 sm_border">
                <input type="text" value="{{ $members->Member_Lastname }}" readonly
                       class="form-control-plaintext searchfilter" data-column="Member_Lastname"
                       placeholder="Lastname" style="color: #ffffff !important;">
            </div>

            @php
            $background = '';
            $color = '';
            if(!empty($members->member_type)){
            if($members->member_type == 'Passiv'){
            $background .='yellow';
            $color .= 'black';
            }
            elseif($members->member_type == 'Slettet'){
            $background .='Red';
            $color .= '#ffffff';
            }
            else{
            $background .='Green';
            $color .= '#ffffff';
            }
            }
            @endphp
            <div class="col-sm-2 sm_border"
                 style="color:{{ $color }} !important;background-color:{{ $background }};">
                <input type="text" value="{{ (!empty($members->member_type) ? $members->member_type : '')  }}"
                       readonly class="form-control-plaintext searchfilter" data-column="member_type"
                       placeholder="Member Type"
                       style="color:{{ $color }} !important;background-color:{{ $background }};">
            </div>
            <div class="col-sm-2 sm_border">
                <input type="text" value="{{ $members->phone_mobile }}" readonly
                       class="form-control-plaintext searchfilter" data-column="phone_mobile"
                       placeholder="Tel Mobile" style="color: #ffffff !important;">
            </div>
            <div class="col-sm-3 sm_border">
                <a style="cursor: pointer; text-decoration-color: white;" href="mailto:{{ $members->email }}">
                    <input type="text" value="{{ $members->email }}" readonly
                           class="form-control-plaintext searchfilter" data-column="email" placeholder="Email"
                           style="color: #ffffff !important; cursor: pointer;"></a>
            </div>
        </div>
        <br>
        <div class="row">
            @if(empty($members->email))
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <div class="alert alert-warning alert-dismissible fade show" style="margin-bottom: 3px;">
                    <strong>ADVARSEL!</strong> Dette medlemmet mangler "Epost".
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            </div>
            <div class="col-sm-3"></div>
            @endif
            @if(empty($members->phone_mobile))
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <div class="alert alert-warning alert-dismissible fade show" style="margin-bottom: 3px;">
                    <strong>ADVARSEL!</strong> Dette medlemmet mangler "Tlf mobil".
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            </div>
            <div class="col-sm-3"></div>
            @endif

            @if(empty($members->member_since))
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <div class="alert alert-warning alert-dismissible fade show" style="margin-bottom: 3px;">
                    <strong>ADVARSEL!</strong> Dette medlemmet mangler "Medlem siden".
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            </div>
            <div class="col-sm-3"></div>
            @endif
            @if(empty($members->resignation_date))
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <div class="alert alert-warning alert-dismissible fade show" style="margin-bottom: 3px;">
                    <strong>ADVARSEL!</strong> Dette medlemmet mangler "Registreringsdato".
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                </div>
            </div>
            <div class="col-sm-3"></div>
            @endif

        </div>

        <form id="update_form" style="
    border: 2px solid;
    background-color: #e9ecef40;">
            @csrf
            <input type="hidden" value="{{ $members->MemberID }}" name="memberid">
            <div class="row">
                <div class="col-md-12">
                    <nav>
                        <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
                            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home"
                               role="tab" aria-controls="nav-home" aria-selected="true">BASIC</a>
                            <a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-profile"
                               role="tab" aria-controls="nav-profile" aria-selected="false">CONTACT</a>
                            <a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-contact"
                               role="tab" aria-controls="nav-contact" aria-selected="false">MEMBER</a>

                            <a class="nav-item nav-link" id="nav-contact-facility" data-toggle="tab"
                               href="#nav-facility"
                               role="tab" aria-controls="nav-facility" aria-selected="false">FACILITIES</a>

                            <a class="nav-item nav-link" id="nav-contact-share" data-toggle="tab" href="#nav-share"
                               role="tab" aria-controls="nav-share" aria-selected="false">SHARES</a>

                            <a class="nav-item nav-link" id="nav-contact-logs" data-toggle="tab" href="#nav-logs"
                               role="tab" aria-controls="nav-logs" aria-selected="false">LOGS</a>

                            <a class="nav-item nav-link btn-success" id="nav-ticket"
                               href="{{route('add_ticket', $members->MemberID)}}">
                                TICKETS
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-arrow-right" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                          d="M1 8a.5.5 0 0 1 .5-.5h11.793l-3.147-3.146a.5.5 0 0 1 .708-.708l4 4a.5.5 0 0 1 0 .708l-4 4a.5.5 0 0 1-.708-.708L13.293 8.5H1.5A.5.5 0 0 1 1 8z"/>
                                </svg>
                            </a>
                        </div>
                    </nav>

                    {{-- Basic Tab --}}
                    <div class="tab-content" id="nav-tabContent" style="padding: 5px">
                        <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                             aria-labelledby="nav-home-tab">

                            {{--
                            <div class="row">
                                @if (empty($members->Member_Fistname) )
                                <div class="col-sm-3"></div>
                                <div class="col-sm-6">
                                    <div class="alert alert-warning alert-dismissible fade show"
                                         style="margin-bottom: 3px;">
                                        <strong>ADVARSEL!</strong> Dette medlemmet mangler "Fornavnet".
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    </div>
                                </div>
                                <div class="col-sm-3"></div>
                                @endif
                                @if(empty($members->Member_Lastname))
                                <div class="col-sm-3"></div>
                                <div class="col-sm-6">
                                    <div class="alert alert-warning alert-dismissible fade show"
                                         style="margin-bottom: 3px;">
                                        <strong>ADVARSEL!</strong> Dette medlemmet mangler "Etternavn".
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    </div>
                                </div>
                                <div class="col-sm-3"></div>
                                @endif
                                @if(empty($members->member_type))
                                <div class="col-sm-3"></div>
                                <div class="col-sm-6">
                                    <div class="alert alert-warning alert-dismissible fade show"
                                         style="margin-bottom: 3px;">
                                        <strong>ADVARSEL!</strong> Dette medlemmet mangler "Medlemstype".
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            &times;
                                        </button>
                                    </div>
                                </div>
                                <div class="col-sm-3"></div>
                                @endif
                                @if(empty($members->share_type))
                                <div class="col-sm-3"></div>
                                <div class="col-sm-6">
                                    <div class="alert alert-warning alert-dismissible fade show"
                                         style="margin-bottom: 3px;">
                                        <strong>ADVARSEL!</strong> Dette medlemmet mangler "Delingstype".
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    </div>
                                </div>
                                <div class="col-sm-3"></div>
                                @endif
                                @if(empty($members->share_number))
                                <div class="col-sm-3"></div>
                                <div class="col-sm-6">
                                    <div class="alert alert-warning alert-dismissible fade show"
                                         style="margin-bottom: 3px;">
                                        <strong>ADVARSEL!</strong> Dette medlemmet mangler "Andelenummer".
                                        <button type="button" class="close" data-dismiss="alert">&times;</button>
                                    </div>
                                </div>
                                <div class="col-sm-3"></div>
                                @endif

                            </div>
                            --}}
                            <div class="row">
                                <div class="col-sm-2">
                                    @include('member_info_profile_img')
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group row" style="margin-top: 70px;">
                                        <label for="OccID" class="col-sm-3 col-form-label">OCCID
                                        </label>
                                        <div class="col-sm-3">
                                            <input type="text" readonly class="form-control" value="{{ $members->OccID }}"
                                                   id="OccID" name="OccID" placeholder="OCCID">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-3">
                                            <label for="Member_Fistname" style="margin-top: 30px;" class="col-form-label">
                                                Member
                                            </label>
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="Member_Fistname" class="col-form-label"><b>First Name</b>
                                            </label>
                                            <input type="text" class="form-control" value="{{ $members->Member_Fistname }}"
                                                   id="Member_Fistname" name="Member_Fistname">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="Member_Lastname" class=" col-form-label"><b>Last Name</b>
                                            </label>
                                            <input type="text" class="form-control" value="{{ $members->Member_Lastname }}"
                                                   id="Member_Lastname" name="Member_Lastname">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-3">
                                            <label style="margin-top: 30px;" for="HCP" class="col-form-label">HCP
                                            </label>
                                        </div>
                                        <div class="col-sm-2">
                                            <label for="HCP" class="col-form-label"><b>Online</b>
                                            </label>

                                            <input type="text" id="hidden_hcp" name="hidden_hcp" hidden
                                                   value="{{ !empty($members->new_hcp) ? $members->new_hcp : $members->HCP  }}">
                                            <input type="text" class="form-control hcp-validation" id="HCP"
                                                   value="{{ !empty($members->new_hcp) ? $members->new_hcp : $members->HCP  }}"
                                                   name="HCP" placeholder="Online">
                                        </div>
                                        @if ($members->app_hcp_status =='online')

                                            <div class="col-sm-2" style="margin-top: 4%;margin-left: -2%;"><span
                                                    style="color: green; margin-left:10px;"><b>SELECTED</b></span></div>
                                        @endif
                                        <div class="col-sm-2">
                                            <label for="handicap" class="col-form-label"><b>Manual</b>
                                            </label>
                                            <input type="text" class="form-control hcp-validation" id="handicap"
                                                   value="{{ $members->handicap }}" name="handicap" placeholder="Manual">
                                        </div>
                                        @if ($members->app_hcp_status =='manual')

                                            <div class="col-sm-2" style="margin-top: 4%;margin-left: -2%;"><span
                                                    style="margin-left:10px;color: green;"><b>SELECTED</b></span></div>
                                        @endif
                                    </div>

                                    <div class="form-group row">
                                        <label for="HCP" class="col-sm-3 col-form-label">Member Type
                                        </label>
                                        <div class="col-sm-5">
                                            <select class="form-control" name="member_type" id="member_type">
                                                <option value="">Select</option>

                                                <option
                                                    {{ ($members->member_type == "Aktive" ) ? 'selected' : '' }}
                                                    value="Aktive">
                                                    Aktive
                                                </option>

                                                <option
                                                    {{ ($members->member_type == "Aktiv Evigvarende" ) ? 'selected' : '' }}
                                                    value="Aktiv Evigvarende">
                                                    Aktiv Evigvarende
                                                </option>

                                                <option
                                                    {{ ($members->member_type == "Aktiv Livsvarig" ) ? 'selected' : '' }}
                                                    value="Aktiv Livsvarig">
                                                    Aktiv Livsvarig
                                                </option>

                                                <option
                                                    {{ ($members->member_type == "Andel uten medlemskap" ) ? 'selected' : ''
                                                }} value="Andel uten medlemskap">
                                                    Andel uten medlemskap
                                                </option>

                                                <option
                                                    {{ ($members->member_type == "Eldre Junior" ) ? 'selected' : '' }}
                                                    value="Eldre Junior">
                                                    Eldre Junior
                                                </option>

                                                <option
                                                    {{ ($members->member_type == "Junior" ) ? 'selected' : '' }}
                                                    value="Junior">
                                                    Junior
                                                </option>

                                                <option
                                                    {{ ($members->member_type == "Passiv" ) ? 'selected' : '' }}
                                                    value="Passiv">
                                                    Passiv
                                                </option>

                                                <option
                                                    {{ ($members->member_type == "Slettet" ) ? 'selected' : '' }}
                                                    value="Slettet">
                                                    Slettet
                                                </option>

                                                <option
                                                    {{ ($members->member_type == "Sponsor" ) ? 'selected' : '' }}
                                                    value="Sponsor">
                                                    Sponsor
                                                </option>

                                                <option
                                                    {{ ($members->member_type == "Midlertidig Medlem" ) ? 'selected' : '' }}
                                                    value="Midlertidig Medlem">
                                                    Midlertidig Medlem
                                                </option>

                                                <option
                                                    {{ ($members->member_type == "Aktiv Uten Spillerett" ) ? 'selected' : ''
                                                }} value="Aktiv Uten Spillerett">
                                                    Aktiv Uten Spillerett
                                                </option>

                                                <option
                                                    {{ ($members->member_type == "Andel venteliste" ) ? 'selected' : '' }}
                                                    value="Andel venteliste">
                                                    Andel venteliste
                                                </option>

                                            </select>

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="HCP" class="col-sm-3 col-form-label">Share Type
                                        </label>
                                        <div class="col-sm-5">
                                            {{-- <input type="text" class="form-control" id="HCP" value="{{ $members->HCP }}"
                                                        name="HCP" placeholder="HCP"> --}}

                                            <select class="form-control" name="share_type" id="share_type">

                                                <option value="">Select</option>

                                                <option class="{{$members->share_type}}"
                                                        {{ ($members->share_type == 'A' || $members->share_type == 'A-Share') ?
                                                    'selected' : '' }} value="A-Share">
                                                    A-Share
                                                </option>

                                                <option
                                                    {{ ($members->share_type == "B-Share" ) ? 'selected' : '' }}
                                                    value="B-Share">
                                                    B-Share
                                                </option>

                                                <option
                                                    {{ ($members->share_type == "Unknown Type" ) ? 'selected' : '' }}
                                                    value="Unknown Type">
                                                    Unknown Type
                                                </option>

                                                <option
                                                    {{ ($members->share_type == "Old Share" ) ? 'selected' : '' }}
                                                    value="Old Share">
                                                    Old Share
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="share_number" class="col-sm-3 col-form-label">Share Number
                                        </label>
                                        <div class="col-sm-3">
                                            <input type="text" style="width: 44%;" class="form-control hcp-validation"
                                                   id="share_number" value="{{ $members->share_number }}"
                                                   name="share_number" placeholder="Share Number">

                                        </div>
                                    </div>
                                    <div class="form-group row share_from_div">
                                        <label for="share_from" class="col-md-4 col-form-label
                                        text-md-right">Share From</label>
                                        <div class="col-md-5">
                                            <input id="share_from" type="date" class="form-control"
                                            name="share_from" value="{{ $members->share_from }}" @isset($members->share_from) readonly @endisset>
                                        </div>
                                    </div>
                                    <div class="form-group row share_name_div">
                                        <label for="share_name" class="col-md-4 col-form-label
                                        text-md-right">Share Name</label>
                                        <div class="col-md-5">
                                            <input id="share_name" type="text" class="form-control"
                                            name="share_name" value="{{ $members->share_name }}" @isset($members->share_name) readonly @endisset>
                                        </div>
                                    </div>
                                    <div class="form-group row share_to_div">
                                        <label for="share_to" class="col-md-4 col-form-label
                                        text-md-right">Share To</label>
                                        <div class="col-md-5">
                                            <input id="share_to" type="date" class="form-control"
                                            name="share_to" value="{{ $members->share_to }}" @isset($members->share_to) readonly @endisset>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2"></div>
                            </div>



                        </div>
                        {{-- Contact Tab --}}
                        <div class="tab-pane fade" id="nav-profile" role="tabpanel"
                             aria-labelledby="nav-profile-tab">
                            <div class="row">
                                <div class="col-sm-2">
                                    @include('member_info_profile_img')
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group row" style="margin-top: 70px;">
                                        <label for="address1" class="col-sm-3 col-form-label">Address Line 1
                                        </label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" value="{{ $members->address1 }}"
                                                   id="address1" name="address1" placeholder="Address Line 1">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="address2" class="col-sm-3 col-form-label">Address Line 2
                                        </label>
                                        <div class="col-sm-5">
                                            <input type="text" class="form-control" value="{{ $members->address2 }}"
                                                   id="address2" name="address2" placeholder="Address Line 2">

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="city" class="col-sm-3 col-form-label">Zip / City
                                        </label>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control number_only"
                                                   value="{{ $members->zipcode }}" id="zipcode" name="zipcode"
                                                   placeholder="Zip">

                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control" id="city" value="{{ $members->city }}"
                                                   name="city" placeholder="City">

                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="email" class="col-sm-3 col-form-label">Email
                                        </label>
                                        <div class="col-sm-5">
                                            <input type="email" class="form-control" id="email"
                                                   value="{{ $members->email }}" name="email" placeholder="Email">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="email_billing" class="col-sm-3 col-form-label">Email Invoice</label>
                                        <div class="col-sm-5">
                                            <input type="email" class="form-control" id="email_billing"
                                                   value="{{ $members->email_billing }}" name="email_billing"
                                                   placeholder="Email Invoice">
                                            <small class="errInputMessage d-none"></small>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="sms_news_letter" class="col-sm-3 col-form-label">Use SMS</label>
                                        <div class="col-sm-4">
                                            <label class="switch" for="sms_news_letter">
                                                <input type="checkbox" id="sms_news_letter" name="sms_news_letter"
                                                       @if($members->sms_news_letter == 1) checked @endif value="1">
                                                <span class="slider round"></span>
                                            </label>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <div class="col-sm-3">
                                            <label for="tel_jobs" style="margin-top: 30px;" class="col-form-label">Phone
                                            </label>
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="tel_privately" class="col-form-label"><b>Private</b>
                                            </label>
                                            <input type="text" class="form-control number_only" id="tel_privately"
                                                   value="{{ $members->tel_privately }}" name="tel_privately"
                                                   placeholder="Private">
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="tel_jobs" class="col-form-label"><b>Work</b>
                                            </label>
                                            <input type="text" class="form-control number_only" id="tel_jobs"
                                                   value="{{ $members->tel_jobs }}" name="tel_jobs" placeholder="Work">
                                        </div>
                                        <div class="col-sm-3">
                                            <label for="phone_mobile" class=" col-form-label"><b> Mobile</b>
                                            </label>
                                            <input type="text" class="form-control number_only" id="tel_jobs"
                                                   value="{{ $members->phone_mobile }}" name="phone_mobile"
                                                   placeholder="Mobile">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-2"></div>
                            </div>

                        </div>
                        {{-- Member Tab --}}
                        <div class="tab-pane fade" id="nav-contact" role="tabpanel"
                             aria-labelledby="nav-contact-tab">
                            <div class="row">
                                <div class="col-sm-2">
                                    @include('member_info_profile_img')
                                </div>
                                <div class="col-sm-8">
                                    <div class="form-group row" style="margin-top: 70px;">
                                        <label for="sex" class="col-sm-3 col-form-label">Gender
                                        </label>
                                        <div class="col-sm-4">
                                            <select class="form-control" name="sex">
                                                <option value="">Select</option>
                                                <option {{ ($members->sex == "Man" || $members->sex == "M" ) ? 'selected' : '' }} value="Man">
                                                    Male
                                                </option>
                                                <option {{ ($members->sex == "Women" || $members->sex == "K") ? 'selected' : '' }} value="Women">
                                                    Female
                                                </option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="date_of_birth" class="col-sm-3 col-form-label">Date of Birth
                                        </label>
                                        <div class="col-sm-4">
                                            <input type="date" class="form-control"
                                                   value="{{ $members->date_of_birth }}" id="date_of_birth"
                                                   name="date_of_birth" placeholder="Date of Birth">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="member_since" class="col-sm-3 col-form-label">Member Since
                                        </label>
                                        <div class="col-sm-4">
                                            <input type="date" class="form-control"
                                                   value="{{ $members->member_since }}" id="member_since"
                                                   name="member_since" placeholder="Member Since">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="resignation_date" class="col-sm-3 col-form-label">Registration Date
                                        </label>
                                        <div class="col-sm-4">
                                            <input type="date" class="form-control"
                                                   id="resignation_date" value="{{ $members->resignation_date }}"
                                                   name="resignation_date" placeholder="Registration Date">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>


                        {{-- Facility Tab --}}
                        <div class="tab-pane fade" id="nav-facility" role="tabpanel"
                             aria-labelledby="nav-contact-facility">
                                <div class="row">
                                    <div class="col-sm-2">
                                        @include('member_info_profile_img')
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="form-group row" style="margin-top: 70px;">
                                            <div class="col-sm-2"></div>
                                            <div class="col-sm-3">
                                                <label for="wardrobe" class="col-form-label">Wardrobe
                                                </label>
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" value="{{ $members->wardrobe }}"
                                                       id="wardrobe" name="wardrobe">
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="charging_site" class=" col-form-label">Charging
                                                </label>
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="charging_site"
                                                       value="{{ $members->charging_site }}" name="charging_site">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-2"></div>
                                            <div class="col-sm-3">
                                                <label for="drinks_cabinet" class="col-form-label">Drinks Cabinet
                                                </label>
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" name="drinks_cabinet" class="form-control"
                                                       value="{{ $members->drinks_cabinet }}" id="drinks_cabinet">
                                            </div>
                                            <div class="col-sm-3">
                                                <label for="stick_cabinet" class=" col-form-label">Stick Cabinet
                                                </label>
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" value="{{ $members->stick_cabinet }}"
                                                       id="stick_cabinet" name="stick_cabinet">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-sm-2"></div>
                                            <label for="trolley_space" class="col-sm-3 col-form-label">Trolley
                                            </label>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control" id="trolley_space"
                                                       value="{{ $members->trolley_space }}" name="trolley_space">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>


                        {{-- Share Tab --}}
                        <div class="tab-pane fade" id="nav-share" role="tabpanel"
                             aria-labelledby="nav-contact-share">
                            <div class="row">
                                <div class="col-sm-2">
                                    @include('member_info_profile_img')
                                </div>
                                <div class="col-sm-8">
                                    @php
                                        $old = array();
                                    @endphp
                                    <table class="table" style="margin-top: 5rem;" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>OccID</th>
                                                <th>Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($getallchilds as $getallchild)
                                            {{-- {{substr($getallchild->OccID,2)}} --}}
                                            @php
                                                $sub = substr($getallchild->OccID,2)
                                            @endphp
                                            @if ( strlen((string)$sub)<=3 )
                                                <tr>
                                                    <td>{{ $getallchild->OccID }}</td>
                                                    <td>{{ $getallchild->Member_Fistname .' '. $getallchild->Member_Lastname}}</td>
                                                    <td>
                                                        {{-- {{$getallchild->member_type}} --}}
                                                        {{-- btn btn-sm btn-danger --}}
                                                        @php
                                                            $class = '';
                                                            if($getallchild->member_type == 'Passiv' || $getallchild->member_type ==
                                                            'Slettet')
                                                            {
                                                            $class = 'btn-danger';
                                                            }
                                                            else {
                                                            $class = 'btn-success';
                                                            }
                                                        @endphp
                                                        <a class="btn  btn-sm {{$class}}"
                                                           href="{{ route('memberedits',$getallchild->MemberID)}}">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                                 fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                                                                <path
                                                                    d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z"/>
                                                            </svg>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @else
                                                @php
                                                    array_push($old,$getallchild->MemberID);
                                                @endphp
                                            @endif
                                        @endforeach
                                        </tbody>
                                    </table>

                                    <div class="center col-11">
                                        <p class="float-left" style="">
                                            <button name="old" id="old" class="btn btn-primary">Old</button>
                                        </p>
                                    </div>

                                    <table class="table" cellspacing="0" id="old_data" style="display:none;">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>OccID</th>
                                                <th>Name</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($getallchilds as $getallchild)
                                                @foreach ($old as $id)
                                                    @if ($getallchild->MemberID == $id)
                                                        <tr>
                                                            <td>{{ $getallchild->expire_date }}</td>
                                                            <td>{{ $getallchild->OccID }}</td>
                                                            <td>{{ $getallchild->Member_Fistname .' '. $getallchild->Member_Lastname}}</td>
                                                            <td>
                                                                {{-- {{$getallchild->member_type}} --}}
                                                                {{-- btn btn-sm btn-danger --}}
                                                                @php
                                                                    $class = '';
                                                                    if($getallchild->member_type == 'Passiv' || $getallchild->member_type ==
                                                                    'Slettet'|| $getallchild->member_type == 'Aktiv Uten Spillerett')
                                                                    {
                                                                    $class = 'btn-danger';
                                                                    }
                                                                    else {
                                                                    $class = 'btn-success';
                                                                    }
                                                                @endphp
                                                                <a class="btn  btn-sm {{$class}}"
                                                                   href="{{ route('memberedits',$getallchild->MemberID)}}">
                                                                    <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                                         height="16" fill="currentColor" class="bi bi-pen"
                                                                         viewBox="0 0 16 16">
                                                                        <path
                                                                            d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z"/>
                                                                    </svg>
                                                                </a>
                                                            </td>
                                                        </tr>

                                                    @endif
                                                @endforeach
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>


                        {{-- Logs Tab --}}
                        <div class="tab-pane fade" id="nav-logs" role="tabpanel" aria-labelledby="nav-contact-logs">
                            <div class="row">
                                <div class="col-sm-2">
                                    @include('member_info_profile_img')
                                </div>
                                <div class="col-8" style="padding: 0px 20px; margin-top: 5rem;">
                                    <div class="d-flex justify-content-center">
                                        <label for="log_note" class="col-form-label"><b>Log Note</b></label>
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <textarea
                                            class="col-form-label p-3"
                                            name="log_note"
                                            id="log_note"
                                            cols="60"
                                            rows="3"
                                            placeholder="Log Note"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary mb-4 update_btn_class">Update
                                    </button>
                                </div>
                            </div>
                            @if($logs->isNotEmpty())
                            <table class="table table-striped" cellspacing="0">
                                <thead>
                                <tr>
                                    <th style="width: 15%; vertical-align: middle;">Date Time</th>
                                    <th style="width: 26%;">Field</th>
                                    <th style="width: 34%;">Old</th>
                                    <th style="width: 34%;">New</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach ($logs as $log)
                                <tr>
                                    <td>{{\Carbon\Carbon::parse($log->log_timestamp)->format('Y-m-d H:i')}}</td>
                                    <td>{{config('settings.member_fields')[$log->log_field]}}</td>
                                    @if($log->log_field === 'notes')
                                    <td colspan="2">{{$log->log_new}}</td>
                                    @else
                                    <td>{{$log->log_old}}</td>
                                    <td>{{$log->log_new}}</td>
                                    @endif
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @else
                            <div class="alert alert-danger mt-4">
                                No Logs Found!!!
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <br>
                <br>
                <div class="col-12">
                    <div class="d-flex justify-content-center">
                        <label for="additional_info" class="col-form-label
                        "><b>Additional Info</b></label>
                    </div>
                </div>
                <div class="col-12" style="padding: 20px">
                    <div class="d-flex justify-content-center">
                            <textarea
                                    class=" col-form-label p-3" name="additional_info" id="additional_info" cols="60"
                                    rows="3"
                                    value="{{ $members->additional_info }}">{{ $members->additional_info }}</textarea>
                    </div>
                </div>
                {{--
                <div class="form-group row">
                    <label for="additional_info" class="col-md-4 col-form-label
                        text-md-right">Additional Info</label>
                    </center>
                    <div class="col-md-6">
                        <!--<input value="{{ $members->additional_info }}" id="additional_info" type="text" class="form-control" -->
                        <!--name="additional_info"   >-->
                        <textarea name="additional_info" id="" cols="30" rows="3"
                                  value="{{ $members->additional_info }}">{{ $members->additional_info }}</textarea>
                    </div>
                </div>
                --}}

                <div class="center col-11" style="padding: 20px">
                    <p class="float-sm-right pcursor print-excel" style="">
                        <button type="submit" class="btn btn-primary update_btn_class">Update</button>
                    </p>
                </div>
            </div>
        </form>
    </div>
</section>
@stop
@push('script2')
<script>
    $(document).on('click', '.close', function () {
        e.preventDefault();
    })

    function emailCheck() {
        let email = $('#email').val();
        let mailFill = false;
        let email_billing = $('#email_billing').val();
        let billMailFill = false;
        let error = false;

        if (email !== '' && email !== null && email !== undefined) mailFill = true;
        if (email_billing !== '' && email_billing !== null && email_billing !== undefined) billMailFill = true;

        if (mailFill && billMailFill) error = false;
        else {
            if (mailFill) {
                if (billMailFill) {
                    error = false;
                    $('#email_billing').next('.errInputMessage').empty().addClass('d-none');
                } else {
                    error = true;
                    $('#email_billing').next('.errInputMessage').empty().text('Invoice Email Not Valid!').removeClass('d-none');
                }
            } else {
                if (billMailFill) {
                    error = true;
                    $('#email').next('.errInputMessage').empty().text('Email Not Valid!').removeClass('d-none');
                } else {
                    error = false;
                    $('#email').next('.errInputMessage').empty().addClass('d-none');
                }
            }

            if (billMailFill) {
                if (mailFill) {
                    error = false;
                    $('#email').next('.errInputMessage').empty().addClass('d-none');
                } else {
                    error = true;
                    $('#email').next('.errInputMessage').empty().text('Email Not Valid!').removeClass('d-none');
                }
            } else {
                if (mailFill) {
                    error = true;
                    $('#email_billing').next('.errInputMessage').empty().text('Invoice Email Not Valid!').removeClass('d-none');
                } else {
                    error = false;
                    $('#email_billing').next('.errInputMessage').empty().addClass('d-none');
                }
            }
        }
        return error;
    }

    $(document).ready(function () {
        $('#update_form').submit(function (e) {
            e.preventDefault();
            $('.update_btn_class').attr('disabled', true);
            var th = $(this);
            var formData = new FormData(this);
            var hidden_hcp = $('#hidden_hcp').val();
            var hcp = $('#HCP').val();
            // console.log(hidden_hcp);
            // console.log(hcp);
            if (hidden_hcp != hcp) {

                $.confirm({
                    title: 'Reset HCP!!',
                    content: 'Are you sure you want to reset the members current HCP and remove all current registered rounds from the calculation?',
                    // autoClose: 'cancelAction|8000',
                    buttons: {
                        deleteUser: {
                            text: 'Yes',
                            btnClass: 'btn-red',
                            width: 500,
                            action: function () {
                                $.ajax({
                                    url: "{{ route('memberupdatess')  }}",
                                    method: "POST",
                                    data: formData,
                                    contentType: false,
                                    cache: false,
                                    processData: false,
                                    success: function (res) {
                                        console.log(res);
                                        if (res.success) {
                                            $('#message_updated').removeAttr('hidden');
                                            location.reload();
                                        }
                                    }
                                });
                            }
                        },
                        cancelButton: {
                            text: 'No',
                            action: function () {

                            }
                        },
                        // cancelAction: function () {
                        // 	$.alert('action is canceled');
                        // }
                    }
                });
            } else {

                $.ajax({
                    url: "{{ route('memberupdatess')  }}",
                    method: "POST",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (res) {
                        console.log(res);
                        if (res.success) {

                            $('#message_updated').removeAttr('hidden');
                            location.reload();
                        }
                    }
                });

            }
        });
    });

    $('#old').click(function (e) {
        e.preventDefault();
        if ($('#old_data').css('display') == 'none') {

            $('#old_data').css('display', 'inline-table');
        } else {
            $('#old_data').css('display', 'none');

        }
    })
</script>
@endpush

