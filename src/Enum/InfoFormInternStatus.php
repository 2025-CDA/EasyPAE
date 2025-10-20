<?php

namespace App\Enum;

enum InfoFormInternStatus: string
{
    case VALIDATED = 'wesh';

    case INVALIDATED = 'pas cool';

    case PENDING = 'En cours';

    public function toString(): string
    {
        return $this->value;
    }
}
