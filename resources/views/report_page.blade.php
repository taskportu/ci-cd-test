@extends('layout')
@section('home')
@include('menu')
@push('style')
<style> 
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
</style>
   
@endpush
<div class="container">
    {{-- <h3 class="text-center">Report Generation</h3> --}}
    <br>
    <div class="row">
        {{-- <div class="col text-center">
            <font class="alpha" face="verdana" size="4"><b>A</b></font>
            <font class="alpha" face="verdana" size="4"><b>B</b></font>
            <font class="alpha" face="verdana" size="4"><b>C</b></font>
            <font class="alpha" face="verdana" size="4"><b>D</b></font>
            <font class="alpha" face="verdana" size="4"><b>E</b></font>
            <font class="alpha" face="verdana" size="4"><b>F</b></font>
            <font class="alpha" face="verdana" size="4"><b>G</b></font>
            <font class="alpha" face="verdana" size="4"><b>H</b></font>
            <font class="alpha" face="verdana" size="4"><b>I</b></font>
            <font class="alpha" face="verdana" size="4"><b>J</b></font>
            <font class="alpha" face="verdana" size="4"><b>K</b></font>
            <font class="alpha" face="verdana" size="4"><b>L</b></font>
            <font class="alpha" face="verdana" size="4"><b>M</b></font>
            <font class="alpha" face="verdana" size="4"><b>N</b></font>
            <font class="alpha" face="verdana" size="4"><b>O</b></font>
            <font class="alpha" face="verdana" size="4"><b>P</b></font>
            <font class="alpha" face="verdana" size="4"><b>Q</b></font>
            <font class="alpha" face="verdana" size="4"><b>R</b></font>
            <font class="alpha" face="verdana" size="4"><b>S</b></font>
            <font class="alpha" face="verdana" size="4"><b>T</b></font>
            <font class="alpha" face="verdana" size="4"><b>U</b></font>
            <font class="alpha" face="verdana" size="4"><b>V</b></font>
            <font class="alpha" face="verdana" size="4"><b>W</b></font>
            <font class="alpha" face="verdana" size="4"><b>X</b></font>
            <font class="alpha" face="verdana" size="4"><b>Z</b></font>
            <font class="alpha" face="verdana" size="4"><b>Y</b></font>
        </div> --}}
    </div>
    <div class="row" style="margin-left: 3px;">
        <br>
        <form class="form-inline">
            <div class="form-group mb-2">
               <label for="exampleFormControlSelect1" style="margin-top: 27px;"><h6 style="font-family: sans-serif;font-size: 18px;font-weight: 700;">Search for</h6></label>
            </div>
            <div class="form-group mx-sm-3 mb-2">
                <div class="dropdown">
                    <button id="dLabel" class="dropdown-select" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Select
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dLabel">
                        <li >Select</li>
                        <li data-value="OccID">OccID</li>
                        <li data-value="Member_Fistname">First Name</li>
                        <li data-value="Member_lastname" >Last Name</li>
                        <li  >Alphabetic</li>

                    </ul>
                </div>
            </div>
            <div class="form-group mx-sm-3 mb-2">
                <input type="text" id="searchkey" class="form-control" style="margin-top: 24px;" >
            </div>
            <div class="form-group mx-sm-3 mb-2">
                <button type="submit" style="margin-top: 24px;" class="btn btn-primary" id="search">Search</button>
            </div>
        </form>
    </div>
    <div class="rows mt-4" >
        <div class="center col-12">
            <p class="float-sm-right pcursor print-excel" style="" id="print">PRINT</p>
            <span class="float-sm-right pcursor" style="margin-left: 5px;margin-right: 5px;">*</span>
            <p class="float-sm-right print-excel"   id="excel" >EXCEL</p>
            <a href="" id="download-excel" class="download-excel" hidden ></a>
        </div>
        <div id="printview">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">OccID</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">HCP</th>
                    </tr>
                </thead>
                <tbody id="result">
                </tbody>
            </table>
        </div>
    </div>
</div>
{{-- <div id="userInfo" ></div> --}}
@push('script2')
    <script src="/js/jquery.PrintArea.js" type="text/JavaScript" language="javascript"></script>
    <script>
        // Excel to Export Excel 
        $(document).on('click','#excel',function (e) { 
            e.preventDefault();
            var _token = "{{ csrf_token() }}";
            var searchkey = $('#searchkey').val();
            var selectedkey = $('#dLabel').attr('data-selected');
            $.ajax({
                url: "{{ route('exportdata') }}",
                data:{ searchkey:searchkey,selectedkey:selectedkey,_token:_token },
                success:function(res){
                    console.log(res);
                    $('#download-excel').attr('href',res);
                    $('.download-excel')[0].click();
                    
                }
            });
        })
        // print butoon
        $(document).on('click','#print',function (e) { 
            e.preventDefault();
            var _token = "{{ csrf_token() }}";
            var searchkey = $('#searchkey').val();
            var selectedkey = $('#dLabel').attr('data-selected');
            $.ajax({
                url: "{{ route('printdetails') }}",
                method:"POST",
                data:{ searchkey:searchkey,selectedkey:selectedkey,_token:_token },
                success:function(res){
                    // console.log(res);
                    $('#result').html(res);
                    var printContent = document.getElementById('userInfo');
                    // $('#userInfo').html(res);
                    
                    // var WinPrint = window.open('', '', '');
                    // WinPrint.document.write(printContent.innerHTML);
                    // // WinPrint.document.close();
                    // WinPrint.focus();
                    // WinPrint.print();
                    // WinPrint.close();

                    var mode = 'iframe'; //popup
                    var close = mode == "popup";
                    var options = { mode : mode, popClose : close};
                    $("#printview").printArea( options );

                }
            });
        })
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