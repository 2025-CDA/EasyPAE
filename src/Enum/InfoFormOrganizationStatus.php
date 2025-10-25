<?php

namespace App\Enum;

enum InfoFormOrganizationStatus: string
{
    case VALIDATED = 'Validé';
    case PENDING = 'En cours de validation';
    case INVALIDATED = 'Invalidé';

    public function toString(): string
    {
        return $this->value;
    }
}
