<?php

namespace App\Models;

use DB;
use Illuminate\Database\Eloquent\Model;

class AppTracking extends Model
{
	protected $table = 'app_tracking';
	public $timestamps = false;
	protected $fillable = ['date', 'member_id', 'email', 'phone', 'count'];


}
