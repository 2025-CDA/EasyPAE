<?php

namespace App\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Dto\InfoFormDTO;

use App\Repository\InfoFormRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Doctrine\ORM\EntityManagerInterface;

readonly class InfoFormProcessor implements ProcessorInterface
{
    public function __construct(
        private InfoFormRepository     $infoFormRepository,
        private EntityManagerInterface $entityManager
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

            $dto = new InfoFormDTO();
            $dto->id = 'validation_result_' . $infoFormId;
            $dto->validationMessage = 'Resume form validation processed successfully';

            return $dto;

        } catch (\Exception $e) {
            throw new BadRequestHttpException('Validation failed: ' . $e->getMessage());
        }
    }
}
