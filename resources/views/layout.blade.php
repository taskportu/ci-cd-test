<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">

        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="apple-touch-fullscreen" content="yes" />
        <meta name="apple-mobile-web-app-title" content="OCC">
        <meta name="apple-mobile-web-app-status-bar-style" content="default" />

        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="csrf-token" content="{{csrf_token()}}" />
        <meta name="description" content="OCC">
        <meta name="author" content="OCC">
        <title>OCC</title>
		
        <link rel="apple-touch-icon" href="{{asset('images/favicon/apple-icon.png')}}">
        <link rel="apple-touch-startup-image" href="{{asset('images/favicon/apple-icon.png')}}">

        <link rel="apple-touch-icon" sizes="57x57" href="{{asset('images/favicon/apple-icon-57x57.png')}}">
        <link
            rel="apple-touch-startup-image"
            sizes="57x57"
            href="{{asset('images/favicon/apple-icon-57x57.png')}}"/>

        <link rel="apple-touch-icon" sizes="60x60" href="{{asset('images/favicon/apple-icon-60x60.png')}}">
        <link
            rel="apple-touch-startup-image"
            sizes="60x60"
            href="{{asset('images/favicon/apple-icon-60x60.png')}}"/>

        <link rel="apple-touch-icon" sizes="72x72" href="{{asset('images/favicon/apple-icon-72x72.png')}}">
        <link
            rel="apple-touch-startup-image"
            sizes="72x72"
            href="{{asset('images/favicon/apple-icon-72x72.png')}}"/>

        <link rel="apple-touch-icon" sizes="76x76" href="{{asset('images/favicon/apple-icon-76x76.png')}}">
        <link
            rel="apple-touch-startup-image"
            sizes="76x76"
            href="{{asset('images/favicon/apple-icon-76x76.png')}}"/>

        <link rel="apple-touch-icon" sizes="114x114" href="{{asset('images/favicon/apple-icon-114x114.png')}}">
        <link
            rel="apple-touch-startup-image"
            sizes="114x114"
            href="{{asset('images/favicon/apple-icon-114x114.png')}}"/>

        <link rel="apple-touch-icon" sizes="120x120" href="{{asset('images/favicon/apple-icon-120x120.png')}}">
        <link
            rel="apple-touch-startup-image"
            sizes="120x120"
            href="{{asset('images/favicon/apple-icon-120x120.png')}}"/>

        <link rel="apple-touch-icon" sizes="144x144" href="{{asset('images/favicon/apple-icon-144x144.png')}}">
        <link
            rel="apple-touch-startup-image"
            sizes="144x144"
            href="{{asset('images/favicon/apple-icon-144x144.png')}}"/>

        <link rel="apple-touch-icon" sizes="152x152" href="{{asset('images/favicon/apple-icon-152x152.png')}}">
        <link
            rel="apple-touch-startup-image"
            sizes="152x152"
            href="{{asset('images/favicon/apple-icon-152x152.png')}}"/>

        <link rel="apple-touch-icon" sizes="180x180" href="{{asset('images/favicon/apple-icon-180x180.png')}}">
        <link
            rel="apple-touch-startup-image"
            sizes="180x180"
            href="{{asset('images/favicon/apple-icon-180x180.png')}}"/>

        <link rel="icon" type="image/png" sizes="144x144"  href="{{asset('images/favicon/android-icon-144x144.png')}}">
        <link rel="icon" type="image/png" sizes="192x192"  href="{{asset('images/favicon/android-icon-192x192.png')}}">
        <link rel="icon" type="image/png" sizes="32x32" href="{{asset('images/favicon/favicon-32x32.png')}}">
        <link rel="icon" type="image/png" sizes="96x96" href="{{asset('images/favicon/favicon-96x96.png')}}">
        <link rel="icon" type="image/png" sizes="16x16" href="{{asset('images/favicon/favicon-16x16.png')}}">
        <link rel="manifest" href="{{asset('images/favicon/manifest.json')}}?date=13052021&v=1">
        <meta name="OCC" content="#ffffff">
        <meta name="OCC" content="{{asset('images/favicon/ms-icon-144x144.png')}}">
        <meta name="White" content="#ffffff">

        <!-- Bootstrap Core CSS -->
        <link href="{{ asset('/css/bootstrap.min.css') }}?date=20-04-2021&v=1" rel="stylesheet">
        <link href="{{ asset('/css/bootstrap-glyphicons.css') }}?date=20-04-2021&v=1" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
        <!-- Latest compiled and minified CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
{{--        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">--}}
{{--        <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap-glyphicons.css" rel="stylesheet">--}}
        <link href="{{ asset('css/template.css') }}?date=07-05-2021&v=2" rel="stylesheet">
		<link href="{{ asset('/css/style.css') }}?date=07-05-2021&v=3" rel="stylesheet">
		<link href="{{ asset('/css/cropper.css') }}?date=12-01-2022&v=1" rel="stylesheet">

        {{-- Google Fonts --}}
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Roboto+Slab&display=swap" rel="stylesheet">

		{{-- Confirm jquery --}}
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300&display=swap" rel="stylesheet">
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
        <script src="{{ asset('/js/moment.js') }}"></script>
        <script src="{{ asset('/js/moment-with-locales.js') }}"></script>
{{--        <script src="{{asset('/js/service-worker.js')}}"></script>--}}
		<script src="{{ asset('/js/js.js') }}?date=13092021&v=2"></script>
		<script src="{{ asset('/js/cropper.js') }}"></script>
		<script src="/js/jquery.PrintArea.js" type="text/JavaScript" language="javascript"></script>

        {{-- date css link --}}
		<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/3.1.3/css/bootstrap-datetimepicker.min.css'>

		{{-- Confirm jquery --}}
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>

		{{-- calendar --}}
		<script src="{{ asset('/calendar/jquery-ui.js') }}"></script>
		<link rel="stylesheet" href="{{ asset('/calendar/jquery-ui.css') }}">

        <!-- Latest compiled and minified JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

        <!-- (Optional) Latest compiled and minified JavaScript translation files -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>

		{{-- <link rel="stylesheet" href="/app_calender/jquery.ui.all.css">
        <script src="/app_calender/jquery-1.8.3.js"></script>
        <script src="/app_calender/jquery.ui.core.js"></script>
        <script src="/app_calender/jquery.ui.widget.js"></script>
        <script src="/app_calender/ui/jquery.ui.datepicker.js"></script>
		<link rel="stylesheet" href="/app_calender/demos.css"> --}}

		{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">


    <link rel="stylesheet" href="/app_calender/style.css"> --}}

		@stack('link')
		@stack('style')
		<style>
			.btn-danger.focus,.btn-danger:focus {
				/* border-color: #28a645 !important; */
				box-shadow:0 0 0 .2rem #28a645 !important;
			}
			@media print {
				.single_view {
				font-size: 1mm;
				/*   font-size: 1mm !important;*/
				}
			}
			.pop-up-font{
				font-size: 15px;
			}
		</style>
		<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-178235821-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-178235821-1');
</script>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-MMXVLW9');</script>
<!-- End Google Tag Manager -->



    </head>
    <body>
        <!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MMXVLW9"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
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
            	<strong>Your HCP has been updated!!</strong>
			</div>
		</div>
		<div id="updatemessage" hidden>
			<div class="alert alert-success text-center">
            	<strong>Email Sent Successfull!</strong>
			</div>
		</div>
		<div id="before_delete">
			<div class="form-group row">
				<label for="OccID" class="col-sm-3 col-form-label pop-up-font">Occ ID</label>
				<div class="col-sm-3">
					<input type="text" readonly name="OccID" class="form-control data_count" id="OccID" placeholder="">
				</div>
			</div>
			<h5 >Register HCP of Round Played</h5>
			<hr>
			<br>
			<div class="form-group row">
				<label for="date" class="col-sm-3 col-form-label pop-up-font">Date Played</label>
				<div class="col-sm-9">
					{{-- <input readonly type="text" name="date" class="form-control" value="" id="date" > --}}

					<input type="text" id="dt1" hidden/>
					<input type="text" id="dt2" name="date" autocomplete="off" style="width: 34%;" />
				</div>
			</div>

			<div class="form-group row">
				<label for="round_played" class="col-sm-3 col-form-label pop-up-font">Course Played</label>
				<div class="col-sm-7">
					{{-- <input readonly type="text" name="round_played" class="form-control" value="" id="round_played" > --}}
					<div id="round">

					</div>
					{{-- <select id="round_played">
						<option >Volvo</option>
					</select> --}}
				</div>
			</div>
			<div class="form-group row">

				<label for="hcpscroe" class="col-sm-3 col-form-label pop-up-font">Current HCP</label>
				<div class="col-sm-3">
					<input type="text"  class="form-control" readonly id="hcpscroe" placeholder="HCP Score" value="" name="hcpscroe">
					<input type="hidden" class="form-control" id="oldhcpscore" name="oldhcpscore">
				</div>
			</div>
			<div class="form-group row">
				<label for="coursepar" class="col-sm-3 col-form-label pop-up-font">Course Par</label>
				<div class="col-sm-3">
					<input type="text" required  class="form-control" id="coursepar"  value="72" name="coursepar">

				</div>
			</div>
			<div class="form-group row">
				<label for="strokesgiven" class="col-sm-3 col-form-label pop-up-font">Strokes Given</label>
				<div class="col-sm-3">
					<input type="text" required  class="form-control" id="strokesgiven"  value="" name="strokesgiven">
				</div>
			</div>
			<div class="form-group row">
				<label for="actualstrokes" class="col-sm-3 col-form-label pop-up-font">Actual Strokes</label>
				<div class="col-sm-3">
					<input type="text" required class="form-control" id="actualstrokes"  value="" name="actualstrokes">
				</div>
			</div>
			<div class="form-group row">
				<label for="round_played" class="col-sm-3 col-form-label pop-up-font">HCP Played</label>
				<div class="col-sm-3">

					<input type="text" class="form-control hcp-validation" id="cal_hcp" placeholder="HCP Score" value="" name="cal_hcp" >
					{{-- </div> --}}
					{{-- style="width: 41%;float: left;" --}}
					{{-- <div class="col-sm-4"> --}}
						{{-- <button type="button" style="background-color: #28a645; border-color: #28a645;" id="cal" class="btn btn-danger">Calculate</button> --}}
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
					{{-- @if(Session::get('authenticated')=='admin')
						<button type="button" id="reset" class="btn btn-danger">Reset</button>
					@endif --}}
					{{-- <button type="button" id="cal" class="btn btn-danger">Calculate</button> --}}

				</div>
			</div>
		</div>
		<div id="saved_details" hidden>
			<div class="form-group row">
				<label for="OccIDS" class="col-sm-3 col-form-label">Occ ID</label>
				<div class="col-sm-3">
					<input type="text" readonly name="OccIDS" class="form-control" id="OccIDS" placeholder="">
				</div>
			</div>
			<div class="form-group row">
				<label for="member_name" class="col-sm-3 col-form-label">Member Name</label>
				<div class="col-sm-7">
					<input type="text" class="form-control" id="member_name"  readonly value=""  >
				</div>
			</div>
			<div class="form-group row">
				<label for="new_hcp" class="col-sm-3 col-form-label">Your New Handicap </label>
				<div class="col-sm-3">
					<input type="text" class="form-control" id="new_hcp" readonly value="" >
				</div>
			</div>
			<div class="form-group row">
				<label for="" class="col-sm-3 col-form-label"></label>
				<div class="col-sm-9">
					<button data-id="exit" class="btn btn-danger after_save">Exit</button>
					<button  data-id="enter_another" class="btn btn-success after_save">Enter Another</button>
				</div>
			</div>
		</div>



	</form>
<span id="current_date" style="display: none">{{ date("d-M-yy") }}</span>
    {{-- Auto Complete --}}
{{--    <script src="https://cdn.jsdelivr.net/gh/xcash/bootstrap-autocomplete@v2.3.7/dist/latest/bootstrap-autocomplete.min.js"></script>--}}
	@yield('script')
	<script>
		$(document).on('click','#dt2',function() {
			// alert();
			$("#dt2").datepicker({
			dateFormat: "yy-mm-dd",
			minDate: 0
			});
		});
    </script>

	@stack('script2')

	<script type="text/javascript">
		//    validatation number only
         $(".number_only").keypress(function (e) {
            //if the letter is not digit then display error and don't type anything
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
                //display error message
                // $("#errmsg").html("Digits Only").show().fadeOut("slow");
                    return false;
            }
        });
		// Validation

		$(document).on('keyup','.hcp-validation',function (event) {
			$(this).val($(this).val().replace(/[^0-9.,\.]/g,''));
			if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
				event.preventDefault();
			}

		});
	//  $("#cal_hcp").on("keypress",function (event) {
    //         //this.value = this.value.replace(/[^0-9\.]/g,'');
    //  $(this).val($(this).val().replace(/[^0-9\.]/g,''));
    //         if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
    //             event.preventDefault();
    //         }
    //     });
	// Exit orEnter Another
	$(document).on('click','.after_save',function (e) {
		e.preventDefault();
		var selected = $(this).attr('data-id');
		if(selected == 'exit'){
			$('.modal').modal('hide');
			location.reload();
		}
		else{
			$('#cal_hcp').val('');
			$('#strokesgiven').val('');
			$('#actualstrokes').val('');

			$('#saved_details').attr('hidden',true);
			$('#before_delete').removeAttr('hidden');
			$('#please').attr('hidden',true);
			$('#saved').attr('hidden',true);
		}
	})
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
					// console.log(res);

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

	function new_calculation_hcp () {

		var hcp = $('#hcpscroe').val(); //current hcp
		var current_hcp = hcp.replace(',','.');
		var coursepar = $('#coursepar').val();
		var strokesgiven = $('#strokesgiven').val();
		var actualstrokes = $('#actualstrokes').val();
		if (coursepar != '' && strokesgiven !='' &&  actualstrokes !='') {

			var storke_ab = parseFloat(coursepar)+parseFloat(strokesgiven);

			var strokes_to = parseFloat(actualstrokes)-parseFloat(storke_ab);

			var strokes_total = parseFloat(strokes_to) * parseFloat(0.86); //mulitple

			var hcp_play = parseFloat(strokes_total.toFixed(2)) + parseFloat(current_hcp);
			var hcpss = hcp_play.toFixed(2);
			var hcp_played = hcpss.replace('.',',');
			$('#cal_hcp').val(hcpss);
			$('#cal_hcp').attr('data-strock',strokes_to);
		}
	}
	$(document).on('mouseleave','#actualstrokes',function () {
		new_calculation_hcp();
	})
	// Round Save
	$(document).on('click','#hcpsave',function (e) {
		e.preventDefault();

		var hcp = $('#hcpscroe').val(); //current hcp
		var dates = $('#dt2').val();
		var OccID = $('#OccID').val();
		var old_hcp = $('#oldhcpscore').val();

		var club = $('#round_played').val();
		var d = new Date(dates);
		var curr_date = d.getDate();
		var curr_month =  d.getMonth() + 1; //Months are zero based
		var curr_year = d.getFullYear();
		var mon =(curr_month.length < 2) ? curr_month : '0'+curr_month;
		var day = (curr_date.length < 2) ? curr_date : '0'+curr_date;
		var date = curr_year + "-" + mon + "-" + day;
		// new calculation
		var coursepar = $('#coursepar').val();
		var strokesgiven = $('#strokesgiven').val();
		var actualstrokes = $('#actualstrokes').val();
		new_calculation_hcp();
		var day_count = $('#OccIDS').attr('data-count');

		var stock_check = $('#cal_hcp').attr('data-strock');
		console.log(stock_check);
		// stock check
		if(stock_check != 15 ){
			alert('Please verify that data entered is correct');
		}
		// end
		if(day_count <= 2){
			alert('Your Played Maximum Round');
		}
		if(coursepar > 74 || coursepar < 68  ){
			alert('Please verify that data entered is correct');
		}
		if(actualstrokes != '' && strokesgiven !='' ){
			$('#please').removeAttr('hidden');
			var _token = "{{ csrf_token() }}";
			var cal_hcp = $('#cal_hcp').val();
			// console.log('txt '+cal_hcp);
			$.ajax({
				url:"{{ route('hcp_save') }}",
				method:"POST",
				data:{_token:_token,hcp:hcp,date:date,OccID:OccID,old_hcp:old_hcp,cal_hcp:cal_hcp,club:club,coursepar:coursepar,strokesgiven:strokesgiven,actualstrokes:actualstrokes,day_count:day_count},
				success:function(res){
					console.log(res);
					// if(){
					// 	alert('Your Played Maximum Round');
					// }
					if(res.limit){
						$('#please').attr('hidden',true);
						alert('Your Played Maximum Round');
						// location.reload();
					}
					// else if(res.count_error)
					// {
					// 	$('#please').attr('hidden',true);
					// 	// alert('Your Played Maximum Round');
					// }
					else
					{

						if(res.success){
							$('#before_delete').remove();
						}
						else{
							$('#before_delete').attr('hidden',true);
							$('#saved_details').removeAttr('hidden');
							$('#saved').removeAttr('hidden');
							$('#member_name').val(res.fullname);
							$('#new_hcp').val(res.hcp);
							$('#hcpscroe').val(res.hcp);
							$('#oldhcpscore').val(res.hcp);
							$('#OccIDS').val($('#OccID').val());
							$('#OccIDS').attr('data-count',res.daycount);
							$('.data_count').attr('data-count',res.daycount);
						}
					}
				}
			});
		}
		else{
			alert('Please Fill the Blank');
		}
	})
	// roud played changed
	// $(document).on('change','#round_played',function(){

	// 	var _token = "{{ csrf_token() }}";
	// 	var OccID = $('#OccID').val();
	// 	var roundplayed = $(this).val();
	// 	// console.log(roundplayed);
	// 	$.ajax({
	// 		url:"{{ route('round_played_check') }}",
	// 		method:"POST",
	// 		data:{OccID:OccID,roundplayed:roundplayed,_token:_token},
	// 		success:function(res){

	// 			$('#hcpscroe').attr('value',res.hcp);
	// 			$('#date').attr('value',res.date);
	// 		}
	// 	});
	// });
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
				// console.log(res);
				$('#round').html(res.select);
				$('#hcpscroe').attr('value',res.hcp);
				$('#oldhcpscore').attr('value',res.hcp);

				var modal_body = $('#hcpregitar').html();
				$('#exampleModalLabel').text('New HCP Registration')
				$('.modal-body').html(modal_body);
				$('.modal').modal('show');

				$("#dt1").datepicker({
					dateFormat: "dd-M-yy",
					minDate: 0,
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
				// console.log(minDate);

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

		$('body #homeMemberPlay').delegate('.memebersearch .smnl','click',function(e){
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
			    if(r.error !== undefined && e.error !== true) {
			        showReturnMessages(r.message);
                }
			    else {
				var d = it;
				var id = $(d).data('memberid');
				$(r).insertAfter('[data-gcid="'+$(d).data('member')+'"]');
				//$().in(r);
				$('.gc-rgfp'+id).remove();
				$('.gc-hmb'+id).show().find('input').prop('checked',false);

				if(!$('.gc-rmgrf').length) {
					$('.gcmrb').show();
				}
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

		// console.log(id);


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
					// console.log(res);


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
		// $("#hcpmodal").attr("disabled", true);
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
		$('.gcmrb').css('display', 'block');
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
                // console.log(r);
				if(f)
					f(r,u,f);
			}
		});
	}

	function f(n,a) {
    	var f = window[n];
		if(typeof f !== 'function')
			return;
		// f.apply(window,a);
	}

	function autoReg(r = '', app = false) {
		var r = r == '' ? '':r.reg;
		// console.log(r);
		let element = '.wfr [data-gcid]';
		// if(app == true) element = '#memberPlay .wfr [data-gcid]';
		var ele = $(element).not('.gc-reg-done').first();
        // console.log(ele.length, app, element);
        if(app !== true)
		    $('.guest_name_update').hide();
		$('[data-regfrom]').hide();
		if(ele.length) {
			var data = ele.find('input').serializeArray();
            // alert(data);
            $.each(function(data){
                var getVal  =   $(data).val();
                console.log(getVal);
                if(stored.indexOf(getVal) != -1)
                    $(data).fadeOut();
                else
                    alert('gh');
            });

            let url = '/res/registerRegList';
            if(app === true) url = '/app/register/reg-list';
            if(r) data[data.length] = {name:"reg",value:r};
            console.log(data);
			ajax('POST', data, url, function(r, u){
                // console.log('inAjaxCallback');
				// console.log(r, u);
				if(typeof r == 'object') {
					if(!r.error) {
						ele.find('.gc-reg-marked').html('<button class="btn btn-success  float-left"><span class="gc-help"><span class="glyphicon glyphicon-ok"></span></span></button>');
						ele.addClass('gc-reg-done');
						autoReg(r, app);
						$('#findMembers').val('').focus();
					} else {
                        showReturnMessages(r.message);
					}
				}
			});
		}
		else {
			$('#findMembers').val('').focus();
			if(app === false)
			    cleatTimer = setTimeout('removeList()',30000);
			else location.reload();
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

	function register(app = false) {
        if(app === false) autoReg();
        else autoReg('', true);
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

		$('[name="guestPlayFindMember"]').keyup(function(e){

            ajax(
				'POST',
				{data:$('[name="guestPlayFindMember"]').val()},
				'/guest-play/find/member',
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
