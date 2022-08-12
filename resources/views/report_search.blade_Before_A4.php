@extends('layout')
@section('home')
@include('menu')
@push('style')



    <style>
        /* The container */
        .container-single {
            display: block;
            position: relative;
            padding-left: 35px;
            margin-bottom: 12px;
            cursor: pointer;
            font-size: 22px;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        /* Hide the browser's default checkbox */
        .container-single input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }

        /* Create a custom checkbox */
        .checkmark-single {
            position: absolute;
            top: 0;
            left: 0;
            height: 25px;
            width: 25px;
            background-color: #eee;
        }

        /* On mouse-over, add a grey background color */
        .container-single:hover input ~ .checkmark-single {
            background-color: #ccc;
        }

        /* When the checkbox is checked, add a blue background */
        .container-single input:checked ~ .checkmark-single {
            background-color: #2196F3;
        }

        /* Create the checkmark/indicator (hidden when not checked) */
        .checkmark-single:after {
            content: "";
            position: absolute;
            display: none;
        }

        /* Show the checkmark when checked */
        .container-single input:checked ~ .checkmark-single:after {
            display: block;
        }

        /* Style the checkmark/indicator */
        .container-single .checkmark-single:after {
            left: 9px;
            top: 5px;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 3px 3px 0;
            -webkit-transform: rotate(45deg);
            -ms-transform: rotate(45deg);
            transform: rotate(45deg);
        }
        /* .singleview{
            width: 8cm !important;
            height: 3cm !important;
            font-size: 7vw !important;
            background-color: #007bff !important;
        } */
        @media (min-width: 320px) and (max-width: 480px) {
            .form-inline {
                display: -ms-flexbox;
                display: block !important;
                -ms-flex-flow: row wrap;
                flex-flow: row wrap;
                -ms-flex-align: center;
                align-items: center;
                }
        }
        .center {
            text-align: right;
            /* border: 3px solid green; */
        }
        .print-excel{
            color: #007bff;
            text-decoration: none;
            background-color: transparent;
            cursor: pointer;
        }
        .footerprint{
            text-align: center;
        }
        .nowarp{
            white-space: nowrap;
        }
    </style>

@endpush
@push('style')
    <style>
        .dual-listbox {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column
        }

        .dual-listbox .dual-lsitbox__container {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-align: center;
            align-items: center;
            -ms-flex-direction: row;
            flex-direction: row
        }

        .dual-listbox .dual-listbox__search {
            border: 1px solid #ddd;
            padding: 10px;
            max-width: 300px
        }

        .dual-listbox .dual-listbox__available,
        .dual-listbox .dual-listbox__selected {
            border: 1px solid #ddd;
            height: 300px;
            overflow-y: auto;
            padding: 0;
            width: 300px
        }

        .dual-listbox .dual-listbox__buttons {
            display: -ms-flexbox;
            display: flex;
            -ms-flex-direction: column;
            flex-direction: column;
            margin: 0 10px
        }

        .dual-listbox .dual-listbox__button {
            margin-bottom: 5px;
            border: 0;
            background-color: #047bff;
            padding: 10px;
            color: #fff;
            cursor: pointer;
            border-radius: 11px;
        }

        .dual-listbox .dual-listbox__button:hover {
            /* background-color: #ddd */
        }

        .dual-listbox .dual-listbox__title {
            padding: 15px 10px;
            font-size: 120%;
            font-weight: 700;
            border-bottom: 1px solid #efefef
        }

        .dual-listbox .dual-listbox__item {
            display: block;
            padding: 10px;
            cursor: pointer;
            user-select: none;
            -moz-user-select: none;
            -webkit-user-select: none;
            -ms-user-select: none;
            border-bottom: 1px solid #efefef;
            transition: background .2s ease
        }

        .dual-listbox .dual-listbox__item.dual-listbox__item--selected {
            background-color: rgba(8, 157, 227, .7)
        }
        .updown{
            margin-left: 10px;
        }
        /* Filter by filed  */
        body {
            background: #F9F9F9;
        }

        .myaccordion {
            max-width: 354px;
            /* margin: 50px auto; */
            box-shadow: 0 0 1px rgba(0,0,0,0.1);
        }

        .myaccordion .card,
        .myaccordion .card:last-child .card-header {
            border: none;
        }

        .myaccordion .card-header {
            border-bottom-color: #EDEFF0;
            background: transparent;
        }

        .myaccordion .fa-stack {
            font-size: 18px;
        }

        .myaccordion .btn {
            width: 100%;
            font-weight: bold;
            color: #004987;
            padding: 0;
        }

        .myaccordion .btn-link:hover,
        .myaccordion .btn-link:focus {
            text-decoration: none;
        }

        .myaccordion li + li {
            margin-top: 10px;
        }
        .bottomsclass{
            margin-bottom: 13px;
        }
        #filter_by_display span{
            margin-right: 1%;
        }
    </style>

@endpush
@push('link')
    <link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.6.3/css/all.css'>
		{{-- <link rel="icon" href="{{asset('/images/favicon.png')}}" type="image/gif" > --}}

