<div class="app-header">
    <h4>HANDIKAP</h4>
</div>
<div id="message_updated"
     class="alert alert-success col-md-4  mt-2 text-center" hidden>
    <strong>Manuelt handikap er oppdatert!</strong>
</div>

<!--<div class="row">-->
<div class="col-12">
    <p class="handicap-info mb-3 mt-3">
        <span class="text-danger">*</span>
        Her kan du legge inn ditt HCP slik at det vises på
        medlemskortet. Vi jobber med en løsning som gjør at du også skal
        kunne oppdatere ditt HCP tilsvarende Golfbox - Følg med!
    </p>
</div>
<!--</div>-->

<div class="col-12  form2">
    <center>
        <table class="table table-borderless">
            <input type="hidden" id="manual_occid"
                   value="{{ $memberdata->OccID }}">
            <tbody>
            <br>
            <input type="hidden" id="hcp_type" name="hcp_type"
                   value="{{ $memberdata->app_hcp_status }}">
            @if ($memberdata->OccID == '10948' || $memberdata->OccID == '10664' )
                {{-- <tr>
                    <th>Online / Manual</th>
                    <td>
                        <select name="hcp_type" id="hcp_type">
<option {{ ($memberdata->app_hcp_status == 'online') ? 'selected' : '' }}           value="online">Online</option>
                            <option {{ ($memberdata->app_hcp_status == 'manual') ? 'selected' : '' }} value="manual">Manual</option>
                        </select>
                        <span id="selected_message"       hidden>SELECTED</span>
                    </td>
                </tr> --}}
                @if ($memberdata->app_hcp_status == 'online')


                    {{-- <div id="colmun_online" hidden> --}}
                    <tr class="colmun_online">
                        <th>Occ ID</th>
                        <td>
                            <div class="col-sm-3"
                                 style="padding-left: unset;">
                                <input type="text" readonly=""
                                       name="OccID" class="form-control"
                                       id="OccID" placeholder=""
                                       value="{{ $memberdata->OccID }}">
                            </div>
                        </td>
                    </tr>
                    <tr class="colmun_online">
                        <th class="th_class">Date Played</th>
                        <td>
                            <div class="col-sm-6"
                                 style="padding: unset;">
                                <input type="text" class="form-control"
                                       id="datepicker"
                                       value="{{ date('d-M-Y') }}">
                                {{-- <input type="text" id="dt2" name="date" autocomplete="off" style="width: 34%;" /> --}}

                            </div>
                        </td>
                    </tr>
                    <tr class="colmun_online">
                        <th>Course Played</th>
                        <td>

                            @php
                                $occ_clubs = DB::table('clubs')->get();
                            @endphp
                            <select id="club"
                                    class="form-control select_club"
                                    name="club">
                                <option occ-golf="" value="OCC-GOLF"
                                        selected>OCC Golf
                                </option>
                                @foreach ($occ_clubs as $occ_club)
                                    @if($occ_club->ClubName != 'OCC-GOLF')
                                        <option>{{ $occ_club->ClubName }}</option>
                                    @endif
                                @endforeach
                            </select>

                        </td>
                    </tr>
                    <tr class="colmun_online">
                        <th class="th_class">Current HCP</th>
                        <td>
                            <div class="col-sm-3"
                                 style="padding-left: unset;">
                                <input type="text" class="form-control"
                                       readonly="" id="hcpscroe"
                                       placeholder="HCP Score"
                                       value="{{ (!empty($memberdata->new_hcp ) ? $memberdata->new_hcp : $memberdata->HCP ) }}"
                                       name="hcpscroe">
                                <input type="hidden"
                                       class="form-control hcp-validation"
                                       id="oldhcpscore"
                                       name="oldhcpscore"
                                       value="{{ (!empty($memberdata->new_hcp ) ? $memberdata->new_hcp : $memberdata->HCP ) }}">
                            </div>
                        </td>
                    </tr>
                    {{-- </div> --}}

                    <tr>
                        <th class="th_class">HCP Played</th>
                        <td>
                            <div class="col-sm-3"
                                 style="padding-left: unset;">
                                <input style="width: 5rem;"
                                       class=" hcp-validation form-control input_clas hcp"
                                       type="tel" min="0" max="5"
                                       name="hcp_online_occid"
                                       id="hcp_online_occid">


                            </div>

                        </td>
                    </tr>
                @else
                    <tr>
                        <th class="th_class">HCP Played</th>
                        <td>
                            <div class="col-sm-3">
                                <input style="width: 5rem;"
                                       class="hcp-validation form-control input_clas handicap"
                                       type="tel" min="0" max="5"
                                       name="hcp_manual_occid"
                                       id="hcp_manual_occid">
                            </div>

                        </td>
                    </tr>
                @endif
            @else
                <tr>
                    <th></th>
                    <td>
                        <div class="col-sm-3"
                             style="padding-left: unset;">
                            <input
                                style="width: 5rem;"
                                class="form-group input_clas handicap hcp-validation"
                                name="hcp_manual_occid"
                                id="hcp_manual_occid"
                                type="tel" min="0"
                                max="5"
                                name="hcp_online_occid"
                                value="{{ (!empty($memberdata->handicap) ? $memberdata->handicap :'') }}">
                        </div>

                    </td>
                </tr>
            @endif


            <tr>
                <th></th>
                <td>
                    <button type="submit" id="hcp_update_manunal"
                            class="btn btn-primary update_hcp_button">Oppdater!
                    </button>
                </td>
            </tr>

            </tbody>

        </table>
    </center>
</div>

{{--  <div class="col-12  form" style="    ">
     <div class="form-group row">
         <label for="name" class="col-sm-3 col-form-label "><b>Name </b>
         </label>
         <div class="col-sm-8">
         <label for="name"  class="col-sm-8 col-form-label labelname" >{{!empty($memberdata)?$memberdata->Member_Fistname . ' '. $memberdata->Member_Lastname:null}}</label>


         </div>
     </div>

     <div class="form-group row">
         <label for="since" class="col-sm-3 col-form-label"><b>Member Since</b>
         </label>
         <div class="col-sm-8">
             <label for="since" class="col-sm-8 col-form-label labelname" >{{!empty($memberdata)?$memberdata->member_since:null}}
             </label>


         </div>
     </div>
     <div class="form-group row">
         <label for="HCP" class="col-sm-3 col-form-label"><b>Current HCP</b>
         </label>
         <div class="col-sm-8">
             <label for="since" class="col-sm-8 col-form-label labelname" >{{!empty($memberdata)?$memberdata->HCP:null}}
             </label>
         </div>
     </div>


 </div>
 <div class="form-group row">
     <label for="quote" class="col-sm-12 col-form-label" style="text-align: center;">

         <b style="
         font-weight: bold;font-size: inherit;font-family: auto;">ANY COURTESIES EXTENDED TO OUR<br>MEMBER WILL BE HIGHLY APPRECIATED </b>
     </label>

 </div>--}}
