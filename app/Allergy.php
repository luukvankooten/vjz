<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Allergy extends Model
{

    protected $fillable = ['allergy'];

    public function user()
    {
        return $this->belongsToMany(User::class, 'allergy_user');
    }
}
