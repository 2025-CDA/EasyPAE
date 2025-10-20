<?php

namespace App\Controller;

use App\Entity\TrainingSession;
use App\Repository\TrainingSessionRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\SerializerInterface;

final class SessionDateController extends AbstractController
{
    #[Route('/internship-dates/{id}', name: 'internship-period', methods: ['GET'])]
    public function showInternshipPeriod(int $id,TrainingSessionRepository $trainingSessionRepository,): Response {
        // Récupérer la session de formation par son id via le repository
        $session = $trainingSessionRepository->find($id);

        // Gérer le cas où l'entité n'existe pas
        if (!$session) {
            throw $this->createNotFoundException('Training session not found for id '.$id);
        }

        // Récupérer les dates via les getters
        $internshipPeriodStart = $session->getInternShipPeriodStart();
        $internshipPeriodEnd = $session->getInternshipPeriodEnd();

        // Regrouper les dates dans un tableau
        $internshipData = [
            'start' => $internshipPeriodStart ? $internshipPeriodStart->format('Y-m-d') : null,
            'end' => $internshipPeriodEnd ? $internshipPeriodEnd->format('Y-m-d') : null,
        ];

        // Sérialiser ou retourner en JSON natif
        return $this->json($internshipData);
        var_dump($internshipData);
    }


        #[Route('/training-dates/{id}', name: 'training-period', methods: ['GET'])]
    public function showTrainingPeriod(int $id,TrainingSessionRepository $trainingSessionRepository,): Response {
        // Récupérer la session de formation par son id via le repository
        $session = $trainingSessionRepository->find($id);

        // Gérer le cas où l'entité n'existe pas
        if (!$session) {
            throw $this->createNotFoundException('Training session not found for id '.$id);
        }

        // Récupérer les dates via les getters
        $trainingPeriodStart = $session->getTrainingPeriodStart();
        $trainingPeriodEnd = $session->getTrainingPeriodEnd();

        // Regrouper les dates dans un tableau
        $trainingData = [
            'start' => $trainingPeriodStart ? $trainingPeriodStart->format('Y-m-d') : null,
            'end' => $trainingPeriodEnd ? $trainingPeriodEnd->format('Y-m-d') : null,
        ];

        // Sérialiser ou retourner en JSON natif
        return $this->json($trainingData);
        var_dump($trainingData);
    }
}