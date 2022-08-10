@extends('layout')
@section('home')
@include('menu')

<div class="col-sm-6 pt-5 mt-5 mx-auto"><h5 class="text-center mb-3">Search By ID / Name</h5>
        	<div class="input-group">
                <input type="text" class="form-control p-2 ticket_member" name="ticket_member" placeholder="">
                <button class="btn btn-dark pl-2 pr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                </button>
            </div>
           <div class="replay_ticket_member">
           </div>

		</div>

@endsection
@push('script2')
<script>
    $(document).on('keyup','.ticket_member',function(){
        var _token = "{{ csrf_token() }}";
        var searchkey = $(this).val();
        $.ajax({
            url: "{{ route('search_ticket_member') }}",
            method:"POST",
            data:{ searchkey:searchkey,_token:_token },
            success:function(res){
                console.log(res);
                $('.replay_ticket_member').html(res);
            }
        });

    });
</script>
@endpush

