<?php

namespace App\Enum;

enum UserRole: string
{
    case INTERN = 'Stagiaire';
    case ORGANIZATION = "Organisation";
    case COMPANY = "Entreprise";

    public function toString(): string
    {
        return $this->value;
    }
}
