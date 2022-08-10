<div class="container-fluid d-none d-sm-block">
    <div class="row">
        <div class="col-12">
            @checkaccess('registration.view', \Request::get('permissions'))
            <a href="{{ url('/registration') }}" class=""><span style="font-size: 35px;font-weight: 500;"> HOME</span></a>
            @endcheckaccess
            @if((Session::get('user')=='user') and (Session::get('authenticated') !== 'admin'))
                <a href="{{ url('adminlogout') }}" class="gc-help">LOGOUT<!-- <span class="gc-sc"> (F5)</span>--></a>
            @else
                <a href="{{ url('admin') }}" class="gc-help">ADMIN<!-- <span class="gc-sc"> (F5)</span>--></a>
                <span style="font-size: 15px;">|</span>
                <a href="{{ url('adminlogout') }}" class="gc-help">LOGOUT<!-- <span class="gc-sc"> (F5)</span>--></a>
            @endif
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
                {{-- <span>*</span> --}}
            @endcheckaccess
        </div>
    </div>
</div>

<div class="container-fluid d-block d-sm-none mt-4">
    <div class="row">
        <div class="col-12">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                @checkaccess('registration.view', \Request::get('permissions'))
                    <a class="navbar-brand text-primary" style="font-size: 25px;font-weight: 500;" href="{{ url('/registration') }}">Home</a>
                @endcheckaccess
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                        @if((Session::get('user')=='user') and (Session::get('authenticated') !== 'admin'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('adminuser.logout') }}">LOGOUT</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link" href="{{ url('admin') }}">ADMIN</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('adminuser.logout') }}">LOGOUT</a>
                            </li>
                        @endif


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
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</div>
