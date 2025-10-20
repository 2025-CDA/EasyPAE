<?php

namespace App\Enum;

enum InfoFormStatus: string
{
    case COMPLETED_INTERN_VALIDATION = 'completed_intern';

    case COMPLETED_COMPANY_VALIDATION = 'completed_company';

    case COMPLETED_ORGANIZATION_VALIDATION = 'completed_organization';

    case FULLY_COMPLETED = 'fully_completed';

    case REJECTED = 'rejected';

    public function toString(): string
    {
        return $this->value;
    }
}
