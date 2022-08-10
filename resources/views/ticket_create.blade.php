@extends('layout')
@section('home')
@include('menu')
<div class="container">
    <div class="row text-left">
        <div class="card-body " style="padding: 0px"
            <div class="row rowsmargin">
                {{-- @if(Session::has('success')) --}}
                <div class="alert alert-success col-md-4 offset-md-5 text-center" style="display:none">
                        <strong>Saved!</strong> 
                    </div>
                {{-- @endif  --}}
                </div> 
                
                {{-- @if(Session::has('error')) --}}
                <div class="form-group row mb-2">
                    <div class="alert alert-danger col-md-10 form-group row" style="display:none">
                        <strong>OccID All ready Insert</strong> 
                    </div>
                </div> 
                {{-- @endif --}}
                <div class="class col-md-12">
                    
                    <form method="POST" action="{{ route('ticket_save') }}" data-submint >
                        @csrf
                        <div class="row">
                            <div class="col-md-3" ></div>
                            <div class="col-md-6" >
                                
                                <div class="card">
                                    <h5 class="card-header h5" style="background-color: #007bff;color: white;font-size: 1.29rem;">Ticket</h5>
                                    <div class="card-body card-body-panel">
                                        
                                        <div class="form-group row">
                                            <label for="name" class="col-md-4 col-form-label
                                            text-md-right require_label">Occ ID</label>
                                        
                                            <div class="col-md-6">
                                                <input id="name" type="text" class="form-control"
                                                name="OccID" value="{{ $member->OccID }}" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="name" class="col-md-4 col-form-label
                                            text-md-right require_label">Name</label>
                                            <div class="col-md-6">
                                                <input id="name" type="text" class="form-control"
                                                name="name" value="{{ $member->Member_Fistname .' '.$member->Member_Lastname }}" readonly >
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label for="member_type" class="col-md-4 col-form-label 
                                            text-md-right require_label">Product</label>
                                            <div class="col-md-6">
                                                <select class="form-control" name="product" id="product" required>

                                                    <option value="" >Select</option>
                                                    <option value="Ferry tickets">Ferry tickets</option>
                                                    <option  value="Greenfee tickets">Greenfee tickets</option>
                                                    <option  value="Pro lessons tickets">Pro lessons tickets</option>
                                                    <option value="Buggy tickets">Buggy tickets</option>
                                                    
                                                </select>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group row">
                                            <label for="shre_number" class="col-md-4 col-form-label 
                                            text-md-right">Count</label>
                                            <div class="col-md-3">
                                                <input id="share_number" type="text" class="form-control  number_only" name="count" maxlength="2" required>
                                            </div>
                                        </div>
                                        <div class="form-group row mb-0">
                                
                                            <div class="center col-11">
                                                <p class="float-sm-right pcursor" style="">
                                                    <button type="submit" id="submit" class="btn btn-primary" style="margin-top: 10px;font-size: 1.29rem;height: 45px;">Add</button>
                                                </p>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                        
                    </form> 
                </div>
            </div>
            <div class="col-md-6">
                            
            </div>
            {{-- <div class="form-group row mb-2">
                @if(Session::has('success'))
                    <div class="alert alert-success col-md-4 offset-md-5 text-center">
                        <strong>Saved!</strong> 
                    </div>
                @endif 
                </div> 
                
                @if(Session::has('error'))
                <div class="form-group row mb-2">
                    <div class="alert alert-danger col-md-10 form-group row">
                        <strong>OccID All ready Insert</strong> 
                    </div>
                </div> 
                @endif
           
            </div>     --}}
        </div>
    </div>
 </div>           

@endsection