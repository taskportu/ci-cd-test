@extends('layout.home')
@section('content')
<head><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script></head>
<div class="form">
    <div class="heading">
        <h4>Student Add</h4>
    </div>

    {{-- session message --}}
    @if (\Session::has('erorr'))
        <div class="text-primary session-msg" style="width: 100%;">
            <p style=" font-weight:bolder; background:orangered">{{\Session::get('erorr')}}</p>
        </div>

        <script>
            $(function(){
                setTimeout(function(){
                    $('.session-msg').slideUp();
                },5000);
            });
        </script>
    @endif

    {{-- student add form --}}
    <form name="myForm" action="/student-add-process" method="post">
        @csrf
        <div class="mb-2">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" name="first_name" id="first_name" class="form-control" pattern="^[a-zA-Z.\\-\\/+=@_ ]*$" required>
            @error('first_name')<span style="color: rgb(151, 4, 4); font-weight:bolder">{{$message}}</span>@enderror
        </div>
        <div class="mb-2">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" name="last_name" id="last_name" class="form-control" pattern="^[a-zA-Z.\\-\\/+=@_ ]*$" required>
            @error('last_name')<span style="color: rgb(151, 4, 4); font-weight:bolder">{{$message}}</span>@enderror
        </div>
        <div class="mb-2">
            <label for="email" class="form-label">E-Mail</label>
            <input type="email" name="email" id="email" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
            @error('email')<span style="color: rgb(151, 4, 4); font-weight:bolder">{{$message}}</span>@enderror
        </div>
        <div class="mb-2">
            <label for="phone_no" class="form-label">Phone No</label>
            <input type="text" name="phone_no" id="phone_no" pattern="^\d{2}\d{3}\d{4}$" class="form-control" required>
            @error('phone_no')<span style="color: rgb(151, 4, 4); font-weight:bolder">{{$message}}</span>@enderror
        </div>
        <div class="mb-2">
            <label for="course_id" class="form-label">Departments</label>
            <select class="form-control" id="department_id" name="department_id" onchange="return department()" required>
                <option value="" disabled selected>Select Your Department</option>
                @foreach ($departments as $department)
                    <option value="{{$department->id}}">{{$department->name}}</option>
                @endforeach
            </select>
            @error('course_id')<span style="color: rgb(151, 4, 4); font-weight:bolder">{{$message}}</span>@enderror
        </div>

        <div class="mb-2">
            <label for="course_id" class="form-label">Course</label>
            <select class="form-control" id="course_id" name="course_id" onchange="course()" required>
                <option value="" disabled selected>Select Your Course</option>
                @foreach ($courses as $course)
                    <option class="_course _department{{$course->department_id}}" value="{{$course->id}}">{{$course->course_name}}</option>
                @endforeach
            </select>
            @error('course_id')<span style="color: rgb(151, 4, 4); font-weight:bolder">{{$message}}</span>@enderror
        </div>

        <div class="mb-2">
            <label for="subjects" class="form-label">Subjects</label>
        </div>
        <div class="mb-2">
            @foreach ($subjects as $subject)
                <input class='_subject _course{{$subject->course_id}}' type="checkbox" id="{{$subject->id}}" name="subject[]" value="{{$subject->id}}">
                <label class='_subject _course{{$subject->course_id}}' for="{{$subject->id}}">{{$subject->subject_name}}</label>
            @endforeach
            @error('subject')<span style="color: rgb(151, 4, 4); font-weight:bolder">{{$message}}</span>@enderror
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script>
    $('._course').hide();
    $('._subject').hide();
    function department(){
        $('._course').hide();
        let department_id = document.getElementById("department_id").value;
        console.log(department_id);
        $('._department'+department_id).show();
    }

    function course(){
        $('._subject').hide();
        let course_id = document.getElementById("course_id").value;
        console.log(course_id);
        $('._course'+course_id).show();
    }
</script>
@endsection