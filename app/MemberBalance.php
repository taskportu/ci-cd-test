<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberBalance extends Model
{
    protected $table = 'member_balances';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $guarded = [];
}
