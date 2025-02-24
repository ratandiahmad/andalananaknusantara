<?php

namespace App\Policies;

use App\Models\SuratPesananInstansi;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class SuratPesananInstansiPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SuratPesananInstansi $suratPesananInstansi): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SuratPesananInstansi $suratPesananInstansi): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SuratPesananInstansi $suratPesananInstansi): bool
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SuratPesananInstansi $suratPesananInstansi): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SuratPesananInstansi $suratPesananInstansi): bool
    {
        //
    }
}
