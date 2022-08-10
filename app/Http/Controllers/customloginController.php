<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class customloginController extends Controller
{
    //
  public function customlogin(Request $request){
    return dd($request->all());

  }
}
