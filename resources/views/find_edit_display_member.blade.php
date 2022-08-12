<div class="">


    <table class="table table-hover">
      <thead>
        <tr>

          <th scope="col">OccID</th>
          <th scope="col">MemberName</th>
          <th scope="col" >HCP</th>
          <th scope="col">Active</th>
          <th scope="col" class="text-left">Edit</th>
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

         <input type="text"   data-fistname="{{$data->MemberID}}"
         value="{{$data->Member_Fistname}}" style="width:50%;display:none"
          data-fistdieplayname="{{$data->Member_Fistname}}">
         <input type="text"   data-lastname="{{$data->MemberID}}"
         value="{{$data->Member_Lastname}}" style="width:48%;display:none"
          name="data-inputlastnamesave">
         </td>
          <td><span data-hcp="{{$data->MemberID}}"> {{ !empty($data->new_hcp) ? $data->new_hcp : $data->HCP  }}
          </span>
          <input type="text"   data-hcpinput="{{$data->MemberID}}"
         value="{{$data->HCP}}" style="width:38%;display:none;" name="data-inputsaveHcp"></td>
          <td align="center">
          	@if($data->Active==1 && $data->member_type != 'Passiv' && $data->member_type != 'Slettet'&& $data->member_type != 'Aktiv Uten Spillerett')
              <button class="btn btn-success btn-sm float-left" style="width: 35px;"  data-active="active"
            data-activestatusid="{{$data->MemberID}}" onClick="active_staus(this)">
                  <img src="{{asset('images/power1.svg')}}" alt="Power">
{{--                  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-power" viewBox="0 0 16 16">--}}
{{--                      <path d="M7.5 1v7h1V1h-1z"/>--}}
{{--                      <path d="M3 8.812a4.999 4.999 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812z"/>--}}
{{--                  </svg>--}}
               </button>
            @else
            <button class="btn btn-danger btn-sm float-left" style="width: 35px;" data-active="inactive"
             data-activestatusid="{{$data->MemberID}}"  onClick="active_staus(this)">
                <img src="{{asset('images/power1.svg')}}" alt="Power">
{{--                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-power" viewBox="0 0 16 16">--}}
{{--                    <path d="M7.5 1v7h1V1h-1z"/>--}}
{{--                    <path d="M3 8.812a4.999 4.999 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812z"/>--}}
{{--                </svg>--}}
          </button>
            @endif
          </td>
          <td align="right">
         <!--<button class="btn btn-success btn-sm"-->
         <!-- onClick="find_report_eit_member(this.id)"-->
         <!--  id="{{$data->MemberID}}" data-edit="{{$data->MemberID}}" data-active="none">-->
         <!--  <span class="glyphicon glyphicon-pencil"></span></button>-->
         <!-- <button  style="display:none" class="btn btn-success btn-sm" onClick="save_report_member(this.id)" id="{{$data->MemberID}}" data-save="{{$data->MemberID}}" ><span class="glyphicon glyphicon-floppy-disk"></span></button>-->
         <a href="{{ route('memberedits',$data->MemberID)}}">
            <button class="btn btn-success btn-sm float-left" >
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pen" viewBox="0 0 16 16">
                    <path d="m13.498.795.149-.149a1.207 1.207 0 1 1 1.707 1.708l-.149.148a1.5 1.5 0 0 1-.059 2.059L4.854 14.854a.5.5 0 0 1-.233.131l-4 1a.5.5 0 0 1-.606-.606l1-4a.5.5 0 0 1 .131-.232l9.642-9.642a.5.5 0 0 0-.642.056L6.854 4.854a.5.5 0 1 1-.708-.708L9.44.854A1.5 1.5 0 0 1 11.5.796a1.5 1.5 0 0 1 1.998-.001zm-.644.766a.5.5 0 0 0-.707 0L1.95 11.756l-.764 3.057 3.057-.764L14.44 3.854a.5.5 0 0 0 0-.708l-1.585-1.585z"/>
                </svg>
            </button>

          </a>

          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
</div>
