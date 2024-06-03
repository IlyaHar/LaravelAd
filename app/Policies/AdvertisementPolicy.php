<?php

namespace App\Policies;

use App\Models\Advertisement;
use App\Models\User;

class AdvertisementPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function update(User $user, Advertisement $advertisement): bool
    {
        return $user->id === $advertisement->author_id;
    }

    public function delete(User $user, Advertisement $advertisement): bool
    {
        return $user->id === $advertisement->author_id;
    }
}
