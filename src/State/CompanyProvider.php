<?php

namespace App\State;

use App\Dto\CompanyDTO;
use ApiPlatform\Metadata\Operation;
use App\Repository\CompanyRepository;
use App\Repository\InfoFormRepository;
use ApiPlatform\State\ProviderInterface;
use App\Repository\InfoFormCompanyRepository;
use App\Repository\InfoFormInternCompanyRepository;
use ApiPlatform\Metadata\CollectionOperationInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CompanyProvider implements ProviderInterface
{
    public function __construct(
        private readonly CompanyRepository $CompanyRepository,
        private readonly InfoFormCompanyRepository $InfoFormCompanyRepository,
        private readonly InfoFormInternCompanyRepository $InfoFormInternCompanyRepository,
        private readonly InfoFormRepository $InfoFormRepository,
        
    )
    {
    }

    public function provide(Operation $operation, array $uriVariables = [], array $context = []): array
    {

        // if ($operation instanceof CollectionOperationInterface) {
        //     $interns = $this->internMemberRepository->findAll();
        //     $dtos = [];            

        //         $dtos[] = $dto;
            
        //     return $dtos;
        // }

        if (isset($uriVariables['id'])) {
            $company = $this->InfoFormCompanyRepository->find((int) $uriVariables['id']);
            if (!$company) {
                // Option 1 : lancer explicitement l’exception
                throw new NotFoundHttpException('Company not found.');
                // Option 2 : return null; // Api Platform gère la 404
            }
    
            $dto = new CompanyDTO();
          
            $dto->id = $company->getId(); // id de infoFormCompany
            $dto->idCompany = $company->getInfoForm()?->getCompany()?->getId(); // id de Company
            $dto->idInfoFormInternCompany = $company->getInfoForm()?->getInfoFormIntern()?->getInfoFormInternCompany()?->getId(); // id de InfoFormInternCompany

            // status de l'InfoForm
            $dto->status = $company->getInfoForm()?->getStatus();
           
            // info de la Company (Company)
// faire en sorte que ce soit sur l'id de la company specifique
            $dto->siret = $company->getInfoForm()?->getCompany()?->getSiret(); 
            $dto->name = $company->getInfoForm()?->getCompany()?->getName();
            $dto->phoneNumber = $company->getInfoForm()?->getCompany()?->getPhoneNumber();
            
            // info que l'intern donne de la Company (InfoFormInternCompany)
// faire en sorte que ce soit sur l'id de la company/companymember/user specifique?
            $dto->companyName = $company->getInfoForm()?->getInfoFormIntern()?->getInfoFormInternCompany()?->getCompanyName();
            $dto->address = $company->getInfoForm()?->getInfoFormIntern()?->getInfoFormInternCompany()?->getAddress();
            $dto->email = $company->getInfoForm()?->getInfoFormIntern()?->getInfoFormInternCompany()?->getEmail();
            $dto->contactName = $company->getInfoForm()?->getInfoFormIntern()?->getInfoFormInternCompany()?->getContactName();

            // data de InfoFormCompany
            $dto->fax = $company->getFax();
            $dto->activity = $company->getActivity();
            $dto->activityDescription = $company->getActivityDescription();
            $dto->stamp = $company->getStamp();
            $dto->legalRepresentativeGender = $company->getLegalRepresentativeGender();
            $dto->legalRepresentativeLastName = $company->getLegalRepresentativeLastName();
            $dto->legalRepresentativeFirstName = $company->getLegalRepresentativeFirstName();
            $dto->legalRepresentativeSignature = $company->getLegalRepresentativeSignature();
            $dto->legalRepresentativeEmail = $company->getLegalRepresentativeEmail();
            $dto->interviewStartDateTime = $company->getInterviewStartDateTime();
            $dto->interviewEndDateTime = $company->getInterviewEndDateTime();
            $dto->agreeTerms = $company->isAgreeTerms();
            $dto->workLocation = $company->getWorkLocation();
            $dto->tutorGender = $company->getTutorGender();
            $dto->tutorFirstName = $company->getTutorFirstName();
            $dto->tutorLastName = $company->getTutorLastName();
            $dto->tutorEmail = $company->getTutorEmail();
            $dto->tutorPhoneNumber = $company->getTutorPhoneNumber();

            $dtos[] = $dto;

            return $dtos;
        }

        return [];

    }
}
