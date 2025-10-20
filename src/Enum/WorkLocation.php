<?php

namespace App\Enum;

enum WorkLocation: string
{
    case ON_SITE = 'Présentiel';

    case REMOTE = 'Distanciel';

    case HYBRID = 'Hybrid';

    public function toString(): string
    {
        return $this->value;
    }
}
