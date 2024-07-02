<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;
use App\Models\Profile;
use App\Models\User;

class ProfilePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the profile.
     */
    public function update(User $user, Profile $profile)
    {
        // Autoriza se o usuário é dono do perfil
        return $user->id === $profile->user_id;
    }
}
