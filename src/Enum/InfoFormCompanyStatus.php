<?php

namespace App\Enum;

enum InfoFormCompanyStatus: string
{
    case VALIDATED = 'Validé';
    case INVALIDATED = 'Pas validé';
    case PENDING = 'En cours de validation';

    public function toString(): string
    {
        return $this->value;
    }
}
