<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DomCrawler\Crawler;

class SecurityControllerTest extends WebTestCase
{
    //Récupération du client
    public function getClient($path) {
		$client = static::createClient();
		$client->request('GET', $path);
	}

    //Tests

    public function testLogin() {
		$this->getClient('/login');
		$this->assertResponseStatusCodeSame(Response::HTTP_OK, "Le chemin du login utilisateur n'existe pas");
	}
    public function testAfficheLogin() {
		$this->getClient('/login');
		$this->assertSelectorExists('div#login_div', "Le formulaire de login n'est pas affiché");
	}

	public function testValidLogin() {
		$client = static::createClient();
		$crawler = $client->request('GET', '/login');
		$form = $crawler
		->selectButton('form_submit_btn')
		->form([
			'login_form[email]' => 'lefort.marie@garnier.com',
			'login_form[password]' => 'Fake'
		]);
		$client->submit($form);

		$this->assertResponseRedirects('/utilisateurs/');
		// $client->followRedirect();
		// $this->assertResponseIsSuccessful();
	}
	public function testInvalidLogin() {
		$client = static::createClient();
		$crawler = $client->request('GET', '/login');
		$form = $crawler
		->selectButton('form_submit_btn')
		->form([
			'login_form[email]' => 'testInvalid@test.com',
			'login_form[password]' => 'FakeInvalid'
		]);
		$client->submit($form);

		$this->assertResponseRedirects('/login');
		$client->followRedirect();
		$this->assertResponseIsSuccessful();
	}

	// public function testValidRegister() {
	// 	$client = static::createClient();
	// 	$crawler = $client->request('GET', '/login');
	// 	$form = $crawler
	// 	->selectButton('form_submit_btn')
	// 	->form([
	// 		'registration_form[nom]' => 'test',
	// 		'registration_form[prenom]' => 'test',
	// 		'registration_form[email]' => 'test@test.com',
	// 		'registration_form[password]' => 'Fake'
	// 	]);
	// 	$client->submit($form);

	// 	$this->assertResponseRedirects('/utilisateurs/');
	// 	$client->followRedirect();
	// 	$this->assertResponseIsSuccessful();
	// }
	// public function testInvalidRegister() {
	// 	$client = static::createClient();
	// 	$crawler = $client->request('GET', '/login');
	// 	$form = $crawler
	// 	->selectButton('form_submit_btn')
	// 	->form([
	// 		'registration_form[nom]' => 'invalid',
	// 		'registration_form[prenom]' => 'invalid',
	// 		'registration_form[email]' => 'invalid@test',
	// 		'registration_form[password]' => 'invalid'
	// 	]);
	// 	$client->submit($form);

	// 	$this->assertResponseRedirects('/login');
	// 	$client->followRedirect();
	// 	$this->assertResponseIsSuccessful();
	// }
}
