<?php

namespace App\Enum;

enum InfoFormOrganizationStatus: string
{
    case VALIDATED = 'validated';
    case PENDING = 'pending';
    case INVALIDATED = 'invalidated';
    case INITIALIZED = 'initialized';

    public function toString(): string
    {
        return $this->value;
    }
}
