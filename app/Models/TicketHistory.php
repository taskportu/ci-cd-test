<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketHistory extends Model
{
    protected $table = 'ticket_histories';
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $guarded = [];
}
