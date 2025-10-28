<?php

namespace App\Enum;

enum UserRole: string
{
    case INTERN = 'intern';
    case ORGANIZATION = "organization";
    case COMPANY = "company";

    public function toString(): string
    {
        return $this->value;
    }
}
