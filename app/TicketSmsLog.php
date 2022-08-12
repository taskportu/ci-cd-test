<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TicketSmsLog extends Model
{
    protected $table = 'ticket_sms_logs';
    public $timestamps = false;
    protected $primaryKey = 'id';
    protected $guarded = [];
}
