<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'tickets';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $guarded = [];
//    public static function where(string $string, string $string1, $MemberID)
//    {
//
//    }
}
