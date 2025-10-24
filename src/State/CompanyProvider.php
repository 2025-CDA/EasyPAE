<?php

namespace App\State;

use App\Dto\CompanyDTO;
use ApiPlatform\Metadata\Operation;
use App\Repository\InfoFormRepository;
use ApiPlatform\State\ProviderInterface;
use App\Repository\InfoFormCompanyRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class CompanyProvider implements ProviderInterface
{
    public function __construct(
        private readonly InfoFormRepository        $infoFormRepository,
        private readonly InfoFormCompanyRepository $infoFormCompanyRepository,
    )
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): CompanyDTO
    {
        $operationName = $operation->getName();

        return match ($operationName) {
            'company_infoForm_infoFormId_infoFormCompany_infoFormCompanyId' => $this->getCompanyInfoFormInfoFormCompany($uriVariables),
            default => throw new BadRequestHttpException('Operation not supported')
        };

    }

    private function getCompanyInfoFormInfoFormCompany(array $uriVariables): CompanyDTO
    {
        $infoFormId = $uriVariables['infoFormId'] ?? null;
        $infoFormCompanyId = $uriVariables['infoFormCompanyId'] ?? null;

        if (!$infoFormId || !$infoFormCompanyId) {
            throw new BadRequestHttpException('Info form ID and info form company ID are required');
        }

        $infoForm = $this->infoFormRepository->find((int)$infoFormId);

        if (!$infoForm) {
            throw new NotFoundHttpException('Info form not found');
        }

        $infoFormCompany = $this->infoFormCompanyRepository->find((int)$infoFormCompanyId);

        if (!$infoFormCompany) {
            throw new NotFoundHttpException('Info form company not found');
        }

        if ($infoFormCompany->getInfoForm()?->getId() !== $infoForm->getId()) {
            throw new NotFoundHttpException('Info form company does not belong to this info form');
        }

//        $company = $infoFormCompany;

        if (!$infoFormCompany) {
            throw new NotFoundHttpException('Company not found');
        }

        $dto = new CompanyDTO();
        $dto->infoFormId = $infoForm->getId();
        $dto->infoFormCompanyId = $infoFormCompany->getId();

        $dto->name = $infoFormCompany->getName();
        $dto->address = $infoFormCompany->getAddress();
        $dto->activity = $infoFormCompany->getActivity();
        $dto->phoneNumber = $infoFormCompany->getTutorPhoneNumber();
        $dto->email = $infoFormCompany->getEmail();
        $dto->fax = $infoFormCompany->getFax();
        $dto->siret = $infoFormCompany->getInfoForm()?->getCompany()?->getSiret();

        $dto->legalRepresentativeFirstName = $infoFormCompany->getLegalRepresentativeFirstName();
        $dto->legalRepresentativeLastName = $infoFormCompany->getLegalRepresentativeLastName();
        $dto->legalRepresentativeEmail = $infoFormCompany->getLegalRepresentativeEmail();

        $dto->tutorFirstName = $infoFormCompany->getTutorFirstName();
        $dto->tutorLastName = $infoFormCompany->getTutorLastName();
        $dto->tutorEmail = $infoFormCompany->getTutorEmail();
        $dto->tutorPhoneNumber = $infoFormCompany->getTutorPhoneNumber();

        return $dto;
    }

}
