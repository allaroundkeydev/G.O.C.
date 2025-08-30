<?php
//app\Policies\HaciendaPresentacionPolicy.php
namespace App\Policies;

use App\Models\HaciendaPresentacion;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class HaciendaPresentacionPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, HaciendaPresentacion $haciendaPresentacion): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, HaciendaPresentacion $haciendaPresentacion): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, HaciendaPresentacion $haciendaPresentacion): bool
    {
        return true;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, HaciendaPresentacion $haciendaPresentacion): bool
    {
        return true;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, HaciendaPresentacion $haciendaPresentacion): bool
    {
        return true;
    }
}
