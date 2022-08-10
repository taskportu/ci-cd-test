<div class="row memebersearch">	
  <div class="col-12 mx-auto mb-1">
  	<div class="row">
        <div class="col-12 pb-2 pt-1 gc-spt">
            <div class="row">
                <div class="col-6">
                    <div class="row">
                        <div class="col-2">Medl.Nr.</div>
                        <div class="col-10">Medlem</div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="row">
                        <div class="col-6">Klubbnavn</div>
                        {{-- <div class="col-3">Active</div> --}}
                        <div class="col-6 text-right">HCP</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @php ($i = 0)
@foreach($members as $m)

 @php($i++)
 <?php
    $club = DB::table('hcp_regitars')->where('OccID',$m->OccID)->latest('id')->first();
    // $hcp = DB::table('hcp_regitars')->where('OccID',$m->OccID)->latest('id')->first();
    $id = array();
    $id[] = $m->OccID;
    $hcp = DB::table('hcp_regitars')->where('OccID',$m->OccID)->latest('id')->first();
 ?>
  	<div class="row smnl pb-1 mb-1 testimonial" data-id="{{ $m->MemberID }}"  id="{{$m->MemberID}}" data-home="homesearch" data-mousvalue="{{$i}}" >
    	<div class="col-6">
        	<div class="row">
            	<div class="col-2">
                {{ $m->OccID }}
                </div>
            	<div class="col-10">
                {{$m->Member_Fistname }} {{$m->Member_Lastname}}
                </div>
            </div>
        </div>
    	<div class="col-6">
        	<div class="row">
            	<div class="col-10">
                   
                	<span class="gc-st">{{ !empty($m->new_club) ? $m->new_club :'OCC Golf' }}</span>
                </div>
            	<div class="col-2 text-right"><!--N/A-->
                {{-- {{ number_format($m->HCP,1,',','') }} --}}
                {{ !empty($m->new_hcp) ? $m->new_hcp : $m->HCP  }}
                </div>
            </div>
        </div>
    </div>
<?php
    // $hcp = DB::table('hcp_regitars')->orderBy('id', 'desc')->where('OccID', $m->OccID)->first();
    // echo $hcp  ;
        ?>
@endforeach
  </div>
</div>