@extends('layout.home')
@section('content')
<div class="form">
    <div class="heading">
        <h4>Subject Add</h4>
    </div>

    <form action="/subject-add-process" method="post">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Subject Name</label>
            <input type="text" name="name" id="name" class="form-control" required>
            @error('name')<span style="color: rgb(151, 4, 4); font-weight:bolder">{{$message}}</span>@enderror
        </div>
        <div class="mb-3">
            <label for="course_id">Course</label>
            <select class="form-control" id="course_id" name="course_id" required>
                @foreach ($courses as $course)
                    <option value="{{$course->id}}">{{$course->course_name}}</option>
                @endforeach
            </select>
            @error('course_id')<span style="color: rgb(151, 4, 4); font-weight:bolder">{{$message}}</span>@enderror
          </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection