<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact', methods: ['GET', 'POST'])]
    public function contact(Request $request, EntityManagerInterface $entityManager, MailerInterface $mailer): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $entityManager->persist($contact);
                $entityManager->flush();

                try {
                    $emailToUser = (new Email())
                        ->from('noreply@yourdomain.com')
                        ->to($contact->getEmail())
                        ->subject('Confirmation of your contact request')
                        ->text("Thank you, {$contact->getFirstname()} {$contact->getLastname()}, we have received your message regarding: '{$contact->getSubject()}'. We will respond shortly.");
                    $mailer->send($emailToUser);

                    // Tentative d'envoi de l'email à l'administrateur
                    $emailToAdmin = (new Email())
                        ->from('noreply@yourdomain.com')
                        ->to('youradminemail@yourdomain.com')
                        ->subject('New contact message')
                        ->html("You have received a new contact message from <strong>{$contact->getFirstname()} {$contact->getLastname()}</strong> (Email: {$contact->getEmail()}, Phone: {$contact->getPhone()}).<br>Subject: {$contact->getSubject()}<br>Message: {$contact->getMessage()}");
                    $mailer->send($emailToAdmin);

                    $this->addFlash('success', 'Your message has been sent successfully!');
                    return $this->redirectToRoute('app_contact');
                } catch (\Symfony\Component\Mailer\Exception\TransportExceptionInterface $e) {
                    // Gestion de l'erreur d'envoi de l'email
                    $this->addFlash('error', 'Failed to send email: ' . $e->getMessage());
                }
            } else {
                $this->addFlash('error', 'There are errors in the form. Please correct them.');
            }
        }

        return $this->render('contact/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
