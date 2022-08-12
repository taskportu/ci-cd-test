@extends('layout')
@section('home')
    @if(Session::has('kiosk_mode'))
    @include('reg_menu')
    @else
    @include('menu')
    @endif
    <style>
        .notphone {
            background-color: #ffffb2;
        }
    </style>
    <div class="container">
        <h3 class="text-center">Guest</h3>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th scope="col">Phone</th>
                <th scope="col">Name</th>
                <th scope="col">Times played</th>
            </tr>
            </thead>
            <tbody>
            @php
                //foreach($phone as $gs):
             //echo htmlentities(substr($gs->reg_fistname,0,4)).'<br>';
            // endforeach;
            @endphp
            @php ($i = 0)
            @foreach($phone as $g)
                @php ($i++)
                <!--{{str_limit(strtoupper( $g->reg_fistname),4,'')}}-->
                <tr class="{{ ($g->reg_phone ? 'havephone' : 'notphone') }}"
                    data-name="{{str_limit(strtoupper( $g->reg_fistname),4,'')}}{{str_limit(strtoupper( $g->reg_lastname),4,'')}}"
                    data-phone="{{ ($g->reg_phone ? $g->reg_phone :$i) }}">
                    <td data-toggle="tooltip" data-html="true" data-placement="top"
                        title="Club -{{$g->reg_club}} <br> HCP - {{$g->reg_hcp}} <br> Tlf - {{$g->reg_phone}}">{{$g->reg_phone}}</td>
                    <td data-toggle="tooltip" data-html="true" data-placement="top"
                        title="Club -{{$g->reg_club}} <br> HCP - {{$g->reg_hcp}} <br> Tlf - {{$g->reg_phone}}">{{ucfirst( $g->reg_fistname)}} {{ucfirst($g->reg_lastname)}}</td>
                    <td data-toggle="tooltip" data-html="true" data-placement="top"
                        title="Club -{{$g->reg_club}} <br> HCP - {{$g->reg_hcp}} <br> Tlf - {{$g->reg_phone}}">{{$g->counts}}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <script>
        //phone number search
        $(document).ready(function () {
            var seen = {};
            $('.havephone').each(function (index, element) {
                var txt = $(this).children('td').eq(0).html();

                if (seen[txt]) {

                    var countval = $(this).children('td').eq(2).html();//count total
                    var phone = $(this).children('td').eq(0).html();//phone
                    findphone(countval, phone);
                    $(this).children('td').hide();
                    //console.log(txt +'count'+countval);
                } else {
                    seen[txt] = true;

                }
            });
        });

        // not phonenumer
        /*$( document ).ready(function() {
            var seen  = {};
        $('.notphone').each(function(index, element) {
           var txt = $(this).data('name');

                    if (seen[txt])
                    {

                            var countval = $(this).children('td').eq(2).html();
                            //var phone = $(this).children('td').eq(0).html();
                            var name =$(this).data('name');
                            //var phone = phone==''?'':phone;
                            findnothavephone(countval,name);
                            $(this).children('td').hide();
                            //console.log(countval+'ghf'+name);
                        }

                    else
                    {
                        seen[txt] = true;

                    }
            });



        });*/
        //all member
        $(document).ready(function () {
            var seen = {};
            $('[data-name]').each(function (index, element) {
                var txt = $(this).data('name');
                if (seen[txt]) {
                    var countval = $(this).children('td').eq(2).html();
                    var name = $(this).data('name');
                    var phone = $(this).children('td').eq(0).html();
                    findallname(countval, name, phone);
                    $(this).children('td').remove();
                    //console.log(countval+'name='+name+'phone='+phone);
                } else {
                    seen[txt] = true;
                }
            });
        });

        function findphone(countval, phone) {
            //console.log(countval+'phone'+phone);
            var get = parseInt($('table').find("[data-phone='" + phone + "']").children('td').eq(2).html());
            var cc = parseInt(countval);
            var sum = parseInt(get + cc);
            $('table').find("[data-phone='" + phone + "']").children('td').eq(2).html(sum);

        }

        //RICHBJER

        function findnothavephone(countval, name) {

            var get = parseInt($('table').find("[data-name='" + name + "']").children('td').eq(2).html());
            var getid = parseInt(countval);
            var sum = parseInt(get + getid);
            $('table').find("[data-name='" + name + "']").children('td').eq(2).html(sum);
        }


        function findallname(countval, name, phone) {
            // var get = parseInt($('table').find("[data-name='" + name + "']").children('td').eq(2).html());
            var getid = parseInt(countval);
            var sum = parseInt(get + getid);
            // $('table').find("[data-name='" + name + "']").children('td').eq(2).html(sum);
            // $('table').find("[data-name='" + name + "']").children('td').eq(0).html(phone);
        }

    </script>
@endsection
