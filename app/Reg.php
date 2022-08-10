<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reg extends Model {
	protected $table = 'registrations';
	public $timestamps = true;
	protected $primaryKey = 'reg_auto';
    protected $guarded = [];

	public static function getTableName() {
		return (new self())->getTable();
	}

    /**
     * Create Registration Validations
     *
     * @author A
     * @return array
     */
    public static function createValidations($type=""): array
    {
        $arr = [
            'reg_fistname' => 'string|nullable|max:32',
            'reg_lastname' => 'string|nullable|max:32',
            'reg_club' => 'string|nullable|max:64',
//            'reg_hcp' => 'required|numeric',
            'reg_phone' => 'required|string|max:20',
        ];
        if($type !== '') :
            unset($arr['reg_club']);
            unset($arr['reg_hcp']);
        endif;
        return $arr;
    }

    /**
     * Create Registration Validations
     *
     * @author A
     * @return array
     */
    public static function updateValidations(): array
    {
        return [
            'reg_fistname' => 'string|nullable|max:32',
            'reg_lastname' => 'string|nullable|max:32',
            'reg_club' => 'string|nullable|max:64',
//            'reg_hcp' => 'required|numeric',
        ];
    }
}
