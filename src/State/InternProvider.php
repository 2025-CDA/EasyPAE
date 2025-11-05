<?php

namespace App\State;

use App\Dto\InternDTO;
use ApiPlatform\Metadata\Operation;
use App\Repository\InfoFormRepository;
use ApiPlatform\State\ProviderInterface;
use App\Repository\InternMemberRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class InternProvider implements ProviderInterface
{
    public function __construct(
        private InternMemberRepository $internMemberRepository,
        private InfoFormRepository     $infoFormRepository,
        private UserRepository         $userRepository,
    )
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array|object|null
    {

        $operationName = $operation->getName();

        return match ($operationName) {
            'intern_infoForm_infoFormId_infoFormIntern' => $this->getInfoFormInfoFormIntern($uriVariables),
            'intern_userId_infoForms' => $this->getUserInfoForms($uriVariables),
            default => throw new BadRequestHttpException('Operation not supported')
        };

    }

    private function getInfoFormInfoFormIntern(array $uriVariables): InternDTO
    {
        $infoFormId = $uriVariables['infoFormId'] ?? null;

        if (!$infoFormId) {
            throw new BadRequestHttpException('Info form intern ID is required');
        }

        $infoForm = $this->infoFormRepository->find($infoFormId);

        if (!$infoForm) {
            throw new NotFoundHttpException('Info form not found for this intern');
        }

        $dto = new InternDTO();
        $dto->infoFormInternId = $infoForm->getInfoFormIntern()?->getId();

        $user = $infoForm->getInternMember()?->getUser();

        $dto->internFirstName = $user?->getFirstName();
        $dto->internLastName = $user?->getLastName();
        $dto->internEmail = $user?->getEmail();


        $trainingSession = $infoForm->getTrainingSession();
        if ($trainingSession) {
            $dto->trainingName = $trainingSession->getTraining()?->getName();
            $dto->offerNumber = $trainingSession->getOfferNumber();
            $dto->internshipStart = $trainingSession->getInternShipPeriodStart();
            $dto->internshipEnd = $trainingSession->getInternshipPeriodEnd();
        }

        return $dto;
    }

    private function getUserInfoForms(array $uriVariables): array
    {
        $userId = $uriVariables['userId'] ?? null;

        if (!$userId) {
            throw new BadRequestHttpException('User ID is required');
        }

        $user = $this->userRepository->find((int)$userId);

        if (!$user) {
            throw new NotFoundHttpException('User not found');
        }

        $internMember = $user->getInternMember();

        if (!$internMember) {
            throw new NotFoundHttpException('User is not an intern');
        }

        $infoForms = $this->infoFormRepository->findBy([
            'internMember' => $internMember
        ], ['createdAt' => 'DESC']);

        $dtos = [];
        foreach ($infoForms as $infoForm) {
            $dto = new InternDTO();

            // Identifiant du DTO (requis pour API Platform)
            $dto->infoFormId = $infoForm->getId();

            // 1. Status de l'infoForm
            $dto->infoFormStatus = $infoForm->getStatus();

            // 2. Dates de début et fin de l'info_form_intern
            $infoFormIntern = $infoForm->getInfoFormIntern();
            if ($infoFormIntern) {
                $dto->infoFormInternDateStart = $infoFormIntern->getDateStart();
                $dto->infoFormInternDateEnd = $infoFormIntern->getDateEnd();
            }

            // 3 & 4. Tutor first name et last name de l'info_form_company
            // 5. Email de contact de l'info_form_company
            $infoFormCompany = $infoForm->getInfoFormCompany();
            if ($infoFormCompany) {
                $dto->infoFormCompanyTutorFirstName = $infoFormCompany->getTutorFirstName();
                $dto->infoFormCompanyTutorLastName = $infoFormCompany->getTutorLastName();
                $dto->infoFormCompanyContactEmail = $infoFormCompany->getLegalRepresentativeEmail();
            }

            // 6, 7, 8, 9. Récupérer les informations de la company via les companyMembers
            $companyMembers = $infoForm->getCompanyMembers();
            if ($companyMembers->count() > 0) {
                $companyMember = $companyMembers->first();

                // Avatar du user de l'entreprise
                $companyUser = $companyMember->getUser();
                if ($companyUser) {
                    $dto->companyUserAvatar = $companyUser->getAvatar();
                }

                // Informations de la company
                $company = $companyMember->getCompany();
                if ($company) {
                    $dto->companyName = $company->getName();
                    $dto->companyAddress = $company->getAddress();
                    $dto->companyPhoneNumber = $company->getPhoneNumber();
                }
            }

            $dtos[] = $dto;
        }

        return $dtos;
    }
}
