<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{csrf_token()}}" />
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>occ-golf</title>
        <!-- Bootstrap Core CSS -->
        <link rel="shortcut icon" type="image/png" href=""/>
        <link href="{{ asset('/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ asset('/css/bootstrap-glyphicons.css') }}" rel="stylesheet">
		<link href="{{ asset('/css/style.css') }}" rel="stylesheet">
		{{-- calender --}}
		
		{{-- Confirm jquery --}}
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

		<!-- jQuery -->
		
        <script src="{{ asset('/js/jquery-3.3.1.min.js') }}"></script>
        <script src="{{ asset('/js/popper.min.js') }}"></script>
        <script src="{{ asset('/js/bootstrap.min.js') }}"></script>
		<script src="{{ asset('/js/js.js') }}"></script>
		<script src="/js/jquery.PrintArea.js" type="text/JavaScript" language="javascript"></script>
        {{-- date css link --}}
		<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.3/css/bootstrap-datetimepicker.min.css'>

		{{-- Confirm jquery --}}
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

		{{-- calendar --}}
		<script src="/calendar/jquery-ui.js"></script>
		<link rel="stylesheet" href="/calendar/jquery-ui.css">

		@stack('link')
		@stack('style')
		<style>
			.btn-danger.focus,.btn-danger:focus {
				/* border-color: #28a645 !important; */
				box-shadow:0 0 0 .2rem #28a645 !important;
			}
		</style>
		
    </head>
    <body>
        @yield('home')
        <div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
      		<div class="modal-dialog modal-dialog-centered" role="document">
        		<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel"></h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
                    <div class="modal-body p-2">

                    </div>
        		</div>
      		</div>
    	</div>
	</body>
	<form id="hcpregitar" hidden>
		
		<div id="restmessage" hidden>
			<div class="alert alert-success text-center">
            	<strong>Hcp Reset Successfull!</strong> 
			</div>
		</div>
		{{-- No Edited --}}
		<div id="saved" hidden>
			<div class="alert alert-success text-center">
            	<strong>Saved!</strong> 
			</div>
		</div>
		<div id="updatemessage" hidden>
			<div class="alert alert-success text-center">
            	<strong>Email Sent Successfull!</strong> 
			</div>
		</div>
		<div class="form-group row">
			<label for="OccID" class="col-sm-3 col-form-label">Occ ID</label>
			<div class="col-sm-9">
				<input type="text" readonly name="OccID" class="form-control" id="OccID" placeholder="">
			</div>
		</div>
		<div class="form-group row">
			<label for="round_played" class="col-sm-3 col-form-label">Club List</label>
			<div class="col-sm-9">
				{{-- <input readonly type="text" name="round_played" class="form-control" value="" id="round_played" > --}}
				<div id="round">

				</div>
				{{-- <select id="round_played">
					<option >Volvo</option>
				</select> --}}
			</div>
		</div>
		<div class="form-group row">
			<label for="hcpscroe" class="col-sm-3 col-form-label">Last Score </label>
			<div class="col-sm-9">
				<input type="text"  class="form-control" readonly id="hcpscroe" placeholder="HCP Score" value="" name="hcpscroe">
				
				<input type="hidden" class="form-control" id="oldhcpscore" name="oldhcpscore">
			</div>
		</div>
		<div class="form-group row">
			<label for="round_played" class="col-sm-3 col-form-label">Enter Round HCP</label>
			<div class="col-sm-9">
				
				<input type="text" class="form-control" id="cal_hcp" placeholder="HCP Score" value="" name="cal_hcp" >
				{{-- </div> --}}
				{{-- style="width: 41%;float: left;" --}}
				{{-- <div class="col-sm-4"> --}}
					{{-- <button type="button" style="background-color: #28a645; border-color: #28a645;" id="cal" class="btn btn-danger">Calculate</button> --}}
				
				
				
			</div>
		</div>
		<div class="form-group row">
			<label for="date" class="col-sm-3 col-form-label">Date</label>
			<div class="col-sm-9">
				{{-- <input readonly type="text" name="date" class="form-control" value="" id="date" > --}}
				
				<input type="text" id="dt1" />
				<input type="text" id="dt2" name="date" autocomplete="off" />

				<input type="text" id="datesss" placeholder="test">
				<input type="text" id="datesss2" placeholder="test2">
			</div>
		</div>
		<div class="form-group row">
			<label for="date" class="col-sm-3 col-form-label"></label>
			<div class="col-sm-9">

				<span id="please" hidden style="color: green;">
					<strong>Please Wait......</strong>
				</span>
				<br>
				<button type="submit" id="hcpsave" class="btn btn-success">Save</button>
				{{-- {{ Session::get('authenticated') }} --}}
				@if(Session::get('authenticated')=='admin')
					<button type="button" id="reset" class="btn btn-danger">Reset</button>
				@endif
				{{-- <button type="button" id="cal" class="btn btn-danger">Calculate</button> --}}
				
			</div>
		</div>
	</form>
