<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\CurrentUser;
use App\Entity\User;

class SecurityController extends AbstractController
{
     #[Route(path: '/api/login', name: 'app_login', methods: ['POST'])]
     public function login(): JsonResponse
     {
         // This controller will not be executed,
         // as the security system will intercept the request before it reaches this point.
         // If it is executed, it means there is a misconfiguration in your security.yaml.
         throw new \LogicException('This code should not be reached!');
     }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }
}
