
<div class="col-10 text-left offset-md-1">
	<table class="table table-bordered">
                  <thead>
                    <tr>
                      <th scope="col">List of Report</th>
                    </tr>
                  </thead>
               <tbody>
               @foreach($information as $display)
                <tr>
                 <td>{{$display->Date}}</td>
                </tr>
                @endforeach()
               </tbody>
       </table>
</div>


	

        	 


	
    	
        