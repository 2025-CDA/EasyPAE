<?php

namespace App\Enum;

enum WorkLocation: string
{
    case ON_SITE = 'on_site';

    case REMOTE = 'remote';

    case HYBRID = 'hybrid';

    public function toString(): string
    {
        return $this->value;
    }
}
