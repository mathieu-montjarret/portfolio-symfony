<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\GalleryRepository;


class GalleryController extends AbstractController
{
    #[Route('/gallery', name: 'app_gallery')]
    public function gallery(GalleryRepository $galleryRepository): Response
    {

        $galleries = $galleryRepository->findAll();

        $photoDirectory = $this->getParameter('photo_directory');

        return $this->render('gallery/gallery.html.twig', [
            'galleries' => $galleries,
            'photoDirectory' => $photoDirectory,
            'controller_name' => 'GalleryController',
        ]);
    }

    #[Route('/gallery/{name}', name: 'gallery_show')]
    public function show(GalleryRepository $galleryRepository, string $name): Response
    {
        $gallery = $galleryRepository->findOneBy(['name' => $name]);

        if (!$gallery) {
            throw $this->createNotFoundException('La galerie demandée n\'existe pas.');
        }

        $photos = $gallery->getPhotos();

        $photoDirectory = $this->getParameter('photo_directory');

        return $this->render('gallery/show.html.twig', [
            'gallery' => $gallery,
            'photos' => $photos,
            'photoDirectory' => $photoDirectory,
        ]);
    }
}
