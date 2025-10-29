<?php

namespace App\State;

use App\Dto\InternDTO;
use App\Entity\InfoForm;
use App\Enum\InfoFormStatus;
use App\Entity\InfoFormIntern;
use App\Entity\InfoFormCompany;
use ApiPlatform\Metadata\Operation;
use App\Entity\InfoFormOrganization;
use App\Entity\InfoFormInternCompany;
use App\Repository\InfoFormRepository;
use App\Enum\InfoFormOrganizationStatus;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\State\ProcessorInterface;
use App\Repository\InternMemberRepository;
use App\Repository\InfoFormInternRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

readonly class InternProcessor implements ProcessorInterface
{
    public function __construct(
        private InfoFormRepository $infoFormRepository,
        private InfoFormInternRepository $infoFormInternRepository,
        private InternMemberRepository $internMemberRepository,
        private UserRepository $userRepository,
        private EntityManagerInterface $entityManager
    )
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): InternDTO|null
    {
        if (!$data instanceof InternDTO) {
            return null;
        }

        $operationName = $operation->getName();

        return match ($operationName) {
            'intern_infoForm_add' => $this->internInfoFormAdd($data),
            'intern_infoForm_infoFormId_infoFormIntern_edit' => $this->internInfoFormInfoFormInternEdit($data, $uriVariables),
            'intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_edit' => $this->internInfoFormInfoFormInternInfoFormInternCompanyEdit($data, $uriVariables),
            'intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_validation' => $this->internInfoFormInfoFormInternInfoFormInternCompanyValidation($data, $uriVariables),
            default => throw new BadRequestHttpException('Operation not supported')
        };
    }

    private function internInfoFormAdd(InternDTO $data): InternDTO
    {
        $internMember = $this->internMemberRepository->find($data->internId);
        if (!$internMember) {
            throw new NotFoundHttpException('Intern member not found');
        }

        $infoForm = new InfoForm();
        $infoForm->setInternMember($internMember);
        // $infoForm->setOrganization($organization);
        // $infoForm->setTrainingSession($trainingSession);
        $infoForm->setStatus(InfoFormStatus::INITIALIZED);


        $this->entityManager->persist($infoForm);

        $infoFormIntern = new InfoFormIntern();
        if ($data->infoFormInternDateStart !== null) {
            $infoFormIntern->setDateStart($data->infoFormInternDateStart);
        }
        if ($data->infoFormInternDateEnd !== null) {
            $infoFormIntern->setDateEnd($data->infoFormInternDateEnd);
        }
            if ($data->infoFormInternStatus !== null) {
                $infoFormIntern->setStatus($data->infoFormInternStatus);
            }

        $this->entityManager->persist($infoFormIntern);
        $infoForm->setInfoFormIntern($infoFormIntern);

        $infoFormOrganization = new InfoFormOrganization();
        // if ($data->infoFormOrganizationStatus !== null) {
        //     $infoFormOrganization->setStatus($data->infoFormOrganizationStatus);
        // }
            $infoFormOrganization->setStatus(InfoFormOrganizationStatus::INITIALIZED);

        $this->entityManager->persist($infoFormOrganization);
        $infoForm->setInfoFormOrganization($infoFormOrganization);



        if ($data->infoFormInternCompanyName !== null) {
            $infoFormInternCompany = new InfoFormInternCompany();
            $infoFormInternCompany->setCompanyName($data->infoFormInternCompanyName);

            if ($data->infoFormInternCompanyAddress !== null) {
                $infoFormInternCompany->setAddress($data->infoFormInternCompanyAddress);
            }

            if ($data->infoFormInternCompanyLegalRepresentativeFirstName !== null) {
                $infoFormInternCompany->setLegalRepresentativeFirstName($data->infoFormInternCompanyLegalRepresentativeFirstName);
            }

            if ($data->infoFormInternCompanyLegalRepresentativeLastName !== null) {
                $infoFormInternCompany->setLegalRepresentativeLastName($data->infoFormInternCompanyLegalRepresentativeLastName);
            }

            if ($data->infoFormInternCompanyLegalRepresentativeEmail !== null) {
                $infoFormInternCompany->setEmail($data->infoFormInternCompanyLegalRepresentativeEmail);
            }

            $this->entityManager->persist($infoFormInternCompany);
            $infoFormIntern->setInfoFormInternCompany($infoFormInternCompany);
        }

        // if ($data->infoFormCompanyStatus !== null) {
            $infoFormCompany = new InfoFormCompany();
            $infoFormCompany->setStatus($data->infoFormCompanyStatus);
            $infoForm->setInfoFormCompany($infoFormCompany);
            $this->entityManager->persist($infoFormCompany);
        // }

         $this->entityManager->flush();

        // remplir les identifiants attendus par ApiPlatform
        $data->infoFormId = $infoForm->getId();
        $data->infoFormInternId = $infoFormIntern->getId();

        return $data;
    }

    private function internInfoFormInfoFormInternEdit(InternDTO $data, array $uriVariables): InternDTO
    {
        $infoFormInternId = $uriVariables['infoFormInternId'] ?? null;

        if (!$infoFormInternId) {
            throw new BadRequestHttpException('Missing required URI variable: infoFormInternId');
        }

        $infoFormIntern = $this->infoFormInternRepository->find($infoFormInternId);
        if (!$infoFormIntern) {
            throw new NotFoundHttpException('InfoFormIntern not found');
        }

        if ($data->infoFormInternDateStart !== null) {
            $infoFormIntern->setDateStart($data->infoFormInternDateStart);
        }
        if ($data->infoFormInternDateEnd !== null) {
            $infoFormIntern->setDateEnd($data->infoFormInternDateEnd);
        }

        $this->entityManager->flush();

        return $data;
    }

    private function internInfoFormInfoFormInternInfoFormInternCompanyEdit(InternDTO $data, array $uriVariables): InternDTO
    {
        $infoFormId = $uriVariables['infoFormId'] ?? null;

        if (!$infoFormId) {
            throw new BadRequestHttpException('Missing required URI variable: infoFormId');
        }

        $infoForm = $this->infoFormRepository->find($infoFormId);
        if (!$infoForm) {
            throw new NotFoundHttpException('InfoForm not found');
        }

        $infoFormIntern = $infoForm->getInfoFormIntern();
        if (!$infoFormIntern) {
            throw new NotFoundHttpException('InfoFormIntern not found for this InfoForm');
        }

        $infoFormInternCompany = $infoFormIntern->getInfoFormInternCompany();
        if (!$infoFormInternCompany) {
            $infoFormInternCompany = new InfoFormInternCompany();
            $this->entityManager->persist($infoFormInternCompany);
            $infoFormIntern->setInfoFormInternCompany($infoFormInternCompany);
        }

        if ($data->infoFormInternCompanyName !== null) {
            $infoFormInternCompany->setCompanyName($data->infoFormInternCompanyName);
        }

        if ($data->infoFormInternCompanyAddress !== null) {
            $infoFormInternCompany->setAddress($data->infoFormInternCompanyAddress);
        }

        if ($data->infoFormInternCompanyLegalRepresentativeFirstName !== null) {
            $infoFormInternCompany->setLegalRepresentativeFirstName($data->infoFormInternCompanyLegalRepresentativeFirstName);
        }

        if ($data->infoFormInternCompanyLegalRepresentativeLastName !== null) {
            $infoFormInternCompany->setLegalRepresentativeLastName($data->infoFormInternCompanyLegalRepresentativeLastName);
        }

        if ($data->infoFormInternCompanyLegalRepresentativeEmail !== null) {
            $infoFormInternCompany->setEmail($data->infoFormInternCompanyLegalRepresentativeEmail);
        }

        $this->entityManager->flush();

        return $data;
    }

    private function internInfoFormInfoFormInternInfoFormInternCompanyValidation(InternDTO $data, array $uriVariables): InternDTO
    {
        $infoFormId = $uriVariables['infoFormId'] ?? null;

        if (!$infoFormId) {
            throw new BadRequestHttpException('Missing required URI variable: infoFormId');
        }

        $infoForm = $this->infoFormRepository->find($infoFormId);
        if (!$infoForm) {
            throw new NotFoundHttpException('InfoForm not found');
        }

        if ($data->infoFormStatus !== null) {
            $infoForm->setStatus($data->infoFormStatus);
        }

        $infoFormIntern = $infoForm->getInfoFormIntern();
        if ($infoFormIntern && $data->infoFormInternStatus !== null) {
            $infoFormIntern->setStatus($data->infoFormInternStatus);
        }

        $infoFormCompany = $infoForm->getInfoFormCompany();
        if ($infoFormCompany && $data->infoFormCompanyStatus !== null) {
            $infoFormCompany->setStatus($data->infoFormCompanyStatus);
        }

        $this->entityManager->flush();

        $infoFormInternCompany = $infoFormIntern?->getInfoFormInternCompany();
        $email = $infoFormInternCompany?->getEmail();

        if ($email) {
            $existingUser = $this->userRepository->findOneBy(['email' => $email]);

//            TODO: add email sending the email here.
            if ($existingUser) {
                // send connection mail
            } else {
                //  send account creation mail
            }
        }

        return $data;
    }

}