<span id="current_date" style="display: none">{{ date("d-M-yy") }}</span>
	@yield('script')

	<script>
		// $(document).on('click','#datesss2',function () {
		// 	$("#dt2").datepicker({
		// 	dateFormat: "dd-M-yy",
		// 	minDate: 0
		// 	});
		// })
		$(document).on('click','#datesss',function () {
			
			$("#dt1").datepicker({
				dateFormat: "dd-M-yy",
				minDate: 0,
				// onSelect: function() {
					
				// }
			});
			var dt2 = $("#dt2");
			var dt1 = $("#dt1");
			$(dt1).datepicker('setDate', 'today');
			$(dt2).datepicker('setDate', 'today');
			var startDate = $(dt1).datepicker("getDate");
			

			var minDate = $(dt1).datepicker("getDate");
			var dt2Date = dt2.datepicker("getDate");
			//difference in days. 86400 seconds in day, 1000 ms in second
			var dateDiff = (dt2Date - minDate) / (86400 * 1000);

			startDate.setDate(startDate.getDate() - 30);
			console.log(minDate);

			if (dt2Date == null || dateDiff < 0) {
			dt2.datepicker("setDate", minDate);
			} else if (dateDiff > 30) {
			dt2.datepicker("setDate", startDate);
			}
			//sets dt2 maxDate to the last day of 30 days window
			dt2.datepicker("option", "maxDate",minDate );
			dt2.datepicker("option", "minDate", startDate);

			$("#dt2").datepicker({
			dateFormat: "dd-M-yy",
			minDate: 0
			});
		})
      	$(document).on('click','#dt2',function() {
			
			$("#dt2").datepicker({
			dateFormat: "dd-M-yy",
			minDate: 0
			});
		});
    </script>

	@stack('script2')
	
	<script type="text/javascript">
	// HCP Cal 
	$(document).on('click','#cal',function (e) { 
		e.preventDefault();
		var OccID = $('#OccID').val();
		var cal_hcp = $('#cal_hcp').val();
		if(cal_hcp != ''){
			
			var _token = "{{ csrf_token() }}";
			$.ajax({
				url:"{{ route('hcp_calcuation') }}",
				method:"POST",
				data:{_token:_token,OccID:OccID,cal_hcp:cal_hcp},
				success:function(res){
					console.log(res);

					if(res.result){
						$('#hcpscroe').val(res.result);
					}
					if(res.message){
						alert(res.message);
					}
				}
			});
		}
		else{
			alert('Please Enter the HCP');
		}
	});
	// reset hcp
	$(document).on('click','#reset',function (e) {
		e.preventDefault();
		$('#please').removeAttr('hidden');
		$.confirm({
			title: 'Reset HCP!!',
			content: 'Are you sure you want to reset the HCP manually?' ,
			// autoClose: 'cancelAction|8000',
			buttons: {
				deleteUser: {
					text: 'Reset',
					btnClass: 'btn-red',
					action: function () {
						var OccID = $('#OccID').val();
						var _token = "{{ csrf_token() }}";
						$.ajax({
							url:"{{ route('hcp_reset') }}",
							method:"POST",
							data:{_token:_token,OccID:OccID},
							success:function(res){
								console.log(res);
								if(res.success){
									$('#please').attr('hidden',true);
									$('#restmessage').removeAttr('hidden');
									setTimeout(function(){ 
										$('.modal').modal('hide');
										location.reload();
									}, 3000);
									

								}
								
							}
						});
					}
				},
				cancelButton: {
					text:'No',
					action:function () {
						$('#please').attr('hidden',true);	
					}
				},
				// cancelAction: function () {
				// 	$.alert('action is canceled');
				// }
			}
		});

	});
	// Round Save
	$(document).on('click','#hcpsave',function (e) {
		e.preventDefault();
		
		var hcp = $('#hcpscroe').val();
		var date = $('#current_date').text();
		var OccID = $('#OccID').val();
		var old_hcp = $('#oldhcpscore').val();
		var cal_hcp = $('#cal_hcp').val();
		console.log(old_hcp);
		if(cal_hcp != ''){
			$('#please').removeAttr('hidden');
			var _token = "{{ csrf_token() }}";
			$.ajax({
				url:"{{ route('hcp_save') }}",
				method:"POST",
				data:{_token:_token,hcp:hcp,date:date,OccID:OccID,old_hcp:old_hcp,cal_hcp:cal_hcp},
				success:function(res){
					console.log(res);
					// if(res.success){
					// 	$('#please').attr('hidden',true);
					// 	$('#saved').removeAttr('hidden');
					// 	setTimeout(function(){ 
					// 		$('.modal').modal('hide');
					// 		location.reload();
					// 	}, 3000);
						

					// }
					if(res.message){

						$('#please').attr('hidden',true);
						$('#updatemessage').removeAttr('hidden');
						setTimeout(function(){ 
							$('.modal').modal('hide');
							location.reload();
						}, 3000);
						

					}
					else{
						$('#please').attr('hidden',true);
						$('#saved').removeAttr('hidden');
							setTimeout(function(){ 
								$('.modal').modal('hide');
								location.reload();
							}, 3000);
					}
				}
			});
		}
		else{
			alert('Please Enter the HCP');
		}
	})
	// roud played changed
	$(document).on('change','#round_played',function(){
		
		var _token = "{{ csrf_token() }}";
		var OccID = $('#OccID').val();
		var roundplayed = $(this).val();
		// console.log(roundplayed);
		$.ajax({
			url:"{{ route('round_played_check') }}",
			method:"POST",
			data:{OccID:OccID,roundplayed:roundplayed,_token:_token},
			success:function(res){
				
				$('#hcpscroe').attr('value',res.hcp);
				$('#date').attr('value',res.date);
			}
		});
	});
	// HCP Modal 
	$(document).on('click','#hcpmodal',function (e) {
		e.preventDefault();
		
		
		$('#OccID').val('');
		var member_id = $(this).attr('data-memberid');
		var lastDate = new Date();
		// $("#datesss").datepicker("setDate", lastDate);
		// $("#datesss").datepicker( "setDate" , "7/11/2011" );
		var current_date = $('#current_date').text();
		$('#OccID').attr('value',member_id);
		// $('#dt1').attr('value',current_date);

		var _token = "{{ csrf_token() }}";
		$.ajax({
			url:"{{ route('hcpregget') }}",
			method:"POST",
			data:{member_id:member_id,_token:_token},
			success:function(res){
				console.log(res);
				$('#round').html(res.select);
				$('#hcpscroe').attr('value',res.hcp);
				$('#oldhcpscore').attr('value',res.hcp);

				var modal_body = $('#hcpregitar').html();
				$('#exampleModalLabel').text('Registring Score')
				$('.modal-body').html(modal_body);
				$('.modal').modal('show');

				$("#dt1").datepicker({
					dateFormat: "dd-M-yy",
					minDate: 0,
					// onSelect: function() {
						
					// }
				});
				var dt2 = $("#dt2");
				var dt1 = $("#dt1");
				$("#dt2").datepicker({
					dateFormat: "dd-M-yy",
					minDate: 0
				});
				$(dt1).datepicker('setDate', 'today');
				$(dt2).datepicker('setDate', 'today');

				var startDate = $(dt1).datepicker("getDate");
			

				var minDate = $(dt1).datepicker("getDate");
				var dt2Date = dt2.datepicker("getDate");
				//difference in days. 86400 seconds in day, 1000 ms in second
				var dateDiff = (dt2Date - minDate) / (86400 * 1000);

				startDate.setDate(startDate.getDate() - 30);
				console.log(minDate);

				if (dt2Date == null || dateDiff < 0) {
				dt2.datepicker("setDate", minDate);
				} else if (dateDiff > 30) {
				dt2.datepicker("setDate", startDate);
				}
				//sets dt2 maxDate to the last day of 30 days window
				dt2.datepicker("option", "maxDate",minDate );
				dt2.datepicker("option", "minDate", startDate);
				

				if(res.round_palyed !=''){

					$('#round_played option[value='+res.round_palyed+']').attr('selected','selected');
				}
				
			}
		});
	});
	$(document).on('click','.close',function (e) {
		e.preventDefault();
		$('.modal').modal('hide');
		location.reload();
	})
	// Working code for modal
	// $(document).on('click','#hcpmodal',function (e) {
	// 	e.preventDefault();
	// 	var current_date = $('#current_date').text();
	// 	var member_id = $(this).attr('data-memberid');
	// 	var hcp = $(this).attr('data-hcp');
	// 	var modal_body = $('#hcpregitar').html();
	// 	console.log(modal_body);
	// 	// var modal_body = '<form><div class="form-group row"><label for="Member_ID" class="col-sm-3 col-form-label">Member ID</label><div class="col-sm-9"><input type="text" name="Member_ID" class="form-control" value="'+member_id+'" id="Member_ID" placeholder="Member ID"></div></div><div class="form-group row"><label for="hcpscroe" class="col-sm-3 col-form-label">HCP Score </label><div class="col-sm-9"><input type="text" class="form-control" id="hcpscroe" placeholder="HCP Score" value="'+hcp+'" name="hcpscroe"></div></div><div class="form-group row"><label for="date" class="col-sm-3 col-form-label">Date</label><div class="col-sm-9"><input readonly type="text" name="date" class="form-control" value="'+current_date+'" id="date" ></div></div></form>';

	// 	$('#exampleModalLabel').text('Registring Score')
	// 	$('.modal-body').html(modal_body);
	// 	$('.modal').modal('show');
	// });
	var ajaxRes;
	var currentFocus = 0;
	var stext = '';
	var curserInSearch = false;
	var isCtrl,isShift,isAlt = false;

