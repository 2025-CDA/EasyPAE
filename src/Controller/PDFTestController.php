<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PDFTestController extends AbstractController
{
    #[Route('/p/d/f/test', name: 'app_p_d_f_test')]
    public function index(): Response
    {
        return $this->render('pdf_test/index.html.twig', [
            'controller_name' => 'PDFTestController',
        ]);
    }
}
