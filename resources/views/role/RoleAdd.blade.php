@extends('layout.home')
@section('content')
<head><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script></head>
    <div class="form" onload="myFunction()">
        <div class="heading">
            <h4>Role Add</h4>
        </div>

        <form action="role-add-process" method="post">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Role Name</label>
                <input type="text" name="name" id="name" class="form-control" pattern="^[a-zA-Z.\\-\\/+=@_ ]*$" required>
                @error('name')<span style="color: rgb(151, 4, 4); font-weight:bolder">{{$message}}</span>@enderror
            </div>
            <button type="submit" id="role_fetch_all" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection