
    <h4 align="center" class="mt-1">
    
    {{$currendate}}
    
  
  </h4>
  
  <table class="table" border="0">
        <thead>
        </thead>
        <tbody>
            <tr>
                <td>Players Total :</td>
                <td>{{$total = $playerCount->visited +$playerCount->not_visited}}</td>            
            </tr>
            
            <tr>
                <td>Guests today :</td>
                <td>{{ $playerCount->not_visited}}</td> 
            </tr>
            <tr>
                <td>Members today :</td>
                <td>{{ $playerCount->visited}}</td>          
            </tr>
        </tbody>
    </table>
 
   <table class="table table-bordered">
        <thead >
            <tr>
            	<th align="right">MemberID</th>
                <th>Name</th>
                
                <th align="right">TimesPlayed</th>
            </tr>
        </thead>
        <tbody>
         @foreach($allyear as $m)
   @php
   	$guest = App\Reg::whereIn('reg_guest_member',
   		function($query) use ($m) {
    	$query->select('reg_auto')
        	->from('registrations')
            ->whereDate('created_at',$m->created_at)
        	->where('reg_member_id',$m->reg_member_id);
    	}   	
    )->get();
    
   @endphp
   
    @if(!empty($m->reg_member_id))
        @php
            $count = App\Reg::where('reg_member_id',$m->reg_member_id)
            	->whereYear('created_at',date('Y'))               
            	->select(DB::raw('count("reg_member_id") as counts'))                             
                ->groupBy('reg_member_id')
                ->get();
        @endphp
    @endif 
    <tr>
    	<td>{{empty($m->OccID)?'Guest':$m->OccID}}</td>
        <td>{{ empty($m->reg_fistname)?$m->Member_Fistname.' '.$m->Member_Lastname:$m->reg_fistname.' '. $m->reg_lastname}}</td>
        <td>{{ $count->first()->counts }}</td>
       
    </tr>
    @foreach($guest as $g)    
        @php
            $count = App\Reg::where('reg_fistname',$g->reg_fistname)
            	->whereYear('created_at',date('Y'))
               	->select(DB::raw('count("reg_fistname") as counts'))                
                ->groupBy('reg_phone')
                ->get();
        @endphp
        
    <tr bgcolor="#ffffb2">
    	<td data-toggle="tooltip"  data-html="true" data-placement="top" title="Club -{{$g->reg_club}} <br> HCP - {{$g->reg_hcp}} <br> Tlf - {{$g->reg_phone}}"> Guest </td>
        <td data-toggle="tooltip"  data-html="true" data-placement="top" title="Club -{{$g->reg_club}} <br> HCP - {{$g->reg_hcp}} <br> Tlf - {{$g->reg_phone}}">{{ucfirst( $g->reg_fistname)}} {{ucfirst($g->reg_lastname)}} </td>
        <td data-toggle="tooltip"  data-html="true" data-placement="top" title="Club -{{$g->reg_club}} <br> HCP - {{$g->reg_hcp}} <br> Tlf - {{$g->reg_phone}}">{{ $count->first()->counts }}</td>
       
    </tr>
    
    @endforeach
    
   @endforeach
        </tbody> 
        			
   </table>