// 	$(document).ready(function(e) {
		
		$('[name="Pick_Date"]').change(function(e){
            ajax(
				'POST',
				{data:$('[name="Pick_Date"]').val()},
				'/report/findinfromation',
				function(res,u,f) {
					$('.listreport').html(res);
					$('[name="Pick_Date"]').val('');
				}
			);
        });
		
	

		$('#findMembers').focus(function(e) {
            curserInSearch = true;
        }).blur(function(e) {
           curserInSearch = false;
        });

		$('#findMembers').keyup(function(e) {
			removeList();
			if(e.keyCode == 40) {				
				
				if(currentFocus>4)
						return currentFocus;
				 else{
						 currentFocus++;
					}
					
				markFormSearchList(currentFocus);
			} else if(e.keyCode == 38) {
				
					if(currentFocus<2)
						return currentFocus;
					else{
							currentFocus--;
						}	
				
				markFormSearchList(currentFocus);
			} else if(e.keyCode == 13) {
				selectFormSearchList();
			} else {
				currentFocus = 0;
				var text = $(this).val();
				if(text != stext) {
					$.get('{{ Request::root() }}/res/findMembers',{member:text},function(res) {
						$('.dsm').html(res);
					});
					stext = text;
				}
			}
			
			function markFormSearchList(currentFocus) {
				$('[data-mousvalue="'+currentFocus+'"]').addClass('fisthomesearch');
							
				$(function() {
				 $(".memebersearch .fisthomesearch").each(function() {
				     if(parseInt($(this).attr('data-mousvalue'))!=parseInt(currentFocus))
				   {
						$(this).removeClass('fisthomesearch');   
					}
				 });
			   });
				
			}
		});

		$('body').delegate('.memebersearch .smnl','click',function(e){
			var id = $(this).data('id');
			if($('[data-gcid="'+id+'"]').length) {
				$('[data-gcid="'+id+'"]').addClass('gc-inlist');
			} else {
				$.get('{{ Request::root() }}/res/getToList',{id:id},function(res) {
					$('.gcmrb, .gc-rmt').show();
					$('.wfr').append(res);
				});
			}
			$('#findMembers').val('').focus();
			$('.dsm').html('');
		}).undelegate('.wfr .gc-ibag','click').delegate('.wfr .gc-ibag','click',function(res) {
			var it = $(this);
			var ids = it.data('id');

			$('.gcmrb').hide();

			$.get('{{ Request::root() }}/res/gustRegFormInReg',{id:ids},function(res) {
				$('.gc-'+ids).append(res);
			});

		}).undelegate('form.gc-rmgrf','submit').delegate('form.gc-rmgrf','submit',function(e) {
			var it = $(this);
			var data = $(this).serializeArray();
			ajax('POST',data,'/res/saveTheNewGuest',function(r,u) {
				var d = it;
				var id = $(d).data('memberid');
				$(r).insertAfter('[data-gcid="'+$(d).data('member')+'"]');
				//$().in(r);
				$('.gc-rgfp'+id).remove();
				$('.gc-hmb'+id).show().find('input').prop('checked',false);

				if(!$('.gc-rmgrf').length) {
					$('.gcmrb').show();
				}
			})
			return false;
		}).delegate('.wfr .gc-inlist','mouseover',function(e){
			$(this).removeClass('gc-inlist');

		})