@endpush
<div class="container">
    {{-- <h3 class="text-center">Report Generation</h3> --}}
    {{-- <div class="center col-12">
        <p class="float-sm-right pcursor print-excel" style="" id="print">PRINT</p>
        <span class="float-sm-right pcursor" style="margin-left: 5px;margin-right: 5px;">*</span>
        <p class="float-sm-right print-excel"   id="excel" >EXCEL</p>
        <a href="" id="download-excel" class="download-excel" hidden ></a>
    </div> --}}
    <br>
    <div class="rows mt-4" >
    <div class="center col-12" style="margin-top: 44px;">

    </div>

    <div class="dual-listbox">
        {{-- <input class="dual-listbox__search" placeholder="Search"> --}}
        <div class="dual-lsitbox__container">
            <ul class="dual-listbox__available list">
                {{-- <li class="dual-listbox__title">Available options</li> --}}
                <li class="dual-listbox__item " data-value="OccID">Member ID</li>
                <li class="dual-listbox__item" data-value="Member_Fistname">Member Firstname</li>
                <li class="dual-listbox__item" data-value="Member_Lastname">Member Lastname</li>
                <li class="dual-listbox__item" data-value="new_hcp">HCP Online</li>
                <li class="dual-listbox__item" data-value="member_type">Member Type</li>
                <li class="dual-listbox__item" data-value="address1">Address 1</li>
                <li class="dual-listbox__item" data-value="address2">Address 2</li>
                <li class="dual-listbox__item" data-value="city">City</li>
                <li class="dual-listbox__item" data-value="zipcode">Zipcode</li>
                <li class="dual-listbox__item" data-value="tel_privately">Tel Privately</li>
                <li class="dual-listbox__item" data-value="tel_jobs">Tel Jobs</li>
                <li class="dual-listbox__item" data-value="phone_mobile">Phone Mobile</li>
                <li class="dual-listbox__item" data-value="sex">Sex</li>
                <li class="dual-listbox__item" data-value="handicap">HCP Teeplay</li>
                <li class="dual-listbox__item" data-value="stock_number">Stock Number</li>
                <li class="dual-listbox__item" data-value="playing_eligibility">Playing Eligibility</li>
                <li class="dual-listbox__item" data-value="date_of_birth">Date of Birth</li>
                <li class="dual-listbox__item" data-value="email">Email</li>
                <li class="dual-listbox__item" data-value="member_since">Member Since</li>
                <li class="dual-listbox__item" data-value="resignation_date">Resignation Date</li>
                <li class="dual-listbox__item" data-value="additional_info">Additional Info</li>
                <li class="dual-listbox__item" data-value="family_head">Family Head</li>
                <li class="dual-listbox__item" data-value="family_head_name">Family Head Name</li>
                <li class="dual-listbox__item" data-value="family_head_no">Family Head No</li>
                <li class="dual-listbox__item" data-value="shareholder_name">Shareholder Name</li>
                <li class="dual-listbox__item" data-value="shareholder_member_no">Shareholder Member No</li>
                <li class="dual-listbox__item" data-value="wardrobe">Wardrobe</li>
                <li class="dual-listbox__item" data-value="drinks_cabinet">Drinks Cabinet</li>
                <li class="dual-listbox__item" data-value="stick_cabinet">Stick Cabinet</li>
                <li class="dual-listbox__item" data-value="car">Car</li>
                <li class="dual-listbox__item" data-value="charging_site">Charging Site</li>
                <li class="dual-listbox__item" data-value="trolley_space">Trolley Space</li>

            </ul>
            <div class="dual-listbox__buttons">
                <button class="dual-listbox__button add_all">Add all</button>
                <button class="dual-listbox__button add-selected">Add</button>
                <button class="dual-listbox__button remove-selected">Remove</button>
                <button class="dual-listbox__button remove-all">Remove all</button>
            </div>
            <ul class="dual-listbox__selected selectul">
                {{-- <li class="dual-listbox__title selected">Selected options</li> --}}
            </ul>
            <div class="updown">
                <button class="dual-listbox__button up">Up</button>
                <button class="dual-listbox__button down">Down</button>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-12">
            <button type="button" id="filter_show" class="btn btn-primary" data-toggle="collapse" data-target="#filter-panel">
                <span class="glyphicon glyphicon-cog"></span> Filter by Fields
            </button>

            <button type="button" id="filter_search" class="btn btn-primary " style="margin-left: 260px;border-radius: 10px;" >
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg> Search
            </button>

            {{-- <input type="text" name="label_search" id="label_search"> --}}
            {{-- <label for="" id=""> Single Print</label> --}}
            <button type="button" id="single_print" class="btn btn-primary " style="margin-left: 3px;border-radius: 10px;" >
                <span class="glyphicon glyphicon-print"></span> Single Print
            </button>

            <p class="float-sm-right pcursor print-excel printall-excelall" data-name="print" style="" id="printall">PRINT</p>
            <span class="float-sm-right pcursor" style="margin-left: 5px;margin-right: 5px;">*</span>
            <p class="float-sm-right print-excel printall-excelall" data-name="excel"  id="" >EXCEL</p>
            <a href="" id="download-excel" class="download-excel" hidden ></a>
        </div>
        <div class="col-sm-12" style="margin-top: 1%;" id="filter_by_display">

        </div>
        <div class="col-sm-4 collapse mt-5" id="filter-panel">
            <div id="accordion" class="myaccordion">
                <div class="card">
                    <div class="card-header" id="headingOne">
                    <h2 class="mb-0">
                        <button class="d-flex align-items-center justify-content-between btn btn-link collapsed" data-toggle="collapse" data-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                        Occ ID
                        <span class="fa-stack fa-sm">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fas fa-plus fa-stack-1x fa-inverse"></i>
                        </span>
                        </button>
                    </h2>
                    </div>
                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordion">
                    <div class="card-body">
                        <!-- Default unchecked -->
                        <div class="custom-control custom-checkbox bottomsclass">
                            <input type="checkbox" data-col="OccID" class="custom-control-input selectedcheckbox" id="occidcheck">
                            <label class="custom-control-label" for="occidcheck">Occ ID</label>
                        </div>
                        <div class="row bottomsclass">
                            <div class="col-sm-4" style="float: left;">
                                <label for="">From:</label>
                            </div>
                            <div class="col-sm-8" style="float: left;">
                                <input type="number" data-text="occfrom"disabled class="occid occidfrom" name="" id="">
                            </div>
                        </div>
                        <div class="row bottomsclass">
                            <div class="col-sm-4" style="float: left;">
                                <label for="">To:</label>
                            </div>
                            <div class="col-sm-8" style="float: left;">
                                <input type="number" data-text="occto" disabled class="occid occidto" name="" id="">
                            </div>
                        </div>

                    </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingTwo">
                    <h2 class="mb-0">
                        <button class="d-flex align-items-center justify-content-between btn btn-link collapsed" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        HCP Online
                        <span class="fa-stack fa-2x">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fas fa-plus fa-stack-1x fa-inverse"></i>
                        </span>
                        </button>
                    </h2>
                    </div>
                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                    <div class="card-body">
                        <!-- Default unchecked -->
                        <div class="custom-control custom-checkbox bottomsclass">
                            <input type="checkbox"  class="custom-control-input" id="hcpcheck">
                            <label class="custom-control-label" for="hcpcheck">HCP</label>
                        </div>
                        <div class="row bottomsclass">
                            <div class="col-sm-4" style="float: left;">
                                <label for="">From:</label>
                            </div>
                            <div class="col-sm-8" style="float: left;">
                                <input type="text" data-text="hcpfrom" class="hcp hcpfrom" disabled name="" id="">
                            </div>
                        </div>
                        <div class="row bottomsclass">
                            <div class="col-sm-4" style="float: left;">
                                <label for="">To:</label>
                            </div>
                            <div class="col-sm-8" style="float: left;">
                                <input type="text" data-text="hcpto" class="hcp hcpto" disabled name="" id="">
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingThree">
                    <h2 class="mb-0">
                        <button class="d-flex align-items-center justify-content-between btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        Date of Birth
                        <span class="fa-stack fa-2x">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fas fa-plus fa-stack-1x fa-inverse"></i>
                        </span>
                        </button>
                    </h2>
                    </div>
                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
                    <div class="card-body">
                        <!-- Default unchecked -->
                        <div class="custom-control custom-checkbox bottomsclass">
                            <input type="checkbox" class="custom-control-input" id="dobcheck">
                            <label class="custom-control-label" for="dobcheck">Date of Birth</label>
                        </div>
                        <div class="row bottomsclass">
                            <div class="col-sm-4" style="float: left;">
                                <label for="">From:</label>
                            </div>
                            <div class="col-sm-8" style="float: left;">
                                <input disabled data-text="dobfrom" class="dob dobfrom" type="date" name="" id="">
                            </div>
                        </div>
                        <div class="row bottomsclass">
                            <div class="col-sm-4" style="float: left;">
                                <label for="">To:</label>
                            </div>
                            <div class="col-sm-8" style="float: left;">
                                <input disabled data-text="dobto" class="dob dobto" type="date" name="" id="">
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingmember_since">
                    <h2 class="mb-0">
                        <button class="d-flex align-items-center justify-content-between btn btn-link collapsed" data-toggle="collapse" data-target="#collapsemember_since" aria-expanded="false" aria-controls="collapsemember_since">
                        Member Since
                        <span class="fa-stack fa-2x">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fas fa-plus fa-stack-1x fa-inverse"></i>
                        </span>
                        </button>
                    </h2>
                    </div>
                    <div id="collapsemember_since" class="collapse" aria-labelledby="headingmember_since" data-parent="#accordion">
                    <div class="card-body">
                        <!-- Default unchecked -->
                        <div class="custom-control custom-checkbox bottomsclass">
                            <input type="checkbox" class="custom-control-input" id="membersincecheck">
                            <label class="custom-control-label" for="membersincecheck">Member Since</label>
                        </div>
                        <div class="row bottomsclass">
                            <div class="col-sm-4" style="float: left;">
                                <label for="">From:</label>
                            </div>
                            <div class="col-sm-8" style="float: left;">
                                <input class="membersincefrom membersince" data-text="membersincefrom" disabled  type="date" name="" id="">
                            </div>
                        </div>
                        <div class="row bottomsclass">
                            <div class="col-sm-4" style="float: left;">
                                <label for="">To:</label>
                            </div>
                            <div class="col-sm-8" style="float: left;">
                                <input class="membersinceto membersince" disabled data-text="membersinceto"  type="date" name="" id="">
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingregistration_date">
                    <h2 class="mb-0">
                        <button class="d-flex align-items-center justify-content-between btn btn-link collapsed" data-toggle="collapse" data-target="#collapseregistration_date" aria-expanded="false" aria-controls="collapseregistration_date">
                        Registration Date
                        <span class="fa-stack fa-2x">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fas fa-plus fa-stack-1x fa-inverse"></i>
                        </span>
                        </button>
                    </h2>
                    </div>
                    <div id="collapseregistration_date" class="collapse" aria-labelledby="headingregistration_date" data-parent="#accordion">
                    <div class="card-body">
                        <!-- Default unchecked -->
                        <div class="custom-control custom-checkbox bottomsclass">
                            <input type="checkbox" class="custom-control-input" id="registrationcheck">
                            <label class="custom-control-label" for="registrationcheck">Registration Date</label>
                        </div>
                        <div class="row bottomsclass">
                            <div class="col-sm-4" style="float: left;">
                                <label for="">From:</label>
                            </div>
                            <div class="col-sm-8" style="float: left;">
                                <input disabled data-text="registrationfrom" class="registration registrationfrom" type="date" name="" id="">
                            </div>
                        </div>
                        <div class="row bottomsclass">
                            <div class="col-sm-4" style="float: left;">
                                <label for="">To:</label>
                            </div>
                            <div class="col-sm-8" style="float: left;">
                                <input disabled class="registration registrationto" data-text="registrationto" type="date" name="" id="">
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingsex">
                    <h2 class="mb-0">
                        <button class="d-flex align-items-center justify-content-between btn btn-link collapsed" data-toggle="collapse" data-target="#collapsesex" aria-expanded="false" aria-controls="collapsesex">
                        Sex
                        <span class="fa-stack fa-2x">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fas fa-plus fa-stack-1x fa-inverse"></i>
                        </span>
                        </button>
                    </h2>
                    </div>
                    <div id="collapsesex" class="collapse" aria-labelledby="headingsex" data-parent="#accordion">
                    <div class="card-body">
                        <div class="custom-control custom-checkbox bottomsclass">
                            <input type="checkbox" class="custom-control-input" id="sexcheck">
                            <label class="custom-control-label" for="sexcheck">Sex</label>
                        </div>
                        <div class="row bottomsclass">
                            <div class="col-sm-4" style="float: left;">
                                <label for="sexmale">Male:</label>
                            </div>
                            <div class="col-sm-8" style="float: left;">
                                {{-- <input type="checkbox" name="" id=""> --}}
                                {{-- <div class="custom-control custom-checkbox bottomsclass">
                                    <input type="checkbox" data-text="sexmale" disabled name="male" class="custom-control-input sex" id="sexmale">
                                    <label class="custom-control-label" for="sexmale"></label>
                                </div> --}}
                                <div class="custom-control custom-radio">
                                    <input type="radio" data-text="Man" class="custom-control-input sex " id="sexmale" name="sex" disabled checked>
                                    <label class="custom-control-label" for="sexmale"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row bottomsclass">
                            <div class="col-sm-4" style="float: left;">
                                <label for="sexfemale">Female:</label>
                            </div>
                            <div class="col-sm-8" style="float: left;">
                                {{-- <input type="checkbox" name="" id=""> --}}
                                {{-- <div class="custom-control custom-checkbox bottomsclass">
                                    <input type="checkbox" data-text="sexfemale" disabled name="female" class="custom-control-input sex" id="sexfemale">
                                    <label class="custom-control-label" for="sexfemale"></label>
                                </div> --}}
                                <div class="custom-control custom-radio">
                                    <input type="radio" data-text="Women" class="custom-control-input sex " id="sexfemale" name="sex" disabled checked>
                                    <label class="custom-control-label" for="sexfemale"></label>
                                </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingfamily_head">
                    <h2 class="mb-0">
                        <button class="d-flex align-items-center justify-content-between btn btn-link collapsed" data-toggle="collapse" data-target="#collapsefamily_head" aria-expanded="false" aria-controls="collapsefamily_head">
                        Family Head
                        <span class="fa-stack fa-2x">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fas fa-plus fa-stack-1x fa-inverse"></i>
                        </span>
                        </button>
                    </h2>
                    </div>
                    <div id="collapsefamily_head" class="collapse" aria-labelledby="headingfamily_head" data-parent="#accordion">
                    <div class="card-body">
                        <div class="custom-control custom-checkbox bottomsclass">
                            <input type="checkbox" class="custom-control-input" id="familyheadcheck">
                            <label class="custom-control-label" for="familyheadcheck">Family Head</label>
                        </div>
                        <div class="row bottomsclass">
                            <div class="col-sm-4" style="float: left;">
                                <label for="yesChecked">Yes:</label>
                            </div>
                            <div class="col-sm-8" style="float: left;">
                                {{-- <input type="radio" name="" id=""> --}}
                                <!-- Default checked -->
                                <div class="custom-control custom-radio">
                                    <input type="radio" data-text="yes" class="custom-control-input familyhead" id="yesChecked" name="familyhead" disabled checked>
                                    <label class="custom-control-label" for="yesChecked"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row bottomsclass">
                            <div class="col-sm-4" style="float: left;">
                                <label for="noChecked">No:</label>
                            </div>
                            <div class="col-sm-8" style="float: left;">
                                {{-- <input type="radio" name="" id=""> --}}
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input familyhead" id="noChecked" name="familyhead" data-text="no" disabled checked>
                                    <label class="custom-control-label" for="noChecked"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingemail">
                    <h2 class="mb-0">
                        <button class="d-flex align-items-center justify-content-between btn btn-link collapsed" data-toggle="collapse" data-target="#collapseemail" aria-expanded="false" aria-controls="collapseemail">
                       Email
                        <span class="fa-stack fa-2x">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fas fa-plus fa-stack-1x fa-inverse"></i>
                        </span>
                        </button>
                    </h2>
                    </div>
                    <div id="collapseemail" class="collapse" aria-labelledby="headingemail" data-parent="#accordion">
                    <div class="card-body">
                        <div class="custom-control custom-checkbox bottomsclass">
                            <input type="checkbox" class="custom-control-input" id="emailcheck">
                            <label class="custom-control-label" for="emailcheck">Email</label>
                        </div>
                        <div class="row bottomsclass">
                            <div class="col-sm-4" style="float: left;">
                                <label for="emailyesChecked">Yes:</label>
                            </div>
                            <div class="col-sm-8" style="float: left;">
                                {{-- <input type="radio" name="" id=""> --}}
                                <div class="custom-control custom-radio">
                                    <input type="radio" data-text="yes" class="custom-control-input email" id="emailyesChecked" name="email" disabled checked>
                                    <label class="custom-control-label" for="emailyesChecked"></label>
                                </div>
                            </div>
                        </div>
                        <div class="row bottomsclass">
                            <div class="col-sm-4" style="float: left;">
                                <label for="emailnoChecked">No:</label>
                            </div>
                            <div class="col-sm-8" style="float: left;">
                                {{-- <input type="radio" name="" id=""> --}}
                                <div class="custom-control custom-radio">
                                    <input type="radio" data-text="no" class="custom-control-input email" id="emailnoChecked" name="email" disabled checked>
                                    <label class="custom-control-label" for="emailnoChecked"></label>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingMembertype">
                    <h2 class="mb-0">
                        <button class="d-flex align-items-center justify-content-between btn btn-link collapsed" data-toggle="collapse" data-target="#collapseMembertype" aria-expanded="false" aria-controls="collapseMembertype">
                       Member Type
                        <span class="fa-stack fa-2x">
                            <i class="fas fa-circle fa-stack-2x"></i>
                            <i class="fas fa-plus fa-stack-1x fa-inverse"></i>
                        </span>
                        </button>
                    </h2>
                    </div>
                    <div id="collapseMembertype" class="collapse" aria-labelledby="headingMembertype" data-parent="#accordion">
                    <div class="card-body">
                        <div class="custom-control custom-checkbox bottomsclass">
                            <input type="checkbox" class="custom-control-input" id="membertypecheck">
                            <label class="custom-control-label" for="membertypecheck">Member Type</label>
                        </div>
                        <div class="row bottomsclass">
                            <div class="col-sm-4" style="float: left;">
                                <label for="">Member Type:</label>
                            </div>
                            <div class="col-sm-8" style="float: left;">
                                {{-- <select class="form-control membertype" disabled name="member_type" id="member_type">

                                        <option >Select</option>

                                        <option value="AR">Aktive</option>

                                        <option  value="AE">Aktiv Evigvarende</option>

                                        <option  value="AC">Aktiv Livsvarig</option>

                                        <option value="EJ">Eldre Junior</option>

                                        <option value="JU">Junior</option>

                                        <option value="PA">Passiv</option>

                                        <option value="SL">Slettet</option>

                                        <option value="AU">Andel uten medlemskap</option>

                                    </select> --}}
                                    <select class="form-control membertype" name="member_type" id="member_type"  disabled="disabled">

                                        {{-- <option >Select</option> --}}
                                        <option value="Aktive">Aktive</option>

                                        <option value="Aktiv Evigvarende">Aktiv Evigvarende</option>

                                        <option value="Aktiv Livsvarig">Aktiv Livsvarig</option>

                                        <option value="Eldre Junior">Eldre Junior</option>

                                        <option value="Junior">Junior</option>

                                        <option value="Passiv">Passiv</option>

                                        <option value="Slettet">Slettet</option>

                                        <option value="Andel uten medlemskap">Andel uten medlemskap</option>


                                    </select>
                            </div>
                        </div>
                        {{-- <div class="row bottomsclass">
                            <div class="col-sm-4" style="float: left;">
                                <label for="">No:</label>
                            </div>
                            <div class="col-sm-8" style="float: left;">
                                <input type="radiobutton" name="" id="">
                            </div>
                        </div> --}}
                    </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <br>
    <div class="row" style="margin-top: 1%;">
        <div class="col-sm-8" id="printviews">
            {{-- <table class="table table-hover">
                <thead>
                    <tr>
                    <th scope="col">ClubID</th>
                    <th scope="col">ClubName</th>
                    <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table> --}}
        </div>
    </div>
    <div class="center col-12">
        {{-- <p class="float-sm-right pcursor print-excel printall-excelall" data-name="print" style="" id="printall">PRINT</p>
        <span class="float-sm-right pcursor" style="margin-left: 5px;margin-right: 5px;">*</span>
        <p class="float-sm-right print-excel printall-excelall" data-name="excel"  id="" >EXCEL</p>
        <a href="" id="download-excel" class="download-excel" hidden ></a> --}}
    </div>
    <br>


