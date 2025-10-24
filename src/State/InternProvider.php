<?php

namespace App\State;

use App\Dto\InternDTO;
use ApiPlatform\Metadata\Operation;
use App\Repository\InfoFormRepository;
use ApiPlatform\State\ProviderInterface;
use App\Repository\InternMemberRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class InternProvider implements ProviderInterface
{
    public function __construct(
        private InternMemberRepository $internMemberRepository,
        private InfoFormRepository     $infoFormRepository,
    )
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array|object|null
    {

        $operationName = $operation->getName();

        return match ($operationName) {
            'intern_infoForm_InfoFormIntern_infoFormInternId' => $this->getInfoFormInfoFormIntern($uriVariables),
            default => throw new BadRequestHttpException('Operation not supported')
        };

    }

    private function getInfoFormInfoFormIntern(array $uriVariables): InternDTO
    {
        $infoFormInternId = $uriVariables['infoFormInternId'];

        if (!$infoFormInternId) {
            throw new BadRequestHttpException('Info form intern ID is required');
        }

        $internMember = $this->internMemberRepository->find((int)$infoFormInternId);

        if (!$internMember) {
            throw new NotFoundHttpException('Intern member not found');
        }

        $infoForm = $this->infoFormRepository->findOneBy([
            'internMember' => $internMember
        ]);

        if (!$infoForm) {
            throw new NotFoundHttpException('Info form not found for this intern');
        }

        $dto = new InternDTO();
        $dto->infoFormInternId = $internMember->getId();

        if ($user = $internMember->getUser()) {
            $dto->internFirstName = $user->getFirstName();
            $dto->internLastName = $user->getLastName();
            $dto->internEmail = $user->getEmail();
        }

        $trainingSession = $infoForm->getTrainingSession();
        if ($trainingSession) {
            $dto->trainingName = $trainingSession->getTraining()?->getName();
            $dto->offerNumber = $trainingSession->getOfferNumber();
            $dto->internshipStart = $trainingSession->getInternShipPeriodStart();
            $dto->internshipEnd = $trainingSession->getInternshipPeriodEnd();
        }

        return $dto;
    }
}
