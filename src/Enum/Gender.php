<?php

namespace App\Enum;

enum Gender: string
{
    case FEMALE = 'Mme';
    case MALE = 'M';
    case OTHER = 'Autres';

    public function toString(): string
    {
        return $this->value;
    }
}
