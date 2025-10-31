<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Attribute\Route;

final class HomepageController extends AbstractController
{
    #[Route('/', name: 'api_home', methods: ['GET'])]
    public function index(): JsonResponse
    {
        $testArray = [
            ['id' => 1, 'name' => 'Alice'],
            ['id' => 2, 'name' => 'Bob'],
            ['id' => 3, 'name' => 'Charlie'],
        ];

        return $this->json($testArray);
    }

    #[Route('/home', name: 'home', methods: ['GET'])]
    public function home(SessionInterface $session): Response
    {
        $userEmail = $session->get('user_email');
        
        return $this->render('pages/home.html.twig', [
            'isLoggedIn' => $userEmail !== null,
            'userEmail' => $userEmail
        ]);
    }
}
