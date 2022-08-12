@extends('layout.home')
@section('content')
<div class="form">
    <div class="heading">
        <h4>Employee User Add</h4>
    </div>

    <form action="/employee-user-add-proccess" method="post">
        @csrf
        {{-- All employees emails show to select one employee --}}
        <div class="mb-3">
            <label for="id" class="form-label">E-Mail</label>
            <select class="form-control" id="id" name="id" autofocus pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
                <option value="" disabled selected>Select Employee E-mail</option>
                @foreach ($employees as $employee)
                    <option value="{{$employee->id}}">{{$employee->email}}</option>
                @endforeach
                @error('id')<span style="color: rgb(151, 4, 4); font-weight:bolder">{{$message}}</span>@enderror
            </select>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" placeholder="PASSWORD" id="password" name="txt_password" onkeyup='check();' required>
            @error('txt_password')<span style="color: rgb(151, 4, 4); font-weight:bolder">{{$message}}</span>@enderror
            {{--  pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$" --}}
        </div>

        <div class="mb-3">
            <label for="confirmpassword" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" placeholder="CONFIRM PASSWORD" id="confirmpassword" name="txt_confirmpassword" onkeyup='check();' value="" required>
            <div id="message"></div>
            @error('txt_confirmpassword')<span style="color: rgb(151, 4, 4); font-weight:bolder">{{$message}}</span>@enderror
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script type="text/javascript">
    function Validate() {
        var password = document.getElementById("password").value;
        var confirmPassword = document.getElementById("confirmpassword").value;
        if (password != confirmPassword) {
            alert("Passwords do not match.");
            return false;
        }
        return true;
    }

	var check = function() {
		if (document.getElementById('password').value =="" && document.getElementById('confirmpassword').value=="") {				document.getElementById('message').innerHTML = 'please input password';
			document.getElementById('message').style.color = 'orange';
		} else if (document.getElementById('password').value ==document.getElementById('confirmpassword').value) {
    			document.getElementById('message').style.color = '#21c267';
    			document.getElementById('message').innerHTML = 'matching';
  		} else {
    		document.getElementById('message').style.color = 'orange';
    		document.getElementById('message').innerHTML = 'not matching';
  		}
	}
</script>

@endsection