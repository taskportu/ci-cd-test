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
            /* border: none; */
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.0/css/font-awesome.min.css" integrity="sha512-FEQLazq9ecqLN5T6wWq26hCZf7kPqUbFC9vsHNbXMJtSZZWAcbJspT+/NEAQkBfFReZ8r9QlA9JHaAuo28MTJA==" crossorigin="anonymous" />
    <!--<link rel='stylesheet' href='https://use.fontawesome.com/releases/v5.6.3/css/all.css'>-->
		{{-- <link rel="icon" href="{{asset('/images/favicon.png')}}" type="image/gif" > --}}

@endpush
<div class="container">
    {{-- {{ date('Y-m-d') }} --}}
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
                <li class="dual-listbox__item" data-value="HCP">HCP Online</li>
                <li class="dual-listbox__item" data-value="member_type">Member Type</li>
                <li class="dual-listbox__item" data-value="share_type">Share Type</li>
                <li class="dual-listbox__item" data-value="share_number">Share Number</li>
                <li class="dual-listbox__item" data-value="address1">Address Line 1</li>
                <li class="dual-listbox__item" data-value="address2">Address Line 2</li>
                <li class="dual-listbox__item" data-value="city">City</li>
                <li class="dual-listbox__item" data-value="zipcode">Zipcode</li>
                <li class="dual-listbox__item" data-value="tel_privately">Tel Privat</li>
                <li class="dual-listbox__item" data-value="tel_jobs">Tel Work</li>
                <li class="dual-listbox__item" data-value="phone_mobile">Tel Mobile</li>
                <li class="dual-listbox__item" data-value="sex">Sex</li>
                <li class="dual-listbox__item" data-value="handicap">HCP Manual</li>


                <li class="dual-listbox__item" data-value="date_of_birth">Date of Birth</li>
                <li class="dual-listbox__item" data-value="email">Email</li>
                <li class="dual-listbox__item" data-value="member_since">Member Since</li>
                <li class="dual-listbox__item" data-value="resignation_date">Resignation Date</li>
                <li class="dual-listbox__item" data-value="additional_info">Additional Info</li>

                <li class="dual-listbox__item" data-value="wardrobe">Wardrobe</li>
                <li class="dual-listbox__item" data-value="drinks_cabinet">Drinks Cabinet</li>
                <li class="dual-listbox__item" data-value="stick_cabinet">Stick Cabinet</li>

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
                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"width="16" height="16"
	 viewBox="0 0 100.25 100.25" style="enable-background:new 0 0 100.25 100.25;" xml:space="preserve" fill="currentColor">
<g>
	<path d="M50,30.5c-10.201,0-18.5,8.299-18.5,18.5S39.799,67.5,50,67.5S68.5,59.201,68.5,49S60.201,30.5,50,30.5z M50,64.5
		c-8.547,0-15.5-6.953-15.5-15.5S41.453,33.5,50,33.5S65.5,40.453,65.5,49S58.547,64.5,50,64.5z"/>
	<path d="M95.225,41.501L83.257,39.69c-0.658-2.218-1.547-4.372-2.651-6.425l7.176-9.733c0.44-0.597,0.378-1.426-0.146-1.951
		l-9.216-9.215c-0.525-0.524-1.354-0.587-1.951-0.147l-9.702,7.152c-2.062-1.12-4.23-2.022-6.466-2.691L58.5,4.776
		C58.389,4.042,57.759,3.5,57.017,3.5H43.985c-0.742,0-1.372,0.542-1.483,1.276L40.701,16.68c-2.236,0.669-4.404,1.572-6.466,2.691
		l-9.702-7.152c-0.597-0.44-1.426-0.378-1.951,0.147l-9.215,9.215c-0.524,0.524-0.587,1.354-0.147,1.951l7.176,9.733
		c-1.104,2.053-1.993,4.207-2.651,6.425L5.777,41.501c-0.734,0.111-1.276,0.741-1.276,1.483v13.032c0,0.742,0.542,1.372,1.275,1.483
		l12.027,1.82c0.665,2.194,1.552,4.319,2.647,6.341l-7.231,9.808c-0.44,0.597-0.377,1.426,0.147,1.951l9.215,9.215
		c0.524,0.525,1.354,0.587,1.951,0.147l9.84-7.254c2.012,1.08,4.124,1.954,6.3,2.607l1.829,12.09
		c0.111,0.734,0.741,1.276,1.483,1.276h13.032c0.742,0,1.372-0.542,1.483-1.276l1.829-12.09c2.176-0.653,4.288-1.527,6.3-2.607
		l9.84,7.254c0.597,0.44,1.426,0.377,1.951-0.147l9.216-9.215c0.524-0.524,0.587-1.354,0.146-1.951L80.55,65.66
		c1.096-2.022,1.983-4.147,2.647-6.341l12.027-1.82c0.733-0.111,1.275-0.741,1.275-1.483V42.984
		C96.5,42.243,95.958,41.612,95.225,41.501z M93.5,54.726l-11.703,1.771c-0.588,0.089-1.068,0.517-1.224,1.09
		c-0.704,2.595-1.748,5.095-3.103,7.432c-0.3,0.517-0.265,1.162,0.09,1.643l7.04,9.549l-7.391,7.391l-9.578-7.061
		c-0.48-0.353-1.122-0.39-1.637-0.093c-2.331,1.339-4.818,2.369-7.395,3.06c-0.575,0.155-1.005,0.635-1.094,1.225l-1.78,11.769
		H45.273l-1.78-11.769c-0.089-0.589-0.519-1.07-1.094-1.225c-2.577-0.691-5.064-1.721-7.395-3.06
		c-0.515-0.296-1.158-0.259-1.637,0.093l-9.578,7.061l-7.391-7.391l7.04-9.549c0.354-0.481,0.39-1.126,0.09-1.643
		c-1.355-2.336-2.399-4.837-3.103-7.432c-0.156-0.574-0.636-1.001-1.224-1.09L7.498,54.726V44.274l11.65-1.762
		c0.591-0.089,1.073-0.521,1.226-1.099c0.693-2.616,1.735-5.144,3.099-7.514c0.297-0.516,0.26-1.159-0.093-1.638l-6.982-9.471
		l7.391-7.391l9.443,6.961c0.481,0.354,1.126,0.39,1.644,0.089c2.375-1.38,4.916-2.437,7.55-3.142
		c0.576-0.154,1.006-0.635,1.095-1.225l1.752-11.583h10.452l1.752,11.583c0.089,0.59,0.519,1.071,1.095,1.225
		c2.634,0.705,5.174,1.762,7.55,3.142c0.517,0.302,1.162,0.265,1.644-0.089l9.443-6.961L84.6,22.79l-6.982,9.471
		c-0.353,0.479-0.39,1.122-0.093,1.638c1.363,2.37,2.406,4.898,3.099,7.514c0.153,0.578,0.635,1.009,1.226,1.099l11.65,1.762
		L93.5,54.726L93.5,54.726z"/>
</g>
</svg> Filter by Fields
            </button>

            <button type="button" id="filter_search" class="btn btn-primary " style="margin-left: 260px;border-radius: 10px; margin:10px" >
                <svg xmlns="http://www.w3.org/2000/svg"width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                </svg> Search
            </button>

            {{-- <input type="text" name="label_search" id="label_search"> --}}
            {{-- <label for="" id=""> Single Print</label> --}}
            <button type="button" id="single_print" class="btn btn-primary " style="margin-left: 3px;border-radius: 10px;" >
                <svg width="16px" height="16px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
        <g id="icon-125-printer-text" sketch:type="MSArtboardGroup" fill="currentColor">
            <path d="M26,25 L28.0057181,25 C29.6594143,25 31,23.6556493 31,22.0005775 L31,12.9994225 C31,11.3428872 29.6594313,10 28.0057181,10 L26,10 L26,2.99961498 C26,1.89525812 25.1090746,1 24.0025781,1 L8.99742191,1 C7.89427625,1 7,1.88743329 7,2.99961498 L7,10 L7,10 L4.99428189,10 C3.34058566,10 2,11.3443507 2,12.9994225 L2,22.0005775 C2,23.6571128 3.3405687,25 4.99428189,25 L7,25 L7,29.000385 C7,30.1047419 7.89092539,31 8.99742191,31 L24.0025781,31 C25.1057238,31 26,30.1125667 26,29.000385 L26,25 L26,25 L26,25 Z M7,24 L5.00732994,24 C3.89833832,24 3,23.1033337 3,21.9972399 L3,13.0027601 C3,11.8935426 3.89871223,11 5.00732994,11 L27.9926701,11 C29.1016617,11 30,11.8966663 30,13.0027601 L30,21.9972399 C30,23.1064574 29.1012878,24 27.9926701,24 L26,24 L26,21 L7,21 L7,24 L7,24 L7,24 Z M8.9999602,2 C8.44769743,2 8,2.45303631 8,2.99703014 L8,10 L25,10 L25,2.99703014 C25,2.4463856 24.5452911,2 24.0000398,2 L8.9999602,2 L8.9999602,2 Z M8,22 L8,29.0029699 C8,29.5536144 8.45470893,30 8.9999602,30 L24.0000398,30 C24.5523026,30 25,29.5469637 25,29.0029699 L25,22 L8,22 L8,22 Z M25,16 C25.5522848,16 26,15.5522848 26,15 C26,14.4477152 25.5522848,14 25,14 C24.4477152,14 24,14.4477152 24,15 C24,15.5522848 24.4477152,16 25,16 L25,16 Z M9,24 L9,25 L24,25 L24,24 L9,24 L9,24 Z M9,27 L9,28 L24,28 L24,27 L9,27 L9,27 Z" id="printer-text" sketch:type="MSShapeGroup"></path>
        </g>
    </g>
