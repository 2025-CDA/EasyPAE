<?php

namespace App\State;

use App\Dto\CompanyDTO;
use App\Entity\TrainingSession;
use App\Repository\InfoFormRepository;
use App\Repository\InfoFormCompanyRepository;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class CompanyProcessor implements ProcessorInterface
{
    public function __construct(
        private InfoFormRepository $infoFormRepository,
        private InfoFormCompanyRepository $infoFormCompanyRepository,
        private EntityManagerInterface $entityManager
    )
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): TrainingSession|CompanyDTO|null
    {
        if (!$data instanceof CompanyDTO) {
            return null;
        }

        $operationName = $operation->getName();

        return match ($operationName) {
            'company_infoForm_infoFormId_infoFormCompany_edit' => $this->companyInfoFormInfoFormCompanyEdit($data, $uriVariables),
            'company_infoForm_infoFormId_infoFormCompany_validation' => $this->companyInfoFormInfoFormCompanyValidation($data, $uriVariables),
            default => throw new BadRequestHttpException('Operation not supported')
        };
    }

    private function companyInfoFormInfoFormCompanyEdit(CompanyDTO $data, array $uriVariables): CompanyDTO
    {
        $infoFormId = $uriVariables['infoFormId'] ?? null;

        if (!$infoFormId) {
            throw new BadRequestHttpException('Missing required URI variables');
        }

        $infoForm = $this->infoFormRepository->find($infoFormId);
        $infoFormCompanyId = $infoForm->getInfoFormCompany()?->getId();

        $infoFormCompany = $this->infoFormCompanyRepository->find($infoFormCompanyId);
        if (!$infoFormCompany) {
            throw new NotFoundHttpException('InfoFormCompany not found');
        }

        if ($infoForm->getInfoFormCompany()?->getId() !== $infoFormCompany->getId()) {
            throw new BadRequestHttpException('InfoFormCompany does not belong to this InfoForm');
        }

        if ($data->name !== null) {
            $infoFormCompany->getInfoForm()?->getCompany()?->setName($data->name);
        }
        if ($data->address !== null) {
            $infoFormCompany->getInfoForm()?->getCompany()?->setAddress($data->address);
        }
        if ($data->activity !== null) {
            $infoFormCompany->setActivity($data->activity);
        }
        if ($data->phoneNumber !== null) {
            $infoFormCompany->getInfoForm()?->getCompany()?->setPhoneNumber($data->phoneNumber);
        }
        if ($data->email !== null) {
            $infoFormCompany->setLegalRepresentativeEmail($data->email);
        }
        if ($data->fax !== null) {
            $infoFormCompany->setFax($data->fax);
        }
        if ($data->siret !== null) {
            $infoFormCompany->getInfoForm()?->getCompany()?->setSiret($data->siret);
        }
        if ($data->legalRepresentativeFirstName !== null) {
            $infoFormCompany->setLegalRepresentativeFirstName($data->legalRepresentativeFirstName);
        }
        if ($data->legalRepresentativeLastName !== null) {
            $infoFormCompany->setLegalRepresentativeLastName($data->legalRepresentativeLastName);
        }
        if ($data->legalRepresentativeEmail !== null) {
            $infoFormCompany->setLegalRepresentativeEmail($data->legalRepresentativeEmail);
        }
        if ($data->tutorFirstName !== null) {
            $infoFormCompany->setTutorFirstName($data->tutorFirstName);
        }
        if ($data->tutorLastName !== null) {
            $infoFormCompany->setTutorLastName($data->tutorLastName);
        }
        if ($data->tutorEmail !== null) {
            $infoFormCompany->setTutorEmail($data->tutorEmail);
        }
        if ($data->tutorPhoneNumber !== null) {
            $infoFormCompany->setTutorPhoneNumber($data->tutorPhoneNumber);
        }

        $this->entityManager->flush();

        return $data;
    }

    private function companyInfoFormInfoFormCompanyValidation(CompanyDTO $data, array $uriVariables): CompanyDTO
    {
        $infoFormId = $uriVariables['infoFormId'] ?? null;
        $infoFormCompanyId = $uriVariables['infoFormCompanyId'] ?? null;

        if (!$infoFormId) {
            throw new BadRequestHttpException('Missing required URI variables');
        }

        $infoForm = $this->infoFormRepository->find($infoFormId);
           $infoFormCompanyId = $infoForm->getInfoFormCompany()->getId() ?? null;
        if (!$infoForm) {
            throw new NotFoundHttpException('InfoForm not found');
        }

        $infoFormCompany = $this->infoFormCompanyRepository->find($infoFormCompanyId);
        if (!$infoFormCompany) {
            throw new NotFoundHttpException('InfoFormCompany not found');
        }

        if ($infoForm->getInfoFormCompany()?->getId() !== $infoFormCompany->getId()) {
            throw new BadRequestHttpException('InfoFormCompany does not belong to this InfoForm');
        }

        if ($data->name !== null) {
            $infoFormCompany->getInfoForm()?->getCompany()?->setName($data->name);
        }
        if ($data->address !== null) {
            $infoFormCompany->getInfoForm()?->getCompany()?->setAddress($data->address);
        }
        if ($data->activity !== null) {
            $infoFormCompany->setActivity($data->activity);
        }
        if ($data->phoneNumber !== null) {
            $infoFormCompany->getInfoForm()?->getCompany()?->setPhoneNumber($data->phoneNumber);
        }
        if ($data->email !== null) {
            $infoFormCompany->setLegalRepresentativeEmail($data->email);
        }
        if ($data->fax !== null) {
            $infoFormCompany->setFax($data->fax);
        }
        if ($data->siret !== null) {
            $infoFormCompany->getInfoForm()?->getCompany()?->setSiret($data->siret);
        }
        if ($data->legalRepresentativeFirstName !== null) {
            $infoFormCompany->setLegalRepresentativeFirstName($data->legalRepresentativeFirstName);
        }
        if ($data->legalRepresentativeLastName !== null) {
            $infoFormCompany->setLegalRepresentativeLastName($data->legalRepresentativeLastName);
        }
        if ($data->legalRepresentativeEmail !== null) {
            $infoFormCompany->setLegalRepresentativeEmail($data->legalRepresentativeEmail);
        }
        if ($data->tutorFirstName !== null) {
            $infoFormCompany->setTutorFirstName($data->tutorFirstName);
        }
        if ($data->tutorLastName !== null) {
            $infoFormCompany->setTutorLastName($data->tutorLastName);
        }
        if ($data->tutorEmail !== null) {
            $infoFormCompany->setTutorEmail($data->tutorEmail);
        }
        if ($data->tutorPhoneNumber !== null) {
            $infoFormCompany->setTutorPhoneNumber($data->tutorPhoneNumber);
        }

        if ($data->infoFormStatus !== null) {
            $infoForm->setStatus($data->infoFormStatus);
        }

        if ($data->infoFormCompanyStatus !== null) {
            $infoFormCompany->setStatus($data->infoFormCompanyStatus);
        }

        if ($data->infoFormOrganizationStatus !== null) {
            $infoForm->getInfoFormOrganization()?->setStatus($data->infoFormOrganizationStatus);
        }

        $this->entityManager->flush();

        return $data;
    }
}
