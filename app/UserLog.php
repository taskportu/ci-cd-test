<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    protected $table = 'user_logs';
    public $timestamps = false;
    protected $primaryKey = 'log_id';
    protected $guarded = [];
}
