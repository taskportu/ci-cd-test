<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class club extends Model
{
    protected $table = 'clubs';
	public $timestamps = false;
	protected $fillable = ['ClubID', 'ClubName'];
}