</svg> Single Print
            </button>

            <button type="button" id="multi_print" class="btn btn-primary " style="margin-left: 3px;border-radius: 10px;" >
                <svg width="16px" height="16px" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">
    <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">
        <g id="icon-125-printer-text" sketch:type="MSArtboardGroup" fill="currentColor">
            <path d="M26,25 L28.0057181,25 C29.6594143,25 31,23.6556493 31,22.0005775 L31,12.9994225 C31,11.3428872 29.6594313,10 28.0057181,10 L26,10 L26,2.99961498 C26,1.89525812 25.1090746,1 24.0025781,1 L8.99742191,1 C7.89427625,1 7,1.88743329 7,2.99961498 L7,10 L7,10 L4.99428189,10 C3.34058566,10 2,11.3443507 2,12.9994225 L2,22.0005775 C2,23.6571128 3.3405687,25 4.99428189,25 L7,25 L7,29.000385 C7,30.1047419 7.89092539,31 8.99742191,31 L24.0025781,31 C25.1057238,31 26,30.1125667 26,29.000385 L26,25 L26,25 L26,25 Z M7,24 L5.00732994,24 C3.89833832,24 3,23.1033337 3,21.9972399 L3,13.0027601 C3,11.8935426 3.89871223,11 5.00732994,11 L27.9926701,11 C29.1016617,11 30,11.8966663 30,13.0027601 L30,21.9972399 C30,23.1064574 29.1012878,24 27.9926701,24 L26,24 L26,21 L7,21 L7,24 L7,24 L7,24 Z M8.9999602,2 C8.44769743,2 8,2.45303631 8,2.99703014 L8,10 L25,10 L25,2.99703014 C25,2.4463856 24.5452911,2 24.0000398,2 L8.9999602,2 L8.9999602,2 Z M8,22 L8,29.0029699 C8,29.5536144 8.45470893,30 8.9999602,30 L24.0000398,30 C24.5523026,30 25,29.5469637 25,29.0029699 L25,22 L8,22 L8,22 Z M25,16 C25.5522848,16 26,15.5522848 26,15 C26,14.4477152 25.5522848,14 25,14 C24.4477152,14 24,14.4477152 24,15 C24,15.5522848 24.4477152,16 25,16 L25,16 Z M9,24 L9,25 L24,25 L24,24 L9,24 L9,24 Z M9,27 L9,28 L24,28 L24,27 L9,27 L9,27 Z" id="printer-text" sketch:type="MSShapeGroup"></path>
        </g>
    </g>
</svg> Selected Single Print
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
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"width="25" height="25"
	 viewBox="0 0 100.25 100.25" style="enable-background:new 0 0 100.25 100.25;" xml:space="preserve" fill="currentColor">
<g>
	<path d="M50,30.5c-10.201,0-18.5,8.299-18.5,18.5S39.799,67.5,50,67.5S68.5,59.201,68.5,49S60.201,30.5,50,30.5z M50,64.5
		c-8.547,0-15.5-6.953-15.5-15.5S41.453,33.5,50,33.5S65.5,40.453,65.5,49S58.547,64.5,50,64.5z"/>
	<path d="M95.225,41.501L83.257,39.69c-0.658-2.218-1.547-4.372-2.651-6.425l7.176-9.733c0.44-0.597,0.378-1.426-0.146-1.951
		l-9.216-9.215c-0.525-0.524-1.354-0.587-1.951-0.147l-9.702,7.152c-2.062-1.12-4.23-2.022-6.466-2.691L58.5,4.776
		C58.389,4.042,57.759,3.5,57.017,3.5H43.985c-0.742,0-1.372,0.542-1.483,1.276L40.701,16.68c-2.236,0.669-4.404,1.572-6.466,2.691
		l-9.702-7.152c-0.597-0.44-1.426-0.378-1.951,0.147l-9.215,9.215c-0.524,0.524-0.587,1.354-0.147,1.951l7.176,9.733
		c-1.104,2.053-1.993,4.207-2.651,6.425L5.777,41.501c-0.734,0.111-1.276,0.741-1.276,1.483v13.032c0,0.742,0.542,1.372,1.275,1.483
		l12.027,1.82c0.665,2.194,1.552,4.319,2.647,6.341l-7.231,9.808c-0.44,0.597-0.377,1.426,0.147,1.951l9.215,9.215
		c0.524,0.525,1.354,0.587,1.951,0.147l9.84-7.254c2.012,1.08,4.124,1.954,6.3,2.607l1.829,12.09
		c0.111,0.734,0.741,1.276,1.483,1.276h13.032c0.742,0,1.372-0.542,1.483-1.276l1.829-12.09c2.176-0.653,4.288-1.527,6.3-2.607
		l9.84,7.254c0.597,0.44,1.426,0.377,1.951-0.147l9.216-9.215c0.524-0.524,0.587-1.354,0.146-1.951L80.55,65.66
		c1.096-2.022,1.983-4.147,2.647-6.341l12.027-1.82c0.733-0.111,1.275-0.741,1.275-1.483V42.984
		C96.5,42.243,95.958,41.612,95.225,41.501z M93.5,54.726l-11.703,1.771c-0.588,0.089-1.068,0.517-1.224,1.09
		c-0.704,2.595-1.748,5.095-3.103,7.432c-0.3,0.517-0.265,1.162,0.09,1.643l7.04,9.549l-7.391,7.391l-9.578-7.061
		c-0.48-0.353-1.122-0.39-1.637-0.093c-2.331,1.339-4.818,2.369-7.395,3.06c-0.575,0.155-1.005,0.635-1.094,1.225l-1.78,11.769
		H45.273l-1.78-11.769c-0.089-0.589-0.519-1.07-1.094-1.225c-2.577-0.691-5.064-1.721-7.395-3.06
		c-0.515-0.296-1.158-0.259-1.637,0.093l-9.578,7.061l-7.391-7.391l7.04-9.549c0.354-0.481,0.39-1.126,0.09-1.643
		c-1.355-2.336-2.399-4.837-3.103-7.432c-0.156-0.574-0.636-1.001-1.224-1.09L7.498,54.726V44.274l11.65-1.762
		c0.591-0.089,1.073-0.521,1.226-1.099c0.693-2.616,1.735-5.144,3.099-7.514c0.297-0.516,0.26-1.159-0.093-1.638l-6.982-9.471
		l7.391-7.391l9.443,6.961c0.481,0.354,1.126,0.39,1.644,0.089c2.375-1.38,4.916-2.437,7.55-3.142
		c0.576-0.154,1.006-0.635,1.095-1.225l1.752-11.583h10.452l1.752,11.583c0.089,0.59,0.519,1.071,1.095,1.225
		c2.634,0.705,5.174,1.762,7.55,3.142c0.517,0.302,1.162,0.265,1.644-0.089l9.443-6.961L84.6,22.79l-6.982,9.471
		c-0.353,0.479-0.39,1.122-0.093,1.638c1.363,2.37,2.406,4.898,3.099,7.514c0.153,0.578,0.635,1.009,1.226,1.099l11.65,1.762
		L93.5,54.726L93.5,54.726z"/>
</g>
</svg>
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
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"width="25" height="25"
	 viewBox="0 0 100.25 100.25" style="enable-background:new 0 0 100.25 100.25;" xml:space="preserve" fill="currentColor">
<g>
	<path d="M50,30.5c-10.201,0-18.5,8.299-18.5,18.5S39.799,67.5,50,67.5S68.5,59.201,68.5,49S60.201,30.5,50,30.5z M50,64.5
		c-8.547,0-15.5-6.953-15.5-15.5S41.453,33.5,50,33.5S65.5,40.453,65.5,49S58.547,64.5,50,64.5z"/>
	<path d="M95.225,41.501L83.257,39.69c-0.658-2.218-1.547-4.372-2.651-6.425l7.176-9.733c0.44-0.597,0.378-1.426-0.146-1.951
		l-9.216-9.215c-0.525-0.524-1.354-0.587-1.951-0.147l-9.702,7.152c-2.062-1.12-4.23-2.022-6.466-2.691L58.5,4.776
		C58.389,4.042,57.759,3.5,57.017,3.5H43.985c-0.742,0-1.372,0.542-1.483,1.276L40.701,16.68c-2.236,0.669-4.404,1.572-6.466,2.691
		l-9.702-7.152c-0.597-0.44-1.426-0.378-1.951,0.147l-9.215,9.215c-0.524,0.524-0.587,1.354-0.147,1.951l7.176,9.733
		c-1.104,2.053-1.993,4.207-2.651,6.425L5.777,41.501c-0.734,0.111-1.276,0.741-1.276,1.483v13.032c0,0.742,0.542,1.372,1.275,1.483
		l12.027,1.82c0.665,2.194,1.552,4.319,2.647,6.341l-7.231,9.808c-0.44,0.597-0.377,1.426,0.147,1.951l9.215,9.215
		c0.524,0.525,1.354,0.587,1.951,0.147l9.84-7.254c2.012,1.08,4.124,1.954,6.3,2.607l1.829,12.09
		c0.111,0.734,0.741,1.276,1.483,1.276h13.032c0.742,0,1.372-0.542,1.483-1.276l1.829-12.09c2.176-0.653,4.288-1.527,6.3-2.607
		l9.84,7.254c0.597,0.44,1.426,0.377,1.951-0.147l9.216-9.215c0.524-0.524,0.587-1.354,0.146-1.951L80.55,65.66
		c1.096-2.022,1.983-4.147,2.647-6.341l12.027-1.82c0.733-0.111,1.275-0.741,1.275-1.483V42.984
		C96.5,42.243,95.958,41.612,95.225,41.501z M93.5,54.726l-11.703,1.771c-0.588,0.089-1.068,0.517-1.224,1.09
		c-0.704,2.595-1.748,5.095-3.103,7.432c-0.3,0.517-0.265,1.162,0.09,1.643l7.04,9.549l-7.391,7.391l-9.578-7.061
		c-0.48-0.353-1.122-0.39-1.637-0.093c-2.331,1.339-4.818,2.369-7.395,3.06c-0.575,0.155-1.005,0.635-1.094,1.225l-1.78,11.769
		H45.273l-1.78-11.769c-0.089-0.589-0.519-1.07-1.094-1.225c-2.577-0.691-5.064-1.721-7.395-3.06
		c-0.515-0.296-1.158-0.259-1.637,0.093l-9.578,7.061l-7.391-7.391l7.04-9.549c0.354-0.481,0.39-1.126,0.09-1.643
		c-1.355-2.336-2.399-4.837-3.103-7.432c-0.156-0.574-0.636-1.001-1.224-1.09L7.498,54.726V44.274l11.65-1.762
		c0.591-0.089,1.073-0.521,1.226-1.099c0.693-2.616,1.735-5.144,3.099-7.514c0.297-0.516,0.26-1.159-0.093-1.638l-6.982-9.471
		l7.391-7.391l9.443,6.961c0.481,0.354,1.126,0.39,1.644,0.089c2.375-1.38,4.916-2.437,7.55-3.142
		c0.576-0.154,1.006-0.635,1.095-1.225l1.752-11.583h10.452l1.752,11.583c0.089,0.59,0.519,1.071,1.095,1.225
		c2.634,0.705,5.174,1.762,7.55,3.142c0.517,0.302,1.162,0.265,1.644-0.089l9.443-6.961L84.6,22.79l-6.982,9.471
		c-0.353,0.479-0.39,1.122-0.093,1.638c1.363,2.37,2.406,4.898,3.099,7.514c0.153,0.578,0.635,1.009,1.226,1.099l11.65,1.762
		L93.5,54.726L93.5,54.726z"/>
