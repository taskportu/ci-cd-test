@extends('layout.home')
@section('content')
<div class="add-button">
    <a href="student-add" class="btn btn-primary">Add New Student</a>
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
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">E-Mail</th>
            <th scope="col">Phone No</th>
            <th scope="col">Course</th>
            <th scope="col">Role</th>
            <th scope="col">ACTION</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
            <tr>
                <td scope="row">{{$student->id}}</td>
                <td>{{$student->first_name}}</td>
                <td>{{$student->last_name}}</td>
                <td>{{$student->email}}</td>
                <td>{{$student->phone_no}}</td>
                <td>{{$student->course_name}}</td>
                <td>{{$student->role_name}}</td>
                <td>
                    <a class="btn btn-warning" href="student-edit/{{$student->id}}">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="pagination">{{$students->links()}}</div>
@endsection