@extends('layout.home')
@section('content')
<div class="form">
    <div class="heading">
        <h4>Student Edit</h4>
    </div>

    <form action="/student-update-process" method="post">
        @csrf
        <input type="hidden" value="{{$student->id}}" name="id">
        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" value="{{$student->first_name}}" name="first_name" id="first_name" class="form-control" pattern="^[a-zA-Z.\\-\\/+=@_ ]*$" required>
            @error('first_name')<span style="color: rgb(151, 4, 4); font-weight:bolder">{{$message}}</span>@enderror
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" value="{{$student->last_name}}" name="last_name" id="last_name" class="form-control" pattern="^[a-zA-Z.\\-\\/+=@_ ]*$" required>
            @error('last_name')<span style="color: rgb(151, 4, 4); font-weight:bolder">{{$message}}</span>@enderror
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">E-Mail</label>
            <input type="email" value="{{$student->email}}" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" class="form-control" required>
            @error('email')<span style="color: rgb(151, 4, 4); font-weight:bolder">{{$message}}</span>@enderror
        </div>
        <div class="mb-3">
            <label for="phone_no" class="form-label">Phone No</label>
            <input type="text" value="{{$student->phone_no}}" name="phone_no" pattern="^\d{2}\d{3}\d{4}$" id="phone_no" class="form-control" required>
            @error('phone_no')<span style="color: rgb(151, 4, 4); font-weight:bolder">{{$message}}</span>@enderror
        </div>
        <div class="mb-3">
            <label for="course_name" class="form-label">Course</label>
            @php
                foreach ($courses as $course) {
                    if ($course->id==$student->course_id) {
                        $course_name=$course->course_name;
                    }
                }
            @endphp
            <input type="hidden" id="course_id" name="course_id" value="{{$student->course_id}}">
            <input type="text" name="course_name" class="form-control" value="{{$course_name}}" id="course_name" readonly>
            {{-- <select class="form-control" id="course_id" name="course_id" required>
                @foreach ($courses as $course)
                    <option value="{{$course->id}}" {{$student->course_id==$course->id?'selected':''}} readonly>{{$course->course_name}}</option>
                @endforeach
            </select> --}}
            @error('course_id')<span style="color: rgb(151, 4, 4); font-weight:bolder">{{$message}}</span>@enderror
        </div>
        <div class="mb-3">       
            @foreach ($subjects as $subject)
                <input class='_subject _course{{$subject->course_id}}' type="checkbox" id="subject.{{$subject->id}}" name="subject[]" value="{{$subject->id}}"
                    @foreach ($student_subjects as $student_subject)
                        {{$student_subject->subject_id==$subject->id?'checked':''}}
                    @endforeach
                 >
                <label class='_subject _course{{$subject->course_id}}' for="subject.{{$subject->id}}">{{$subject->subject_name}}</label>
            @endforeach
        </div>
        @error('subject')<span style="color: rgb(151, 4, 4); font-weight:bolder">{{$message}}</span>@enderror
        @if (\Session::has('erorr'))
            <div class="session-msg form-label" style="color: rgb(151, 4, 4); font-weight:bolder; width:100%">
                {{\Session::get('erorr')}}
            </div>

            <script>
                $(function(){
                    setTimeout(function(){
                        $('.session-msg').slideUp();
                    },5000);
                });
            </script>
        @endif

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script>
    let course_id = document.getElementById("course_id").value;
    $('._subject').hide();
    $('._course'+course_id).show();
    function course(){
        let course_id = document.getElementById("course_id").value;
        console.log(course_id);
        $('._course'+course_id).show();
    }
</script>
@endsection