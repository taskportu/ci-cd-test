@extends('layout.home')
@section('content')
<div class="form">
    <div class="heading">
        <h4>Course Add</h4>
    </div>

    <form action="/course-add-process" method="post">
        @csrf
        <div class="mb-3">
            <label for="code" class="form-label">Course Code</label>
            <input type="text" name="code" id="code" class="form-control">
            @error('code')<span style="color: rgb(151, 4, 4); font-weight:bolder">{{$message}}</span>@enderror
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Course Name</label>
            <input type="text" name="name" id="name" class="form-control">
            @error('name')<span style="color: rgb(151, 4, 4); font-weight:bolder">{{$message}}</span>@enderror
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" cols="30" rows="3" class="form-control"></textarea>
        </div>
        <div class="mb-3">
            <label for="department_id">Department</label>
            <select class="form-control" id="department_id" name="department_id">
                <option value="" disabled selected>Select Employee E-mail</option>
                @foreach ($departments as $department)
                    <option value="{{$department->id}}">{{$department->name}}</option>
                @endforeach
            </select>
            @error('department_id')<span style="color: rgb(151, 4, 4); font-weight:bolder">{{$message}}</span>@enderror
          </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection