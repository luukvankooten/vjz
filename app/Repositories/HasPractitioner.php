<?php

namespace App\Repositories;

trait HasPractitioner
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function practitioner()
    {
        return $this->belongsToMany(self::class, 'user_practitioner', 'user_id', 'practitioner_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function user()
    {
        return $this->belongsToMany(self::class, 'user_practitioner', 'practitioner_id', 'user_id');
    }

    /**
     * @param $user
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function assignPractitioner($user)
    {
        return $this->practitioner()->attach($user);
    }
}