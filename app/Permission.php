<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $guarded = [];
}
