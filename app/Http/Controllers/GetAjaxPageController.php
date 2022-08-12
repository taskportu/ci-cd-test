<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Members;
use App\Reg;

class GetAjaxPageController extends Controller
{
	public function addNewMember(Request $request)
	{
		return view('res.page.addNewMemberForm');
	}

	public function addNewClubForm(Request $request)
	{
		return view('res.page.addNewClubForm');
	}

	public function helps()
	{
		return view('res.page.help');
	}
	public function getAddNew(Request $request)
	{
		return view('res.page.addnew');
	}
}
