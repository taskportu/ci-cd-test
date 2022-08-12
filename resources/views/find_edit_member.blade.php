@extends('layout')
@section('home')
@include('menu')

<div class="col-sm-6 pt-5 mt-5 mx-auto"><h5 class="text-center mb-3">Edit/Delete member</h5>
        	<div class="input-group">
                <input type="text" class="form-control p-2 gc-homesearch" name="editmember" placeholder="">
                <button class="btn btn-dark pl-2 pr-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>
                </button>
            </div>
           <div class="replay_edit_member">
           </div>

		</div>

@endsection
