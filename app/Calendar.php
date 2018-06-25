<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    protected $table = 'calendar';

    protected $fillable = [
        'title', 'description', 'user_id', 'creator_id', 'datetime'
    ];

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function practitioner()
    {
        return $this->hasOne(User::class, 'id', 'creator_id');
    }
}
