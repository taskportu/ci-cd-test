<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MemberChangesLog extends Model
{
    protected $table = 'member_changes_logs';
    public $timestamps = false;
    protected $primaryKey = 'log_id';
    protected $guarded = [];
}
