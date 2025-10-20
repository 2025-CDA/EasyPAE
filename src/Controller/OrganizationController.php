<?php

namespace App\Controller;

use App\Entity\InternMember;
use App\Entity\TrainingSession;
use App\Repository\InternMemberRepository;
use App\Repository\OrganizationMemberRepository;
use App\Repository\OrganizationRepository;
use App\Repository\TrainingSessionRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class OrganizationController extends AbstractController
{
    #[Route('/organization/sessions', name: 'organization-sessions')]
    public function showOrganizationSessions(TrainingSessionRepository $trainingSessionRepository): Response
    {
        $sessions = $trainingSessionRepository->findAll();

        return $this->json($sessions);
        dd($sessions);
    }

    #[Route('/organization/sessions/add', name: 'organization-sessions-add')]
    public function addOrganizationSessions(Request $request, EntityManagerInterface $entityManager,): Response
    {
        $sessions = new TrainingSession();

        $form = $this->createForm(TrainingSessionFormType::class, $sessions);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($sessions);
            $entityManager->flush();

            return $this->redirectToRoute('organization-sessions');
        }

        return $this->json($sessions);
    }

    #[Route('/organization/sessions/{id}/edit', name: 'organization-sessions-edit')]
    public function editOrganizationSessions(Request $request, EntityManagerInterface $entityManager, TrainingSession $trainingSession): Response
    {

        $form = $this->createForm(TrainingSessionFormType::class, $trainingSession);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('organization-sessions');
        }

        return $this->json($trainingSession);
    }


    #[Route('/organization/session/{id}/members', name: 'organization-session-members')]
    public function showOrgaSessionsMembers(int $id, InternMemberRepository $internMemberRepo): Response
    {
        // Appel d'une méthode personnalisée à créer dans InternMemberRepository
        $members = $internMemberRepo->findByTrainingSessionId($id);

        $membersData = [];

        foreach ($members as $member) {
            $user = $member->getUser();
            if ($user) {
                $membersData[] = [
                    'firstName' => $user->getFirstName(),
                    'lastName' => $user->getLastName(),
                ];
            }
        }

        return $this->json($membersData);
        dd($membersData);
    }
}

