<?php

namespace App\Enum;

enum WeekDay: string
{
    case MONDAY = 'Lundi';
    case TUESDAY = 'Mardi';
    case WEDNESDAY = 'Mercredi';
    case THURSDAY = 'Jeudi';
    case FRIDAY = 'Vendredi';
    case SATURDAY = 'Samedi';
    case SUNDAY = 'Dimanche';

    public function toString(): string
    {
        return $this->value;
    }
}
