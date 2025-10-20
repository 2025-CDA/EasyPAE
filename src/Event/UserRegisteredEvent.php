<?php

namespace App\Event;

class UserRegisteredEvent
{
    public function __construct(private readonly int $userId)
    {
    }

    public function getUserId(): int
    {
        return $this->userId;
    }
}
