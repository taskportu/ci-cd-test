@extends('layout')
@section('home')
@include('menu')
<div class="container">
<h5 class="text-center">Add Club</h5>
	<div class="row mt-3 text-left">
    	  <div class="card-body ">

            {{-- <form method="POST" action="{{ url('report/clubadd') }}" data-submint> --}}
                    @csrf

                      <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">
                            	 Club Name:</label>
							  <div class="col-md-4">
                               <input id="ClubName" type="text" class="form-control"
                                placeholder="ClubName" required name="ClubName" >
							 </div>
                             <div class="col-md-3">
                             	<button type="button" id="clubsave" class="btn btn-primary">
                                    {{ __('Save') }}
                                </button>
                             </div>
                      </div>
                      <div class="form-group row mb-2">
                      	 {{-- @if(Session::has('success')) --}}
                            <div class="col-md-5 offset-md-4 " id="club_saved" hidden>
                                <div class="alert alert-success text-center">Saved</div>
                            </div>
                          {{-- @endif  --}}
                           {{-- @if(Session::has('error')) --}}
                            <div class="col-md-5 offset-md-4" id="club_error" hidden>
                                <div class="alert alert-danger text-center">All ready Insert</div>
                            </div>
                            {{-- @endif --}}
                        </div>
                   {{-- </form>  --}}
          </div>

</div>
<hr>
<h5 class="text-center pb-1">Edit/Delete</h5>
     <div class="col-6 pt-5  mx-auto">
        	<div class="input-group">
                <input type="text" class="form-control p-2 gc-homesearch" placeholder="Search Club to Edit/Delete" name="findmember_report">
                <button class="btn btn-secondary pl-2 pr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                </button>

            </div>
            <!--<span class="gc-sc float-right">help F1</span>--><div class="replay_clubname">
    </div>
		</div>


@endsection
@push('script2')
    <script>
        $(document).on('click','#clubsave',function (e) {
            e.preventDefault();
            // alert();
            $.confirm({
                title: 'Club Registration!!',
                content: 'Are you sure Add the New Club?' ,
                // autoClose: 'cancelAction|8000',
                buttons: {
                    deleteUser: {
                        text: 'Save',
                        btnClass: 'btn-green',
                        action: function () {
                            var ClubName = $('#ClubName').val();
                            var _token = "{{ csrf_token() }}";
                            $.ajax({
                                url:"{{ route('clubadd') }}",
                                method:"POST",
                                data:{_token:_token,ClubName:ClubName},
                                success:function(res){
                                    console.log(res);
                                    if(res.success){
                                        $('#club_error').attr('hidden',true);
                                        $('#club_saved').removeAttr('hidden');
                                    }
                                    if(res.error){
                                         $('#club_saved').attr('hidden',true);
                                        $('#club_error').removeAttr('hidden');
                                    }
                                }
                            });
                        }
                    },
                    cancelButton: {
                        text:'No',
                        action:function () {
                            // $('#please').attr('hidden',true);
                        }
                    },
                    // cancelAction: function () {
                    // 	$.alert('action is canceled');
                    // }
                }
            });
        });
    </script>
@endpush
