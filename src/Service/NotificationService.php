<?php

namespace App\Service;

use DateTime;
use App\Entity\User;
use App\Entity\InfoForm;
use App\Entity\Notification;
use App\Entity\InfoFormIntern;
use App\Entity\TrainingSession;
use App\Entity\UserNotification;
use Doctrine\ORM\EntityManagerInterface;

class NotificationService
{
    public function __construct(
        private EntityManagerInterface $em,
    ) {}

    /**
     * Crée une notification pour l'utilisateur lorsqu'un InfoForm est validé.
     * Stocke title et content dans la table user_notification (entité UserNotification).
     */
    public function sendInfoFormValidatedInternNotification(User $user, InfoForm $infoForm, InfoFormIntern $infoFormIntern): void
    {

        // Récupère les dates depuis l'objet InfoFormIntern et formate proprement
        $dateStringStart = '';
        $dateStringEnd = '';

        $ds = $infoFormIntern->getDateStart();
        if ($ds instanceof \DateTimeInterface) {
            $dateStringStart = $ds->format('d-m-Y');
        } elseif (is_string($ds) && $ds !== '') {
            try {
                $dt = new DateTime($ds);
                $dateStringStart = $dt->format('d-m-Y');
            } catch (\Exception $e) {
                $dateStringStart = $ds;
            }
        }

        $de = $infoFormIntern->getDateEnd();
        if ($de instanceof \DateTimeInterface) {
            $dateStringEnd = $de->format('d-m-Y');
        } elseif (is_string($de) && $de !== '') {
            try {
                $dt = new DateTime($de);
                $dateStringStart = $dt->format('d-m-Y');
            } catch (\Exception $e) {
                $dateStringStart = $de;
            }
        }

        $companyName = $infoForm->getCompanyMembers()->first()->getCompany()->getName();

        $title = 'Fiche de renseignement validée';
        $content = "Le stage du {$dateStringStart} au {$dateStringEnd} , au sein de l'entreprise {$companyName} a été validé.";

        $userNotification = new UserNotification();
        $userNotification->setUser($user);

        // setters usuels : adapter si noms différents dans votre entité
        if (method_exists($userNotification, 'setTitle')) {
            $userNotification->setTitle($title);
        }
        if (method_exists($userNotification, 'setContent')) {
            $userNotification->setContent($content);
        }

        if (method_exists($userNotification, 'setCreatedAt')) {
            $userNotification->setCreatedAt(new \DateTimeImmutable());
        }
        if (method_exists($userNotification, 'setIsRead')) {
            $userNotification->setIsRead(false);
        }
        if (method_exists($userNotification, 'setIsSigned')) {
            $userNotification->setIsSigned(false);
        }

        $this->em->persist($userNotification);
        $this->em->flush();
    }

    public function sendInfoFormValidatedCompanyNotification(User $user, InfoForm $infoForm, InfoFormIntern $infoFormIntern): void
    {

        // Récupère les dates depuis l'objet InfoFormIntern et formate proprement
        $dateStringStart = '';
        $dateStringEnd = '';

        $ds = $infoFormIntern->getDateStart();
        if ($ds instanceof \DateTimeInterface) {
            $dateStringStart = $ds->format('d-m-Y');
        } elseif (is_string($ds) && $ds !== '') {
            try {
                $dt = new DateTime($ds);
                $dateStringStart = $dt->format('d-m-Y');
            } catch (\Exception $e) {
                $dateStringStart = $ds;
            }
        }

        $de = $infoFormIntern->getDateEnd();
        if ($de instanceof \DateTimeInterface) {
            $dateStringEnd = $de->format('d-m-Y');
        } elseif (is_string($de) && $de !== '') {
            try {
                $dt = new DateTime($de);
                $dateStringStart = $dt->format('d-m-Y');
            } catch (\Exception $e) {
                $dateStringStart = $de;
            }
        }

        $internFirstName = $infoForm->getInternMember()->getUser()->getFirstName();
        $internLastName = $infoForm->getInternMember()->getUser()->getLastName();

        $title = 'Fiche de renseignement validée';
        $content = "Le stage de {$internFirstName} {$internLastName} du {$dateStringStart} au {$dateStringEnd} au sein de votre entreprise a été validé.";

        $userNotification = new UserNotification();
        $userNotification->setUser($user);

        // setters usuels : adapter si noms différents dans votre entité
        if (method_exists($userNotification, 'setTitle')) {
            $userNotification->setTitle($title);
        }
        if (method_exists($userNotification, 'setContent')) {
            $userNotification->setContent($content);
        }

        if (method_exists($userNotification, 'setCreatedAt')) {
            $userNotification->setCreatedAt(new \DateTimeImmutable());
        }
        if (method_exists($userNotification, 'setIsRead')) {
            $userNotification->setIsRead(false);
        }
        if (method_exists($userNotification, 'setIsSigned')) {
            $userNotification->setIsSigned(false);
        }

        $this->em->persist($userNotification);
        $this->em->flush();
    }


}
