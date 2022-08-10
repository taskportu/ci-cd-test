@extends('layout')
@section('home')
    @include('menu')
    <div class="container">
        {{-- <h3 class="text-center">Status</h3> --}}
        <div class="row mt-5">
            <div class="col-12 col-sm-6 offset-sm-3">
                <div class="card-header bg-dark text-white">User Stats</div>
                <div class="js-messages"></div>
                @if(!empty($stats))
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-center">Date</th>
                                    <th class="text-center">Stats</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($stats as $key => $stat)
                                    <tr>
                                        <td class="text-center">{{$stat['date']}}</td>
                                        <td class="text-center">{{$stat['member_count']}}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
    </div>
@endsection
