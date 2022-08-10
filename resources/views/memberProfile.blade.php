<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <title>{{$member->Member_Fistname}} {{$member->Member_Lastname}}</title>
{{--        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">--}}
{{--        <link rel="stylesheet" type="text/css" href="{{ base_path().'/public/css/bootstrap.min.css' }}">--}}
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" integrity="sha384-HSMxcRTRxnN+Bdg0JdbxYKrThecOKuH5zCYotlSAcp1+c8xmyTe9GYg1l9a69psu" crossorigin="anonymous">
        <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css"/>
    </head>

    <body>
        @php
            /*$userImage = false;
            if(isset($member->image) && !empty($member->image)) {
                $exist = Storage::disk('public')->exists('/images/members/'.$member->image);
                $userImage = route('get.profile.image', $member->image);
                if($exist === false) $userImage = false;
                //dd($userImage);
            }*/

            $userImage = false;
            if(isset($member->image) && !empty($member->image)) {
                $exist = Storage::disk('public')->exists('/images/members/'.$member->image);
                $userImage = route('get.profile.image', $member->image);
                if($exist === false) $userImage = false;
                //dd($userImage);
            }
        @endphp

        <div class="container mt-5" style="margin-top: 10%;">
            @if(isset($pdf) && $pdf === false)
                <div class="row">
                    <div class="col">
                        <div class="d-flex justify-content-end mb-4">
                            <a class="btn btn-primary" href="{{route('member.pdf', $member->MemberID)}}">Export to PDF</a>
                        </div>
                    </div>
                </div>
            @endif
            <div style="display: block; margin-bottom: 0px;">
                <img style="width: 30%; height: auto; background:#f6f5f5; margin-left: 33%; margin-right: auto; border: 2px solid #c5c3c3; border-radius: 10px; padding: 10px;" src="{{$image}}" alt="{{$member->Member_Fistname}} {{$member->Member_Lastname}}">
            </div>
            <div style="display: block;">
                <h2 style="text-align: center;" class="text-center mb-3">{{$member->Member_Fistname}} {{$member->Member_Lastname}}</h2>
            </div>
<!--            <div class="row">
                <div class="col-sm-4 col-sm-offset-4">
                    @if(\Request::route()->getName() === 'member.profile')
                    <img class="img-fluid mb-3" src="@if($userImage){{URL::asset($userImage)}}@else{{asset('images/user.png')}}@endif" alt="{{$member->Member_Fistname}} {{$member->Member_Lastname}}">
                    @else
                    <img style="margin-left: auto; margin-right: auto;" class="img-fluid mb-3" src="{{$image}}" alt="{{$member->Member_Fistname}} {{$member->Member_Lastname}}">
                    @endif
                </div>
                <div class="col-sm-6 col-sm-offset-3">
                    <h2 class="text-center mb-3">{{$member->Member_Fistname}} {{$member->Member_Lastname}}</h2>
                </div>
            </div>-->
        </div>
        <script src="{{ asset('js/app.js') }}" type="text/js"></script>
{{--        <script src="{{ base_path().'/public/js/bootstrap.min.js' }}" type="text/js"></script>--}}
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js" integrity="sha384-aJ21OjlMXNL5UyIl/XNwTMqvzeRMZH2w8c5cRVpzpU8Y5bApTppSuUkhZXN0VxHd" crossorigin="anonymous"></script>
    </body>
</html>