</g>
</svg>
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
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"width="25" height="25"
	 viewBox="0 0 100.25 100.25" style="enable-background:new 0 0 100.25 100.25;" xml:space="preserve" fill="currentColor">
<g>
	<path d="M50,30.5c-10.201,0-18.5,8.299-18.5,18.5S39.799,67.5,50,67.5S68.5,59.201,68.5,49S60.201,30.5,50,30.5z M50,64.5
		c-8.547,0-15.5-6.953-15.5-15.5S41.453,33.5,50,33.5S65.5,40.453,65.5,49S58.547,64.5,50,64.5z"/>
	<path d="M95.225,41.501L83.257,39.69c-0.658-2.218-1.547-4.372-2.651-6.425l7.176-9.733c0.44-0.597,0.378-1.426-0.146-1.951
		l-9.216-9.215c-0.525-0.524-1.354-0.587-1.951-0.147l-9.702,7.152c-2.062-1.12-4.23-2.022-6.466-2.691L58.5,4.776
		C58.389,4.042,57.759,3.5,57.017,3.5H43.985c-0.742,0-1.372,0.542-1.483,1.276L40.701,16.68c-2.236,0.669-4.404,1.572-6.466,2.691
		l-9.702-7.152c-0.597-0.44-1.426-0.378-1.951,0.147l-9.215,9.215c-0.524,0.524-0.587,1.354-0.147,1.951l7.176,9.733
		c-1.104,2.053-1.993,4.207-2.651,6.425L5.777,41.501c-0.734,0.111-1.276,0.741-1.276,1.483v13.032c0,0.742,0.542,1.372,1.275,1.483
		l12.027,1.82c0.665,2.194,1.552,4.319,2.647,6.341l-7.231,9.808c-0.44,0.597-0.377,1.426,0.147,1.951l9.215,9.215
		c0.524,0.525,1.354,0.587,1.951,0.147l9.84-7.254c2.012,1.08,4.124,1.954,6.3,2.607l1.829,12.09
		c0.111,0.734,0.741,1.276,1.483,1.276h13.032c0.742,0,1.372-0.542,1.483-1.276l1.829-12.09c2.176-0.653,4.288-1.527,6.3-2.607
		l9.84,7.254c0.597,0.44,1.426,0.377,1.951-0.147l9.216-9.215c0.524-0.524,0.587-1.354,0.146-1.951L80.55,65.66
		c1.096-2.022,1.983-4.147,2.647-6.341l12.027-1.82c0.733-0.111,1.275-0.741,1.275-1.483V42.984
		C96.5,42.243,95.958,41.612,95.225,41.501z M93.5,54.726l-11.703,1.771c-0.588,0.089-1.068,0.517-1.224,1.09
		c-0.704,2.595-1.748,5.095-3.103,7.432c-0.3,0.517-0.265,1.162,0.09,1.643l7.04,9.549l-7.391,7.391l-9.578-7.061
		c-0.48-0.353-1.122-0.39-1.637-0.093c-2.331,1.339-4.818,2.369-7.395,3.06c-0.575,0.155-1.005,0.635-1.094,1.225l-1.78,11.769
		H45.273l-1.78-11.769c-0.089-0.589-0.519-1.07-1.094-1.225c-2.577-0.691-5.064-1.721-7.395-3.06
		c-0.515-0.296-1.158-0.259-1.637,0.093l-9.578,7.061l-7.391-7.391l7.04-9.549c0.354-0.481,0.39-1.126,0.09-1.643
		c-1.355-2.336-2.399-4.837-3.103-7.432c-0.156-0.574-0.636-1.001-1.224-1.09L7.498,54.726V44.274l11.65-1.762
		c0.591-0.089,1.073-0.521,1.226-1.099c0.693-2.616,1.735-5.144,3.099-7.514c0.297-0.516,0.26-1.159-0.093-1.638l-6.982-9.471
		l7.391-7.391l9.443,6.961c0.481,0.354,1.126,0.39,1.644,0.089c2.375-1.38,4.916-2.437,7.55-3.142
		c0.576-0.154,1.006-0.635,1.095-1.225l1.752-11.583h10.452l1.752,11.583c0.089,0.59,0.519,1.071,1.095,1.225
		c2.634,0.705,5.174,1.762,7.55,3.142c0.517,0.302,1.162,0.265,1.644-0.089l9.443-6.961L84.6,22.79l-6.982,9.471
		c-0.353,0.479-0.39,1.122-0.093,1.638c1.363,2.37,2.406,4.898,3.099,7.514c0.153,0.578,0.635,1.009,1.226,1.099l11.65,1.762
		L93.5,54.726L93.5,54.726z"/>
</g>
</svg>
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
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"width="25" height="25"
	 viewBox="0 0 100.25 100.25" style="enable-background:new 0 0 100.25 100.25;" xml:space="preserve" fill="currentColor">
<g>
	<path d="M50,30.5c-10.201,0-18.5,8.299-18.5,18.5S39.799,67.5,50,67.5S68.5,59.201,68.5,49S60.201,30.5,50,30.5z M50,64.5
		c-8.547,0-15.5-6.953-15.5-15.5S41.453,33.5,50,33.5S65.5,40.453,65.5,49S58.547,64.5,50,64.5z"/>
	<path d="M95.225,41.501L83.257,39.69c-0.658-2.218-1.547-4.372-2.651-6.425l7.176-9.733c0.44-0.597,0.378-1.426-0.146-1.951
		l-9.216-9.215c-0.525-0.524-1.354-0.587-1.951-0.147l-9.702,7.152c-2.062-1.12-4.23-2.022-6.466-2.691L58.5,4.776
		C58.389,4.042,57.759,3.5,57.017,3.5H43.985c-0.742,0-1.372,0.542-1.483,1.276L40.701,16.68c-2.236,0.669-4.404,1.572-6.466,2.691
		l-9.702-7.152c-0.597-0.44-1.426-0.378-1.951,0.147l-9.215,9.215c-0.524,0.524-0.587,1.354-0.147,1.951l7.176,9.733
		c-1.104,2.053-1.993,4.207-2.651,6.425L5.777,41.501c-0.734,0.111-1.276,0.741-1.276,1.483v13.032c0,0.742,0.542,1.372,1.275,1.483
		l12.027,1.82c0.665,2.194,1.552,4.319,2.647,6.341l-7.231,9.808c-0.44,0.597-0.377,1.426,0.147,1.951l9.215,9.215
		c0.524,0.525,1.354,0.587,1.951,0.147l9.84-7.254c2.012,1.08,4.124,1.954,6.3,2.607l1.829,12.09
		c0.111,0.734,0.741,1.276,1.483,1.276h13.032c0.742,0,1.372-0.542,1.483-1.276l1.829-12.09c2.176-0.653,4.288-1.527,6.3-2.607
		l9.84,7.254c0.597,0.44,1.426,0.377,1.951-0.147l9.216-9.215c0.524-0.524,0.587-1.354,0.146-1.951L80.55,65.66
		c1.096-2.022,1.983-4.147,2.647-6.341l12.027-1.82c0.733-0.111,1.275-0.741,1.275-1.483V42.984
		C96.5,42.243,95.958,41.612,95.225,41.501z M93.5,54.726l-11.703,1.771c-0.588,0.089-1.068,0.517-1.224,1.09
		c-0.704,2.595-1.748,5.095-3.103,7.432c-0.3,0.517-0.265,1.162,0.09,1.643l7.04,9.549l-7.391,7.391l-9.578-7.061
		c-0.48-0.353-1.122-0.39-1.637-0.093c-2.331,1.339-4.818,2.369-7.395,3.06c-0.575,0.155-1.005,0.635-1.094,1.225l-1.78,11.769
		H45.273l-1.78-11.769c-0.089-0.589-0.519-1.07-1.094-1.225c-2.577-0.691-5.064-1.721-7.395-3.06
		c-0.515-0.296-1.158-0.259-1.637,0.093l-9.578,7.061l-7.391-7.391l7.04-9.549c0.354-0.481,0.39-1.126,0.09-1.643
		c-1.355-2.336-2.399-4.837-3.103-7.432c-0.156-0.574-0.636-1.001-1.224-1.09L7.498,54.726V44.274l11.65-1.762
		c0.591-0.089,1.073-0.521,1.226-1.099c0.693-2.616,1.735-5.144,3.099-7.514c0.297-0.516,0.26-1.159-0.093-1.638l-6.982-9.471
		l7.391-7.391l9.443,6.961c0.481,0.354,1.126,0.39,1.644,0.089c2.375-1.38,4.916-2.437,7.55-3.142
		c0.576-0.154,1.006-0.635,1.095-1.225l1.752-11.583h10.452l1.752,11.583c0.089,0.59,0.519,1.071,1.095,1.225
		c2.634,0.705,5.174,1.762,7.55,3.142c0.517,0.302,1.162,0.265,1.644-0.089l9.443-6.961L84.6,22.79l-6.982,9.471
		c-0.353,0.479-0.39,1.122-0.093,1.638c1.363,2.37,2.406,4.898,3.099,7.514c0.153,0.578,0.635,1.009,1.226,1.099l11.65,1.762
		L93.5,54.726L93.5,54.726z"/>
