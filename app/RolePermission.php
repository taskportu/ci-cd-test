<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    protected $table = 'role_permissions';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $guarded = [];
}