// 		.delegate('form:not("[data-submint],.gc-rmgrf")','submit',function(e){
// 			var it = $(this);
// 			ajax(it.attr('method'),it.serializeArray(),'/'+it.attr('action'),function(r,u,f) {
// 				$(it.data('log')).html(r);
// 				console.log(r);
// 			});
// 			return false;
// 		});
// 	});

function selectFormSearchList(){
	var id  = $('.fisthomesearch').attr('data-id');
	$.get('{{ Request::root() }}/res/getToList',{id:id},function(res) {
					$('.gcmrb, .gc-rmt').show();
					$('.wfr').append(res);
					$('.memebersearch').hide();
					$('#findMembers').val('');
					$('.fisthomesearch').attr('data-id','');
				});
	
	}
function edit_clubreport(id) { 

		console.log(id);
		
		
	}

	
	/*function removeRegForm(id) 
	{
		$('.gcmrb').show();
		$('.gc-'+id).html('');
		$('.gc-hmb'+id).show().find('input').prop('checked',false);
	}
*/
function find_report_eit_member(id) { 

		$('.'+id).hide();
		$('[data-fistname="'+id+'"]').show();
		$('[data-lastname="'+id+'"]').show();
		$('[data-edit="'+id+'"]').hide();
		$('[data-save="'+id+'"]').show();
		$('[data-hcp="'+id+'"]').hide();
		$('[data-hcpinput="'+id+'"]').show();
		
		
	}
	
	
