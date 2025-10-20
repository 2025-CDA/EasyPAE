<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use App\Entity\User;

class SecurityController extends AbstractController
{
    // #[Route(path: '/api/login_check', name: 'app_login', methods: ['POST'])]
    // public function login(#[CurrentUser] ?User $user): Response
    // {
    //     if (null === $user) {
    //         return $this->json([
    //             'message' => 'Missing credentials or invalid login',
    //         ], Response::HTTP_UNAUTHORIZED);
    //     }

    //     // Ici vous pouvez renvoyer des infos sur l'utilisateur ou un token
    //     return $this->json([
    //         'user' => $user->getUserIdentifier(),
    //         // 'token' => ... (le token JWT est envoyé automatiquement si LexikJWT est configuré)
    //     ]);
    // }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
