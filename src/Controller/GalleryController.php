<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GalleryController extends AbstractController
{
    #[Route('/gallery', name: 'app_gallery')]
    public function gallery(): Response
    {
        return $this->render('gallery/gallery.html.twig', [
            'controller_name' => 'GalleryController',
        ]);
    }
}