<?php

namespace App\Policies;

use App\Models\Representante;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RepresentantePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
{
    return in_array($user->rol, ['admin', 'contador']);
}

public function view(User $user, Representante $representante): bool
{
    return in_array($user->rol, ['admin', 'contador']);
}

public function create(User $user): bool
{
    return in_array($user->rol, ['admin', 'contador']);
}

public function update(User $user, Representante $representante): bool
{
    return in_array($user->rol, ['admin', 'contador']);
}

public function delete(User $user, Representante $representante): bool
{
    return in_array($user->rol, ['admin', 'contador']);
}
}
