<div class="row">
    <div class="col-12 app_menu">
        <nav class="navbar bg-dark navbar-dark">
            <a class="navbar-brand" href="{{route('app', ['name' => 'front'])}}" style="font-size: small;">OUSTØEN COUNTRY CLUB</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="collapsibleNavbar">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('app').'?name=front'}}">HJEM</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('app').'?name=card'}}">MEDLEMSKORT</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{url('app').'?name=hcp'}}">HANDIKAP</a>
                    </li> --}}
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{url('app').'?name=info'}}">INFORMASJON</a>
                    </li> --}}
                    @if($memberdata->member_type !== 'Sponsor' && $memberdata->member_type !== 'Passiv')
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('app').'?name=play'}}">REGISTRERING</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('app').'?name=play2'}}">KOMMENDE UKE / TERMINLISTE</a>
                    </li>
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{url('app').'?name=group'}}">SPILLGRUPPE</a>
                    </li> --}}

                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{url('app').'?name=pay'}}">BETALING</a>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('app').'?name=ferry'}}">FERGE</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{url('app').'?name=greenfee'}}">GJESTEBILLETTER</a>
                    </li>
                    @if($memberdata->member_type !== 'Sponsor' && $memberdata->member_type !== 'Passiv')
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('app').'?name=buggy'}}">BUGGY</a>
                        </li>
                    @endif
                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{url('app').'?name=pro-lessons'}}">PRO TIMER</a>
                    </li> --}}
                    @if($memberdata->member_type !== 'Sponsor' && $memberdata->member_type !== 'Passiv')
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('app').'?name=mine-fasiliteter'}}">MINE FASILITETER</a>
                        </li>
                    @endif
                    @if($memberdata->member_type !== 'Sponsor' && $memberdata->member_type !== 'Passiv')
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('app').'?name=min-kontaktinfo'}}">MIN KONTAKTINFO</a>
                        </li>
                    @endif
                     {{-- <li class="nav-item">
                        <a class="nav-link" href="{{url('app').'?name=setup'}}">INNSTILLINGER</a>
                    </li> --}}
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('applogout') }}">LOGOUT</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>
