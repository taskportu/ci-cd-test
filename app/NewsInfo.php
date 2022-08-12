<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsInfo extends Model
{
    protected $table = 'news_updates';
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $guarded = [];
}
