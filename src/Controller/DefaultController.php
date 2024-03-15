<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class DefaultController extends AbstractController
{
    #[Route('/default', name: 'app_default')]
    public function home(): Response
    {
        return $this->render('default/home.html.twig', [
            'controller_name' => 'DefaultController',
        ]);
    }
}