function save_report_member(id) {
	
	var fistname =$('[data-fistname="'+id+'"]').val();
	var lastname = $('[data-lastname="'+id+'"]').val();
	$('[data-save="'+id+'"]').hide();
	$('[data-fistname="'+id+'"]').hide();
	$('[data-lastname="'+id+'"]').hide();
	$('[data-edit="'+id+'"]').show();
	$('[data-hcpinput="'+id+'"]').hide();
	$('.'+id).show();
	$('.'+id).html(fistname+' '+lastname);
	
	
	
	$('[data-hcp="'+id+'"]').html($('[data-hcpinput="'+id+'"]').val()).show();
	ajax(	'POST',
				{data:id,hcp:$('[data-hcpinput="'+id+'"]').val(),fistname:fistname,lastname:lastname},
				'/report/find_edit_replay_member',
				function(res,u,f) {
					console.log(res);
				
				
				}
			);
	
 }
 
 function active_staus(elem) {	
	var status = $(elem).data("active");
	var id    = $(elem).data('activestatusid');
	
	/*if($(elem).data('active')=='inactive'){		
		$(elem).removeClass('btn-danger');
		$(elem).addClass('btn-success ');
		$(elem).data('active','active');
				
					
	} else {
				
		
		$(elem).data('active','inactive');		
	}*/
	if(status=='active')
	{
		$(elem).removeClass('btn-success');
		$(elem).addClass('btn-danger');
		$(elem).data('active','inactive');
		var id    = $(elem).data('activestatusid');
		ajax(	'POST',
				{data:id,status:status},
				'/report/find_edit_active',
				function(res,u,f) {
					console.log(res);
							
				}
			);
		}
	else
	{
		$(elem).removeClass('btn-danger');
		$(elem).addClass('btn-success ');
		$(elem).data('active','active');
		var id    = $(elem).data('activestatusid');
		ajax(	'POST',
				{data:id,status:status},
				'/report/find_edit_active',
				function(res,u,f) {
					console.log(res);
							
				}
			);
	}
 }




	
	
	
