<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegistrationTest extends WebTestCase
{
    public function testRegistrationPageIsSuccessful()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/registration');

        // Vérifie que la réponse est un succès (code 200)
        $this->assertResponseIsSuccessful();

        // Vérifie que le titre de la page est correct
        $this->assertSelectorTextContains('title', 'Registration');

        // Vérifie que le formulaire contient les champs nécessaires
        $this->assertSelectorExists('input[name="registration[Firstname]"]');
        $this->assertSelectorExists('input[name="registration[Lastname]"]');
        $this->assertSelectorExists('input[name="registration[Username]"]');
        $this->assertSelectorExists('input[name="registration[Email]"]');
        $this->assertSelectorExists('input[name="registration[password][first]"]');
        $this->assertSelectorExists('input[name="registration[password][second]"]');
        $this->assertSelectorExists('button[type="submit"]');
    }

    public function testSuccessfulRegistration()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/registration');

        // Sélectionne le formulaire et remplit les champs
        $form = $crawler->selectButton('Sign Up')->form();
        $form['registration[Firstname]'] = 'John';
        $form['registration[Lastname]'] = 'Doe';
        $form['registration[Username]'] = 'johndoe';
        $form['registration[Email]'] = 'johndoe@yahoo.com';
        $form['registration[password][first]'] = 'Password123!';
        $form['registration[password][second]'] = 'Password123!';

        // Soumet le formulaire
        $client->submit($form);

        // Vérifie la réponse après la soumission
        $this->assertResponseRedirects('/login');
        $client->followRedirect();

        // Vérifie que la page de redirection est la page de connexion
        $this->assertSelectorTextContains('h1', 'Log In');
    }
}
