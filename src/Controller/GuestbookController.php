<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GuestbookController extends AbstractController
{
    #[Route('/guestbook', name: 'app_guestbook')]
    public function guestbook(): Response
    {
        return $this->render('guestbook/guestbook.html.twig', [
            'controller_name' => 'GuestbookController',
        ]);
    }
}