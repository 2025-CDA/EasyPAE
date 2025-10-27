<?php

namespace App\Enum;

enum CompanyRole: string
{
    case TUTOR = 'tutor';
    case LEGAL_REPRESENTATIVE = 'legal_representative';

    public function toString(): string
    {
        return $this->value;
    }
}
