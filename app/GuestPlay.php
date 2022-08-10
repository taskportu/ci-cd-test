<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class GuestPlay extends Model
{
    protected $table = 'guest_plays';
    public $timestamps = true;
    protected $primaryKey = 'id';
    protected $guarded = [];

    /**
     * Create Guest Play Validations
     *
     * @author A
     * @return array
     */
    public static function createValidations(): array
    {
        return [
            'reg_fistname' => 'required|string|max:191',
            'reg_lastname' => 'required|string|max:191',
            'reg_club' => 'required|integer',
            'reg_phone' => ['required', 'numeric'],
        ];
    }

    /**
     * Update Guest Play Validations
     *
     * @author A
     * @return array
     */
    /*public static function updateValidations()
    {
        $update = GuestPlay::createValidations();
        return $update;
    }*/
}
