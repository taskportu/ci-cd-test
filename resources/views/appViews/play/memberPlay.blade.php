<div id="memberPlay">
    <div class="container-fluid pl-0 pr-0">
        <div class="row">
            <div class="col-12">
                <div class="play-round-head">
                    <h4>REGISTRER DAGENS RUNDE</h4>
                </div>
            </div>
        </div>
    </div>
    @if($memberdata->member_type !== 'Sponsor' && $memberdata->member_type !== 'Passiv')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <p class="front-site-info mb-3 mt-0">
                    Så nært opp til faktisk spill, registrerer du her at du og evt. andre familiemedlemmer skal spille. Merk: Det er fortsatt ballrenna som gjelder.
                </p>
            </div>
        </div>
            <div class="registered-today">
                <div class="row">
                    <div class="col-12 col-sm-10 offset-sm-1">
                        <div class="registered-tbl-div table-responsive @if($memberPlayRegData['currentMemberPlayReg']->isEmpty()) d-none @endif" id="regPlayTable">
                            <table class="table table-bordered table-hover registered-round">
                                <thead class="">
                                    <tr>
                                        <th style="width: 1% !important;">T</th>
                                        <th>Navn</th>
                                        <th style="width: 1% !important;">Tid</th>
                                    </tr>
                                </thead>
                                <tbody data-round="">
                                @if($memberPlayRegData['currentMemberPlayReg']->isNotEmpty())
                                    @foreach($memberPlayRegData['currentMemberPlayReg'] as $main)
                                        <tr>
                                            <td>M</td>
                                            <td>{{$main->reg_fistname ?? ''}} {{$main->reg_lastname ?? ''}}</td>
                                            <td>{{\Carbon\Carbon::parse($main->reg_time)->format('H:i')}}</td>
                                        </tr>
                                        @if(array_key_exists($main->reg_auto, $memberPlayRegData['todayRegistration']))
                                            @foreach($memberPlayRegData['todayRegistration'][$main->reg_auto] as $reg_auto => $sub)
                                                <tr>
                                                    <td>@if($sub['reg_member_id'] != null && $sub['reg_member_id'] != '') M @else G @endif</td>
                                                    <td>{{$sub['reg_fistname'] ?? ''}} {{$sub['reg_lastname'] ?? ''}}</td>
                                                    <td>{{\Carbon\Carbon::parse($sub['reg_time'])->format('H:i')}}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        <div class="row">
            <div class="col-12 mx-auto wfr">
                <div class="row">
                    <div class="col-12 gc-{{ $member['MemberID'] }}">
                        <div class="family mb-3"></div>
                    </div>
                </div>
                <div class="row mb-1 pb-4" id="notinsert">
                    <div class="col-12 col-sm-3"></div>
                    <div class="col-12 col-sm-6">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-8 offset-md-2 text-left gc-{{ $member['MemberID'] }}">
                                    <label class="btn btn-default add-family d-block mb-2" data-id="{{$member['MemberID']}}" data-family="{{$member['MemberID']}}">{{$member['Member_Fistname'] }} {{$member['Member_Lastname']}}</label>
                                @foreach($familyMembers as $family)
                                        <label class="btn btn-default add-family d-block mb-2" data-id="{{$member['MemberID']}}" data-family="{{$family['MemberID']}}">{{$family['Member_Fistname'] }} {{$family['Member_Lastname']}}</label>
                                @endforeach


                                <div class="row">
                                    <div class="col-12">
                                        {{-- <p class="front-site-info mb-3 mt-0">Her kan du registrere gjestespiller som spiller sammen med deg.</p> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 gc-{{ $member['MemberID'] }}">
                        <div class="js-messages"></div>
                        <div class="guest"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
        <div class="row">
            <div class="col-12">
                <div class="alert alert-danger text-danger d-block ml-3 mr-3" role="alert">
                    You don't have access to this page.
                </div>
            </div>
        </div>
    @endif
</div>



@section('script')
    <script>
        console.log(moment('2021-04-01 15:23:21').format("HH:mm"));
        $('body #memberPlay').undelegate('.gc-ibag', 'click').delegate('.gc-ibag', 'click', function (res) {
            var it = $(this);
            var ids = it.data('id');

            $('.gcmrb').hide();

            $.get('{{ Request::root() }}/app/gustRegFormInReg', {id: ids}, function (res) {
                $('.gc-' + ids + ' .guest').append(res);
            })
        }).undelegate('form.gc-rmgrf', 'submit').delegate('form.gc-rmgrf', 'submit', function (e) {
            var it = $(this);
            var data = $(this).serializeArray();
            let round = $('.registered-round').data('round');
            data.push({'name': 'round', 'value' : round});
            data.push({'name': 'type', 'value' : 'guest'});
            console.log(data, 'data');
            // '/app/register/reg-list'
            ajax('POST', data, '/app/register/reg-list', function (response, uri) {
                var d = it;
                var id = d.data('memberid');
                var family = d.data('member');
                // if(response.reg !== undefined) {
                //     let regName = (response.reg['reg_fistname'] !== undefined) ? response.reg['reg_fistname']  : ' - ';
                //     let regDate = (response.reg['reg_time'] !== undefined) ? moment(response.reg['reg_time']).format("HH:mm") : ' - ';
                //     let textAppend = `<tr style="background: #ffffd6;"><td>G</td><td style="white-space: nowrap">${regName}</td><td style="white-space: nowrap">${regDate}</td></tr>`;
                //     $('#regPlayTable tbody').append(textAppend);
                //     console.log(regDate, response.reg['reg_time'], response.reg,  response.reg['reg_time'] !== undefined);
                // }
                // let gCount = $('.guest .row').length;
                // if(gCount === 0) location.reload();
                console.log(response);
                if(response.error ===false) {
                    console.log(response.round !== '' , response.round !== undefined , response.round !== null , round === undefined);
                    if(response.round !== '' && response.round !== undefined && response.round !== null) {
                        if(round === undefined)
                            $('.registered-round').attr('data-round', response.round);
                        console.log(response.round, 'test');

                        if(response.regFamily !== undefined && response.regFamily !== null && round === undefined) {
                            $('.add-family').filter(function(){
                                // console.log($(this).data('family') === response.reg['reg_member_id'], 'fam');
                                return $(this).data('family') === response.regFamily['reg_member_id']
                            }).addClass('d-none').removeClass('d-block');;
                            // console.log($('.add-family[data-family="'+ response.regFamily['reg_member_id'] +'"]'));
                            // $('.add-family[data-family="'+ response.regFamily['reg_member_id'] +'"]').hide();
                            let regDate = (response.regFamily['reg_time'] !== undefined) ? moment(response.regFamily['reg_time']).format("HH:mm") : ' - ';
                            let appendTbl = `<tr><td>M</td><td>${response.regFamily['reg_fistname']} ${response.regFamily['reg_lastname']}</td><td>${regDate}</td></tr>`
                            $('.registered-tbl-div').removeClass('d-none');
                            $('.registered-round tbody').append(appendTbl);
                            $('.add-family[data-family="' + family + '"]').addClass('d-none').removeClass('d-block');
                        }
                        if(response.reg !== undefined && response.reg !== null) {
                            $('.add-family').filter(function(){
                                // console.log($(this).data('family') === response.reg['reg_member_id'], 'mem');
                                return $(this).data('family') === response.reg['reg_member_id']
                            }).addClass('d-none').removeClass('d-block');
                            $('.add-family[data-family="'+ response.reg['reg_member_id'] +'"]').hide();
                            let regDate = (response.reg['reg_time'] !== undefined) ? moment(response.reg['reg_time']).format("HH:mm") : ' - ';
                            let appendTbl = `<tr><td>G</td><td>${response.reg['reg_fistname']} ${response.reg['reg_lastname']}</td><td>${regDate}</td></tr>`;
                            $('.registered-round tbody').append(appendTbl);
                            $('.add-family[data-family="' + family + '"]').addClass('d-none').removeClass('d-block');
                        }

                    }
                    $('.gc-rgfp'+id).hide();
                }
                else {
                    showReturnMessages(response.message);
                }
            })
            return false;
        }).delegate('.wfr .gc-inlist', 'mouseover', function (e) {
            $(this).removeClass('gc-inlist');

        });

        $('.add-family').on('click', function () {
            let it = $(this);
            let id = it.data('id');
            let family = it.data('family');
            let round = $('.registered-round').data('round');
            // console.log(round, 'round');
            let data = {};
            data['family'] = id;
            data['member'] = family;
            data['round'] = round;
            data['type'] = 'family';

            ajax('POST', data, '/app/register/reg-list', function (response, url) {
                var d = it;
                var id = d.data('memberid');
                console.log(response.round !== '', response.round !== undefined, response.round !== null, response.error);
                if(response.error === false) {
                    if(response.round !== '' && response.round !== undefined && response.round !== null) {
                        if(round === undefined)
                            $('.registered-round').attr('data-round', response.round);

                        console.log(response.regFamily !== undefined , response.regFamily !== null , round === undefined);
                        if(response.regFamily !== undefined && response.regFamily !== null && round === undefined) {
                            $('.add-family').filter(function(){
                                // console.log($(this).data('family') === response.reg['reg_member_id'], 'fam');
                                return $(this).data('family') === response.regFamily['reg_member_id'];
                            }).addClass('d-none').removeClass('d-block');
                            // console.log($('.add-family[data-family="'+ response.regFamily['reg_member_id'] +'"]'));
                            // $('.add-family[data-family="'+ response.regFamily['reg_member_id'] +'"]').hide();
                            let regDate = (response.regFamily['reg_time'] !== undefined) ? moment(response.regFamily['reg_time']).format("HH:mm") : ' - ';
                            let appendTbl = `<tr><td>M</td><td>${response.regFamily['reg_fistname']} ${response.regFamily['reg_lastname']}</td><td>${regDate}</td></tr>`
                            $('.registered-tbl-div').removeClass('d-none');
                            $('.registered-round tbody').append(appendTbl);
                            console.log($('.add-family[data-family="' + response.regFamily['reg_member_id'] + '"]'), response.regFamily['reg_member_id']);
                            $('.add-family[data-family="' + response.regFamily['reg_member_id'] + '"]').addClass('d-none').removeClass('d-block');
                        }
                        if(response.reg !== undefined && response.reg !== null) {
                            $('.add-family').filter(function(){
                                    // console.log($(this).data('family') === response.reg['reg_member_id'], 'mem');
                                    return $(this).data('family') === response.reg['reg_member_id'];
                                }).addClass('d-none').removeClass('d-block');;
                            $('.add-family[data-family="'+ response.reg['reg_member_id'] +'"]').hide();
                            let regDate = (response.reg['reg_time'] !== undefined) ? moment(response.reg['reg_time']).format("HH:mm") : ' - ';
                            let appendTbl = `<tr><td>M</td><td>${response.reg['reg_fistname']} ${response.reg['reg_lastname']}</td><td>${regDate}</td></tr>`;
                            $('.registered-round tbody').append(appendTbl);
                            $('.add-family[data-family="' + response.reg['reg_member_id'] + '"]').addClass('d-none').removeClass('d-block');
                        }

                    }
                }
                console.log(data, response);
                // console.log(data, id, $(d).data('member'), r, u);
                // $(r).insertAfter('[data-gcid="' + $(d).data('member') + '"]');
                // $().in(r);
                // $('.gc-rgfp' + id).remove();
                // $('.gc-rgfp' + $(d).data('member') + '' + id).remove();
                // $('.gc-hmb' + id).show().find('input').prop('checked', false);

                // if (!$('.gc-rmgrf').length) {
                //     $('.gcmrb').show();
                // }
            })

            {{--$.get('{{ Request::root() }}/app/register/reg-list', {id: id, family: family}, function (res) {--}}
            {{--    $('.gc-' + id + ' .family').append(res);--}}
            {{--    $('.add-family[data-family="' + family + '"]').removeClass('d-block').addClass('d-none');--}}
            {{--})--}}
        })

        function app_remove_regfromgust(id) {
            let uniqueId = $(id).attr('data-id');
            let family = $(id).data('family');
            $('[data-regfrom="' + uniqueId + '"]').remove();
            $('.add-family[data-family="' + family + '"]').removeClass('d-none').addClass('d-block');

            let familyCount = $('.add-family[data-family="' + family + '"]').length;
            if (familyCount == 1 || familyCount == 0) $('.gcmrb').css('display', 'none');
            else $('.gcmrb').css('display', 'block');

            console.log(familyCount);
        }

        function registerMember() {

        }
    </script>
@endsection

{{--@section('script')
    <script>
        console.log(moment('2021-04-01 15:23:21').format("HH:mm"));
        $('body #memberPlay').undelegate('.gc-ibag', 'click').delegate('.gc-ibag', 'click', function (res) {
            var it = $(this);
            var ids = it.data('id');

            $('.gcmrb').hide();

            $.get('{{ Request::root() }}/app/gustRegFormInReg', {id: ids}, function (res) {
                $('.gc-' + ids + ' .guest').append(res);
            })
        }).undelegate('form.gc-rmgrf', 'submit').delegate('form.gc-rmgrf', 'submit', function (e) {
            var it = $(this);
            var data = $(this).serializeArray();
            // '/app/register/reg-list'
            ajax('POST', data, '/app/register/reg-list', function (response, uri) {
                var d = it;
                var id = d.data('memberid');
                if(response.reg !== undefined) {
                    let regName = (response.reg['reg_fistname'] !== undefined) ? response.reg['reg_fistname']  : ' - '
                    let regHcp = (response.reg['reg_hcp'] !== undefined) ? response.reg['reg_hcp'] : ' - ';
                    let regDate = (response.reg['reg_time'] !== undefined) ? moment(response.reg['reg_time']).format("HH:mm") : ' - ';
                    let textAppend = `<tr style="background: #ffffd6;"><td>G</td><td style="white-space: nowrap">${regName}</td><td style="white-space: nowrap">${regHcp}</td><td style="white-space: nowrap">${regDate}</td></tr>`;
                    $('#regPlayTable tbody').append(textAppend);
                    console.log(regDate, response.reg['reg_time'], response.reg,  response.reg['reg_time'] !== undefined);
                }
                $('.gc-rgfp' + id).remove();
                let gCount = $('.guest .row').length;
                if(gCount === 0) location.reload();
            })
            return false;
        }).delegate('.wfr .gc-inlist', 'mouseover', function (e) {
            $(this).removeClass('gc-inlist');

        });

        $('.add-family').on('click', function () {
            let it = $(this);
            let id = it.data('id');
            let family = it.data('family');
            let data = {};
            data['family'] = id;
            data['member'] = family;
            data['type'] = 'family';
            // console.log('data', data);
            // $('.gcmrb').hide();

            ajax('POST', data, '/app/register/reg-list', function (response, url) {
                var d = it;
                var id = d.data('memberid');
                if(response.error ===false && response.type === 'member') {
                    location.reload();
                }
                console.log(data, response);
                // console.log(data, id, $(d).data('member'), r, u);
                // $(r).insertAfter('[data-gcid="' + $(d).data('member') + '"]');
                // $().in(r);
                // $('.gc-rgfp' + id).remove();
                // $('.gc-rgfp' + $(d).data('member') + '' + id).remove();
                // $('.gc-hmb' + id).show().find('input').prop('checked', false);

                // if (!$('.gc-rmgrf').length) {
                //     $('.gcmrb').show();
                // }
            })

            --}}{{--$.get('{{ Request::root() }}/app/register/reg-list', {id: id, family: family}, function (res) {--}}{{--
            --}}{{--    $('.gc-' + id + ' .family').append(res);--}}{{--
            --}}{{--    $('.add-family[data-family="' + family + '"]').removeClass('d-block').addClass('d-none');--}}{{--
            --}}{{--})--}}{{--
        })

        function app_remove_regfromgust(id) {
            let uniqueId = $(id).attr('data-id');
            let family = $(id).data('family');
            $('[data-regfrom="' + uniqueId + '"]').remove();
            $('.add-family[data-family="' + family + '"]').removeClass('d-none').addClass('d-block');

            let familyCount = $('.add-family[data-family="' + family + '"]').length;
            if (familyCount == 1 || familyCount == 0) $('.gcmrb').css('display', 'none');
            else $('.gcmrb').css('display', 'block');

            console.log(familyCount);
        }

        function registerMember() {

        }
    </script>
@endsection--}}

@push('link')
    <style>
        .bg-dark {
            background-color: #002a71 !important;
        }

        .navbar-dark .navbar-toggler {
            color: rgb(0, 42, 113);
            border-color: rgb(253, 253, 253);
        }

        ul.slik-virker {
            list-style-type: none;
            margin: 0;
        }

        ul.slik-virker > li {
            text-indent: -5px;
        }

        ul.slik-virker > li:before {
            content: " - ";
            text-indent: 0px;
        }
    </style>
@endpush
