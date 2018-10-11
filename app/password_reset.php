<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class password_reset extends Model
{
    //
	protected $table = 'password_resets';
	protected $fillable = [
        'email',
    ];
}
