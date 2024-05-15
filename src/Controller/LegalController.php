<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LegalController extends AbstractController
{
    #[Route('/legal-notice', name: 'app_legal_notice')]
    public function legalNotice(): Response
    {
        return $this->render('legal/legal_notice.html.twig');
    }

    #[Route('/privacy-policy', name: 'app_privacy_policy')]
    public function privacyPolicy(): Response
    {
        return $this->render('legal/privacy_policy.html.twig');
    }

    #[Route('/cookie-policy', name: 'app_cookie_policy')]
    public function cookiePolicy(): Response
    {
        return $this->render('legal/cookie_policy.html.twig');
    }

    #[Route('/terms-of-use', name: 'app_terms_of_use')]
    public function termsOfUse(): Response
    {
        return $this->render('legal/terms_of_use.html.twig');
    }

    #[Route('/terms-of-sale', name: 'app_terms_of_sale')]
    public function termsOfSale(): Response
    {
        return $this->render('legal/terms_of_sale.html.twig');
    }
}
