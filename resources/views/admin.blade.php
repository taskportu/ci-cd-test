@extends('layout')
@section('home')
    @include('menu')
    <style>
        #voo {
            background-color: #ffffb2;
        }
    </style>
    <div class="container">
        {{-- <h3 class="text-center">Status</h3> --}}
        <div class="row mt-5">
            <div class="col-12 col-sm-8 offset-sm-2">

                @if(isset($newsInfo) && isset($newsInfo->header) && isset($newsInfo->body))
                <div class="card mb-4">
                    <div class="card-header bg-dark text-white">News Info : {{$newsInfo->header}}</div>
                    <div class="card-body">{{$newsInfo->body}}</div>
                </div>
                @endif

                <table class="table table-bordered mb-5" style="text-align: center;">
                    <thead style="text-align: center;">
                    <tr>
                        <th scope="col">Member Type</th>
                        <th scope="col" style="width: 10%;">Counted</th>
                        <th scope="col" style="width: 10%;">Unique Email</th>
                    </tr>
                    </thead>
                    <tbody>
                    {{-- @foreach ($email_counts as $email_key =>$email_value) --}}
                    @foreach ($status as $key => $statu)
                        <tr>
                            <td style="{{ ($key == 'Total Sum' ? "font-weight: bold;" : '' ) }}">
                                {{$key}}
                            </td>
                            <td style="{{ ($key == 'Total Sum' ? "font-weight: bold;" : '' ) }}">
                                {{ $statu}}
                            </td>
                            <td style="{{ ($key == 'Total Sum' ? "color: white;" : '' ) }}">
                                @if(isset($email_counts) && array_key_exists($key, $email_counts))
                                    {{$email_counts[$key]}}
                                @endif
                                {{--                                {{ ( $key = $email_counts[$key] ? $email_counts[$key] : ''  ) }}--}}
                            </td>
                        </tr>
                    @endforeach
                    {{-- @endforeach --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

