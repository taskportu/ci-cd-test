<div class="row mb-1 pb-1" data-gcid="{{ $member['MemberID'] }}" id="notinsert">
	<input type="hidden" name="MemberID" value="{{ $member['MemberID'] }}"/>
    <input type="hidden" name="hcp" value="{{$member['HCP']}}">
	<div class="col-12">
    	<div class="mltr pt-1 pb-1">
            <div class="row">
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-2">{{ $member['OccID'] }}</div>
                        <div class="col-10">
                        	<div class="row">
                            	<div class="col-4">
                                	{{$member['Member_Fistname'] }} {{$member['Member_Lastname']}}
                                </div>
                                <div class="col-5 ">
                                    <span class="gc-st">{{ (!empty($member['new_club']) ? $member['new_club'] :'OCC-GOLF') }}</span>
                                </div>
                                <div class="col-3 text-right" >
                                    <button class="btn btn-success btn-sm" style="height:30px;width:41px; text-align:center"  data-memberid="{{$member['OccID']}}" id="hcpmodal">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                                            <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z"/>
                                        </svg>
                                    </button>
                                    {{-- <a href="#"  id="hcpmodal" data-hcp="{{ $member->HCP  }}">modal</a>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="row">
                    	<div class="col-8 " style="margin-right:-15px !important">
                            {{-- <span class="gc-hmb{{ $member['MemberID'] }} float-right">
                                <label for="gc-b{{ $member['MemberID'] }}" data-id="{{ $member['MemberID'] }}" class="gc-ibag">
                                    <span class="gc-help gc-help-light">
                                        <p class="text-center guest_name_update">Legg til<br>gjest!
                                        </p>
                                    </span>
                                </label>
                            </span> --}}
                        </div>
                        <div class="col-4 gc-reg-marked text-right">
                            <button class="btn btn-danger" style="padding:5px 10px !important" type="button" onclick="removegest({{ $member['MemberID'] }})">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <div class="row">
            <div class="col-12 gc-{{ $member['MemberID'] }}">
            </div>
        </div>
    </div>
</div>
