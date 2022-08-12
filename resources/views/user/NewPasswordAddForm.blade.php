<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="{{ url('/style.css') }}" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard</title>

    
</head>
<body class="body">
    
        <div class="main-container bg-dark" style="margin: 30px 25%; padding:20px;">

           
<div class="form">
    <div class="heading">
        <h4>Create New Password</h4>
    </div>

    <form action="/new-password-add-process" method="post">
        @csrf
        @if (\Session::has('user'))
            <?php $user=Session::get('user') ?>            
        @endif
        <input type="hidden" name="id" value="{{$user->user_id}}">
        <div class="mb-3">
            <label for="password" class="form-label">New Password</label>
            <input type="password" class="form-control" placeholder="New Password" id="password" name="txt_password" onkeyup='check();' required>
            {{--  pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$" --}}
        </div>
    
        <div class="mb-3">
            <label for="confirmpassword" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" placeholder="Confirm Password" id="confirmpassword" name="txt_confirmpassword" onkeyup='check();' required>
            <div id="message"></div>
        </div>
        <button type="submit" class="btn btn-primary" onclick="return validate()">Save changes</button>
    </form>
        </div>
    
        
        <script type="text/javascript">
            function validate() {
                var password = document.getElementById("password").value;
                var confirmPassword = document.getElementById("confirmpassword").value;
                if (password != confirmPassword) {
                    alert("Passwords do not match.");
                    return false;
                }
                return true;
            }
        
                var check = function() {
                    if (document.getElementById('password').value =="" && document.getElementById('confirmpassword').value=="") {
                        document.getElementById('message').innerHTML = 'please input password';
                        document.getElementById('message').style.color = 'orange';
                    } else if (document.getElementById('password').value ==
                    document.getElementById('confirmpassword').value) {
                        document.getElementById('message').style.color = '#21c267';
                        document.getElementById('message').innerHTML = 'matching';
                  } else {
                    document.getElementById('message').style.color = 'orange';
                    document.getElementById('message').innerHTML = 'not matching';
                  }
                }
            </script>
    
</div>

</body>
</html>











