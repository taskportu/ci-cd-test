@extends('layout.home')
@section('content')
<div class="add-button">
    <a href="course-add" class="btn btn-primary">Add New Course</a>
    @if (\Session::has('success'))
        <div class="text-primary session-msg">
            <p>{{\Session::get('success')}}</p>
        </div>

        <script>
            $(function(){
                setTimeout(function(){
                    $('.session-msg').slideUp();
                },5000);
            });
        </script>
    @endif
</div>

<div class="table-layout">
    <table class="table table-striped table-hover">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Course Code</th>
            <th scope="col">Course Name</th>
            <th scope="col">Description</th>
            <th scope="col">Department Name</th>
            <th scope="col">ACTION</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($courses as $course)
            <tr>
                <td scope="row">{{$course->id}}</td>
                <td>{{$course->course_code}}</td>
                <td>{{$course->course_name}}</td>
                <td>{{$course->description}}</td>
                <td>{{$course->name}}</td>
                <td>
                    <a class="btn btn-warning" href="course-edit/{{$course->id}}">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="pagination">{{$courses->links()}}</div>
@endsection