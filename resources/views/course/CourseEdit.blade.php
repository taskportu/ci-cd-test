@extends('layout.home')
@section('content')
<div class="form">
    <div class="heading">
        <h4>Course Edit</h4>
    </div>

    <form action="/course-update-process" method="post">
        @csrf
        <input type="hidden" name="id" value="{{$course->id}}">
        <div class="mb-3">
            <label for="code" class="form-label">Course Code</label>
            <input type="text" value="{{$course->course_code}}" name="code" id="code" class="form-control">
            @error('code')<span style="color: rgb(151, 4, 4); font-weight:bolder">{{$message}}</span>@enderror
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Course Name</label>
            <input type="text" value="{{$course->course_name}}" name="name" id="name" class="form-control">
            @error('name')<span style="color: rgb(151, 4, 4); font-weight:bolder">{{$message}}</span>@enderror
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" cols="30" rows="3" class="form-control">{{$course->description}}</textarea>
        </div>
        <div class="mb-3">
            <label for="department_id">Department</label>
            <select class="form-control" id="department_id" name="department_id">
                @foreach ($departments as $department)
                    <option value="{{$department->id}}" {{$course->department_id==$department->id? 'selected':''}}>{{$department->name}}</option>
                @endforeach
            </select>
            @error('department_id')<span style="color: rgb(151, 4, 4); font-weight:bolder">{{$message}}</span>@enderror
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection