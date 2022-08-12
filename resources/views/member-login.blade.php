@extends('layout')
@section('home')
<div class="container-fluid">
	<div class="row">
    	<div class="container">
        	<div class="row">
            	<div class="col-lg-6 mx-auto mt-5 pt-5">
                	<form class="row" action="auth/login" method="post" data-submint="authLogin">
                    	<div class="col-12">
                        	<input required autocomplete="off" placeholder="Password" class="form-control" type="password" name="code">
                            @csrf
                        </div>
                        <div class="col-12 mt-2">
                        	<button class="btn btn-primary float-right" type="submit">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>

$('[data-submint="authLogin"]').submit(function(e) {
	var it = $(this);
	ajax(it.attr('method'),it.serializeArray(),'/'+it.attr('action'),function(r,u,f) {
		console.log(r);
		if(typeof(r) === "object" && !r.error) {
			if(r.mode == 'admin') {
				window.location.href = "{{ URL::to('admin') }}"
			} else if(r.mode == 'user'){
				window.location.href = "{{ URL::to('/') }}"
			}
			//window.location.reload('{{ url('admin') }}');
			//window.location {{ url("shop/") }}';
		}
	});
	return false;
});
</script>
@endsection