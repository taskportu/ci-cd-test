<div class="row mb-1 pb-1" data-gcid="" data-updategustid="{{$unique}}">
    <input type="hidden" name="MemberID" value="{{ json_encode($req) }}"/>
    <div class="col-12" data-child="{{$req->member}}">
        <div class="mltr pt-1 pb-1">
            <div class="row">
                <div class="col-sm-9">
                    <div class="row">
                        <div class="col-2"><span class="gc-help">Guest</span></div>
                        <div class="col-10">
                            <div class="row">
                                <div class="col-6">{{$req->fistName}} {{$req->lastName }}</div>
                                <div class="col-4 text-truncate"><span class="gc-st">{{ $req->club }}</span></div>
                                <div class="col-2 text-right">{{ $req->hcp }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="row">
                        <div class="col-6 ">{{$req->phone}}</div>

                        <div class="col-6 gc-reg-marked" style="padding-left: 32px;" data-id="{{$unique}}" onclick="remove_updategustplayer(this)">
                            <button class="btn btn-danger" type="button">
                        		<span class="gc-help">
                                <span class="glyphicon glyphicon-remove"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
