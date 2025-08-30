<?php

namespace App\Policies;

use App\Models\Auditor;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AuditorPolicy
{
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
