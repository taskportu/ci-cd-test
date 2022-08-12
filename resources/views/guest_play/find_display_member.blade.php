<div class="">
    <table class="table table-hover">
        <thead>
        <tr>
            <th scope="col">OccID</th>
            <th scope="col">MemberName</th>
            <th scope="col" class="text-left">Add</th>
        </tr>
        </thead>
        <tbody>
        @foreach($members as $data)
            <tr id="{{$data->MemberID}}">
                <td>{{$data->OccID}}</td>
                <td>
                    <span class="{{$data->MemberID}}">
                        {{$data->Member_Fistname}} {{$data->Member_Lastname}}
                    </span>
                    <input type="text" data-fistname="{{$data->MemberID}}"
                           value="{{$data->Member_Fistname}}" style="width:50%;display:none"
                           data-fistdieplayname="{{$data->Member_Fistname}}">
                    <input type="text" data-lastname="{{$data->MemberID}}"
                           value="{{$data->Member_Lastname}}" style="width:48%;display:none"
                           name="data-inputlastnamesave">
                </td>
                <td>
                    <span data-hcp="{{$data->MemberID}}">
                        {{ !empty($data->new_hcp) ? $data->new_hcp : $data->HCP  }}
                    </span>
                    <input type="text" data-hcpinput="{{$data->MemberID}}"
                           value="{{$data->HCP}}" style="width:38%;display:none;" name="data-inputsaveHcp">
                </td>
                <td align="right">
                    <a href="{{ route('guestplay.register',$data->MemberID)}}">
                        <button class="btn btn-info btn-sm float-left p-0">
                            <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABYAAAAWCAYAAADEtGw7AAAABmJLR0QA/wD/AP+gvaeTAAAAy0lEQVQ4jdXVQWoCQRCF4c8QcgazUBPUrSfwFoKH8CausvUMgRxD3Ai6d3RCFOIZssrCDg7NBGYaFXxQFP2gfopqqOJKakTvPjqJrE9kZeAZBjgkgltYYVI0+5gnAotaoAcPwWhidwFwhuciuIraISqpDngU4uLgWro/8OM//ivGkTcM+Sny35HHgJt3nGMaeT8hv1UB39/n3XzGZfq4FvirDvhvFEd06xSWqOG0Mr85d7zB2mmf7hPBbSyFKxKfph5eEsE5tom11fULpTEZxG+CuEUAAAAASUVORK5CYII="/>
                        </button>
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