</g>
</svg>
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
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"width="25" height="25"
	 viewBox="0 0 100.25 100.25" style="enable-background:new 0 0 100.25 100.25;" xml:space="preserve" fill="currentColor">
<g>
	<path d="M50,30.5c-10.201,0-18.5,8.299-18.5,18.5S39.799,67.5,50,67.5S68.5,59.201,68.5,49S60.201,30.5,50,30.5z M50,64.5
		c-8.547,0-15.5-6.953-15.5-15.5S41.453,33.5,50,33.5S65.5,40.453,65.5,49S58.547,64.5,50,64.5z"/>
	<path d="M95.225,41.501L83.257,39.69c-0.658-2.218-1.547-4.372-2.651-6.425l7.176-9.733c0.44-0.597,0.378-1.426-0.146-1.951
		l-9.216-9.215c-0.525-0.524-1.354-0.587-1.951-0.147l-9.702,7.152c-2.062-1.12-4.23-2.022-6.466-2.691L58.5,4.776
		C58.389,4.042,57.759,3.5,57.017,3.5H43.985c-0.742,0-1.372,0.542-1.483,1.276L40.701,16.68c-2.236,0.669-4.404,1.572-6.466,2.691
		l-9.702-7.152c-0.597-0.44-1.426-0.378-1.951,0.147l-9.215,9.215c-0.524,0.524-0.587,1.354-0.147,1.951l7.176,9.733
		c-1.104,2.053-1.993,4.207-2.651,6.425L5.777,41.501c-0.734,0.111-1.276,0.741-1.276,1.483v13.032c0,0.742,0.542,1.372,1.275,1.483
		l12.027,1.82c0.665,2.194,1.552,4.319,2.647,6.341l-7.231,9.808c-0.44,0.597-0.377,1.426,0.147,1.951l9.215,9.215
		c0.524,0.525,1.354,0.587,1.951,0.147l9.84-7.254c2.012,1.08,4.124,1.954,6.3,2.607l1.829,12.09
		c0.111,0.734,0.741,1.276,1.483,1.276h13.032c0.742,0,1.372-0.542,1.483-1.276l1.829-12.09c2.176-0.653,4.288-1.527,6.3-2.607
		l9.84,7.254c0.597,0.44,1.426,0.377,1.951-0.147l9.216-9.215c0.524-0.524,0.587-1.354,0.146-1.951L80.55,65.66
		c1.096-2.022,1.983-4.147,2.647-6.341l12.027-1.82c0.733-0.111,1.275-0.741,1.275-1.483V42.984
		C96.5,42.243,95.958,41.612,95.225,41.501z M93.5,54.726l-11.703,1.771c-0.588,0.089-1.068,0.517-1.224,1.09
		c-0.704,2.595-1.748,5.095-3.103,7.432c-0.3,0.517-0.265,1.162,0.09,1.643l7.04,9.549l-7.391,7.391l-9.578-7.061
		c-0.48-0.353-1.122-0.39-1.637-0.093c-2.331,1.339-4.818,2.369-7.395,3.06c-0.575,0.155-1.005,0.635-1.094,1.225l-1.78,11.769
		H45.273l-1.78-11.769c-0.089-0.589-0.519-1.07-1.094-1.225c-2.577-0.691-5.064-1.721-7.395-3.06
		c-0.515-0.296-1.158-0.259-1.637,0.093l-9.578,7.061l-7.391-7.391l7.04-9.549c0.354-0.481,0.39-1.126,0.09-1.643
		c-1.355-2.336-2.399-4.837-3.103-7.432c-0.156-0.574-0.636-1.001-1.224-1.09L7.498,54.726V44.274l11.65-1.762
		c0.591-0.089,1.073-0.521,1.226-1.099c0.693-2.616,1.735-5.144,3.099-7.514c0.297-0.516,0.26-1.159-0.093-1.638l-6.982-9.471
		l7.391-7.391l9.443,6.961c0.481,0.354,1.126,0.39,1.644,0.089c2.375-1.38,4.916-2.437,7.55-3.142
		c0.576-0.154,1.006-0.635,1.095-1.225l1.752-11.583h10.452l1.752,11.583c0.089,0.59,0.519,1.071,1.095,1.225
		c2.634,0.705,5.174,1.762,7.55,3.142c0.517,0.302,1.162,0.265,1.644-0.089l9.443-6.961L84.6,22.79l-6.982,9.471
		c-0.353,0.479-0.39,1.122-0.093,1.638c1.363,2.37,2.406,4.898,3.099,7.514c0.153,0.578,0.635,1.009,1.226,1.099l11.65,1.762
		L93.5,54.726L93.5,54.726z"/>
</g>
</svg>
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
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"width="25" height="25"
	 viewBox="0 0 100.25 100.25" style="enable-background:new 0 0 100.25 100.25;" xml:space="preserve" fill="currentColor">
<g>
	<path d="M50,30.5c-10.201,0-18.5,8.299-18.5,18.5S39.799,67.5,50,67.5S68.5,59.201,68.5,49S60.201,30.5,50,30.5z M50,64.5
		c-8.547,0-15.5-6.953-15.5-15.5S41.453,33.5,50,33.5S65.5,40.453,65.5,49S58.547,64.5,50,64.5z"/>
	<path d="M95.225,41.501L83.257,39.69c-0.658-2.218-1.547-4.372-2.651-6.425l7.176-9.733c0.44-0.597,0.378-1.426-0.146-1.951
		l-9.216-9.215c-0.525-0.524-1.354-0.587-1.951-0.147l-9.702,7.152c-2.062-1.12-4.23-2.022-6.466-2.691L58.5,4.776
		C58.389,4.042,57.759,3.5,57.017,3.5H43.985c-0.742,0-1.372,0.542-1.483,1.276L40.701,16.68c-2.236,0.669-4.404,1.572-6.466,2.691
		l-9.702-7.152c-0.597-0.44-1.426-0.378-1.951,0.147l-9.215,9.215c-0.524,0.524-0.587,1.354-0.147,1.951l7.176,9.733
		c-1.104,2.053-1.993,4.207-2.651,6.425L5.777,41.501c-0.734,0.111-1.276,0.741-1.276,1.483v13.032c0,0.742,0.542,1.372,1.275,1.483
		l12.027,1.82c0.665,2.194,1.552,4.319,2.647,6.341l-7.231,9.808c-0.44,0.597-0.377,1.426,0.147,1.951l9.215,9.215
		c0.524,0.525,1.354,0.587,1.951,0.147l9.84-7.254c2.012,1.08,4.124,1.954,6.3,2.607l1.829,12.09
		c0.111,0.734,0.741,1.276,1.483,1.276h13.032c0.742,0,1.372-0.542,1.483-1.276l1.829-12.09c2.176-0.653,4.288-1.527,6.3-2.607
		l9.84,7.254c0.597,0.44,1.426,0.377,1.951-0.147l9.216-9.215c0.524-0.524,0.587-1.354,0.146-1.951L80.55,65.66
		c1.096-2.022,1.983-4.147,2.647-6.341l12.027-1.82c0.733-0.111,1.275-0.741,1.275-1.483V42.984
		C96.5,42.243,95.958,41.612,95.225,41.501z M93.5,54.726l-11.703,1.771c-0.588,0.089-1.068,0.517-1.224,1.09
		c-0.704,2.595-1.748,5.095-3.103,7.432c-0.3,0.517-0.265,1.162,0.09,1.643l7.04,9.549l-7.391,7.391l-9.578-7.061
		c-0.48-0.353-1.122-0.39-1.637-0.093c-2.331,1.339-4.818,2.369-7.395,3.06c-0.575,0.155-1.005,0.635-1.094,1.225l-1.78,11.769
		H45.273l-1.78-11.769c-0.089-0.589-0.519-1.07-1.094-1.225c-2.577-0.691-5.064-1.721-7.395-3.06
		c-0.515-0.296-1.158-0.259-1.637,0.093l-9.578,7.061l-7.391-7.391l7.04-9.549c0.354-0.481,0.39-1.126,0.09-1.643
		c-1.355-2.336-2.399-4.837-3.103-7.432c-0.156-0.574-0.636-1.001-1.224-1.09L7.498,54.726V44.274l11.65-1.762
		c0.591-0.089,1.073-0.521,1.226-1.099c0.693-2.616,1.735-5.144,3.099-7.514c0.297-0.516,0.26-1.159-0.093-1.638l-6.982-9.471
		l7.391-7.391l9.443,6.961c0.481,0.354,1.126,0.39,1.644,0.089c2.375-1.38,4.916-2.437,7.55-3.142
		c0.576-0.154,1.006-0.635,1.095-1.225l1.752-11.583h10.452l1.752,11.583c0.089,0.59,0.519,1.071,1.095,1.225
		c2.634,0.705,5.174,1.762,7.55,3.142c0.517,0.302,1.162,0.265,1.644-0.089l9.443-6.961L84.6,22.79l-6.982,9.471
		c-0.353,0.479-0.39,1.122-0.093,1.638c1.363,2.37,2.406,4.898,3.099,7.514c0.153,0.578,0.635,1.009,1.226,1.099l11.65,1.762
		L93.5,54.726L93.5,54.726z"/>
