<?php

namespace App\Enum;

enum UserRole: string
{
    case INTERN = 'Stagiaire';
    case ORGANIZATION = "Membre d'une organisation";
    case COMPANY = "Membre d'une entreprise";

    public function toString(): string
    {
        return $this->value;
    }
}
