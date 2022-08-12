@extends('layout.home')
@section('content')
   <div class="form">
        <div class="heading">
          <h4>Department Edit</h4>
        </div>
        <form action="/departmentupdateprocess" method="post">
            @csrf
            <div class="mb-3">
                <input type="hidden" value="{{$departments->id}}" class="form-control" id="id" name="id" required>
            </div>
            <div class="mb-3">
                <label for="code" class="form-label">Department Code</label>
                <input type="text" value="{{$departments->code}}" class="form-control" id="code" name="code" required>
                @error('code')<span style="color: rgb(151, 4, 4); font-weight:bolder">{{$message}}</span>@enderror
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Department Name</label>
                <input type="text" value="{{$departments->name}}" class="form-control" id="name" name="name" required>
                @error('name')<span style="color: rgb(151, 4, 4); font-weight:bolder">{{$message}}</span>@enderror
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" id="description" cols="30" rows="3" class="form-control">{{$departments->description}}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
@endsection