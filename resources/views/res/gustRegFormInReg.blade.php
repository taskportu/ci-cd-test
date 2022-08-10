<div class="row mb-1 mt-1 gc-rgfp{{ $member->MemberID }}{{$unique}}" data-regfrom="{{$unique}}">
    <div class="col-12">
        <form class="input-group gc-rmgrf" data-member="{{ $member->MemberID }}" data-memberid="{{ $member->MemberID }}{{$unique}}">
                <input type="hidden" name="member" value="{{ $member->MemberID }}"/>
            <input type="hidden" name="form" value="true"/>
            <datalist id="gc-grfcl">
                @foreach($club as $club)
                    <option value="{{ $club->ClubName }}">{{ $club->ClubName}}</option>
                @endforeach
            </datalist>
            <input type="text" disabled style="width:7%" placeholder="Gjest">

            <input type="text" class="form-control from_check" pattern=".*\S+.*" placeholder="Fornavn" required name="fistName">
            <input type="text" class="form-control from_check" pattern=".*\S+.*" placeholder="Etternavn" required name="lastName">
            <input type="number" class="form-control from_check" placeholder="Mobil" name="phone">
            <input type="text" class="form-control from_check" placeholder="Klubb navn" style="padding-left:5px;width:50px" autocomplete="off" name="club" list="gc-grfcl"
                   placeholder="Club name">
            <input type="text" class="form-control from_check" style="max-width:70px" placeholder="HCP" name="hcp">
            <button class="btn btn-success gc-sm{{ $member->MemberID }}" type="submit">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-check2" viewBox="0 0 16 16">
                    <path d="M13.854 3.646a.5.5 0 0 1 0 .708l-7 7a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L6.5 10.293l6.646-6.647a.5.5 0 0 1 .708 0z"/>
                </svg>
            </button>
            <button class="btn btn-danger" type="button" data-id="{{$unique}}" onClick="remove_regfromgust(this)">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                </svg>
            </button>
        </form>
    </div>
</div>