</div>
<br>
<br>

<div id="print_fields" hidden></div>

<div id="single_print_view" hidden class="singleview" style="font-size: 68px;width: 8cm;height: 3cm;" ></div>

<div id="selected_single_print_row"  class="" style="font-size: 68px;width: 8cm;height: 3cm;" >

</div>
{{-- <table class="singel_printed_table"><table> --}}
@push('script2')
    <script>
    // Single print select
    $(document).on('click','.selected_single_print',function () {
        // #printed_table > tbody > tr:nth-child(1) > td.key
        var key = $(this).attr('id');
        const occid2 = $('#printed_table > tbody > tr:nth-child('+key+') > td.checkbox').css('display','none');
        var occid= $('#printed_table > tbody > tr:nth-child('+key+')').html();
        occid = '<table id="selected_print_row" border="1" class="check"><tr>'+occid+'</tr></table>'
        var _token = "{{csrf_token()}}";
        $('#single_print_view').html(occid)
        // var printContent = document.getElementById('single_print_view');
        // var mode = 'iframe'; //popup
        // var close = mode == "popup";
        // var options = { mode : mode, popClose : close};
        // $("#single_print_view").printArea( options );
        var occidss = $('td.checkbox').css('display','');
        var i;
        var print_list = '<table id="slected_single_table_row" >';
        var array = {};

        $('#selected_print_row tr').each(function(index, tr) {
            var lines = $('td', tr).map(function(index, td) {
                array [$(td).attr('data-column')] = $(td).text();
                // return $(td).text();
            });
            console.log(array);
            $.each(array, function( index, value ) {
                // alert( index + ": " + value );
                if(index === 'print'){
                    // alert();
                }
                else{

                    print_list += '<tr ><td class="'+index+'" style="height:50px;font-size: 25px;">'+value+'<td></tr>';
                }
            });

            $('#selected_single_print_row').html(print_list);
            // var printContent = document.getElementById('selected_single_print_row');
            // var mode = 'iframe'; //popup
            // var close = mode == "popup";
            // var options = { mode : mode, popClose : close};
            // $("#selected_single_print_row").printArea( options );
        });
        print_list += '</table >';

        if(
            $('.Member_Fistname').hasClass("Member_Fistname") && $('.Member_Lastname').hasClass("Member_Lastname")
            ){
            fname = $('.Member_Fistname').text();
            lname = $('.Member_Lastname').text();
            $('.Member_Fistname').parent().remove();
            $('.Member_Fistname').remove();
            $('.Member_Lastname').text(fname + ' ' + lname);
        }
        if($('.zipcode').hasClass("zipcode") && $('.city').hasClass("city") ){
            zip = $('.zipcode').text();
            city = $('.city').text();
            $('.city').parent().remove();
            $('.zipcode').text(zip +' '+city);
        }
        $("#selected_single_print_row td:empty").remove();
        // order
        if(
            $('.OccID').hasClass("OccID") &&
             $('.Member_Lastname').hasClass("Member_Lastname") && $('.address1').hasClass("address1")
            )
        {
            var name = $('#slected_single_table_row .Member_Lastname').parent().html();
            $('#slected_single_table_row .Member_Lastname').parent().remove();
            var occid = $('#slected_single_table_row .OccID').parent().html();
            var address1 = $('#slected_single_table_row .address1').parent().html();
            var address2 = $('#slected_single_table_row .address2').parent().html();
            zip = $('#slected_single_table_row .zipcode').parent().html();
            // city = $('.city').parent().html();
            console.log(address1);
            $('#slected_single_table_row .Member_Lastname').parent().remove();
            $('#slected_single_table_row .OccID').parent().remove();
            $('#slected_single_table_row .address1').parent().remove();
            $('#slected_single_table_row .address2').parent().remove();
            $('#slected_single_table_row .zipcode').parent().remove();

            $('#slected_single_table_row tr:first').before('<tr>'+zip+'</tr>');
            $('#slected_single_table_row tr:first').before('<tr>'+address2+'</tr>');
            $('#slected_single_table_row tr:first').before('<tr>'+address1+'</tr>');
            $('#slected_single_table_row tr:first').before('<tr>'+name+'</tr>');
            $('#slected_single_table_row tr:first').before('<tr>'+occid+'</tr>');




        }
        $('#slected_single_table_row tr').each(function(index, tr) {
            var th = $(this).find('td').attr('class');
            if(th === 'Member_Fistname' ){
                $('#slected_single_table_row > tbody ').eq(0).after('<td class="OccID" style="height:50px;font-size: 25px;">eqwdasdwee</td>');
            }
            // console.log(tr );
            // console.log(tr);
        });
        var printContent = document.getElementById('selected_single_print_row');
        var mode = 'iframe'; //popup
        var close = mode == "popup";
        var options = { mode : mode, popClose : close};
        $("#selected_single_print_row").printArea( options );

        // console.log(print_list);
    });
    // Single print
    $(document).on('click','#single_print',function () {
        // $('#single_print_view').html($('#label_search').val())
        // var printContent = document.getElementById('single_print_view');
        // var mode = 'iframe'; //popup
        // var close = mode == "popup";
        // var options = { mode : mode, popClose : close};
        // $("#single_print_view").printArea( options );
        var selected_data = {};
        var select_col = [];
        $('.selectul li').each(function()
        {
            select_col.push($(this).attr('data-value'));
        });
        var print_excel = $(this).attr('data-name');
        if($('#filter-panel').hasClass('show')){
            $('#filter-panel').removeClass('show');
        }
        if(select_col.length === 0){
            alert('Please select the filds');
        }else{

            if($('#occidcheck').prop("checked") == true){
                var occidfrom = $('.occidfrom').val();
                var occidto = $('.occidto').val();
                selected_data['occidfrom'] =occidfrom;
                selected_data['occidto'] = occidto;
                if(occidfrom != '' && occidto != '' ){

                    if ($('#occid_span').hasClass('occid_span')) {
                        $('#occid_span').remove();
                        $('#filter_by_display').append('<span id="occid_span" class="occid_span">Filter By OccID From: '+occidfrom+' To: '+occidto+'</span>');
                    }
                    else{
                        $('#filter_by_display').append('<span id="occid_span" class="occid_span">Filter By OccID From: '+occidfrom+' To: '+occidto+'</span>');
                    }
                }

            }
            else{
                $('#occid_span').remove();
            }
            // HCP
            if($('#hcpcheck').prop("checked") == true){
                var hcpfrom = $('.hcpfrom').val();
                var hcpto = $('.hcpto').val();
                selected_data['hcpfrom'] =hcpfrom;
                selected_data['hcpto'] = hcpto;
                if(hcpfrom != '' && hcpto != '' ){
                    if ($('#hcpcheck_span').hasClass('hcpcheck_span')) {
                        $('#hcpcheck_span').remove();
                        $('#filter_by_display').append('<span id="hcpcheck_span" class="hcpcheck_span">Filter By HCP From: '+hcpfrom+' To: '+hcpto+'</span>');
                    }
                    else{
                        $('#filter_by_display').append('<span id="hcpcheck_span" class="hcpcheck_span">Filter By HCP From: '+hcpfrom+' To: '+hcpto+'</span>');
                    }
                }

            }
            else{
                $('#hcpcheck_span').remove();
            }
            // DOB
            if($('#dobcheck').prop("checked") == true){
                var dobfrom = $('.dobfrom').val();
                var dobto = $('.dobto').val();
                selected_data['dobfrom'] =dobfrom;
                selected_data['dobto'] = dobto;
                if(dobfrom != '' && dobto != '' ){
                    if ($('#dobcheck_span').hasClass('dobcheck_span')) {
                        $('#dobcheck_span').remove();
                        $('#filter_by_display').append('<span id="dobcheck_span" class="dobcheck_span">Filter By Date of Birth From: '+dobfrom+' To: '+dobto+'</span>');
                    }
                    else{
                        $('#filter_by_display').append('<span id="dobcheck_span" class="dobcheck_span">Filter By Date of Birth  From: '+dobfrom+' To: '+dobto+'</span>');
                    }
                }

            }
            else{
                $('#dobcheck_span').remove();
            }
            // Member Since
            if($('#membersincecheck').prop("checked") == true){
                var membersincefrom = $('.membersincefrom').val();
                var membersinceto = $('.membersinceto').val();
                selected_data['membersincefrom'] =membersincefrom;
                selected_data['membersinceto'] = membersinceto;
                if(membersincefrom != '' && registrationto != '' ){
                    if(membersincefrom != '' && membersinceto != '' ){
                        if ($('#membersincecheck_span').hasClass('membersincecheck_span')) {
                            $('#membersincecheck_span').remove();
                            $('#filter_by_display').append('<span id="membersincecheck_span" class="membersincecheck_span">Filter By Member Since Date From: '+membersincefrom+' To: '+membersinceto+'</span>');
                        }
                        else{
                            $('#filter_by_display').append('<span id="membersincecheck_span" class="membersincecheck_span">Filter By Member Since Date From: '+membersincefrom+' To: '+membersinceto+'</span>');
                        }
                    }
                }

            }
            else{
                $('#membersincecheck_span').remove();
            }
            // Registration
            if($('#registrationcheck').prop("checked") == true){
                var registrationfrom = $('.registrationfrom').val();
                var registrationto = $('.registrationto').val();
                selected_data['registrationfrom'] =registrationfrom;
                selected_data['registrationto'] = registrationto;
                if(registrationfrom != '' && registrationto != '' ){
                    if ($('#registrationcheck_span').hasClass('registrationcheck_span')) {
                        $('#registrationcheck_span').remove();
                        $('#filter_by_display').append('<span id="registrationcheck_span" class="registrationcheck_span">Filter By Registration Date From: '+registrationfrom+' To: '+registrationto+'</span>');
                    }
                    else{
                        $('#filter_by_display').append('<span id="registrationcheck_span" class="registrationcheck_span">Filter By Registration Date From: '+registrationfrom+' To: '+registrationto+'</span>');
                    }
                }
            }
            else{
                $('#registrationcheck_span').remove();
            }
            // SEX
            if($('#sexcheck').prop("checked") == true){

                var sex = $('input[name="sex"]:checked').attr('data-text');
                selected_data['sex'] = sex ;
                // if(sex != '' && sex != '' ){
                    if ($('#sexcheck_span').hasClass('sexcheck_span')) {
                        $('#sexcheck_span').remove();
                        console.log(sex);
                        var sex_name= (sex == 'M') ? 'Menn' : ((sex == 'K')  ? "kvinner" : "");
                        $('#filter_by_display').append('<span id="sexcheck_span" class="sexcheck_span">Filter By Sex: '+sex+'</span>');
                    }
                    else{
                        var sex_name= (sex == 'M') ? 'Menn' : ((sex == 'K')  ? "kvinner" : "");
                        $('#filter_by_display').append('<span id="sexcheck_span" class="sexcheck_span">Filter By Sex: '+sex+'</span>');
                    }
                // }

            }
            else{
                $('#sexcheck_span').remove();
            }
            // Familyhead
            if($('#familyheadcheck').prop("checked") == true){

                var familyhead = $('input[name="familyhead"]:checked').attr('data-text');
                selected_data['familyhead'] = familyhead;

                if ($('#familyheadcheck_span').hasClass('familyheadcheck_span')) {
                    $('#familyheadcheck_span').remove();
                    $('#filter_by_display').append('<span id="familyheadcheck_span" class="familyheadcheck_span">Filter By Family Head: '+familyhead+'</span>');
                }
                else{
                    $('#filter_by_display').append('<span id="familyheadcheck_span" class="familyheadcheck_span">Filter By Family Head: '+familyhead+'</span>');
                }
            }
            else{
                $('#familyheadcheck_span').remove();
            }
            // Email
            if($('#emailcheck').prop("checked") == true){

                var email = $('input[name="email"]:checked').attr('data-text');
                selected_data['email'] =email;
                if ($('#emailcheck_span').hasClass('emailcheck_span')) {
                    $('#emailcheck_span').remove();
                    $('#filter_by_display').append('<span id="emailcheck_span" class="emailcheck_span">Filter By Email: '+email+'</span>');
                }
                else{
                    $('#filter_by_display').append('<span id="emailcheck_span" class="emailcheck_span">Filter By Email: '+email+'</span>');
                }
            }
            else{
                $('#emailcheck_span').remove();
            }

            if($('#membertypecheck').prop("checked") == true){

                var member_type = $("#member_type option:selected").val();
                selected_data['member_type'] =member_type;
                // console.log(member_type);
                var mesage = $("#member_type option:selected").text();
                if(mesage != 'Select'){

                    if ($('#membertypecheck_span').hasClass('membertypecheck_span')) {
                        $('#membertypecheck_span').remove();
                        $('#filter_by_display').append('<span id="membertypecheck_span" class="membertypecheck_span">Filter By Member Type: '+mesage+'</span>');
                    }
                    else{
                        $('#filter_by_display').append('<span id="membertypecheck_span" class="membertypecheck_span">Filter By Member Type: '+mesage+'</span>');
                    }
                }


            }
            else{
                $('#membertypecheck_span').remove();
            }


            var _token = "{{ csrf_token() }}";
            $.ajax({
                url: "{{ route('single_print') }}",
                method:"POST",
                // dataType:"json",
                data:{ selected_data:selected_data ,_token:_token,select_col:select_col },
                success:function(res){
                    console.log(res);
                    $('#printviews').html(res.print);
                    // if(print_excel == 'print'){

                    //     var printContent = document.getElementById('printviews');
                    //     var mode = 'iframe'; //popup
                    //     var close = mode == "popup";
                    //     var options = { mode : mode, popClose : close};
                    //     $("#printviews").printArea( options );
                    // }
                    // else{

                    //     $('#download-excel').attr('href',res.excel);
                    //     $('.download-excel')[0].click();
                    // }

                }
            });
        }
    });
    $(document).on('click','.printall-excelall',function () {
        // e.preventDefault();

        var selected_data = {};
        var select_col = [];
        $('.selectul li').each(function()
        {
            select_col.push($(this).attr('data-value'));
        });
        var print_excel = $(this).attr('data-name');
        if($('#filter-panel').hasClass('show')){
            $('#filter-panel').removeClass('show');
        }
        if(select_col.length === 0){
            alert('Please select the filds');
        }
        else{
            if($('#occidcheck').prop("checked") == true){
                var occidfrom = $('.occidfrom').val();
                var occidto = $('.occidto').val();
                selected_data['occidfrom'] =occidfrom;
                selected_data['occidto'] = occidto;
                // if ($('#occid_span').hasClass('occid_span')) {
                //     $('#occid_span').remove();
                //     $('#filter_by_display').append('<span id="occid_span" class="occid_span">Filter By OccID From: '+occidfrom+' To: '+occidto+'</span>');
                // }
                // else{
                //     $('#filter_by_display').append('<span id="occid_span" class="occid_span">Filter By OccID From: '+occidfrom+' To: '+occidto+'</span>');
                // }

            }
            // else{
            //     $('#occid_span').remove();
            // }
            // HCP
            if($('#hcpcheck').prop("checked") == true){
                var hcpfrom = $('.hcpfrom').val();
                var hcpto = $('.hcpto').val();
                selected_data['hcpfrom'] =hcpfrom;
                selected_data['hcpto'] = hcpto;

                // if ($('#hcpcheck_span').hasClass('hcpcheck_span')) {
                //     $('#hcpcheck_span').remove();
                //     $('#filter_by_display').append('<span id="hcpcheck_span" class="hcpcheck_span">Filter By HCP From: '+hcpfrom+' To: '+hcpto+'</span>');
                // }
                // else{
                //     $('#filter_by_display').append('<span id="hcpcheck_span" class="hcpcheck_span">Filter By HCP From: '+hcpfrom+' To: '+hcpto+'</span>');
                // }

            }
            // DOB
            if($('#dobcheck').prop("checked") == true){
                var dobfrom = $('.dobfrom').val();
                var dobto = $('.dobto').val();
                selected_data['dobfrom'] =dobfrom;
                selected_data['dobto'] = dobto;

                // if ($('#dobcheck_span').hasClass('dobcheck_span')) {
                //     $('#dobcheck_span').remove();
                //     $('#filter_by_display').append('<span id="dobcheck_span" class="dobcheck_span">Filter By Date of Birth From: '+dobfrom+' To: '+dobto+'</span>');
                // }
                // else{
                //     $('#filter_by_display').append('<span id="dobcheck_span" class="dobcheck_span">Filter By Date of Birth  From: '+dobfrom+' To: '+dobto+'</span>');
                // }

            }
            // Member Since
            if($('#membersincecheck').prop("checked") == true){
                var membersincefrom = $('.membersincefrom').val();
                var membersinceto = $('.membersinceto').val();
                selected_data['membersincefrom'] =membersincefrom;
                selected_data['membersinceto'] = membersinceto;

                // if ($('#membersincecheck_span').hasClass('membersincecheck_span')) {
                //     $('#membersincecheck_span').remove();
                //     $('#filter_by_display').append('<span id="membersincecheck_span" class="membersincecheck_span">Filter By Member Since Date From: '+membersincefrom+' To: '+membersinceto+'</span>');
                // }
                // else{
                //     $('#filter_by_display').append('<span id="membersincecheck_span" class="membersincecheck_span">Filter By Member Since Date From: '+membersincefrom+' To: '+membersinceto+'</span>');
                // }

            }
            // Registration
            if($('#registrationcheck').prop("checked") == true){
                var registrationfrom = $('.registrationfrom').val();
                var registrationto = $('.registrationto').val();
                selected_data['registrationfrom'] =registrationfrom;
                selected_data['registrationto'] = registrationto;

                // if ($('#registrationcheck_span').hasClass('registrationcheck_span')) {
                //     $('#registrationcheck_span').remove();
                //     $('#filter_by_display').append('<span id="registrationcheck_span" class="registrationcheck_span">Filter By Registration Date From: '+registrationfrom+' To: '+registrationto+'</span>');
                // }
                // else{
                //     $('#filter_by_display').append('<span id="registrationcheck_span" class="registrationcheck_span">Filter By Registration Date From: '+registrationfrom+' To: '+registrationto+'</span>');
                // }
            }
            // SEX
            if($('#sexcheck').prop("checked") == true){

                var sex = $('input[name="sex"]:checked').attr('data-text');
                selected_data['sex'] = sex ;

                // if ($('#sexcheck_span').hasClass('sexcheck_span')) {
                //     $('#sexcheck_span').remove();
                //     var sex_name= ((sex == 'm') ? 'Menn' : 'Kvinner')
                //     $('#filter_by_display').append('<span id="sexcheck_span" class="sexcheck_span">Filter By Sex: '+sex_name+'</span>');
                // }
                // else{
                //     $('#filter_by_display').append('<span id="sexcheck_span" class="sexcheck_span">Filter By Sex: '+sex_name+'</span>');
                // }

            }
            // Familyhead
            if($('#familyheadcheck').prop("checked") == true){

                var familyhead = $('input[name="familyhead"]:checked').attr('data-text');
                selected_data['familyhead'] = familyhead;

                // if ($('#familyheadcheck_span').hasClass('familyheadcheck_span')) {
                //     $('#familyheadcheck_span').remove();
                //     $('#filter_by_display').append('<span id="familyheadcheck_span" class="familyheadcheck_span">Filter By Family Head: '+familyhead+'</span>');
                // }
                // else{
                //     $('#filter_by_display').append('<span id="familyheadcheck_span" class="familyheadcheck_span">Filter By Family Head: '+familyhead+'</span>');
                // }
            }
            // Email
            if($('#emailcheck').prop("checked") == true){

                var email = $('input[name="email"]:checked').attr('data-text');
                selected_data['email'] =email;
                // if ($('#emailcheck_span').hasClass('emailcheck_span')) {
                //     $('#emailcheck_span').remove();
                //     $('#filter_by_display').append('<span id="emailcheck_span" class="emailcheck_span">Filter By Email: '+email+'</span>');
                // }
                // else{
                //     $('#filter_by_display').append('<span id="emailcheck_span" class="emailcheck_span">Filter By Email: '+email+'</span>');
                // }
            }

            if($('#membertypecheck').prop("checked") == true){

                var member_type = $("#member_type option:selected").val();
                selected_data['member_type'] =member_type;
                // console.log(selected_data);
                // if ($('#membertypecheck_span').hasClass('membertypecheck_span')) {
                //     $('#membertypecheck_span').remove();
                //     $('#filter_by_display').append('<span id="membertypecheck_span" class="membertypecheck_span">Filter By Member Type: '+$("#member_type option:selected").text()+'</span>');
                // }
                // else{
                //     $('#filter_by_display').append('<span id="membertypecheck_span" class="membertypecheck_span">Filter By Member Type: '+$("#member_type option:selected").text()+'</span>');
                // }

            }

            // $('.selectul')

            // console.log( select_col );
            var _token = "{{ csrf_token() }}";
            $.ajax({
                url: "{{ route('report_search_get_data') }}",
                method:"POST",
                // dataType:"json",
                data:{ selected_data:selected_data ,_token:_token,select_col:select_col },
                success:function(res){
                    console.log(res);
                    $('#printviews').html(res.print);
                    if(print_excel == 'print'){

                        var printContent = document.getElementById('printviews');
                        var mode = 'iframe'; //popup
                        var close = mode == "popup";
                        var options = { mode : mode, popClose : close};
                        $("#printviews").printArea( options );

                    }
                    else{

                        $('#download-excel').attr('href',res.excel);
                        $('.download-excel')[0].click();
                    }

                }
            });
        }

    });

