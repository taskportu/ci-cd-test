@extends('layout.home')
@section('content')
<div class="form">
    <div class="heading">
        <h4>Employee Add</h4>
    </div>

    <form action="/employee-add-process" method="post">
        @csrf
        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" name="first_name" id="first_name" class="form-control" pattern="^[a-zA-Z.\\-\\/+=@_ ]*$" required>
            @error('first_name')<span style="color: rgb(151, 4, 4); font-weight:bolder">{{$message}}</span>@enderror
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" name="last_name" id="last_name" class="form-control" pattern="^[a-zA-Z.\\-\\/+=@_ ]*$" required>
            @error('last_name')<span style="color: rgb(151, 4, 4); font-weight:bolder">{{$message}}</span>@enderror
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">E-Mail</label>
            <input type="email" name="email" id="email" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" required>
            @error('email')<span style="color: rgb(151, 4, 4); font-weight:bolder">{{$message}}</span>@enderror
        </div>
        <div class="mb-3">
            <label for="phone_no" class="form-label">Phone No</label>
            <input type="text" name="phone_no" id="phone_no" class="form-control" pattern="^\d{2}\d{3}\d{4}$" required>
            @error('phone_no')<span style="color: rgb(151, 4, 4); font-weight:bolder">{{$message}}</span>@enderror
        </div>

        {{-- All departments show to select one department --}}
        <div class="mb-3">
            <label for="department_id">Department</label>
            <select class="form-control" id="department_id" name="department_id" required>
                <option value="" disabled selected>Select Employee E-mail</option>
                @foreach ($departments as $department)
                    <option value="{{$department->id}}">{{$department->name}}</option>
                @endforeach
            </select>
            @error('department_id')<span style="color: rgb(151, 4, 4); font-weight:bolder">{{$message}}</span>@enderror
          </div>

          {{-- All roles show to select one role --}}
          <div class="mb-3">
            <label for="role_id">Role</label>
            <select class="form-control" id="role_id" name="role_id" required>
                <option value="" disabled selected>Select Employee E-mail</option>
                @foreach ($roles as $role)
                    <option value="{{$role->id}}">{{$role->name}}</option>
                @endforeach
            </select>
            @error('role_id')<span style="color: rgb(151, 4, 4); font-weight:bolder">{{$message}}</span>@enderror
          </div>
          
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection