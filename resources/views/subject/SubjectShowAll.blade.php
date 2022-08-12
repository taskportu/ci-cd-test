@extends('layout.home')
@section('content')

<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>

<link rel="stylesheet" href="//cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js">
<link rel="stylesheet" href="//cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
<div class="add-button">
    <a href="subject-add" class="btn btn-primary">Add New Subject</a>
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
    <table class="table table-striped table-hover" id="sub_list" >
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">Subject Name</th>
            <th scope="col">Course Name</th>
            <th scope="col">ACTION</th>
          </tr>
        </thead>
        <tbody>
            @foreach ($subjects as $subject)
            <tr style="background:none">
                <td scope="row">{{$subject->id}}</td>
                <td>{{$subject->subject_name}}</td>
                <td>{{$subject->course_name}}</td>
                <td>
                    <a class="btn btn-warning" href="subject-edit/{{$subject->id}}">Edit</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
<script>
    $(document).ready(function() {
      $('#sub_list').DataTable();
  } );
   </script>
{{-- <div class="pagination">{{$subjects->links()}}</div> --}}

@endsection