function remove_regfromgust(id)
	{
		var id = $(id).attr('data-id');
		$('[data-regfrom="'+id+'"]').remove();
		
	}

	function ajax(m,s,u,f) {
		$.ajax({
			type:m,
			headers: {
				'X-CSRF-TOKEN':'{{ csrf_token() }}'
			},
			data:s,
			url:'{{ Request::root() }}'+u,
			success:function(r) {
				if(f)
					f(r,u,f);
			}
		});
	}

	function f(n,a) {
    	var f = window[n];
		if(typeof f !== 'function')
			return;
		f.apply(window,a);
	}

	function autoReg(r = '') {
		var r = r == '' ? '':r.reg;
		var ele = $('.wfr [data-gcid]').not('.gc-reg-done').first();
		$('.guest_name_update').hide();
		$('[data-regfrom]').hide();
		if(ele.length) {
			var data = ele.find('input').serializeArray();
				//alert(data);
				$.each(function(data){
					var getVal  =   $(data).val();
					if(stored.indexOf(getVal) != -1)
						$(data).fadeOut();
					else
						alert('gh');
				});
				
				if(r)
					data[data.length] = {name:"reg",value:r};
					
			ajax('POST',data,'/res/registerRegList',function(r,u){
				console.log(r);
				if(typeof r == 'object') {
					if(!r.error) {
						ele.find('.gc-reg-marked').html('<button class="btn btn-success  float-left"><span class="gc-help"><span class="glyphicon glyphicon-ok"></span></span></button>');
						ele.addClass('gc-reg-done');
						autoReg(r);
						$('#findMembers').val('').focus();
					} else {
					}
				}
			});
		} else {
			$('#findMembers').val('').focus();
			cleatTimer = setTimeout('removeList()',30000);
		}
	}

	function removeList() {
		$('.wfr .gc-reg-done').each(function(index, element) {
            $(this).remove();
        });

		if(!$('.wfr [data-gcid]').length) {
			$('.gcmrb, .gc-rmt').hide();
		}
	}

	function getHelp() {
		ajax('GET','','/page/help',function(r,u) {
			$('.modal-body').html(r);
			$('.modal').modal('show')
		});
	}

	function getNewMemberForm() {
		ajax('GET','','/page/newMemberForm',function(r,u) {
			$('.modal-body').html(r);
			$('.modal').modal('show')
		});
	}

	function getNewClubForm() {
		ajax('GET','','/page/addNewClubForm',function(r,u) {
			$('.modal-body').html(r);
			$('.modal').modal('show')
		});
	}
	
	function removegest(id)	{	
	  $('[data-gcid="'+id+'"]').remove();
	  $('[data-child="'+id+'"]').parent().remove();
	}
	
	function remove_updategustplayer(id) {	  
		var id = $(id).attr('data-id');
		$('[data-updategustid="'+id+'"]').remove();
	}
	
	function register() {
		autoReg();
	}
	$(function () {
  		$('[data-toggle="tooltip"]').tooltip()
	})
	
	function find_report_member(id){
		$('#'+id).remove();
		ajax(	'POST',
				{data:id},
				'/report/find_replay_delete_member',
				function(res,u,f) {
					$('.replay_clubname').html(res);
					$('#'+id).remove();
				}
			);
	}
	
	function find_report_club(id) {
		$('#'+id).remove();
		
		ajax(	'POST',
				{data:id},
				'/report/find_replay_delete_club',
				function(res,u,f) {
					$('.replay_clubname').html(res);
					$('#'+id).remove();
				}
			);
		
	}
	
	$('[name="findmember_report"]').keyup(function(e){
			
            ajax(
				'POST',
				{data:$('[name="findmember_report"]').val()},
				'/report/findclub',
				function(res,u,f) {
					$('.replay_clubname').html(res);
					
				}
			);
        });
		
		$('[name="editmember"]').keyup(function(e){
			
            ajax(
				'POST',
				{data:$('[name="editmember"]').val()},
				'/report/find_replay_edit_member',
				function(res,u,f) {
					$('.replay_edit_member').html(res);
					
				}
			);
        });
		
