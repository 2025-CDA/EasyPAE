<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class InternController extends AbstractController
{
    #[Route('/intern/form/{id}/intern-info', name: 'app_intern_info')]
    public function showInternInfo(): Response
    {

$internInfoData;

// Id de la formation($id) = infoForm --> (id)
// Prénom du stagiaire($firstname) = infoForm(id) --> infoForm(intern_id) --> internMember(user_id) --> user(firstname)
//Nom du stagiaire($lastname) = infoForm(id) --> infoForm(intern_id) --> internMember(user_id) --> user(lastname)
//Email du stagiaire($email) = infoForm(id) --> infoForm(intern_id) --> internMember(user_id) --> user(email)
//Date de début de stage($internshipDateStart) = infoForm(id) --> infoForm(intern_id) --> internMember(id) --> InternSessionMember(training_session_id) --> TrainingSession(internhip_period_start)
//Date de fin de stage($internshipDateEnd) = infoForm(id) --> infoForm(intern_id) --> internMember(id) --> InternSessionMember(training_session_id) --> TrainingSession(internhip_period_end)
//Numéro de la session ($numberOffer) = infoForm(id) --> infoForm(intern_id) --> internMember(id) --> InternSessionMember(training_session_id) --> TrainingSession(offer_number)
//Libellé de la session ($trainingName) = infoForm(id) --> infoForm(intern_id) --> internMember(id) --> InternSessionMember(training_session_id) --> TrainingSession(training_id) --> Training(name)
        return $this->json($internInfoData);
    }
}
