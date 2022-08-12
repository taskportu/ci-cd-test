<div class="">


    <table class="table table-hover">
      <thead>
        <tr>

          <th scope="col">OccID</th>
          <th scope="col">MemberName</th>
          <th scope="col" class="text-left">Ticket</th>
        </tr>
      </thead>
      <tbody>
        @foreach($members as $data)
        <tr id="{{$data->MemberID}}">

            <td>{{$data->OccID}}</td>
            <td>
                <span  class="{{$data->MemberID}}">
                {{$data->Member_Fistname}} {{$data->Member_Lastname}}
                </span>

            </td>
            <td align="left">
                <a href="{{ route('add_ticket',$data->MemberID)}}">
                    <button class="btn btn-success btn-sm" >
                    <span class="glyphicon glyphicon-plus"></span>
                    </button>
                </a>
            </td>
        </tr>
        @endforeach
      </tbody>
    </table>
</div>
