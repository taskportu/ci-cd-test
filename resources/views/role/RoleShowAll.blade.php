@extends('layout.home')
@section('content')
    <div class="add-button">
        <a href="role-add" class="btn btn-primary">Add New Role</a>
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
                <th scope="col">NAME</th>
                <th scope="col">ACTION</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($roles as $role)
                <tr>
                    <td scope="row">{{$role->id}}</td>
                    <td>{{$role->name}}</td>
                    <td>
                        <a class="btn btn-warning" href="role-edit/{{$role->id}}">Edit</a>
                        {{-- <a class="btn btn-danger" href="role-delete/{{$role->id}}">Delete</a> --}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="pagination">{{$roles->links()}}</div>
@endsection