var n = 1;
   
$('[data-left="last"]').click(function(e){
	$('#alreadytoday').hide();
	 
	var today=new Date(); //Today's Date
	n++;
	var requiredDate=new Date(today.getFullYear(),today.getMonth(),today.getDate()+n)
	console.log(requiredDate);
	let date = JSON.stringify(requiredDate)
	
	 ajax(
				'POST',
				{data:date.slice(1,11)},
				'/report/todaylest_and_next',
				function(res,u,f) {
					$('#replay_last_next').html(res);
					}
			);
       
	return requiredDate;
	});		
$('[data-right="next"]').click(function(e){
	$('#alreadytoday').hide();
	n--;
	var today=new Date(); //Today's Date
	var requiredDate=new Date(today.getFullYear(),today.getMonth(),today.getDate()+n)
	let date = JSON.stringify(requiredDate)
	 ajax(
				'POST',
				{data:date.slice(1,11)},
				'/report/todaylest_and_next',
				function(res,u,f) {
				$('#replay_last_next').html(res);	
				}
			);
	return requiredDate;
	});	
	
function edit_clubreport(id) {
	$('[data-edibuttontclub="'+id+'"]').hide();
	$('[data-clubsave="'+id+'"]').show();
	$('[data-inputclupname="'+id+'"]').show();
	$('[data-span="'+id+'"]').hide();
	
}
function update_clupname(id) {
	var name = $('[data-inputclupname="'+id+'"]').val();
	var id  =  id;
	$('[data-inputclupname="'+id+'"]').hide();
	$('[data-clubsave="'+id+'"]').hide();
	$('[data-edibuttontclub="'+id+'"]').show();
	$('[data-span="'+id+'"]').show().html(name);
	ajax(
				'POST',
				{data:id,name:name},
				'/report/editnameclubname_replay_member',
				function(res,u,f) {
					console.log(res);
					
				}
			);
}

	
		
</script>

</html>
