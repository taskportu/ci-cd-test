<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberLog extends Model
{
    protected $table = 'member_logs';
    public $timestamps = false;
    protected $primaryKey = 'log_id';
    protected $guarded = [];
}
