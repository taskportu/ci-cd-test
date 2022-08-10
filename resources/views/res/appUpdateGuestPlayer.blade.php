<div class="row mb-1 pb-1" data-gcid="" data-updategustid="{{$unique}}">
    <input type="hidden" name="MemberID" value="{{ json_encode($req) }}"/>
    <div class="col-12" data-child="{{$req->member}}">
        <div class="mltr pt-1 pb-1">
            <div class="row">
                <div class="col-12 col-sm-9">
                    <div class="row">
                        @if(isset($req->member) && $req->member !== null)
                            <div class="col-12 col-sm-2 label"><span class="gc-help">Family</span></div>
                        @else
                            <div class="col-12 col-sm-2 label"><span class="gc-help">Guest</span></div>
                        @endif
                        <div class="col-12 col-sm-10">
                            <div class="row">
                                <div class="col-12 col-sm-6 label">{{$req->fistName}} {{$req->lastName }}</div>
                                <div class="col-12 col-sm-4 text-truncate label"><span class="gc-st">{{ $req->club }}</span></div>
                                <div class="col-12 col-sm-2 text-center label">{{ $req->hcp }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-3">
                    <div class="row">
                        <div class="col-12 col-sm-6 label">{{$req->phone}}</div>

                        <div class="col-12 col-sm-6 gc-reg-marked" data-id="{{$unique}}" onclick="remove_updategustplayer(this)">
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
