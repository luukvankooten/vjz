<?php

namespace App\Repositories;

use App\Address;

trait HasAddress
{
    /**
     * A user has an address.
     *
     * @return mixed
     */
    public function address()
    {
        return $this->belongsToMany(Address::class, 'address_user', 'user_id', 'address_id');
    }

    /**
     * Save address belongs to user
     *
     * @param Address $address
     * @return mixed
     */
    public function saveAddress(Address $address)
    {
        return $this->address()->save($address);
    }
}