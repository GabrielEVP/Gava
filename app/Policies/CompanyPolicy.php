<?php

namespace App\Policies;

use App\Models\Company;
use App\Models\User;

class CompanyPolicy
{
    /**
     * Determina si el usuario tiene acceso a la compañía.
     *
     * @param User $user
     * @param Company $company
     * @return bool
     */
    public function access(User $user, Company $company): bool
    {
        return $user->companies->contains($company);
    }
}
