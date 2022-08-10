<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $table = 'user_roles';
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $guarded = [];
}
