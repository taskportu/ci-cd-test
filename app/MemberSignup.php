<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberSignup extends Model
{
    protected $table = 'members_signups';
    public $timestamps = false;
    protected $guarded = [];
}
