<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    protected $table = 'code';
    public $timestamps = false;
    protected $fillable = ['code', 'member_id'];
}
