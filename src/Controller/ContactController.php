<?php

namespace App\Controller;

use App\Service\CustomMailSender;
use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact', methods: ['GET', 'POST'])]
    public function contact(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contact);
            $entityManager->flush();

            // Vérification si le téléphone est vide et affectation de 'Non renseigné'
            $userPhone = $contact->getPhone();
            if (empty($userPhone)) {
                $userPhone = 'Non renseigné';
            }

            $mail = new CustomMailSender();
            $mail->send($contact->getEmail(), 'nashcontactpro@gmail.com', $contact->getFirstname() . ' ' . $contact->getLastname(), 'Administrator', $userPhone, $contact->getSubject(), $contact->getMessage());

            $this->addFlash('success', 'Your inquiry has been sent successfully!');

            return $this->redirectToRoute('app_contact');
        }

        return $this->render('contact/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
