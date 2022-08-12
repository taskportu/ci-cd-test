<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HcpRegitar extends Model
{
    protected $table = 'hcp_regitars';
    public $timestamps = false;
    protected $fillable = [
        'OccID', 'hcp', 'cal_hcp', 'date', 'round_palyed', 'created_at', 'updated_at', 'club',
        'hcp_status', 'coursepar', 'strokesgiven', 'actualstrokes'
    ];
}