</g>
</svg>
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
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"width="25" height="25"
	 viewBox="0 0 100.25 100.25" style="enable-background:new 0 0 100.25 100.25;" xml:space="preserve" fill="currentColor">
<g>
	<path d="M50,30.5c-10.201,0-18.5,8.299-18.5,18.5S39.799,67.5,50,67.5S68.5,59.201,68.5,49S60.201,30.5,50,30.5z M50,64.5
		c-8.547,0-15.5-6.953-15.5-15.5S41.453,33.5,50,33.5S65.5,40.453,65.5,49S58.547,64.5,50,64.5z"/>
	<path d="M95.225,41.501L83.257,39.69c-0.658-2.218-1.547-4.372-2.651-6.425l7.176-9.733c0.44-0.597,0.378-1.426-0.146-1.951
		l-9.216-9.215c-0.525-0.524-1.354-0.587-1.951-0.147l-9.702,7.152c-2.062-1.12-4.23-2.022-6.466-2.691L58.5,4.776
		C58.389,4.042,57.759,3.5,57.017,3.5H43.985c-0.742,0-1.372,0.542-1.483,1.276L40.701,16.68c-2.236,0.669-4.404,1.572-6.466,2.691
		l-9.702-7.152c-0.597-0.44-1.426-0.378-1.951,0.147l-9.215,9.215c-0.524,0.524-0.587,1.354-0.147,1.951l7.176,9.733
		c-1.104,2.053-1.993,4.207-2.651,6.425L5.777,41.501c-0.734,0.111-1.276,0.741-1.276,1.483v13.032c0,0.742,0.542,1.372,1.275,1.483
		l12.027,1.82c0.665,2.194,1.552,4.319,2.647,6.341l-7.231,9.808c-0.44,0.597-0.377,1.426,0.147,1.951l9.215,9.215
		c0.524,0.525,1.354,0.587,1.951,0.147l9.84-7.254c2.012,1.08,4.124,1.954,6.3,2.607l1.829,12.09
		c0.111,0.734,0.741,1.276,1.483,1.276h13.032c0.742,0,1.372-0.542,1.483-1.276l1.829-12.09c2.176-0.653,4.288-1.527,6.3-2.607
		l9.84,7.254c0.597,0.44,1.426,0.377,1.951-0.147l9.216-9.215c0.524-0.524,0.587-1.354,0.146-1.951L80.55,65.66
		c1.096-2.022,1.983-4.147,2.647-6.341l12.027-1.82c0.733-0.111,1.275-0.741,1.275-1.483V42.984
		C96.5,42.243,95.958,41.612,95.225,41.501z M93.5,54.726l-11.703,1.771c-0.588,0.089-1.068,0.517-1.224,1.09
		c-0.704,2.595-1.748,5.095-3.103,7.432c-0.3,0.517-0.265,1.162,0.09,1.643l7.04,9.549l-7.391,7.391l-9.578-7.061
		c-0.48-0.353-1.122-0.39-1.637-0.093c-2.331,1.339-4.818,2.369-7.395,3.06c-0.575,0.155-1.005,0.635-1.094,1.225l-1.78,11.769
		H45.273l-1.78-11.769c-0.089-0.589-0.519-1.07-1.094-1.225c-2.577-0.691-5.064-1.721-7.395-3.06
		c-0.515-0.296-1.158-0.259-1.637,0.093l-9.578,7.061l-7.391-7.391l7.04-9.549c0.354-0.481,0.39-1.126,0.09-1.643
		c-1.355-2.336-2.399-4.837-3.103-7.432c-0.156-0.574-0.636-1.001-1.224-1.09L7.498,54.726V44.274l11.65-1.762
		c0.591-0.089,1.073-0.521,1.226-1.099c0.693-2.616,1.735-5.144,3.099-7.514c0.297-0.516,0.26-1.159-0.093-1.638l-6.982-9.471
		l7.391-7.391l9.443,6.961c0.481,0.354,1.126,0.39,1.644,0.089c2.375-1.38,4.916-2.437,7.55-3.142
		c0.576-0.154,1.006-0.635,1.095-1.225l1.752-11.583h10.452l1.752,11.583c0.089,0.59,0.519,1.071,1.095,1.225
		c2.634,0.705,5.174,1.762,7.55,3.142c0.517,0.302,1.162,0.265,1.644-0.089l9.443-6.961L84.6,22.79l-6.982,9.471
		c-0.353,0.479-0.39,1.122-0.093,1.638c1.363,2.37,2.406,4.898,3.099,7.514c0.153,0.578,0.635,1.009,1.226,1.099l11.65,1.762
		L93.5,54.726L93.5,54.726z"/>
</g>
</svg>
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
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"width="25" height="25"
	 viewBox="0 0 100.25 100.25" style="enable-background:new 0 0 100.25 100.25;" xml:space="preserve" fill="currentColor">
<g>
	<path d="M50,30.5c-10.201,0-18.5,8.299-18.5,18.5S39.799,67.5,50,67.5S68.5,59.201,68.5,49S60.201,30.5,50,30.5z M50,64.5
		c-8.547,0-15.5-6.953-15.5-15.5S41.453,33.5,50,33.5S65.5,40.453,65.5,49S58.547,64.5,50,64.5z"/>
	<path d="M95.225,41.501L83.257,39.69c-0.658-2.218-1.547-4.372-2.651-6.425l7.176-9.733c0.44-0.597,0.378-1.426-0.146-1.951
		l-9.216-9.215c-0.525-0.524-1.354-0.587-1.951-0.147l-9.702,7.152c-2.062-1.12-4.23-2.022-6.466-2.691L58.5,4.776
		C58.389,4.042,57.759,3.5,57.017,3.5H43.985c-0.742,0-1.372,0.542-1.483,1.276L40.701,16.68c-2.236,0.669-4.404,1.572-6.466,2.691
		l-9.702-7.152c-0.597-0.44-1.426-0.378-1.951,0.147l-9.215,9.215c-0.524,0.524-0.587,1.354-0.147,1.951l7.176,9.733
		c-1.104,2.053-1.993,4.207-2.651,6.425L5.777,41.501c-0.734,0.111-1.276,0.741-1.276,1.483v13.032c0,0.742,0.542,1.372,1.275,1.483
		l12.027,1.82c0.665,2.194,1.552,4.319,2.647,6.341l-7.231,9.808c-0.44,0.597-0.377,1.426,0.147,1.951l9.215,9.215
		c0.524,0.525,1.354,0.587,1.951,0.147l9.84-7.254c2.012,1.08,4.124,1.954,6.3,2.607l1.829,12.09
		c0.111,0.734,0.741,1.276,1.483,1.276h13.032c0.742,0,1.372-0.542,1.483-1.276l1.829-12.09c2.176-0.653,4.288-1.527,6.3-2.607
		l9.84,7.254c0.597,0.44,1.426,0.377,1.951-0.147l9.216-9.215c0.524-0.524,0.587-1.354,0.146-1.951L80.55,65.66
		c1.096-2.022,1.983-4.147,2.647-6.341l12.027-1.82c0.733-0.111,1.275-0.741,1.275-1.483V42.984
		C96.5,42.243,95.958,41.612,95.225,41.501z M93.5,54.726l-11.703,1.771c-0.588,0.089-1.068,0.517-1.224,1.09
		c-0.704,2.595-1.748,5.095-3.103,7.432c-0.3,0.517-0.265,1.162,0.09,1.643l7.04,9.549l-7.391,7.391l-9.578-7.061
		c-0.48-0.353-1.122-0.39-1.637-0.093c-2.331,1.339-4.818,2.369-7.395,3.06c-0.575,0.155-1.005,0.635-1.094,1.225l-1.78,11.769
		H45.273l-1.78-11.769c-0.089-0.589-0.519-1.07-1.094-1.225c-2.577-0.691-5.064-1.721-7.395-3.06
		c-0.515-0.296-1.158-0.259-1.637,0.093l-9.578,7.061l-7.391-7.391l7.04-9.549c0.354-0.481,0.39-1.126,0.09-1.643
		c-1.355-2.336-2.399-4.837-3.103-7.432c-0.156-0.574-0.636-1.001-1.224-1.09L7.498,54.726V44.274l11.65-1.762
		c0.591-0.089,1.073-0.521,1.226-1.099c0.693-2.616,1.735-5.144,3.099-7.514c0.297-0.516,0.26-1.159-0.093-1.638l-6.982-9.471
		l7.391-7.391l9.443,6.961c0.481,0.354,1.126,0.39,1.644,0.089c2.375-1.38,4.916-2.437,7.55-3.142
		c0.576-0.154,1.006-0.635,1.095-1.225l1.752-11.583h10.452l1.752,11.583c0.089,0.59,0.519,1.071,1.095,1.225
		c2.634,0.705,5.174,1.762,7.55,3.142c0.517,0.302,1.162,0.265,1.644-0.089l9.443-6.961L84.6,22.79l-6.982,9.471
		c-0.353,0.479-0.39,1.122-0.093,1.638c1.363,2.37,2.406,4.898,3.099,7.514c0.153,0.578,0.635,1.009,1.226,1.099l11.65,1.762
		L93.5,54.726L93.5,54.726z"/>
