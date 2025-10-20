<?php

namespace App\Controller;

use App\Repository\InfoFormCompanyRepository;
use App\Entity\InfoFormIntern;
use App\Repository\InfoFormInternRepository;
use App\Repository\InfoFormOrganizationRepository;
use App\Repository\InfoFormRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class StatusController extends AbstractController
{
    #region status form general
    #[Route('/status/{id}', name: 'app_status_form')]
    public function showStatusForm(int $id, InfoFormRepository $infoFormRepository): Response
    {
        $statusForm = $infoFormRepository->find($id);
        $statusData = $statusForm -> getStatus();
        return $this->json($statusData);

        dd($statusData);
    }
    #endregion

    #region status form company
    #[Route('/status/company/{id}', name: 'app_status_company_form')]
    public function showStatusCompanyForm(int $id, InfoFormCompanyRepository $infoFormCompanyRepository): Response
    {
        $statusCompanyForm = $infoFormCompanyRepository->find($id);
        $statusCompanyData = $statusCompanyForm -> getStatus();
        return $this->json($statusCompanyData);

        dd($statusCompanyData);
    }
    #endregion

    #region status form intern
     #[Route('/status/intern/{id}', name: 'app_status_intern_form')]
    public function showInternStatusForm(int $id, InfoFormInternRepository $infoFormInternRepository): Response
    {
        $statusInternForm = $infoFormInternRepository->find($id);
        $statusInternData = $statusInternForm -> getStatus();
        return $this->json($statusInternData);

        dd($statusInternData);

    }
    #endregion


    #region status form organization
        #[Route('/status/organization/{id}', name: 'app_statu_organizations_form')]
    public function showStatusOrganizationForm(int $id, InfoFormOrganizationRepository $infoFormOrganizationRepository): Response
    {
        $statusOrganizationForm = $infoFormOrganizationRepository->find($id);
        $statusOrganizationData = $statusOrganizationForm -> getStatus();
        return $this->json($statusOrganizationData);

        dd($statusOrganizationData);
    }
    #endregion
}
