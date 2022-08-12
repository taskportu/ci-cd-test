<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HcpImp extends Model
{
    protected $table = 'hcpimp';
    public $timestamps = false;
    protected $fillable = ['occid', 'hcp'];
}
