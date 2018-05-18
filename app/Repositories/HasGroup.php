<?php

namespace App\Repositories;

use App\Group;

trait HasGroup
{
    /**
     * @return mixed
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class);
    }

    /**
     * @param string $group
     * @return mixed=
     */
    public function hasGroup(string $group)
    {
        return $this->group->contains('name', $group);
    }
}