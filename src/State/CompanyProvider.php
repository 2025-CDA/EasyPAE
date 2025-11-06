<?php

namespace App\State;

use App\Dto\CompanyDTO;
use ApiPlatform\Metadata\Operation;
use App\Repository\InfoFormRepository;
use ApiPlatform\State\ProviderInterface;
use App\Repository\InfoFormCompanyRepository;
use App\Repository\CompanyRepository;
use App\Repository\CompanyMemberRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


readonly class CompanyProvider implements ProviderInterface
{
    public function __construct(
        private InfoFormRepository        $infoFormRepository,
        private InfoFormCompanyRepository $infoFormCompanyRepository,
        private CompanyRepository         $companyRepository,
        private CompanyMemberRepository   $companyMemberRepository,
    )
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): CompanyDTO|array
    {
        $operationName = $operation->getName();

        return match ($operationName) {
            'company_infoForm_infoFormId_infoFormCompany' => $this->getCompanyInfoFormInfoFormCompany($uriVariables),
            'company_companyId_infoForms' => $this->getCompanyInfoForms($uriVariables),
            'companyMember_companyMemberId_infoForms' => $this->getCompanyMemberInfoForms($uriVariables),
            default => throw new BadRequestHttpException('Operation not supported')
        };
    }

    private function getCompanyInfoFormInfoFormCompany(array $uriVariables): CompanyDTO
    {
        $infoFormId = $uriVariables['infoFormId'] ?? null;

        if (!$infoFormId) {
            throw new BadRequestHttpException('Info form ID and info form company ID are required');
        }

        $infoForm = $this->infoFormRepository->find($infoFormId);
        $infoFormCompanyId = $infoForm->getInfoFormCompany()?->getId();

        if (!$infoForm) {
            throw new NotFoundHttpException('Info form not found');
        }

        $infoFormCompany = $this->infoFormCompanyRepository->find($infoFormCompanyId);

        if (!$infoFormCompany) {
            throw new NotFoundHttpException('Info form company not found');
        }

        if ($infoFormCompany->getInfoForm()?->getId() !== $infoForm->getId()) {
            throw new NotFoundHttpException('Info form company does not belong to this info form');
        }

        $dto = new CompanyDTO();

        $dto->infoFormId = $infoForm->getId();
        // $dto->infoFormCompanyId = $infoFormCompany->getId();
        $dto->name = $infoFormCompany->getName();
        $dto->address = $infoFormCompany->getAddress();
        $dto->activity = $infoFormCompany->getActivity();
        $dto->phoneNumber = $infoFormCompany->getTutorPhoneNumber();
        $dto->email = $infoFormCompany->getEmail();
        $dto->fax = $infoFormCompany->getFax();
        $dto->siret = $infoFormCompany->getInfoForm()?->getCompanyMembers()?->first()?->getCompany()?->getSiret();
        $dto->legalRepresentativeFirstName = $infoFormCompany->getLegalRepresentativeFirstName();
        $dto->legalRepresentativeLastName = $infoFormCompany->getLegalRepresentativeLastName();
        $dto->legalRepresentativeEmail = $infoFormCompany->getLegalRepresentativeEmail();
        $dto->tutorFirstName = $infoFormCompany->getTutorFirstName();
        $dto->tutorLastName = $infoFormCompany->getTutorLastName();
        $dto->tutorEmail = $infoFormCompany->getTutorEmail();
        $dto->tutorPhoneNumber = $infoFormCompany->getTutorPhoneNumber();

        return $dto;
    }


    private function getCompanyMemberInfoForms(array $uriVariables): array
    {
        $companyMemberId = $uriVariables['companyMemberId'] ?? null;

        if (!$companyMemberId) {
            throw new BadRequestHttpException('Company Member ID is required');
        }

        $companyMember = $this->companyMemberRepository->find((int)$companyMemberId);

        if (!$companyMember) {
            throw new NotFoundHttpException('Company member not found');
        }

        $infoForms = $companyMember->getInfoForms();
        
        $infoFormsData = [];

        foreach ($infoForms as $infoForm) {
            $dto = new CompanyDTO();
            $dto->infoFormId = $infoForm->getId();
            $dto->companyMemberId = $companyMember->getId();
            $dto->infoFormStatus = $infoForm->getStatus();
        
            $infoFormCompany = $infoForm->getInfoFormCompany();
            if ($infoFormCompany) {
                $dto->infoFormCompanyStatus = $infoFormCompany->getStatus();
            }
            
            $infoFormsData[] = $dto;
        }

        return $infoFormsData;
    }
}
