@extends('layout')
@section('home')
@include('menu')

<div class="col-sm-6 pt-5 mt-5 mx-auto"><h5 class="text-center mb-3">Search by ID or Name</h5>
        	<div class="input-group">
                <input type="text" class="form-control ticket_search" name="ticket_search" placeholder="">
                {{-- <button class="btn btn-dark pl-2 pr-2">
                	<span class="glyphicon glyphicon-search"></span>
                </button> --}}
            </div>
           <div class="display_serach_result" hidden>
               {{-- <table class="table table-hover">
                    <thead>
                        <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Firstname</th>
                        <th scope="col">Lastname</th>
                        <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody class="display_serach_result"> --}}
                        
                    </tbody>
                    </table>
           </div>
           
		</div>
        
@endsection
@push('script2')
    <script>
        $(document).on('keyup','.ticket_search',function () { 
            
            var data = $('.ticket_search').val();
            console.log(data);
            $.ajax({
                url:"{{ route('ticket_search')  }}",
                method:"POST",
                data:{data:data},
                success:function(res){
                    console.log(res);
                    $('.display_serach_result').html(res);
                    $('.display_serach_result').removeAttr('hidden');
                }
            });

            
        });
    </script>
@endpush