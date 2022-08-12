@extends('layout')
@section('home')
<div class="container-fluid">
	<div class="row">
    <div class="col-12 ">
        		<!--<span class="gc-help">New</span> |-->

        	<a href="" id="addNewMember"  class="gc-help">MEMBER</a> |
        	<a href="{{ url('report') }}" id="addNewClub"  class="gc-help">REPORT</a>

        </div>
    </div>
</div>
<div class="container ">
  <br>
<!--  <div class="dropdown col-12 text-right ">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      Report
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
      <a class="dropdown-item" href="{{ url('report/now') }}">Now</a>
      <a class="dropdown-item" href="{{ url('report/today') }}">Today</a>
    </div>
  </div>
</div>-->
<div class="row">
	
	<a href="#" id="addNewMember"  class="gc-help m-2">ADD</a>
	<a href="#" id="addNewClub"  class="gc-help m-2">EDIT</a>
	<a href="#" id="addNewClub"  class="gc-help m-2">CLUB</a>
</div>

</div>
<div class="container">
<div>


@endsection
