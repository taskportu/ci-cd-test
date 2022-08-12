@extends('layout.home')
@section('content')
<div class="add-button">
    <a href="/employee-user-add" class="btn btn-primary">Add New Employee User</a>
    
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
    @if (\Session::has('erorr'))
        <div class="text-primary session-msg">
            <p>{{\Session::get('erorr')}}</p>
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
            <th scope="col">Name</th>
            <th scope="col">E-Mail</th>
            <th scope="col">Role</th>
            <th scope="col">ACTION</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($employee_users as $employee_user)
            <tr>
                <td scope="row">{{$employee_user->id}}</td>
                <td>{{$employee_user->name}}</td>
                <td>{{$employee_user->email}}</td>
                <td>{{$employee_user->role_name}}</td>
                <td>
                    <a class="btn btn-danger" href="employee-user-delete/{{$employee_user->id}}">Delete</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="pagination">{{$employee_users->links()}}</div>
@endsection