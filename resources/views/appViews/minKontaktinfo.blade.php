<div class="mine-fasiliteter pb-4">
    <div class="row">
        <div class="col-12">
            <div class="app-header">
                <h4>MIN KONTAKTINFO</h4>
            </div>
        </div>
    </div>

    @if($memberdata->member_type !== 'Sponsor' && $memberdata->member_type !== 'Passiv')
        <div class="row">
            <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2">
                @if(isset($memberdata))
                    <div class="profile-image">
                        <div class="container" align="center">
                            <div class="row">
                                <div class="col-md-4 offset-md-4">
                                    <div class="image_area">
                                        <div class="container">
                                            <label class="label ">
                                                @php
                                                    $userImage = false;
                                                    if(isset($memberdata->image) && !empty($memberdata->image)) {
                                                        $exist = Storage::disk('public')->exists('/images/members/'.$memberdata->image);
                                                        $userImage = route('get.profile.image', $memberdata->image);
                                                        if($exist === false) $userImage = false;
                                                        //dd($userImage);
                                                    }
                                                @endphp
                                                <img class="rounded" id="avatar"
                                                     src="@if($userImage){{URL::asset($userImage)}}@else{{asset('images/user.png')}}@endif"
                                                     alt="avatar">
                                                <div class="overlay">
                                                    <div class="text">Change your avatar</div>
                                                </div>
                                                <input type="file" class="sr-only" id="input" name="image" accept="image/*">
                                            </label>

                                            <div class="alert" role="alert"></div>

                                            <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="modalLabel">Crop the image</h5>
                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="img-container">
                                                                <img id="image" src="">
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                                            <button type="button" class="btn btn-primary" id="crop">Crop</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="js-messages d-none"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="list">
                        <div class="row">
                            <div class="col-12 col-sm-4 text-left">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-geo-alt-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"/>
                                </svg>
                                <strong>Adresse </strong>
                            </div>
                            <div class="col-12 col-sm-8 text-left">
                                @if(isset($memberdata->address1)){{$memberdata->address1}}@if(isset($memberdata->address2))
                                    , {{$memberdata->address2}}@endif @if(isset($memberdata->zipcode))
                                    , {{$memberdata->zipcode}}@endif @if(isset($memberdata->city))
                                    , {{$memberdata->city}}@endif @endif
                            </div>
                        </div>
                    </div>

                    <div class="list">
                        <div class="row">
                            <div class="col-12 col-sm-4 text-left">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-envelope-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555zM0 4.697v7.104l5.803-3.558L0 4.697zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757zm3.436-.586L16 11.801V4.697l-5.803 3.546z"/>
                                </svg>
                                <strong>E-post </strong>
                            </div>
                            <div class="col-12 col-sm-8 text-left">{{$memberdata->email ?? ''}}</div>
                        </div>
                    </div>

                    <div class="list">
                        <div class="row">
                            <div class="col-12 col-sm-4 text-left">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-envelope-fill" viewBox="0 0 16 16">
                                    <path
                                        d="M.05 3.555A2 2 0 0 1 2 2h12a2 2 0 0 1 1.95 1.555L8 8.414.05 3.555zM0 4.697v7.104l5.803-3.558L0 4.697zM6.761 8.83l-6.57 4.027A2 2 0 0 0 2 14h12a2 2 0 0 0 1.808-1.144l-6.57-4.027L8 9.586l-1.239-.757zm3.436-.586L16 11.801V4.697l-5.803 3.546z"/>
                                </svg>
                                <strong>E-post faktura </strong>
                            </div>
                            <div class="col-12 col-sm-8 text-left">{{$memberdata->email_billing ?? ''}}</div>
                        </div>
                    </div>

                    <div class="list text-left">
                        <div class="d-inline-block ml-0 text-white p-2 font-weight-bold" style="background-color: #002a71;">
                            Telefon
                        </div>
                    </div>

                    <div class="list">
                        <div class="row">
                            <div class="col-12 col-sm-4 text-left d-block">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-telephone-fill" viewBox="0 0 16 16">
                                    <path fill-rule="evenodd"
                                          d="M1.885.511a1.745 1.745 0 0 1 2.61.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                                </svg>
                                <strong>Privat</strong>
                            </div>
                            <div class="col-12 col-sm-8 text-left d-block">{{$memberdata->tel_privately ?? ''}}</div>
                        </div>
                    </div>

                    <div class="list">
                        <div class="row">
                            <div class="col-12 col-sm-4 text-left">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-telephone" viewBox="0 0 16 16">
                                    <path
                                        d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                                </svg>
                                <strong>Jobb</strong>
                            </div>
                            <div class="col-12 col-sm-8 text-left">{{$memberdata->tel_jobs ?? ''}}</div>
                        </div>
                    </div>

                    <div class="list">
                        <div class="row">
                            <div class="col-12 col-sm-4 text-left">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                     class="bi bi-phone" viewBox="0 0 16 16">
                                    <path
                                        d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h6zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H5z"/>
                                    <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2z"/>
                                </svg>
                                <strong>Mobil</strong>
                            </div>
                            <div class="col-12 col-sm-8 text-left">{{$memberdata->phone_mobile ?? ''}}</div>
                        </div>
                    </div>
                @endif
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
