<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GuestbookController extends AbstractController
{
    #[Route('/guestbook', name: 'app_guestbook')]
    public function guestbook(Request $request, CommentRepository $commentRepository): Response
    {
        $limit = 5; // Le nombre de commentaires par page
        $page = (int) $request->query->get('page', 1); // Récupère la page actuelle ou utilise la première page par défaut
        $totalComments = count($commentRepository->findAll());
        $lastPage = ceil($totalComments / $limit);
        $offset = ($page - 1) * $limit;

        $comments = $commentRepository->findBy([], [], $limit, $offset);
        return $this->render('guestbook/guestbook.html.twig', [
            'comments' => $comments,
            'lastPage' => $lastPage,
            'currentPage' => $page,
        ]);
    }
}
