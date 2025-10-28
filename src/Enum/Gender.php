<?php

namespace App\Enum;

enum Gender: string
{
    case FEMALE = 'female';
    case MALE = 'male';
    case OTHER = 'other';

    public function toString(): string
    {
        return $this->value;
    }
}
