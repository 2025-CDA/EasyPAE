<?php

namespace App\State;

use App\Dto\OrganizationDTO;
use App\Entity\InfoForm;
use App\Entity\InternMember;
use App\Entity\Training;
use App\Entity\TrainingSession;
use ApiPlatform\Metadata\Operation;
use App\Entity\User;
use App\Enum\UserRole;
use App\Repository\InternMemberRepository;
use App\Repository\OrganizationMemberRepository;
use App\Repository\TrainingRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\State\ProcessorInterface;
use App\Repository\TrainingSessionRepository;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

readonly class InternProcessor implements ProcessorInterface
{
    public function __construct(

    )
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): TrainingSession|OrganizationDTO|null
    {
        if (!$data instanceof OrganizationDTO) {
            return null;
        }

        $operationName = $operation->getName();

        return match ($operationName) {
            'intern_infoForm_add' => $this->internInfoFormAdd($data),
            'intern_infoForm_InfoFormIntern_infoFormInternId_edit' => $this->internInfoFormInfoFormInternEdit($data, $uriVariables),
            'intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_edit' => $this->internInfoFormInfoFormInternInfoFormInternCompanyEdit($data, $uriVariables),
            'intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_validation' => $this->internInfoFormInfoFormInternInfoFormInternCompanyValidation($data),
            default => throw new BadRequestHttpException('Operation not supported')
        };
    }

    private function internInfoFormAdd(OrganizationDTO $data)
    {
    }

    private function internInfoFormInfoFormInternEdit(OrganizationDTO $data, array $uriVariables)
    {
    }

    private function internInfoFormInfoFormInternInfoFormInternCompanyEdit(OrganizationDTO $data, array $uriVariables)
    {
    }

    private function internInfoFormInfoFormInternInfoFormInternCompanyValidation(OrganizationDTO $data)
    {
    }


}