</g>
</svg>
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
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"width="25" height="25"
	 viewBox="0 0 100.25 100.25" style="enable-background:new 0 0 100.25 100.25;" xml:space="preserve" fill="currentColor">
<g>
	<path d="M50,30.5c-10.201,0-18.5,8.299-18.5,18.5S39.799,67.5,50,67.5S68.5,59.201,68.5,49S60.201,30.5,50,30.5z M50,64.5
		c-8.547,0-15.5-6.953-15.5-15.5S41.453,33.5,50,33.5S65.5,40.453,65.5,49S58.547,64.5,50,64.5z"/>
	<path d="M95.225,41.501L83.257,39.69c-0.658-2.218-1.547-4.372-2.651-6.425l7.176-9.733c0.44-0.597,0.378-1.426-0.146-1.951
		l-9.216-9.215c-0.525-0.524-1.354-0.587-1.951-0.147l-9.702,7.152c-2.062-1.12-4.23-2.022-6.466-2.691L58.5,4.776
		C58.389,4.042,57.759,3.5,57.017,3.5H43.985c-0.742,0-1.372,0.542-1.483,1.276L40.701,16.68c-2.236,0.669-4.404,1.572-6.466,2.691
		l-9.702-7.152c-0.597-0.44-1.426-0.378-1.951,0.147l-9.215,9.215c-0.524,0.524-0.587,1.354-0.147,1.951l7.176,9.733
		c-1.104,2.053-1.993,4.207-2.651,6.425L5.777,41.501c-0.734,0.111-1.276,0.741-1.276,1.483v13.032c0,0.742,0.542,1.372,1.275,1.483
		l12.027,1.82c0.665,2.194,1.552,4.319,2.647,6.341l-7.231,9.808c-0.44,0.597-0.377,1.426,0.147,1.951l9.215,9.215
		c0.524,0.525,1.354,0.587,1.951,0.147l9.84-7.254c2.012,1.08,4.124,1.954,6.3,2.607l1.829,12.09
		c0.111,0.734,0.741,1.276,1.483,1.276h13.032c0.742,0,1.372-0.542,1.483-1.276l1.829-12.09c2.176-0.653,4.288-1.527,6.3-2.607
		l9.84,7.254c0.597,0.44,1.426,0.377,1.951-0.147l9.216-9.215c0.524-0.524,0.587-1.354,0.146-1.951L80.55,65.66
		c1.096-2.022,1.983-4.147,2.647-6.341l12.027-1.82c0.733-0.111,1.275-0.741,1.275-1.483V42.984
		C96.5,42.243,95.958,41.612,95.225,41.501z M93.5,54.726l-11.703,1.771c-0.588,0.089-1.068,0.517-1.224,1.09
		c-0.704,2.595-1.748,5.095-3.103,7.432c-0.3,0.517-0.265,1.162,0.09,1.643l7.04,9.549l-7.391,7.391l-9.578-7.061
		c-0.48-0.353-1.122-0.39-1.637-0.093c-2.331,1.339-4.818,2.369-7.395,3.06c-0.575,0.155-1.005,0.635-1.094,1.225l-1.78,11.769
		H45.273l-1.78-11.769c-0.089-0.589-0.519-1.07-1.094-1.225c-2.577-0.691-5.064-1.721-7.395-3.06
		c-0.515-0.296-1.158-0.259-1.637,0.093l-9.578,7.061l-7.391-7.391l7.04-9.549c0.354-0.481,0.39-1.126,0.09-1.643
		c-1.355-2.336-2.399-4.837-3.103-7.432c-0.156-0.574-0.636-1.001-1.224-1.09L7.498,54.726V44.274l11.65-1.762
		c0.591-0.089,1.073-0.521,1.226-1.099c0.693-2.616,1.735-5.144,3.099-7.514c0.297-0.516,0.26-1.159-0.093-1.638l-6.982-9.471
		l7.391-7.391l9.443,6.961c0.481,0.354,1.126,0.39,1.644,0.089c2.375-1.38,4.916-2.437,7.55-3.142
		c0.576-0.154,1.006-0.635,1.095-1.225l1.752-11.583h10.452l1.752,11.583c0.089,0.59,0.519,1.071,1.095,1.225
		c2.634,0.705,5.174,1.762,7.55,3.142c0.517,0.302,1.162,0.265,1.644-0.089l9.443-6.961L84.6,22.79l-6.982,9.471
		c-0.353,0.479-0.39,1.122-0.093,1.638c1.363,2.37,2.406,4.898,3.099,7.514c0.153,0.578,0.635,1.009,1.226,1.099l11.65,1.762
		L93.5,54.726L93.5,54.726z"/>
</g>
</svg>
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
                                    <select class="form-control membertype" name="member_type" id="member_type"  disabled="disabled">

                                        {{-- <option >Select</option> --}}
                                        <option value="Aktive">Aktive</option>

                                        <option value="Aktiv Evigvarende">Aktiv Evigvarende</option>

                                        <option value="Aktiv Livsvarig">Aktiv Livsvarig</option>

                                        <option value="Eldre Junior">Eldre Junior</option>

                                        <option value="Junior">Junior</option>

                                        <option value="Passiv">Passiv</option>

                                        <option value="Slettet">Slettet</option>

                                        <option value="Sponsor">Sponsor</option>

                                        <option value="Andel uten medlemskap">Andel uten medlemskap</option>

                                        <option value="Midlertidig Medlem">Midlertidig Medlem</option>

                                        <option value="Aktiv Uten Spillerett">Aktiv Uten Spillerett</option>

                                        <option value="Andel venteliste">Andel venteliste</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                 <div class="card">
                    <div class="card-header" id="headingShareType">
                    <h2 class="mb-0">
                        <button class="d-flex align-items-center justify-content-between btn btn-link collapsed" data-toggle="collapse" data-target="#collapseShareType" aria-expanded="false" aria-controls="collapseShareType">
                       Share Type
                        <span class="fa-stack fa-2x">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"width="25" height="25"
	 viewBox="0 0 100.25 100.25" style="enable-background:new 0 0 100.25 100.25;" xml:space="preserve" fill="currentColor">
<g>
	<path d="M50,30.5c-10.201,0-18.5,8.299-18.5,18.5S39.799,67.5,50,67.5S68.5,59.201,68.5,49S60.201,30.5,50,30.5z M50,64.5
		c-8.547,0-15.5-6.953-15.5-15.5S41.453,33.5,50,33.5S65.5,40.453,65.5,49S58.547,64.5,50,64.5z"/>
	<path d="M95.225,41.501L83.257,39.69c-0.658-2.218-1.547-4.372-2.651-6.425l7.176-9.733c0.44-0.597,0.378-1.426-0.146-1.951
		l-9.216-9.215c-0.525-0.524-1.354-0.587-1.951-0.147l-9.702,7.152c-2.062-1.12-4.23-2.022-6.466-2.691L58.5,4.776
		C58.389,4.042,57.759,3.5,57.017,3.5H43.985c-0.742,0-1.372,0.542-1.483,1.276L40.701,16.68c-2.236,0.669-4.404,1.572-6.466,2.691
		l-9.702-7.152c-0.597-0.44-1.426-0.378-1.951,0.147l-9.215,9.215c-0.524,0.524-0.587,1.354-0.147,1.951l7.176,9.733
		c-1.104,2.053-1.993,4.207-2.651,6.425L5.777,41.501c-0.734,0.111-1.276,0.741-1.276,1.483v13.032c0,0.742,0.542,1.372,1.275,1.483
		l12.027,1.82c0.665,2.194,1.552,4.319,2.647,6.341l-7.231,9.808c-0.44,0.597-0.377,1.426,0.147,1.951l9.215,9.215
		c0.524,0.525,1.354,0.587,1.951,0.147l9.84-7.254c2.012,1.08,4.124,1.954,6.3,2.607l1.829,12.09
		c0.111,0.734,0.741,1.276,1.483,1.276h13.032c0.742,0,1.372-0.542,1.483-1.276l1.829-12.09c2.176-0.653,4.288-1.527,6.3-2.607
		l9.84,7.254c0.597,0.44,1.426,0.377,1.951-0.147l9.216-9.215c0.524-0.524,0.587-1.354,0.146-1.951L80.55,65.66
		c1.096-2.022,1.983-4.147,2.647-6.341l12.027-1.82c0.733-0.111,1.275-0.741,1.275-1.483V42.984
		C96.5,42.243,95.958,41.612,95.225,41.501z M93.5,54.726l-11.703,1.771c-0.588,0.089-1.068,0.517-1.224,1.09
		c-0.704,2.595-1.748,5.095-3.103,7.432c-0.3,0.517-0.265,1.162,0.09,1.643l7.04,9.549l-7.391,7.391l-9.578-7.061
		c-0.48-0.353-1.122-0.39-1.637-0.093c-2.331,1.339-4.818,2.369-7.395,3.06c-0.575,0.155-1.005,0.635-1.094,1.225l-1.78,11.769
		H45.273l-1.78-11.769c-0.089-0.589-0.519-1.07-1.094-1.225c-2.577-0.691-5.064-1.721-7.395-3.06
		c-0.515-0.296-1.158-0.259-1.637,0.093l-9.578,7.061l-7.391-7.391l7.04-9.549c0.354-0.481,0.39-1.126,0.09-1.643
		c-1.355-2.336-2.399-4.837-3.103-7.432c-0.156-0.574-0.636-1.001-1.224-1.09L7.498,54.726V44.274l11.65-1.762
		c0.591-0.089,1.073-0.521,1.226-1.099c0.693-2.616,1.735-5.144,3.099-7.514c0.297-0.516,0.26-1.159-0.093-1.638l-6.982-9.471
		l7.391-7.391l9.443,6.961c0.481,0.354,1.126,0.39,1.644,0.089c2.375-1.38,4.916-2.437,7.55-3.142
		c0.576-0.154,1.006-0.635,1.095-1.225l1.752-11.583h10.452l1.752,11.583c0.089,0.59,0.519,1.071,1.095,1.225
		c2.634,0.705,5.174,1.762,7.55,3.142c0.517,0.302,1.162,0.265,1.644-0.089l9.443-6.961L84.6,22.79l-6.982,9.471
		c-0.353,0.479-0.39,1.122-0.093,1.638c1.363,2.37,2.406,4.898,3.099,7.514c0.153,0.578,0.635,1.009,1.226,1.099l11.65,1.762
		L93.5,54.726L93.5,54.726z"/>
