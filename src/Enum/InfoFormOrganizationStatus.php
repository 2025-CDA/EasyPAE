<?php

namespace App\Enum;

enum InfoFormOrganizationStatus: string
{
    case VALIDATED = 'guénial';

    case INVALIDATED = 'a chier';

    case PENDING = 'pas le temps';

    public function toString(): string
    {
        return $this->value;
    }
}
