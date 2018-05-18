<?php

namespace App\Repositories;

use App\Consult;
use App\Medicine;
use App\Disease;

trait HasConsult
{
    public function consult()
    {
        return $this->belongsToMany(Consult::class, 'consult_user');
    }
}
