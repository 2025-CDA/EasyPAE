<?php

namespace App\Enum;

enum CompanyRole: string
{
    case TUTOR = 'Tuteur';
    case LEGAL_REPRESENTATIVE = 'Représentant légal';

    public function toString(): string
    {
        return $this->value;
    }
}