// Search btton
    $(document).on('click','#filter_search',function (e) {
        e.preventDefault();
        var selected_data = {};
        var select_col = [];
        $('.selectul li').each(function()
        {
            select_col.push($(this).attr('data-value'));
        });
        var print_excel = $(this).attr('data-name');
        if($('#filter-panel').hasClass('show')){
            $('#filter-panel').removeClass('show');
        }
        if(select_col.length === 0){
            alert('Please select the filds');
        }else{

            if($('#occidcheck').prop("checked") == true){
                var occidfrom = $('.occidfrom').val();
                var occidto = $('.occidto').val();
                selected_data['occidfrom'] =occidfrom;
                selected_data['occidto'] = occidto;
                if(occidfrom != '' && occidto != '' ){

                    if ($('#occid_span').hasClass('occid_span')) {
                        $('#occid_span').remove();
                        $('#filter_by_display').append('<span id="occid_span" class="occid_span">Filter By OccID From: '+occidfrom+' To: '+occidto+'</span>');
                    }
                    else{
                        $('#filter_by_display').append('<span id="occid_span" class="occid_span">Filter By OccID From: '+occidfrom+' To: '+occidto+'</span>');
                    }
                }

            }
            else{
                $('#occid_span').remove();
            }
            // HCP
            if($('#hcpcheck').prop("checked") == true){
                var hcpfrom = $('.hcpfrom').val();
                var hcpto = $('.hcpto').val();
                selected_data['hcpfrom'] =hcpfrom;
                selected_data['hcpto'] = hcpto;
                if(hcpfrom != '' && hcpto != '' ){
                    if ($('#hcpcheck_span').hasClass('hcpcheck_span')) {
                        $('#hcpcheck_span').remove();
                        $('#filter_by_display').append('<span id="hcpcheck_span" class="hcpcheck_span">Filter By HCP From: '+hcpfrom+' To: '+hcpto+'</span>');
                    }
                    else{
                        $('#filter_by_display').append('<span id="hcpcheck_span" class="hcpcheck_span">Filter By HCP From: '+hcpfrom+' To: '+hcpto+'</span>');
                    }
                }

            }
            else{
                $('#hcpcheck_span').remove();
            }
            // DOB
            if($('#dobcheck').prop("checked") == true){
                var dobfrom = $('.dobfrom').val();
                var dobto = $('.dobto').val();
                selected_data['dobfrom'] =dobfrom;
                selected_data['dobto'] = dobto;
                if(dobfrom != '' && dobto != '' ){
                    if ($('#dobcheck_span').hasClass('dobcheck_span')) {
                        $('#dobcheck_span').remove();
                        $('#filter_by_display').append('<span id="dobcheck_span" class="dobcheck_span">Filter By Date of Birth From: '+dobfrom+' To: '+dobto+'</span>');
                    }
                    else{
                        $('#filter_by_display').append('<span id="dobcheck_span" class="dobcheck_span">Filter By Date of Birth  From: '+dobfrom+' To: '+dobto+'</span>');
                    }
                }

            }
            else{
                $('#dobcheck_span').remove();
            }
            // Member Since
            if($('#membersincecheck').prop("checked") == true){
                var membersincefrom = $('.membersincefrom').val();
                var membersinceto = $('.membersinceto').val();
                selected_data['membersincefrom'] =membersincefrom;
                selected_data['membersinceto'] = membersinceto;
                if(membersincefrom != '' && registrationto != '' ){
                    if(membersincefrom != '' && membersinceto != '' ){
                        if ($('#membersincecheck_span').hasClass('membersincecheck_span')) {
                            $('#membersincecheck_span').remove();
                            $('#filter_by_display').append('<span id="membersincecheck_span" class="membersincecheck_span">Filter By Member Since Date From: '+membersincefrom+' To: '+membersinceto+'</span>');
                        }
                        else{
                            $('#filter_by_display').append('<span id="membersincecheck_span" class="membersincecheck_span">Filter By Member Since Date From: '+membersincefrom+' To: '+membersinceto+'</span>');
                        }
                    }
                }

            }
            else{
                $('#membersincecheck_span').remove();
            }
            // Registration
            if($('#registrationcheck').prop("checked") == true){
                var registrationfrom = $('.registrationfrom').val();
                var registrationto = $('.registrationto').val();
                selected_data['registrationfrom'] =registrationfrom;
                selected_data['registrationto'] = registrationto;
                if(registrationfrom != '' && registrationto != '' ){
                    if ($('#registrationcheck_span').hasClass('registrationcheck_span')) {
                        $('#registrationcheck_span').remove();
                        $('#filter_by_display').append('<span id="registrationcheck_span" class="registrationcheck_span">Filter By Registration Date From: '+registrationfrom+' To: '+registrationto+'</span>');
                    }
                    else{
                        $('#filter_by_display').append('<span id="registrationcheck_span" class="registrationcheck_span">Filter By Registration Date From: '+registrationfrom+' To: '+registrationto+'</span>');
                    }
                }
            }
            else{
                $('#registrationcheck_span').remove();
            }
            // SEX
            if($('#sexcheck').prop("checked") == true){

                var sex = $('input[name="sex"]:checked').attr('data-text');
                selected_data['sex'] = sex ;
                // if(sex != '' && sex != '' ){
                    if ($('#sexcheck_span').hasClass('sexcheck_span')) {
                        $('#sexcheck_span').remove();
                        console.log(sex);
                        var sex_name= (sex == 'M') ? 'Menn' : ((sex == 'K')  ? "kvinner" : "");
                        $('#filter_by_display').append('<span id="sexcheck_span" class="sexcheck_span">Filter By Sex: '+sex+'</span>');
                    }
                    else{
                        var sex_name= (sex == 'M') ? 'Menn' : ((sex == 'K')  ? "kvinner" : "");
                        $('#filter_by_display').append('<span id="sexcheck_span" class="sexcheck_span">Filter By Sex: '+sex+'</span>');
                    }
                // }

            }
            else{
                $('#sexcheck_span').remove();
            }
            // Familyhead
            if($('#familyheadcheck').prop("checked") == true){

                var familyhead = $('input[name="familyhead"]:checked').attr('data-text');
                selected_data['familyhead'] = familyhead;

                if ($('#familyheadcheck_span').hasClass('familyheadcheck_span')) {
                    $('#familyheadcheck_span').remove();
                    $('#filter_by_display').append('<span id="familyheadcheck_span" class="familyheadcheck_span">Filter By Family Head: '+familyhead+'</span>');
                }
                else{
                    $('#filter_by_display').append('<span id="familyheadcheck_span" class="familyheadcheck_span">Filter By Family Head: '+familyhead+'</span>');
                }
            }
            else{
                $('#familyheadcheck_span').remove();
            }
            // Email
            if($('#emailcheck').prop("checked") == true){

                var email = $('input[name="email"]:checked').attr('data-text');
                selected_data['email'] =email;
                if ($('#emailcheck_span').hasClass('emailcheck_span')) {
                    $('#emailcheck_span').remove();
                    $('#filter_by_display').append('<span id="emailcheck_span" class="emailcheck_span">Filter By Email: '+email+'</span>');
                }
                else{
                    $('#filter_by_display').append('<span id="emailcheck_span" class="emailcheck_span">Filter By Email: '+email+'</span>');
                }
            }
            else{
                $('#emailcheck_span').remove();
            }

            if($('#membertypecheck').prop("checked") == true){

                var member_type = $("#member_type option:selected").val();
                selected_data['member_type'] =member_type;
                // console.log(member_type);
                var mesage = $("#member_type option:selected").text();
                if(mesage != 'Select'){

                    if ($('#membertypecheck_span').hasClass('membertypecheck_span')) {
                        $('#membertypecheck_span').remove();
                        $('#filter_by_display').append('<span id="membertypecheck_span" class="membertypecheck_span">Filter By Member Type: '+mesage+'</span>');
                    }
                    else{
                        $('#filter_by_display').append('<span id="membertypecheck_span" class="membertypecheck_span">Filter By Member Type: '+mesage+'</span>');
                    }
                }


            }
            else{
                $('#membertypecheck_span').remove();
            }


            var _token = "{{ csrf_token() }}";
            $.ajax({
                url: "{{ route('report_search_get_data') }}",
                method:"POST",
                // dataType:"json",
                data:{ selected_data:selected_data ,_token:_token,select_col:select_col },
                success:function(res){
                    console.log(res);
                    $('#printviews').html(res.print);
                    // if(print_excel == 'print'){

                    //     var printContent = document.getElementById('printviews');
                    //     var mode = 'iframe'; //popup
                    //     var close = mode == "popup";
                    //     var options = { mode : mode, popClose : close};
                    //     $("#printviews").printArea( options );
                    // }
                    // else{

                    //     $('#download-excel').attr('href',res.excel);
                    //     $('.download-excel')[0].click();
                    // }

                }
            });
        }

    });

    $(document).on('click','#membertypecheck',function (e) {
        // e.preventDefault();
        if($(this).prop("checked") == true){
            $('.membertype').removeAttr('disabled');

        }
        else if($(this).prop("checked") == false){

            $('.membertype').attr('disabled',true);

        }
    });
    $(document).on('click','#emailcheck',function (e) {
        // e.preventDefault();
        if($(this).prop("checked") == true){
            $('.email').removeAttr('disabled');

        }
        else if($(this).prop("checked") == false){
            $('.email').prop('checked', false);
            $('.email').attr('disabled',true);

        }
    });
    $(document).on('click','#familyheadcheck',function (e) {
        // e.preventDefault();
        if($(this).prop("checked") == true){
            $('.familyhead').removeAttr('disabled');

        }
        else if($(this).prop("checked") == false){
            $('.familyhead').prop('checked', false);
            $('.familyhead').attr('disabled',true);

        }
    });
    $(document).on('click','#sexcheck',function (e) {
        // e.preventDefault();
        if($(this).prop("checked") == true){
            $('.sex').removeAttr('disabled');

        }
        else if($(this).prop("checked") == false){
            $('.sex').prop('checked', false);
            $('.sex').attr('disabled',true);

        }
    });
    $(document).on('click','#registrationcheck',function (e) {
        // e.preventDefault();
        if($(this).prop("checked") == true){
            $('.registration').removeAttr('disabled');
        }
        else if($(this).prop("checked") == false){
            $('.registration').attr('disabled',true);
        }
    });
    $(document).on('click','#membersincecheck',function (e) {
        // e.preventDefault();
        if($(this).prop("checked") == true){
            $('.membersince').removeAttr('disabled');
        }
        else if($(this).prop("checked") == false){

            $('.membersince').attr('disabled',true);
        }
    });
    $(document).on('click','#dobcheck',function (e) {
        // e.preventDefault();
        if($(this).prop("checked") == true){
            $('.dob').removeAttr('disabled');
        }
        else if($(this).prop("checked") == false){
            $('.dob').attr('disabled',true);
        }
    });
    $(document).on('click','#hcpcheck',function (e) {
        // e.preventDefault();
        if($(this).prop("checked") == true){
            $('.hcp').removeAttr('disabled');
        }
        else if($(this).prop("checked") == false){
            $('.hcp').attr('disabled',true);
        }
    });
    $(document).on('click','#occidcheck',function (e) {
        // e.preventDefault();
        if($(this).prop("checked") == true){
            $('.occid').removeAttr('disabled');
        }
        else if($(this).prop("checked") == false){
            $('.occid').attr('disabled',true);
        }
    });
    $(document).on('click','.up',function (e) {
        e.preventDefault();
        // $('.dual-listbox__item--selected').prev().insertAfter('.dual-listbox__item--selected');
        $('.dual-listbox__item--selected').each(function() {
            $(this).insertBefore($(this).prev());
        });
    });
    $(document).on('click','.down',function (e) {
        e.preventDefault();
        // $('.dual-listbox__item--selected').prev().insertAfter('.dual-listbox__item--selected');
        var $current = $(this).closest('li')
        var $next = $current.next('li');
        $('.dual-listbox__item--selected').each(function() {
            $(this).insertAfter($(this).next());
        });

    });
    // selected li
    $(document).on('click','.list li',function (e) {

        if($(this).hasClass("dual-listbox__item--selected")   ){
            $(this).removeClass('dual-listbox__item--selected');
        }else{

            if (!e.ctrlKey && !e.shiftKey) {
                $('.list li').removeClass('dual-listbox__item--selected');
            }
            $(this).toggleClass('dual-listbox__item--selected');
            // console.log(t);
        }
    });
    // append li li
    $(document).on('click','.selectul li',function (e) {

        if($(this).hasClass("dual-listbox__item--selected")   ){
            $(this).removeClass('dual-listbox__item--selected');
        }else{

            if (!e.ctrlKey && !e.shiftKey) {
                $('.selectul li').removeClass('dual-listbox__item--selected');
            }
            $(this).toggleClass('dual-listbox__item--selected');
            // console.log(t);
        }
    });
    $(document).on('click','.remove-selected',function (e) {
        // e.preventDefault();
        $('.selectul .dual-listbox__item--selected').remove();
    });
    // add selected singles
    $(document).on('click','.add-selected',function (e) {
        e.preventDefault();
        var data_val = $('.dual-listbox__item--selected').attr('data-value');
        $('.dual-listbox__item--selected').each(function()
        {
            var addit = true;
            var th = $(this);
            var selectas = th.text();
            $('.selectul li').each(function()
            {
                var th2 = $(this);
                var selectas2 = th2.text();
                // Duplicate remove the li
                if(selectas != selectas2)
                {


                }
                else{

                    th2.remove();
                }
            });

        });
        $('.list .dual-listbox__item--selected').clone().appendTo('.selectul');
        $('.list li').removeClass('dual-listbox__item--selected');
        $('.selectul li').removeClass('dual-listbox__item--selected');




        // if($('.selectul li').hasClass(data_val))
        // {
        //     alert('All Ready Added');

        // }
        // else{

        //     $('.list .dual-listbox__item--selected').clone().appendTo('.selectul');
        //     $('.list li').removeClass('dual-listbox__item--selected');
        //     $('.selectul li').removeClass('dual-listbox__item--selected');
        // }

    });
    //add all
    $(document).on('click','.add_all',function (e) {
        e.preventDefault();
        var data_val = $('.selectul .dual-listbox__item').attr('data-value');

        if($('.selectul li').hasClass(data_val))
        {
            alert('All Ready Added');
        }
        else
        {

            $('.list .dual-listbox__item').clone().appendTo('.selectul');
            $('.list li').removeClass('dual-listbox__item--selected');
            $('.selectul li').removeClass('dual-listbox__item--selected');

        }

    });
    // remove all
    $(document).on('click','.remove-all',function () {
        $('.selectul li').remove();
    });
    </script>
