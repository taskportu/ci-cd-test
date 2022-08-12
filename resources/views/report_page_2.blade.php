@extends('layout')
@section('home')
@include('menu')
@push('link')
    <!-- Datatable CSS -->
    <link href='/DataTables/datatables.min.css' rel='stylesheet' type='text/css'>
@endpush
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
        <div class="center">
            <p id="print">PRINT</p>
        </div>
        <div id="printview">
            <table class="class='display dataTable'" id="laravel_datatable">
                <thead>
                    <tr>
                        <th scope="col">OccID</th>
                        <th scope="col">First Name</th>
                        <th scope="col">Last Name</th>
                        <th scope="col">HCP</th>
                    </tr>
                </thead>
               
            </table>
        </div>
    </div>
</div>
{{-- <div id="userInfo" ></div> --}}
@push('script2')
    <!-- Datatable JS -->
    {{-- <script src="/DataTables/datatables.min.js"></script> --}}
    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.1/js/buttons.print.min.js"></script>
    <script>
        $(document).ready( function () {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#laravel_datatable').DataTable({
                processing: true,
                serverSide: true,
                'searching': false,
                dom: 'Bfrtip',
                 buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ],
                ajax: {
                    url: "{{ route('databledata') }}",
                    type: 'POST',
                    data: function (d) {
                        d.searchkey = $('#searchkey').val();
                        d.selectedkey = $('#dLabel').attr('data-selected');
                    }
                    // data:{searchkey:searchkey,selectedkey:selectedkey}
                },
                columns: [
                        { data: 'OccID', name: 'OccID' },
                        { data: 'Member_Fistname', name: 'Member_Fistname' },
                        { data: 'Member_Lastname', name: 'Member_Lastname' },
                        { data: 'HCP', name: 'HCP' }
                    ]
            });
        });
        
        $('#search').click(function(){
            // var searchkey = $('#searchkey').val();
            // var selectedkey = $('#dLabel').attr('data-selected');
            $('#laravel_datatable').DataTable().draw(true);
        });

        // sdsddsdsdsd
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
    </script>
@endpush