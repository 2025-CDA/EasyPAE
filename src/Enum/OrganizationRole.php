<?php

namespace App\Enum;

enum OrganizationRole: string
{
    case TRAINER = 'trainer';
    case MONIQUE = 'monique';
    case DIRECTOR = 'director';

    public function toString(): string
    {
        return $this->value;
    }
}
