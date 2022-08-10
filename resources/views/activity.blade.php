@extends('layout')
@section('home')
@include('menu')
<div class="container">
	 <div class="row mt-3 text-left">
        <div class="card-body "> 
        			<div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">
                            	 Date</label>
							  <div class="col-md-4">
                                    <input id="name" type="date" class="form-control" name="Pick_Date" >
							 </div>
                             <div class="col-md-3">
                             	<span id="processtodayinfor"></span>
                             </div>
                      </div>
                    <form method="POST" action="{{ url('report/activityadd') }}" data-submint>
                        @csrf

                       <div class="form-group row">
                            <label for="Activity" class="col-md-4 col-form-label text-md-right">
                            	Activity:
                             </label>
							   <div class="col-md-6">
                                	<input id="Activity" type="text" class="form-control" 
                                	name="Activity" placeholder="What activities took place today" >
							  </div>
                       </div>
                        
                        <div class="form-group row">
                            <label for="Weather" class="col-md-4 col-form-label text-md-right">
                            	Weather:
                             </label>
                                   <div class="col-md-6">
                                        <input id="Weather" type="text" class="form-control"
                                         name="Weather" placeholder="Describe today's weather ... early morning, afternoon etc." >
                                  </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="Temp" class="col-md-4 col-form-label text-md-right">
                            	Temp:
                             </label>
							 <div class="col-md-6">
                                <input id="Name" type="text" class="form-control" name="Temp" 	
         placeholder="What was todays temperature today around 14:00"  >
							 </div>
                        </div>

                        

						<div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">
                              Hotel Report:
                            </label>
							   <div class="col-md-6">
                                 <textarea class="form-control" name="Hotel" rows="3" ></textarea>
							  </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">
                            	Hotel Occ:
                            </label>
							   <div class="col-md-2">
                                <input id="HotelOcc" type="text" class="form-control"
                                 name="HotelOcc" >
							  </div>
                        
                            <label for="password" class="col-md-2 col-form-label text-md-right">
                            	Hotel Revenue:
                            </label>
							   <div class="col-md-2">
                                <input id="HotelRevenue" type="text" class="form-control" 
                                name="HotelRevenue" >
							  </div>
                        </div>
                        <div class="form-group row">
                            <label for="Restaurant" class="col-md-4 col-form-label text-md-right">
                            	Restaurant Report:
                             </label>
							   <div class="col-md-6">
                                 <textarea id="Restaurant"  class="form-control" name="Restaurant" rows="3"  placeholder="How was restaurant business, including guests served" ></textarea>
							  </div>
                        </div>
                        
                    <div class="form-group row">
                       <label for="RestRevenue" class="col-md-4 col-form-label text-md-right">
                            Restaurant Revenue:
                        </label>
                           <div class="col-md-6">
                            <input id="Restaurant" type="text" class="form-control"
                             name="RestRevenue" >
                          </div>
                    </div>
					  <div class="form-group row">
                            <label for="password" class="col-md-4 col-form-label text-md-right">					
                            Other Comment:
                            </label>
							   <div class="col-md-6">
                                   <textarea class="form-control"  name="comment"
                                    id="exampleFormControlTextarea1" placeholder="Write other incidents that can be interesting to keep" rows="3"></textarea>
							  </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="Name" class="col-md-4 col-form-label text-md-right">
                            	Name:
                             </label>
							 <div class="col-md-6">
                                <input id="Name" type="text" placeholder="Name on the person registering the information" class="form-control" name="Name" >
							 </div>
                        </div>
                        
                       <div class="form-group row mb-2">
                            <div class="col-md-6 offset-md-4 ">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Save') }}
                                </button>
                            </div>
                        </div> 
                    <div class="form-group row mb-2">
                           @if(Session::has('success'))
                            <div class="alert alert-success col-md-4 offset-md-5 text-center">
                                <strong>Saved!</strong> 
                            </div>
                           @endif 
                           </div>
                    </form>
                </div>
              
        	
        </div>
        <div class="container listreport">
        	
        </div> 
      
      
                   
</div>
@endsection