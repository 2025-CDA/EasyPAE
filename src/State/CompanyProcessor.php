<?php

namespace App\State;

use App\Dto\OrganizationDTO;
use App\Entity\TrainingSession;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

readonly class CompanyProcessor implements ProcessorInterface
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

            'ocompany_infoForm_infoFormId_infoFormCompany_infoFormCompanyId_edit' => $this->companyInfoForminfoFormCompanyEdit($data, $uriVariables),
            'intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompany_validation' => $this->intern_infoForm_infoFormId_infoFormIntern_infoFormInternCompanyValidation($data, $uriVariables),
            default => throw new BadRequestHttpException('Operation not supported')
        };
    }


}
