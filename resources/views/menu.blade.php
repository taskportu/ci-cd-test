<div class="container-fluid d-none d-sm-block">
	<div class="row">
		<div class="col-12">
            <a href="{{ url('/admin') }}" class=""><span style="font-size: 35px;font-weight: 500;"> HOME</span></a>
            @checkaccess('registration.view', \Request::get('permissions'))
        	<a href="{{ url('/registration') }}" class=""><span>KIOSK</span></a>
            <span>*</span>
            @endcheckaccess
            @if(Session::has('authenticated'))
            <span style="font-size:16px;"><a href="{{ route('adminuser.logout') }}" class="" >LOGOUT</a></span>
            @endif
        </div>
		<div class="col-12">
            {{-- {{ dd(\Request::get('permissions')) }} --}}
        	<span>MEMBER : </span>
            @checkaccess('member.add', \Request::get('permissions'))
            <a href="{{ route('member.add.view') }}">ADD</a>
            <span>*</span>
            @endcheckaccess

            @checkaccess('member.edit', \Request::get('permissions'))
            <a href="{{url('member/find/edit_member')}}">EDIT</a>
            <span>*</span>
            @endcheckaccess

            @checkaccess('club.view', \Request::get('permissions'))
            <a href="{{url('member/club')}}">CLUB</a>
            <span>*</span>
            @endcheckaccess

            @checkaccess('ticket.view', \Request::get('permissions'))
            <a href="{{ route('ticket') }}">TICKETS</a>
            <span>*</span>
            @endcheckaccess

            @checkaccess('purchase.view', \Request::get('permissions'))
            <a href="{{ route('purchases') }}">PURCHASES</a>
            <span>*</span>
            @endcheckaccess

            @checkaccess('news.view', \Request::get('permissions'))
            <a href="{{ route('news.info') }}">NEWS INFO</a>
            <span>*</span>
            @endcheckaccess

            @checkaccess('birthday.view', \Request::get('permissions'))
            <a href="{{ route('member.upcomingbirthday') }}">BDAYS</a>
            <span>*</span>
            @endcheckaccess

            @checkaccess('guest.play.view', \Request::get('permissions'))
            <a href="{{ route('guestplay.register') }}">GUEST PLAY</a>
            {{-- <span>*</span> --}}
            @endcheckaccess

            {{-- @checkaccess('sponsor.ticket.view', \Request::get('permissions'))
            <a href="{{ route('sponsor.ticket.view') }}">SPONSOR TICKET</a>
            @endcheckaccess --}}
		</div>
        <div class="col-12">
        	<span>REPORT :</span>
            @checkaccess('now.view', \Request::get('permissions'))
            <a href="{{ url('admin/report/now') }}">NOW</a>
            <span>*</span>
            @endcheckaccess

            @checkaccess('today.view', \Request::get('permissions'))
            <a href="{{ url('admin/report/today') }}">TODAY</a>
            <span>*</span>
            @endcheckaccess

            @checkaccess('week.view', \Request::get('permissions'))
            <a href="{{ url('admin/report/week') }}">WEEK</a>
            <span>*</span>
            @endcheckaccess

            @checkaccess('month.view', \Request::get('permissions'))
            <a href="{{ url('admin/report/month') }}">MONTH</a>
            <span>*</span>
            @endcheckaccess

            @checkaccess('guest.report.view', \Request::get('permissions'))
            <a href="{{url('report/guest')}}">GUEST</a>
            <span>*</span>
            @endcheckaccess

            @checkaccess('user.stats.view', \Request::get('permissions'))
            <a href="{{route('user.stats')}}">USER STATS</a>
             <span>*</span>
            @endcheckaccess

            @checkaccess('activity.view', \Request::get('permissions'))
            <a href="{{ url('report/activity') }}">ACTIVITY</a>
            <span>*</span>
            @endcheckaccess

            @checkaccess('search.view', \Request::get('permissions'))
            <a href="{{ route('report_search') }}">SEARCH</a>
            @endcheckaccess

        </div>
	</div>
</div>

<div class="container-fluid d-block d-sm-none mt-4">
    <div class="row">
        <div class="col-12">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <a class="navbar-brand text-primary" style="font-size: 25px;font-weight: 500;" href="{{ url('/admin') }}">Home</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        @checkaccess('registration.view', \Request::get('permissions'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/registration') }}">KIOSK</a>
                        </li>
                        @endcheckaccess
                        @if(Session::has('authenticated'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('adminuser.logout') }}">LOGOUT</a>
                        </li>
                        @endif


                        <li class="nav-item bg-primary">
                            <a class="nav-link text-white disabled" href="#">MEMBER :</a>
                        </li>
                        @checkaccess('member.add', \Request::get('permissions'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('member.add.view') }}">ADD</a>
                        </li>
                        @endcheckaccess
                        @checkaccess('member.edit', \Request::get('permissions'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('member/find/edit_member')}}">EDIT</a>
                            </li>
                        @endcheckaccess
                        @checkaccess('club.view', \Request::get('permissions'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('member/club')}}">CLUB</a>
                            </li>
                        @endcheckaccess
                        @checkaccess('ticket.view', \Request::get('permissions'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('ticket') }}">TICKETS</a>
                            </li>
                        @endcheckaccess
                        @checkaccess('purchase.view', \Request::get('permissions'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('purchases') }}">PURCHASES</a>
                            </li>
                        @endcheckaccess
                        @checkaccess('news.view', \Request::get('permissions'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('news.info') }}">NEWS INFO</a>
                            </li>
                        @endcheckaccess
                        @checkaccess('birthday.view', \Request::get('permissions'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('member.upcomingbirthday') }}">BDAYS</a>
                            </li>
                        @endcheckaccess
                        @checkaccess('guest.play.view', \Request::get('permissions'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('guestplay.register') }}">GUEST PLAY</a>
                            </li>
                        @endcheckaccess


                        <li class="nav-item bg-primary">
                            <a class="nav-link text-white disabled" href="#">REPORT :</a>
                        </li>
                        @checkaccess('now.view', \Request::get('permissions'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('admin/report/now') }}">NOW</a>
                            </li>
                        @endcheckaccess
                        @checkaccess('today.view', \Request::get('permissions'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('admin/report/today') }}">TODAY</a>
                            </li>
                        @endcheckaccess
                        @checkaccess('week.view', \Request::get('permissions'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('admin/report/week') }}">WEEK</a>
                            </li>
                        @endcheckaccess
                        @checkaccess('month.view', \Request::get('permissions'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('admin/report/month') }}">MONTH</a>
                            </li>
                        @endcheckaccess
                        @checkaccess('guest.report.view', \Request::get('permissions'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{url('report/guest')}}">GUEST</a>
                            </li>
                        @endcheckaccess
                        @checkaccess('user.stats.view', \Request::get('permissions'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('user.stats')}}">USER STATS</a>
                            </li>
                        @endcheckaccess
                        @checkaccess('activity.view', \Request::get('permissions'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('report/activity') }}">ACTIVITY</a>
                            </li>
                        @endcheckaccess
                        @checkaccess('search.view', \Request::get('permissions'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('report_search') }}">SEARCH</a>
                            </li>
                        @endcheckaccess
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col offset-sm-2 col-sm-8">
            @if(Session::has('error') && Route::currentRouteName() != 'guestplay.register')
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  {{Session::get('error')}}
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
            @endif
        </div>
    </div>
</div>
