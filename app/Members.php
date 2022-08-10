<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Members extends Model {
	protected $table = 'members';
	public $timestamps = false;
    protected $guarded = [];
	protected $primaryKey = 'MemberID';

	public function urlBelongsToCats() {
		return $this->belongsTo('App\Online\members','members');
	}

	public function urlBelongsToPlace() {
		return $this->belongsTo('App\Online\members','members');
	}

	public static function getTableName() {
		return (new self())->getTable();
	}

	public function getAll()
	{
		return collect(DB::select('select * from members'));
	}
}
