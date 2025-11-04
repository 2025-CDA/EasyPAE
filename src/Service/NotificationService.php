<?php

namespace App\Service;

use App\Entity\Notification;
use App\Entity\User;
use App\Entity\InfoForm;
use Doctrine\ORM\EntityManagerInterface;

class NotificationService
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {}

    /**
     * Crée une notification pour l'utilisateur.
     */
    public function sendInfoFormValidatedNotification(User $user, InfoForm $infoForm): void
    {


    }
}