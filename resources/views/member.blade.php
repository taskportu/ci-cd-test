@extends('layout')
@section('home')
@include('menu')
<div class="container">
    <div class="row mt-5">
        <div class="col-12 col-sm-12 ">
            <div class="card mb-4" style="border-color: #002a71; border-width: 2px; border-radius: 6px;">
                <div class="card-header bg-dark text-white">Member Signup</div>
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

                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active show" id="pending-tab" data-toggle="tab" href="#pending" role="tab" aria-controls="pending"
                               aria-selected="false">Pending</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="declined-tab" data-toggle="tab" href="#declined" role="tab"
                               aria-controls="declined" aria-selected="false">Declined</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <div class="tab-pane fade show active" id="pending" role="tabpanel" aria-labelledby="pending-tab">
                            @if(!empty($memberSignup['pending']))
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <td><strong>Name</strong></td>
                                            <td><strong>Toekn</strong></td>
                                            <td><strong>Last Update</strong></td>
                                            <td><strong>Signedup Date</strong></td>
                                            <td class="text-right"><strong></strong></td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($memberSignup['pending'] as $signup)
                                            <tr>
                                                <td>{{$signup['Member_Fistname']}} {{$signup['Member_Lastname'] ?? ''}}</td>
                                                <td><a class="" href="{{ route('member.add.view', ['m' => $signup['signup_token']]) }}">{{$signup['signup_token']}}</a></td>
                                                <td>@if($signup['signup_member_filled'] == 1) Customer @else Admin @endif</td>
                                                <td>@isset($signup['resignation_date']){{ Carbon\Carbon::createFromFormat('Y-m-d', $signup['resignation_date'])->format('d-m-Y') }}@endisset</td>
                                                <td>
                                                    <a class="btn btn-sm btn-info float-right" href="{{ route('new.member.signup.view', $signup['signup_token']) }}" target="_blank">Open Signup Form</a>
                                                    <label id="copy-clipboad" class="btn btn-sm btn-info float-right mr-2" data-url="{{  route('new.member.signup.view', $signup['signup_token'])}}">Copy</label>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-danger">
                                    Sorry!!! No Data Found.
                                </div>
                            @endif
                        </div>
                        <div class="tab-pane fade" id="declined" role="tabpanel" aria-labelledby="declined-tab">
                            @if(!empty($memberSignup['declined']))
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <td><strong>Name</strong></td>
                                            <td><strong>Toekn</strong></td>
                                            <td><strong>Declined Date</strong></td>
                                            <td><strong>Link</strong></td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($memberSignup['declined'] as $signup)
                                            <tr>
                                                <td>{{$signup['Member_Fistname']}} {{$signup['Member_Lastname'] ?? ''}}</td>
                                                <td>{{$signup['signup_token']}}</td>
                                                <td>@isset($signup['resignation_date']) {{ Carbon\Carbon::createFromFormat('Y-m-d', $signup['resignation_date'])->format('d-m-Y') }} @endisset</td>
                                                <td>
                                                    <a class="btn btn-info float-right" href="{{ route('new.member.signup.view', $signup['signup_token']) }}" target="_blank">Open Signup Form</a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="alert alert-danger">
                                    Sorry!!! No Data Found.
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="row text-left mt-5 mb-5">
        <div class="col rowsmargin">
            <div class="alert alert-success col-md-4 offset-md-5 text-center" style="display:none">
                <strong>Saved!</strong>
            </div>
            <div class="alert alert-danger col-md-10 form-group row" style="display:none">
                <strong>OccID All ready Insert</strong>
            </div>
        </div>
        <div class="class col-md-12">
            <form method="POST" action="{{ url('add_memberdata') }}" data-submint id="newmember">
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
{{--                                        {{dd($pendingMember)}}--}}
                                        <input id="name" type="text" class="form-control"
                                        name="MemberFistName" required @if(isset($pendingMember->Member_Fistname)) value = "{{$pendingMember->Member_Fistname}}" @endif>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="name" class="col-md-4 col-form-label
                                    text-md-right require_label">Member LastName</label>
                                    <div class="col-md-6">
                                        <input id="name" type="text" class="form-control"
                                        name="MemberLastName" required @if(isset($pendingMember->Member_Lastname)) value = "{{$pendingMember->Member_Lastname}}" @endif>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="OccID" class="col-md-4 col-form-label
                                    text-md-right @if(!isset($pendingMember)) require_label @endif">OccID</label>
                                    <div class="col-md-3">
                                        <input id="OccID" type="text" class="form-control number_only"
                                        name="OccID" @if(!isset($pendingMember)) required @endif maxlength = "5" minlength="5" autocomplete="off" @if(isset($pendingMember->OccID)) value = "{{$pendingMember->OccID}}" @endif>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="HCP" class="col-md-4 col-form-label
                                    text-md-right @if(!isset($pendingMember)) require_label @endif">HCP Online</label>
                                    <div class="col-md-3">
                                        <input id="HCP" type="text" class="form-control hcp-validation"
                                        name="HCP" @if(!isset($pendingMember)) required @endif @if(isset($pendingMember->HCP)) value = "{{$pendingMember->HCP}}" @endif>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="handicap" class="col-md-4 col-form-label
                                    text-md-right">HCP Manual</label>
                                    <div class="col-md-3">
                                        <input id="handicap" type="text" class="form-control  hcp-validation"
                                        name="handicap" @if(isset($pendingMember->handicap)) value = "{{$pendingMember->handicap}}" @endif>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="member_type" class="col-md-4 col-form-label
                                    text-md-right  @if(!isset($pendingMember)) require_label @endif">Member Type</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="member_type" id="member_type" @if(!isset($pendingMember)) required @endif>
                                            <option value="" >Select</option>
                                            @foreach (config('settings.member_type') as $key => $type)
                                                <option value="{{ $key }}" @if(isset($pendingMember->member_type) && $pendingMember->member_type == $key) selected @endif>{{ $type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="share_type" class="col-md-4 col-form-label
                                    text-md-right ">Share Type</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="share_type" id="share_type" >
                                            <option value=" " >Select</option>
                                            @foreach(config('settings.share_type') as $key => $share)
                                                <option value="{{ $key }}" @if(isset($pendingMember->share_type) && $key == $pendingMember->share_type) selected @endif>{{ $share }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="shre_number" class="col-md-4 col-form-label
                                    text-md-right">Share Number</label>
                                    <div class="col-md-3">
                                        <input id="share_number" type="text" class="form-control number_only" name="share_number"
                                               @if(isset($pendingMember->share_number)) value = "{{ $pendingMember->share_number }}" @endif>
                                    </div>
                                </div>
                                <div class="form-group row share_from_div">
                                    <label for="share_from" class="col-md-4 col-form-label
                                    text-md-right">Share From</label>
                                    <div class="col-md-5">
                                        <input id="share_from" type="date" class="form-control" name="share_from"
                                               @if(isset($pendingMember->share_from)) value = "{{ $pendingMember->share_from }}" @endif>
                                    </div>
                                </div>
                                <div class="form-group row share_name_div">
                                    <label for="share_name" class="col-md-4 col-form-label
                                    text-md-right">Share Name</label>
                                    <div class="col-md-5">
                                        <input id="share_name" type="text" class="form-control" name="share_name"
                                               @if(isset($pendingMember->share_name)) value = "{{ $pendingMember->share_name }}" @endif>
                                    </div>
                                </div>
                                <div class="form-group row share_to_div">
                                    <label for="share_to" class="col-md-4 col-form-label
                                    text-md-right">Share To</label>
                                    <div class="col-md-5">
                                        <input id="share_to" type="date" class="form-control" name="share_to"
                                               @if(isset($pendingMember->share_to)) value = "{{ $pendingMember->share_to }}" @endif>
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
                                        <input id="address1" type="text" class="form-control" name="address1"
                                        @if(isset($pendingMember->address1)) value = "{{ $pendingMember->address1 }}" @endif>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="address2" class="col-md-4 col-form-label
                                    text-md-right">Address Line 2</label>
                                    <div class="col-md-6">
                                        <input id="address2" type="text" class="form-control"
                                        name="address2"
                                        @if(isset($pendingMember->address2)) value = "{{ $pendingMember->address2 }}" @endif>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="city" class="col-md-4 col-form-label
                                    text-md-right">City</label>
                                    <div class="col-md-5">
                                        <input id="city" type="text" class="form-control" name="city"
                                               @if(isset($pendingMember->city)) value = "{{ $pendingMember->city }}" @endif>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="zipcode" class="col-md-4 col-form-label
                                    text-md-right">Zip Code</label>
                                    <div class="col-md-3">
                                        <input id="zipcode" type="text" class="form-control number_only"
                                        name="zipcode"
                                        @if(isset($pendingMember->zipcode)) value = "{{ $pendingMember->zipcode }}" @endif>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email" class="col-md-4 col-form-label
                                    text-md-right">Email</label>
                                    <div class="col-md-6">
                                        <input id="email" type="email" class="form-control"
                                        name="email"
                                               @if(isset($pendingMember->email)) value = "{{ $pendingMember->email }}" @endif>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="email_billing" class="col-md-4 col-form-label
                                    text-md-right">Email Invoice</label>
                                    <div class="col-md-6">
                                        <input id="email_billing" type="email" class="form-control" name="email_billing"
                                        @if(isset($pendingMember->email_billing)) value = "{{ $pendingMember->email_billing }}" @endif>
                                        <small class="errInputMessage d-none"></small>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tel_privately" class="col-md-4 col-form-label
                                    text-md-right">Tel Privat</label>
                                    <div class="col-md-4">
                                        <input id="tel_privately" type="text" class="form-control number_only" name="tel_privately"
                                        @if(isset($pendingMember->tel_privately)) value = "{{ $pendingMember->tel_privately }}" @endif>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="tel_jobs" class="col-md-4 col-form-label
                                    text-md-right">Tel Work</label>
                                    <div class="col-md-4">
                                        <input id="tel_jobs" type="text" class="form-control number_only" name="tel_jobs"
                                        @if(isset($pendingMember->tel_jobs)) value = "{{ $pendingMember->tel_jobs }}" @endif>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="phone_mobile" class="col-md-4 col-form-label
                                    text-md-right">Tel Mobile</label>
                                    <div class="col-md-4">
                                        <input id="phone_mobile" type="text" class="form-control number_only" name="phone_mobile"
                                        @if(isset($pendingMember->phone_mobile)) value = "{{ $pendingMember->phone_mobile }}" @endif>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="sms_news_letter" class="col-md-4 col-form-label
                                    text-md-right">Use SMS</label>
                                    <div class="col-md-4">
                                        <label class="switch" for="sms_news_letter">
                                            <input type="checkbox" id="sms_news_letter" name="sms_news_letter" value="1"
                                            @if(isset($pendingMember->sms_news_letter) && $pendingMember->sms_news_letter == 1) checked @endif>
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
                                    <div class="card-body card-body-panel" > <!-- card-height class remove by kiruththigan because overlap additional info textarea box -->
                                        <div class="form-group row">
                                            <label for="sex" class="col-md-4 col-form-label
                                            text-md-right">Sex</label>
                                            <div class="col-md-3">
                                                {{-- <input id="sex" type="text" class="form-control"
                                                name="sex"   > --}}
                                                <select class="form-control" name="sex">
                                                    <option >Select</option>
                                                    @foreach(config('settings.gender') as $key => $gender)
                                                        <option value="{{ $key }}" @if(isset($pendingMember->sex) && $pendingMember->sex == $key) selected @endif>{{ $gender }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="date_of_birth" class="col-md-4 col-form-label
                                            text-md-right">Date of Birth</label>
                                            <div class="col-md-5">
                                                <input id="date_of_birth" type="date" class="form-control" name="date_of_birth"
                                                       @if(isset($pendingMember->date_of_birth)) value = "{{ $pendingMember->date_of_birth }}" @endif>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="member_since" class="col-md-4 col-form-label
                                            text-md-right">Member Since</label>
                                            <div class="col-md-5">
                                                <input id="member_since" type="date" class="form-control"
                                                name="member_since"
                                                @if(isset($pendingMember->member_since)) value = "{{ $pendingMember->member_since }}" @endif>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="resignation_date" class="col-md-4 col-form-label
                                            text-md-right">Registration Date</label>
                                            <div class="col-md-5">
                                                <input id="resignation_date" type="date" class="form-control"
                                                name="resignation_date" @if(isset($pendingMember->resignation_date)) value = "{{ $pendingMember->resignation_date }}" @else  value="{{date('Y-m-d')}}" @endif>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-3">
                                            <label for="additional_info" class="col-md-4 col-form-label
                                            text-md-right">Additional Info</label>
                                            <div class="col-md-6">
                                                <textarea name="additional_info" class="form-control" id="" cols="30" rows="3">@if(isset($pendingMember->additional_info)){{ $pendingMember->additional_info }}@endif</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- card end -->
                            </div>
                        </div>

                        <div class="row">
                            <div class="col">
                                <div class="card" style="margin-top: 10px;">
                                    <h5 class="card-header h5" style="background-color: #007bff;color: white;font-size: 1.29rem;">Facilities</h5>
                                    <div class="card-body card-body-panel" style="height: 470px;">
                                        <div class="form-group row">
                                            <label for="wardrobe" class="col-md-4 col-form-label
                                            text-md-right">Wardrobe</label>
                                            <div class="col-md-2">
                                                <input id="wardrobe" type="text" class="form-control"
                                                name="wardrobe" @if(isset($pendingMember->wardrobe)) value = "{{ $pendingMember->wardrobe }}" @endif>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="drinks_cabinet" class="col-md-4 col-form-label
                                            text-md-right">Drinks Cabinet</label>
                                            <div class="col-md-2">
                                                <input id="drinks_cabinet" type="text" class="form-control"
                                                name="drinks_cabinet" @if(isset($pendingMember->drinks_cabinet)) value = "{{ $pendingMember->drinks_cabinet }}" @endif>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="stick_cabinet" class="col-md-4 col-form-label
                                            text-md-right">Stick Cabinet</label>
                                            <div class="col-md-2">
                                                <input id="stick_cabinet" type="text" class="form-control"
                                                name="stick_cabinet" @if(isset($pendingMember->stick_cabinet)) value = "{{ $pendingMember->stick_cabinet }}" @endif>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="charging_site" class="col-md-4 col-form-label
                                            text-md-right">Charging Site</label>
                                            <div class="col-md-2">
                                                <input id="charging_site" type="text" class="form-control"
                                                name="charging_site" @if(isset($pendingMember->charging_site)) value = "{{ $pendingMember->charging_site }}" @endif>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="trolley_space" class="col-md-4 col-form-label
                                            text-md-right">Trolley Space</label>
                                            <div class="col-md-2">
                                                <input id="trolley_space" type="text" class="form-control"
                                                name="trolley_space" @if(isset($pendingMember->trolley_space)) value = "{{ $pendingMember->trolley_space }}" @endif>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- upgradtion end --}}
                        <div class="row">
                            <div class="col">
                                <input type="hidden" name="submit" >
                                @if(isset($pendingMember))
                                    <button type="submit" class="submit-btn btn btn-danger float-right" style="margin-top: 10px;font-size: 1.29rem;height: 45px;" value="declined" name="submit">Declined</button>
                                @endif
                                <button type="submit" class="submit-btn btn btn-primary float-right mr-2" style="margin-top: 10px;font-size: 1.29rem;height: 45px;" value="save" name="submit">Save as Pending</button>
                                <button type="submit" class="submit-btn btn btn-success float-right mr-2" style="margin-top: 10px;font-size: 1.29rem;height: 45px;" value="add" name="submit">Add</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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

        $('.submit-btn').on('click', function(e)
        {
            e.preventDefault();
            let submitVal = $(this).val();
            $('input[name="submit"]').val(submitVal);
            if(submitVal == 'save') {
                $('#OccID').removeAttr('required');
                $('#HCP').removeAttr('required');
                $('#member_type').removeAttr('required');
            }
            else {
                $('#OccID').prop('required', true);
                $('label[for="OccID"]').addClass('require_label');
                $('#HCP').prop('required', true);
                $('label[for="HCP"]').addClass('require_label');
                $('#member_type').prop('required', true);
                $('label[for="member_type"]').addClass('require_label');
            }

            var OccID = $('#OccID').val();
            var _token = "{{csrf_token()}}";
            var data = $('#newmember').serialize();
            var url = "{{ route('add_memberdata') }}";
            @if(isset($pendingMember))
                url = "{{ route('add_memberdata', ['m' => $pendingMember->signup_token]) }}";
            @endif
            if(OccID.length != 0 && submitVal == 'add') {
                $.ajax({
                    url:"{{ route('check_member') }}",
                    method:"POST",
                    data:{_token:_token,OccID:OccID},
                    success:function(res){
                        if(res.message == "alert")
                        {
                            var x = '';
                            for (let index = 0; index < res.first_names.length; index++) {
                                const element = res.first_names[index];
                                x = x + '<li>'+element+'</li>';
                            }
                            $.confirm({
                                title: 'Are you sure you want to make as an old member?' ,
                                content: x,
                                buttons: {
                                    OK: {
                                        text: 'Yes',
                                        btnClass: 'btn-red',
                                        width : 500,
                                        action: function () {
                                            formSubmit(url, 'POST', data);
                                        }
                                    },
                                    cancelButton: {
                                        text:'No',
                                        action:function () {}
                                    },
                                }
                            });
                        }
                        else if(res.message == "submit")
                        {
                            formSubmit(url, 'POST', data);
                        }
                    }
                });
            }
            else {
                formSubmit(url, 'POST', data);
            }
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
                                        if(res.redirect === true) {
                                            if(res.redirect_url != undefined && res.redirect_url != '' && res.redirect_url != null)
                                                window.location.replace(res.redirect_url);
                                            else
                                                window.location.reload();
                                        }
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
                                        if(res.redirect === true) {
                                            if(res.redirect_url != undefined && res.redirect_url != '' && res.redirect_url != null)
                                                window.location.replace(res.redirect_url);
                                            else
                                                window.location.reload();
                                        }
                                    }
                                },
                            }
                        });
                    }
                }
            });
        }

        $('#copy-clipboad').on('click', function() {
            let copy = $(this).data('url');
            navigator.clipboard.writeText(copy);
        });
    </script>
@endpush
