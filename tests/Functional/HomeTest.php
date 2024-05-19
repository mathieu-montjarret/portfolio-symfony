<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeTest extends WebTestCase
{
    public function testHomeIsSuccessful()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        // Vérifie que la réponse est un succès (code 200)
        $this->assertResponseIsSuccessful();

        // Vérifie que le titre de la page est correct
        $this->assertSelectorTextContains('title', 'ArtbyCaro | Accueil');

        // Vérifie que le texte "Welcome !" est présent dans un élément h1
        $this->assertSelectorTextContains('h1', 'Welcome !');
    }
}
