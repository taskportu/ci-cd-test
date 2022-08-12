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
    <script src="https://cdn.datatables.net/1.10.12/js/dataTables.bootstrap.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard</title>

    <style>
      
    </style>
    
</head>
<body class="body">
        <div class="main-container bg-dark padding">
            <div class="navbar">
              <div class="logo">
                  {{-- <img src="" alt="logo"> --}}
                  <span><h5 class="logoname">Student Management System</h5></span>
              </div>
    
              <div class="searchbox">
                  <form action="" method="post">
                    <i class="fa fa-search"></i>  
                    <input type="text" placeholder="Search" name="filter_key">
                  </form>
              </div>
            </div>
    
            <div class="container-body">
                <div class="sidebar bg-secondary">
                    <div class="profile">
                        <a href="" data-toggle="modal" data-target="#mainModal"><div class="pro-img"><i class="fa fa-user"></i></div></a>
                        <div class="pro-details">{{ Auth::user()->name }}</div>
                    </div>
                    <ul>
                        <li class="role"><a href="/role-show-all">Role</a></li>
                        <li class="department"><a href="/departmentshowall">Department</a></li>
                        <li class="employee"><a href="/employee-show-all">Employee</a></li>
                        <li class="student"><a href="/student-show-all">Student</a></li>
                        <li class="course"><a href="/course-show-all">Course</a></li>
                        <li class="subject"><a href="/subject-show-all">Subject</a></li>
                        {{-- <li><a href="">Student Subject</a></li> --}}
                        <li class="user"><a href="/employee-user-show-all">Users</a></li>
                        <li><a href="/logout">Log Out</a></li>
                    </ul>
                </div>
    
                <div class="main-body bg-secondary" id="navbar-example">

                  <script type="text/javascript">

                    $(document).ready(function() {             
                         $.ajax({
                           type: "GET",
                           url: "http://127.0.0.1:8000/details",             
                           dataType: "json",   //expect html to be returned                
                           success: function(response){   
                             console.log(response[0]['name']); 
                             console.log(response[0]['email']);                 
                              //  $("#responsecontainer").html(response); 
                               //alert(response);
                           }
                       });
                   });
                   
                   </script>

                    @yield('content')
                </div>
            </div>
        </div>
</body>
</html>



{{-- main modal --}}
<div class="modal fade" id="mainModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title color-black" id="exampleModalLabel">Change Your Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
                <div class="mb-3">
                    @if (Auth::user()->role_id==3)
                        <a href="/student-edit/{{ Auth::user()->employee_id}}">Change Your Details</a>
                    @else
                        <a href="/employee-edit/{{ Auth::user()->employee_id}}">Change Your Details</a>
                    @endif
                </div>
                <div class="mb-3">
                    <a href="" data-toggle="modal" data-target="#exampleModal">Change Your Password</a>
                    {{-- <button class="btn btn-outline-primary" type="button" data-toggle="modal" data-target="#exampleModal">Change Your Password</button> --}}
                </div>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </form>
        </div>
      </div>
    </div>
  </div>







  <!-- Modal -->
  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title color-black" id="exampleModalLabel">Change Password</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="/employee-user-password-edit" method="post">
                @csrf        
                <div class="mb-3">
                    <label for="password" class="form-label color-black">Current Password</label>
                    <input type="password" class="form-control" placeholder="CURRENT PASSWORD" name="txt_current_password" required>
                    {{--  pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$" --}}
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label color-black">Password</label>
                    <input type="password" class="form-control" placeholder="PASSWORD" id="password" name="txt_password" onkeyup='check();' required>
                    {{--  pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[a-zA-Z]).{8,}$" --}}
                </div>
        
                <div class="mb-3">
                    <label for="confirmpassword" class="form-label color-black">Confirm Password</label>
                    <input type="password" class="form-control" placeholder="CONFIRM PASSWORD" id="confirmpassword" name="txt_confirmpassword" onkeyup='check();' required>
                    <div id="message"></div>
                </div>
                <button type="submit" class="btn btn-primary" onclick="return validate()">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </form>
        </div>
      </div>
    </div>
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
