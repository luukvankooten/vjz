<?php

namespace App\Repositories;

use App\Allergy;

trait HasAllergy
{
    public function allergy()
    {
        return $this->belongsToMany(Allergy::class, 'allergy_user', 'allergy_id', 'user_id');
    }
}