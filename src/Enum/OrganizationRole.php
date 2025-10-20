<?php

namespace App\Enum;

enum OrganizationRole: string
{
    case TRAINER = 'Formateur';
    case MONIQUE = 'Monique';
    case DIRECTOR = 'Directeur';

    public function toString(): string
    {
        return $this->value;
    }
}
