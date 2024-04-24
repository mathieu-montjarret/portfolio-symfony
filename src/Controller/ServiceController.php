<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\ServiceRepository;

class ServiceController extends AbstractController
{
    #[Route('/service', name: 'app_service')]
    public function index(ServiceRepository $serviceRepository): Response
    {
        $services = $serviceRepository->findAll();
        $servicesPhotoDirectory = $this->getParameter('services_photo_directory'); // Récupération du paramètre de configuration

        return $this->render('service/service.html.twig', [
            'services' => $services,
            'servicesPhotoDirectory' => $servicesPhotoDirectory, // Passer le photoDirectory au template
        ]);
    }
}
