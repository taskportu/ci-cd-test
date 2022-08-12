@extends('layout.home')
@section('content')
<div class="add-button">
    <a href="employee-add" class="btn btn-primary">Add New Employee</a>
    
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
                <th scope="col">Department</th>
                <th scope="col">Role</th>
                <th scope="col">ACTION</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employees as $employee)
            <tr>
                <td scope="row">{{$employee->id}}</td>
                <td>{{$employee->first_name}}</td>
                <td>{{$employee->last_name}}</td>
                <td>{{$employee->email}}</td>
                <td>{{$employee->phone_no}}</td>
                <td>{{$employee->department_name}}</td>
                <td>{{$employee->role_name}}</td>
                <td>
                    <a class="btn btn-warning" href="employee-edit/{{$employee->id}}">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="pagination">{{$employees->links()}}</div>
@endsection