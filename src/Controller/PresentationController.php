<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PresentationController extends AbstractController
{
    #[Route('/presentation', name: 'app_presentation')]
    public function presentation(): Response
    {
        return $this->render('presentation/presentation.html.twig', [
            'controller_name' => 'PresentationController',
        ]);
    }
}