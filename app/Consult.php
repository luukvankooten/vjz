<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Consult extends Model
{
    protected $table = 'consults';

    protected $fillable = ['details'];

    protected $relation = 'consult_user';

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function medicine()
    {
        return $this->belongsToMany(Medicine::class, $this->relation);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function disease()
    {
        return $this->belongsToMany(Disease::class, $this->relation);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function practitioner()
    {
        return $this->belongsToMany(User::class, $this->relation, 'id', 'practitioner_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function user()
    {
        return $this->belongsToMany(User::class, $this->relation);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function room()
    {
        return $this->belongsToMany(Room::class);
    }

}
