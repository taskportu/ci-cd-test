@extends('layout.home')
@section('content')
<div class="form">
    <div class="heading">
        <h4>Employee Edit</h4>
    </div>

    <form action="/employee-update-process" method="post">
        @csrf
        <input type="hidden" value="{{$employee->id}}" name="id">
        <div class="mb-3">
            <label for="first_name" class="form-label">First Name</label>
            <input type="text" value="{{$employee->first_name}}" name="first_name" id="first_name" class="form-control" pattern="^[a-zA-Z.\\-\\/+=@_ ]*$" required>
            @error('last_name')<span style="color: rgb(151, 4, 4); font-weight:bolder">{{$message}}</span>@enderror
        </div>
        <div class="mb-3">
            <label for="last_name" class="form-label">Last Name</label>
            <input type="text" value="{{$employee->last_name}}" name="last_name" id="last_name" class="form-control" pattern="^[a-zA-Z.\\-\\/+=@_ ]*$" required>
            @error('last_name')<span style="color: rgb(151, 4, 4); font-weight:bolder">{{$message}}</span>@enderror
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">E-Mail</label>
            <input type="email" value="{{$employee->email}}" name="email" id="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$" class="form-control" required>
            @error('email')<span style="color: rgb(151, 4, 4); font-weight:bolder">{{$message}}</span>@enderror
        </div>
        <div class="mb-3">
            <label for="phone_no" class="form-label">Phone No</label>
            <input type="text" value="{{$employee->phone_no}}" name="phone_no" id="phone_no" pattern="^\d{2}\d{3}\d{4}$" class="form-control" required>
            @error('phone_no')<span style="color: rgb(151, 4, 4); font-weight:bolder">{{$message}}</span>@enderror
        </div>

        {{-- All departments show to select one department --}}
        <div class="mb-3">
            <label for="department_id">Department</label>
            <select class="form-control" id="department_id" name="department_id" required>
                <option value="" disabled selected>Select Employee E-mail</option>
                @foreach ($departments as $department)
                    <option value="{{$department->id}}" {{$employee->department_id==$department->id?'selected':''}}>{{$department->name}}</option>
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
                    <option value="{{$role->id}}" {{$employee->role_id==$role->id?'selected':''}}>{{$role->name}}</option>
                @endforeach
            </select>
            @error('role_id')<span style="color: rgb(151, 4, 4); font-weight:bolder">{{$message}}</span>@enderror
          </div>
          
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@endsection