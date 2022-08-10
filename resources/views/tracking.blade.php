@extends('layout')
@section('home')
@include('menu')
<style>
	#voo {background-color: #ffffb2;}
</style>
<div class="container">
	<div class="row mt-4">
		<div class="col">
			<div class="card-header bg-dark text-white">SMS Tracking</div>
			<ul class="nav nav-tabs" id="count" role="tablist">
				<li class="nav-item" role="presentation">
					<a class="nav-link active" id="otp-tab" data-toggle="tab" href="#otp" role="tab" aria-controls="otp" aria-selected="true">OTP</a>
				</li>
				<li class="nav-item" role="presentation">
					<a class="nav-link" id="ticket-tab" data-toggle="tab" href="#ticket" role="tab" aria-controls="ticket" aria-selected="false">Ticket</a>
				</li>
			</ul>
			<div class="tab-content" id="countContent">
				<div class="tab-pane fade show active" id="otp" role="tabpanel" aria-labelledby="otp-tab">
					@if(!$tracking_otps->isEmpty())
					<table class="table table-bordered ">
						<thead style="text-align: center;">
							<tr>
								<th scope="col" style="width: 25%">Member ID</th>
								<th scope="col" style="width: 10%">Phone</th>
								<th scope="col" style="width: 13%">Email</th>
								<th scope="col" style="width: 3%">Count</th>
								<th scope="col" style="width: 10%">Date</th>
								<th scope="col" style="width: 8%">SMS/Email</th>
								<th scope="col" style="width: 31%">Code</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($tracking_otps as $key=>$tracking)
							<tr>
								<td>
									{{$tracking->Member_Fistname}} {{$tracking->Member_Lastname ?? ''}}
								</td>
								<td>
									{{$tracking->phone}}
								</td>
								<td>
									{{$tracking->email}}
								</td>
								<td>
									{{$tracking->count}}
								</td>
								<td>
									{{$tracking->date}}
								</td>
								<td>
									@if($tracking->send_type == 'sms') S @else M @endif
								</td>
								<td>
									{{ $tracking->code }}
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					@else
						<div class="alert alert-danger">
							No Records Found.
						</div>
					@endif
				</div>
				<div class="tab-pane fade" id="ticket" role="tabpanel" aria-labelledby="ticket-tab">
					@if(!$tracking_tickets->isEmpty())
					<table class="table table-bordered ">
						<thead style="text-align: center;">
							<tr>
								<th scope="col" style="width: 10%">Sender Id</th>
								<th scope="col" style="width: 25%">Send By</th>
								<th scope="col" style="width: 8%">Type</th>
								<th scope="col" style="width: 45%">Message</th>
								<th scope="col" style="width: 12%">Date</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($tracking_tickets as $key=>$tracking)
							<tr>
								<td>
									{{$tracking->sender_id}}
								</td>
								@if($tracking->send_by_type == 'member')
									<td>
										{{$tracking->Member_Fistname}} {{$tracking->Member_Lastname ?? ''}}
									</td>
								@else
									<td>
										{{$tracking->first_name}} {{$tracking->last_name ?? ''}}
									</td>
								@endif
								<td>
									{{ ucfirst($tracking->send_by_type)}}
								</td>
								<td>
									{{$tracking->message}}
								</td>
								<td>
									{{\Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $tracking->date_time)->format('Y-m-d H:i')}}
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
					@else
						<div class="alert alert-danger">
							No Records Found.
						</div>
					@endif
				</div>
			</div>
			
		</div>
	</div>
</div>
@endsection