</g>
</svg>
                        </span>
                        </button>
                    </h2>
                    </div>
                    <div id="collapseShareType" class="collapse" aria-labelledby="headingShareType" data-parent="#accordion">
                        <div class="card-body">
                            <div class="custom-control custom-checkbox bottomsclass">
                                <input type="checkbox" class="custom-control-input" id="sharetypecheck">
                                <label class="custom-control-label" for="sharetypecheck">Share Type</label>
                            </div>
                            <div class="row bottomsclass">
                                <div class="col-sm-4" style="float: left;">
                                    <label for="">Share Type:</label>
                                </div>
                                <div class="col-sm-8" style="float: left;">
                                    <select class="form-control sharetype" name="share_type" id="share_type"  disabled="disabled">

                                        {{-- <option >Select</option> --}}
                                        <option value="A-Share">A-Share</option>
                                        <option value="B-Share">B-Share</option>
                                        <option value="Unknown Type">Unknown Type</option>
                                        <option value="Old Share">Old Share</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header" id="headingShareNo">
                    <h2 class="mb-0">
                        <button class="d-flex align-items-center justify-content-between btn btn-link collapsed" data-toggle="collapse" data-target="#collapseShareNo" aria-expanded="false" aria-controls="collapseShareNo">
                        Share Number
                        <span class="fa-stack fa-2x">
                            <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="25" height="25"
	 viewBox="0 0 100.25 100.25" style="enable-background:new 0 0 100.25 100.25;" xml:space="preserve" fill="currentColor">
<g>
	<path d="M50,30.5c-10.201,0-18.5,8.299-18.5,18.5S39.799,67.5,50,67.5S68.5,59.201,68.5,49S60.201,30.5,50,30.5z M50,64.5
		c-8.547,0-15.5-6.953-15.5-15.5S41.453,33.5,50,33.5S65.5,40.453,65.5,49S58.547,64.5,50,64.5z"/>
	<path d="M95.225,41.501L83.257,39.69c-0.658-2.218-1.547-4.372-2.651-6.425l7.176-9.733c0.44-0.597,0.378-1.426-0.146-1.951
		l-9.216-9.215c-0.525-0.524-1.354-0.587-1.951-0.147l-9.702,7.152c-2.062-1.12-4.23-2.022-6.466-2.691L58.5,4.776
		C58.389,4.042,57.759,3.5,57.017,3.5H43.985c-0.742,0-1.372,0.542-1.483,1.276L40.701,16.68c-2.236,0.669-4.404,1.572-6.466,2.691
		l-9.702-7.152c-0.597-0.44-1.426-0.378-1.951,0.147l-9.215,9.215c-0.524,0.524-0.587,1.354-0.147,1.951l7.176,9.733
		c-1.104,2.053-1.993,4.207-2.651,6.425L5.777,41.501c-0.734,0.111-1.276,0.741-1.276,1.483v13.032c0,0.742,0.542,1.372,1.275,1.483
		l12.027,1.82c0.665,2.194,1.552,4.319,2.647,6.341l-7.231,9.808c-0.44,0.597-0.377,1.426,0.147,1.951l9.215,9.215
		c0.524,0.525,1.354,0.587,1.951,0.147l9.84-7.254c2.012,1.08,4.124,1.954,6.3,2.607l1.829,12.09
		c0.111,0.734,0.741,1.276,1.483,1.276h13.032c0.742,0,1.372-0.542,1.483-1.276l1.829-12.09c2.176-0.653,4.288-1.527,6.3-2.607
		l9.84,7.254c0.597,0.44,1.426,0.377,1.951-0.147l9.216-9.215c0.524-0.524,0.587-1.354,0.146-1.951L80.55,65.66
		c1.096-2.022,1.983-4.147,2.647-6.341l12.027-1.82c0.733-0.111,1.275-0.741,1.275-1.483V42.984
		C96.5,42.243,95.958,41.612,95.225,41.501z M93.5,54.726l-11.703,1.771c-0.588,0.089-1.068,0.517-1.224,1.09
		c-0.704,2.595-1.748,5.095-3.103,7.432c-0.3,0.517-0.265,1.162,0.09,1.643l7.04,9.549l-7.391,7.391l-9.578-7.061
		c-0.48-0.353-1.122-0.39-1.637-0.093c-2.331,1.339-4.818,2.369-7.395,3.06c-0.575,0.155-1.005,0.635-1.094,1.225l-1.78,11.769
		H45.273l-1.78-11.769c-0.089-0.589-0.519-1.07-1.094-1.225c-2.577-0.691-5.064-1.721-7.395-3.06
		c-0.515-0.296-1.158-0.259-1.637,0.093l-9.578,7.061l-7.391-7.391l7.04-9.549c0.354-0.481,0.39-1.126,0.09-1.643
		c-1.355-2.336-2.399-4.837-3.103-7.432c-0.156-0.574-0.636-1.001-1.224-1.09L7.498,54.726V44.274l11.65-1.762
		c0.591-0.089,1.073-0.521,1.226-1.099c0.693-2.616,1.735-5.144,3.099-7.514c0.297-0.516,0.26-1.159-0.093-1.638l-6.982-9.471
		l7.391-7.391l9.443,6.961c0.481,0.354,1.126,0.39,1.644,0.089c2.375-1.38,4.916-2.437,7.55-3.142
		c0.576-0.154,1.006-0.635,1.095-1.225l1.752-11.583h10.452l1.752,11.583c0.089,0.59,0.519,1.071,1.095,1.225
		c2.634,0.705,5.174,1.762,7.55,3.142c0.517,0.302,1.162,0.265,1.644-0.089l9.443-6.961L84.6,22.79l-6.982,9.471
		c-0.353,0.479-0.39,1.122-0.093,1.638c1.363,2.37,2.406,4.898,3.099,7.514c0.153,0.578,0.635,1.009,1.226,1.099l11.65,1.762
		L93.5,54.726L93.5,54.726z"/>
</g>
</svg>
                        </span>
                        </button>
                    </h2>
                    </div>
                    <div id="collapseShareNo" class="collapse" aria-labelledby="headingShareNo" data-parent="#accordion">
                        <div class="card-body">
                            <!-- Default unchecked -->
                            <div class="custom-control custom-checkbox bottomsclass">
                                <input type="checkbox"  class="custom-control-input" id="sharenocheck">
                                <label class="custom-control-label" for="sharenocheck">Share Number</label>
                            </div>
                            <div class="row bottomsclass">
                                <div class="col-sm-4" style="float: left;">
                                    <label for="">From:</label>
                                </div>
                                <div class="col-sm-8" style="float: left;">
                                    <input type="text" data-text="sharenofrom" class="shareno sharenofrom" disabled name="" id="">
                                </div>
                            </div>
                            <div class="row bottomsclass">
                                <div class="col-sm-4" style="float: left;">
                                    <label for="">To:</label>
                                </div>
                                <div class="col-sm-8" style="float: left;">
                                    <input type="text" data-text="sharenoto" class="shareno sharenoto" disabled name="" id="">
                                </div>
                            </div>
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

<div id=""  class="" style="width: 20cm;height: 29.7cm; display:none"  >
    <div class="container selected_single_print_row">
        <div class="row" id="selected_single_print_row">
        </div>

   </div>
