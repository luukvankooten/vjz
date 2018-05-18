<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'addresses';

    protected $fillable = ['establishment', 'zip', 'street', 'number', 'addition'];

    public function group()
    {
        return $this->belongsToMany(Group::class, 'address_user', 'address_id', 'user_id');
    }
}
