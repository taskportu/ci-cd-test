@extends('layout.home')
@section('content')
<div class="form">
    <div class="heading">
        <h4>Role Edit</h4>
    </div>

    <form action="/role-update-process" method="post">
        @csrf
        <div class="mb-3">
            <input type="hidden" value="{{$role->id}}" name="id" id="id" class="form-control">
        </div>
        <div class="mb-3">
            <label for="name" class="form-label">Role Name</label>
            <input type="text" value="{{$role->name}}" name="name" id="name" class="form-control" pattern="^[a-zA-Z.\\-\\/+=@_ ]*$" required>
            @error('name')<span style="color: rgb(151, 4, 4); font-weight:bolder">{{$message}}</span>@enderror
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection