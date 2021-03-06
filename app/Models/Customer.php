<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
	protected $table = 'customer';
    protected $guarded = [];

    public $timestamps = true;

    public function responer_One()
    {

        return $this->hasOne('App\Models\User','id','responer');
    }

    public function create_One()
    {
        return $this->hasOne('App\Models\User','id','created_by');
    }


}
    