@extends('layout.home')
@section('content')
<div class="add-button">
    <a href="departmentadd" class="btn btn-primary">Add New Department</a>
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
            <th scope="col">CODE</th>
            <th scope="col">NAME</th>
            <th scope="col">DESCRIPTION</th>
            <th scope="col">ACTION</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($departments as $department)
            <tr>
                <td scope="row">{{$department->id}}</td>
                <td>{{$department->code}}</td>
                <td>{{$department->name}}</td>
                <td>{{$department->description}}</td>
                <td>
                    <a class="btn btn-warning" href="departmentedit/{{$department->id}}">Edit</a>
                    {{-- <a class="btn btn-danger" href="departmentdelete/{{$department->id}}">Delete</a> --}}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<div class="pagination">{{$departments->links()}}</div>
@endsection