@extends('layout')
@section('home')
    <div class="container-fluid">
        <div class="row">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mx-auto mt-5 pt-5">
                        <form class="row" action="auth/login" method="post" data-submit="authLogin">
                            @csrf
                            <div class="input-group mb-3">
                                {{-- <select name="user_type" id="user_type" class="form-control mb-4">
                                    <option value="admin">Admin</option>
                                    <option value="user">User</option>
                                </select> --}}
                                <input required autocomplete="off" placeholder="Username / E-mail" class="form-control" type="text" name="username">

                                <input required autocomplete="off" placeholder="Password" class="form-control" type="password" name="code">

                                <button class="btn btn-primary mr-auto ml-auto" type="submit" style="height: 2.4rem">Login</button>
                            </div>
                            <span class="d-none pass-err" style="padding: 0px 10px 3px 10px; background:#e3b6b6; color: #510404; border:1px solid #510404; border-radius: 4px;"></span>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>

        $('[data-submit="authLogin"]').submit(function(e) {
            var it = $(this);
            ajax(it.attr('method'),it.serializeArray(),'/'+it.attr('action'),function(r,u,f) {
                console.log({'r' : r, 'u' : u, 'f' : f});
                console.log(r.error === false);
                console.log(r.mode == 'admin');
                if(r.error === false) {
                    if(r.mode == 'admin') {
                        console.log('admin');
                        window.location.href = "{{ route('admin.home') }}"
                    }
                    else{
                        console.log('user');
                        window.location.href = "{{ URL::to('/registration') }}"
                    }
                    //window.location.reload('{{ url('admin') }}');
                    //window.location {{ url("shop/") }}';
                }
                else {
                    if(r.error === true)
                        $('.pass-err').empty().text(r.message).removeClass('d-none').addClass('d-block');
                    setTimeout(function(){ $('.pass-err').empty().removeClass('d-block').addClass('d-none'); }, 5000);
                }
            });
            return false;
        });
    </script>
@endsection



{{--
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

    --}}
{{--var prev = @if(Session::has('prevRouteName'))'{{Session::get('prevRouteName')}}'@else false @endif;--}}{{--

$('[data-submint="authLogin"]').submit(function(e) {
	var it = $(this);
	ajax(it.attr('method'),it.serializeArray(),'/'+it.attr('action'),function(r,u,f) {
		console.log(r);
		if(typeof(r) === "object" && !r.error) {
		    --}}
{{--if(prev === 'send.sms') {--}}{{--

		    --}}
{{--    var url = '{{route('send.sms')}}';--}}{{--

            --}}
{{--    window.location.href = url;--}}{{--

            --}}
{{--}--}}{{--

            if(r.mode == 'admin') {
				window.location.href = "{{ URL::to('admin') }}"
			} else if(r.mode == 'user'){
				window.location.href = "{{ URL::to('/') }}"
			}
			--}}
{{--//window.location.reload('{{ url('admin') }}');--}}{{--

			--}}
{{--//window.location {{ url("shop/") }}';--}}{{--

		}
	});
	return false;
});
</script>
@endsection
--}}
