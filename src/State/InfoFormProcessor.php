<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\InfoFormDTO;
use App\Repository\InfoFormRepository;
use App\Service\EmailService;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Doctrine\ORM\EntityManagerInterface;

readonly class InfoFormProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly InfoFormRepository $infoFormRepository,
        private readonly EntityManagerInterface $entityManager,
        private readonly EmailService $emailService // Injection du service d'email
    ) {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): mixed
    {
        $operationName = $operation->getName();

        return match ($operationName) {
            'validate_resume_form' => $this->validateResumeForm($uriVariables),
            default => throw new BadRequestHttpException('Operation not supported')
        };
    }

    private function validateResumeForm(array $uriVariables): InfoFormDTO
    {
        $infoFormId = $uriVariables['infoFormId'] ?? null;
        if (!$infoFormId) {
            throw new BadRequestHttpException('InfoForm ID is required');
        }

        try {
            $infoForm = $this->infoFormRepository->find($infoFormId);
            if (!$infoForm) {
                throw new NotFoundHttpException('InfoForm not found');
            }

            $infoForm->setStatus(\App\Enum\InfoFormStatus::FULLY_COMPLETED);
            $this->entityManager->flush();
            
            // Envoi d'email de confirmation au stagiaire
            // 1. Récupère l'utilisateur via InternMember (avec nullsafe ?->)
            // 2. Si l'utilisateur existe, envoie l'email avec les infos du formulaire
            if ($user = $infoForm->getInternMember()?->getUser()) {
                $this->emailService->sendFormSubmittedEmail(
                    $user->getEmail(),                                  // Destinataire
                    'Votre formulaire a été validé',                    // Sujet
                    $user->getFirstName() . ' ' . $user->getLastName(), // Nom complet
                    [                                                   // Données du formulaire
                        'formulaire_id' => $infoForm->getId(),
                        'statut' => $infoForm->getStatus()->value,
                        'date_validation' => (new \DateTime())->format('d/m/Y H:i')
                    ]
                );
            }
            
            $dto = new InfoFormDTO();
            $dto->id = 'validation_result_' . $infoFormId;
            $dto->validationMessage = 'Resume form validation processed successfully';

            return $dto;

        } catch (\Exception $e) {
            throw new BadRequestHttpException('Validation failed: ' . $e->getMessage());
        }
    }
}