</div>
{{-- <table class="singel_printed_table"><table> --}}
@push('script2')
    <script>
    $(document).on('change','#select_all_checkbox',function () {
        $(".select_box").prop('checked', $(this).prop("checked"));
    });
    // Single print select
      $(document).on('click','#multi_print',function (e) {
            // var headers = $("span",$("#printed_table")).map(function() {
            //     return this.innerHTML;
            // }).get();
            var row = [];
            var fields = [];
            // $("#multi_print input:checkbox:checked",this).map(function() {
            //     return this.innerHTML;
            // }).get()

            // alert(row);
            // console.log(_token);
            $.each($("input[name='multiprint[]']:checked"), function(){
                row.push($(this).val());
            });
            $.each($(".selectul .dual-listbox__item"), function(){
                fields.push($(this).attr('data-value'));
            });
            // $( ".selectul" ).each(function( index ) {
            //     fields.push($(this).text());

            // });
                // console.log( fields );
            // alert("My favourite sports are: " + fields.join(','));
            var _token = "{{ csrf_token() }}";
            // console.log(_token);
            $.ajax({
                url:"{{ route('multi') }}",
                method:"POST",
                data:{row,fields,"_token": "{{ csrf_token() }}"},
                dataType: "json",
                success:function(res){
                //    console.log(_token);
                    $('#selected_single_print_row').html(res.members);
                    $("#selected_single_print_row span").each(function(){
                        if($(this).text().length === 0) {
                            $(this).remove();
                            $(this).after('<br>').remove();
                        }
                    });
                    var printContent = document.getElementsByClassName('selected_single_print_row');
                    var mode = 'iframe'; //popup
                    var close = mode == "popup";
                    var options = { mode : mode, popClose : close};
                    $(".selected_single_print_row").printArea( options );
                    // $(".selected_single_print_row").html('');

                }
            });


            // var tab = '<table border="1" style="width: 21cm;height: 29.7cm;"><tr>';
            // var print_list = '';
            // var count = 0;
            // for (let index = 0; index < row.length; index++) {
            //     print_list += '<div class="selected_multi'+index+' selected_multi">';

            //     print_list += '<span>'+row[index]+'</span><br>';


            //     print_list += '</div>';
            //     if(count % 3 == 0 )
            //     {

            //         tab += '</tr><tr>';
            //     }
            //         tab += '<td>'+row[index]+'</td>';
            //     // if(count % 3 == 0 && count !=0)
            //     // {
            //     //     tab +='</tr>';
            //     // }
            //     count ++;


            // }
            // $('#selected_single_print_row').html(tab);
            // console.log(tab);

        })
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
        // var print_list = '<table id="slected_single_table_row" >';
        var print_list = '';
        var array = {};
        var div = 1;
        $('#selected_print_row tr').each(function(index, tr) {
            var lines = $('td', tr).map(function(index, td) {
                array [$(td).attr('data-column')] = $(td).text();
                // return $(td).text();
            });
            // console.log(array);
            print_list += '<div class="selected_single">';
            $.each(array, function( index, value ) {
                // alert( index + ": " + value );

                if(index === 'print'){
                    // alert();
                }
                else{
                    // print_list += '<tr ><td class="'+index+'" style="height:50px;font-size: 25px;">'+value+'<td></tr>';
                    if(value === ''){

                    }
                    else{
                        print_list += '<span>'+value+'</span><br>';
                        // print_list += '<tr ><td class="'+index+'" style="height:50px;font-size: 25px;">'+value+'<td></tr>';
                    }
                }
            });
            print_list += '</div>';
            $('#selected_single_print_row').html(print_list);

            // var printContent = document.getElementById('selected_single_print_row');
            // var mode = 'iframe'; //popup
            // var close = mode == "popup";
            // var options = { mode : mode, popClose : close};
            // $("#selected_single_print_row").printArea( options );
        });
        print_list += '</table >';
        // var numItems = $('.selected_single').length;
        var output = '<table>';
        var x = 0;
        // for(var i = 0; i < numItems;i++ ){
        //     // console.log(i);
        //     output += '<tr>';
        //     if(x == 1)
        //     {
        //         output += '</tr><tr>';
        //     }

        //     output += '<td>'+i+'</td>';
        //     x++;


        // }
        output += '<tr>';
        // var td = 1;
        for(var i = 0;i<3;i++){
            output += '<td><td>';
        }
        output += '</tr>';
        output += '</table>';
        console.log(output);

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
        // $("#selected_single_print_row span").empty();
        // if($('#selected_single_print_row span').text().length == 0){
        //     $(this).remove();
        // }
        // else{
        //     console.log('text');
        // }
        $("#selected_single_print_row span").each(function(){
            // if($(this).text().length === 0) {
            //     $(this).remove();
            //     $(this).after('<br>').remove();
            // }
        });
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
        // var printContent = document.getElementById('selected_single_print_row');
        // var mode = 'iframe'; //popup
        // var close = mode == "popup";
        // var options = { mode : mode, popClose : close};
        // $("#selected_single_print_row").printArea( options );

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
            if($('#sharetypecheck').prop("checked") == true){

                var share_type = $("#share_type option:selected").val();
                selected_data['share_type'] =share_type;
                // console.log(member_type);
                var mesage = $("#share_type option:selected").text();
                if(mesage != 'Select'){

                    if ($('#sharetypecheck_span').hasClass('sharetypecheck_span')) {
                        $('#sharetypecheck_span').remove();
                        $('#filter_by_display').append('<span id="sharetypecheck_span" class="sharetypecheck_span">Filter By Member Type: '+mesage+'</span>');
                    }
                    else{
                        $('#filter_by_display').append('<span id="sharetypecheck_span" class="sharetypecheck_span">Filter By Share Type: '+mesage+'</span>');
                    }
                }


            }
            else{
                $('#sharetypecheck_span').remove();
            }
            if($('#sharenocheck').prop("checked") == true){
                var sharenofrom = $('.sharenofrom').val();
                var sharenoto = $('.sharenoto').val();
                selected_data['sharenofrom'] =sharenofrom;
                selected_data['sharenoto'] = sharenoto;
                if(sharenofrom != '' && sharenoto != '' ){
                    if ($('#sharenocheck_span').hasClass('sharenocheck_span')) {
                        $('#sharenocheck_span').remove();
                        $('#filter_by_display').append('<span id="sharenocheck_span" class="sharenocheck_span">Filter By Share Number From: '+sharenofrom+' To: '+sharenoto+'</span>');
                    }
                    else{
                        $('#filter_by_display').append('<span id="sharenocheck_span" class="sharenocheck_span">Filter By Share Number From: '+sharenofrom+' To: '+sharenoto+'</span>');
                    }
                }

            }
            else{
                $('#sharenocheck_span').remove();
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

            }
            if($('#sharetypecheck').prop("checked") == true){

                var share_type = $("#share_type option:selected").val();
                selected_data['share_type'] =share_type;

            }
            if($('#sharenocheck').prop("checked") == true){
                var sharenofrom = $('.sharenofrom').val();
                var sharenoto = $('.sharenoto').val();
                selected_data['sharenofrom'] =sharenofrom;
                selected_data['sharenoto'] = sharenoto;

                // if ($('#hcpcheck_span').hasClass('hcpcheck_span')) {
                //     $('#hcpcheck_span').remove();
                //     $('#filter_by_display').append('<span id="hcpcheck_span" class="hcpcheck_span">Filter By HCP From: '+hcpfrom+' To: '+hcpto+'</span>');
                // }
                // else{
                //     $('#filter_by_display').append('<span id="hcpcheck_span" class="hcpcheck_span">Filter By HCP From: '+hcpfrom+' To: '+hcpto+'</span>');
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
            if($('#sharetypecheck').prop("checked") == true){

                var share_type = $("#share_type option:selected").val();
                selected_data['share_type'] =share_type;
                // console.log(member_type);
                var mesage = $("#share_type option:selected").text();
                if(mesage != 'Select'){

                    if ($('#sharetypecheck_span').hasClass('sharetypecheck_span')) {
                        $('#sharetypecheck_span').remove();
                        $('#filter_by_display').append('<span id="sharetypecheck_span" class="sharetypecheck_span">Filter By Share Type: '+mesage+'</span>');
                    }
                    else{
                        $('#filter_by_display').append('<span id="sharetypecheck_span" class="sharetypecheck_span">Filter By Share Type: '+mesage+'</span>');
                    }
                }


            }
            else{
                $('#sharetypecheck_span').remove();
            }
            if($('#sharenocheck').prop("checked") == true){
                var sharenofrom = $('.sharenofrom').val();
                var sharenoto = $('.sharenoto').val();
                selected_data['sharenofrom'] =sharenofrom;
                selected_data['sharenoto'] = sharenoto;
                if(sharenofrom != '' && sharenoto != '' ){
                    if ($('#sharenocheck_span').hasClass('sharenocheck_span')) {
                        $('#sharenocheck_span').remove();
                        $('#filter_by_display').append('<span id="sharenocheck_span" class="sharenocheck_span">Filter By Share Number From: '+sharenofrom+' To: '+sharenoto+'</span>');
                    }
                    else{
                        $('#filter_by_display').append('<span id="sharenocheck_span" class="sharenocheck_span">Filter By Share Number From: '+sharenofrom+' To: '+sharenoto+'</span>');
                    }
                }

            }
            else{
                $('#sharenocheck_span').remove();
            }
            var _token = "{{ csrf_token() }}";
            console.log(selected_data);
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
    $(document).on('click','#sharenocheck',function (e) {
        // e.preventDefault();
        if($(this).prop("checked") == true){
            $('.shareno').removeAttr('disabled');

        }
        else if($(this).prop("checked") == false){

            $('.shareno').attr('disabled',true);

        }
    });
    $(document).on('click','#sharetypecheck',function (e) {
        // e.preventDefault();
        if($(this).prop("checked") == true){
            $('.sharetype').removeAttr('disabled');

        }
        else if($(this).prop("checked") == false){

            $('.sharetype').attr('disabled',true);

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
            // console.log(selectas);
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
        var selected_array = [];
        $('.list li').each(function()
        {
            var th = $(this);
            var selectas = th.text();
            $('.selectul li').each(function()
                {
                    var th2 = $(this);
                    var selectas2 = th2.text();
                    // Duplicate remove the li
                    if(selectas != selectas2)
                    {
                        console.log('All Ready Added');
                    }
                    else{
                        th2.remove();
                    }
            });
        });

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
        // $(document).on('click','#select_all_checkbox',function(e){
        //     $('input:checkbox').not(this).prop('checked', this.checked);
        // });

        // $(document).on('click','.alpha',function (e) {
        //     e.preventDefault();
        //     var alpa = $(this).text();
        //     $('#searchkey').val(alpa);
        //     $('#search').trigger('click');
        // })


    </script>
@endpush