@endpush
@push('script2')

    <script>

        // $(document).ready(function () {
        //     if ($("#radio1").is(":checked")) {
        //         var tes = $(this).attr('data-href');
        //         var result = $( "#resultradio" ).load(tes);
        //     }
        // });
        // $(document).on('click','.selectedtest',function (e){

        //     $('#resultradio :first').remove();
        //     var tes = $(this).attr('data-href');
        //     var result = $( "#resultradio" ).load(tes);
        //     console.log(result);

        // });
        // Excel to Export Excel
        // $(document).on('click','#excel',function (e) {
        //     e.preventDefault();
        //     var radioValue = $("input[name='tabseach']:checked").attr('id');
        //     if(radioValue == 'search'){

        //         var _token = "{{ csrf_token() }}";
        //         var searchkey = $('#searchkey').val();
        //         var selectedkey = $('#dLabel').attr('data-selected');
        //         $.ajax({
        //             url: "{{ route('exportdata') }}",
        //             data:{ searchkey:searchkey,selectedkey:selectedkey,_token:_token },
        //             success:function(res){
        //                 // console.log(res);
        //                 $('#download-excel').attr('href',res);
        //                 $('.download-excel')[0].click();

        //             }
        //         });
        //     }
        //     // else{
        //     //     var _token = "{{ csrf_token() }}";
        //     //     var listdata = [];
        //     //     $('.selectul .dual-listbox__item').each(function(i){
        //     //         listdata[i] = $(this).attr('data-value');
        //     //     });
        //     //     $.ajax({
        //     //         url: "{{ route('exportdata_fileds') }}",
        //     //         method:"POST",
        //     //         data:{ listdata:listdata,_token:_token },
        //     //         success:function(res){
        //     //             console.log(res);
        //     //         }
        //     //     });
        //     // }
        // })
        // print butoon
        // $(document).on('click','#print',function (e) {
        //     e.preventDefault();
        //     var radioValue = $("input[name='tabseach']:checked").attr('id');
        //     if(radioValue == 'search'){

        //         var _token = "{{ csrf_token() }}";
        //         var searchkey = $('#searchkey').val();
        //         var selectedkey = $('#dLabel').attr('data-selected');
        //         $.ajax({
        //             url: "{{ route('printdetails') }}",
        //             method:"POST",
        //             data:{ searchkey:searchkey,selectedkey:selectedkey,_token:_token },
        //             success:function(res){

        //                 $('#result').html(res);
        //                 var printContent = document.getElementById('userInfo');
        //                 var mode = 'iframe'; //popup
        //                 var close = mode == "popup";
        //                 var options = { mode : mode, popClose : close};
        //                 $("#printview").printArea( options );

        //             }
        //         });
        //     }
        //     else{

        //         var _token = "{{ csrf_token() }}";
        //         var listdata = [];
        //         $('.selectul .dual-listbox__item').each(function(i){
        //             listdata[i] = $(this).attr('data-value');
        //         });
        //         $.ajax({
        //             url: "{{ route('getspecific') }}",
        //             method:"POST",
        //             data:{ listdata:listdata,_token:_token },
        //             success:function(res){
        //                 // console.log(res);
        //                 $('#print_fields').html(res);

        //                 var mode = 'iframe'; //popup
        //                 var close = mode == "popup";
        //                 var options = { mode : mode, popClose : close};
        //                 $('#print_fields').printArea( options );

        //             }
        //         });
        //     }
        // })

        $('.dropdown-menu li').on('click', function() {
            var getValue = $(this).text();
            if(getValue == 'Select'){

                $('.dropdown-select').removeAttr('data-selected');
                $('.dropdown-select').text(getValue);

            }
            else{

                $('.dropdown-select').attr('data-selected',$(this).attr('data-value'));
                $('.dropdown-select').text(getValue);
            }
        });

        $(document).on('click','#search',function(e){
            e.preventDefault();
            var _token = "{{ csrf_token() }}";
            var searchkey = $('#searchkey').val();
            var selectedkey = $('#dLabel').attr('data-selected');
            $.ajax({
                url:"{{ route('getdatareportpage') }}",
                method:"POST",
                data:{ searchkey:searchkey,selectedkey:selectedkey,_token:_token },
                success:function(res){
                    $('#result').html(res);
                }
            });
        });

        // $(document).on('click','.alpha',function (e) {
        //     e.preventDefault();
        //     var alpa = $(this).text();
        //     $('#searchkey').val(alpa);
        //     $('#search').trigger('click');
        // })

    </script>
@endpush
