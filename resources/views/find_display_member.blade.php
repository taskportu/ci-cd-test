<div class="">

	
    <table class="table table-hover">
      <thead>
        <tr>
          <th scope="col">ClubID</th>
          <th scope="col">ClubName</th>
          <th scope="col"></th>
        </tr>
      </thead>
      <tbody>
        @foreach($members as $data)
        <tr id="{{$data->ClubID}}">
          <td>{{$data->ClubID}}</td>
          <td>
            <span data-span="{{$data->ClubID}}" id="{{$data->ClubID}}">{{$data->ClubName}}</span>
            <span data-inputclup="{{$data->ClubID}}">
            <input type="text" value="{{$data->ClubName}}" data-inputclupname="{{$data->ClubID}}" style="display:none">
            </td>
          <td align="right">
            <button  class="btn btn-success btn-sm" id="{{$data->ClubID}}" data-edibuttontclub="{{$data->ClubID}}" 
            onClick="edit_clubreport(this.id)">Edit</button>
            <button  style="display:none" class="btn btn-success btn-sm" id="{{$data->ClubID}}" data-clubsave="{{$data->ClubID}}"
            onClick="update_clupname(this.id)" >Save</button>
          <button class="btn btn-danger btn-sm" onClick="find_report_club(this.id)" 
            id="{{$data->ClubID}}">Delete</button>	
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
</div>