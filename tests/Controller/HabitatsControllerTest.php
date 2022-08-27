<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DomCrawler\Crawler;

class HabitatsControllerTest extends WebTestCase
{
    //Récupération du client
    public function getClient($path) {
		$client = static::createClient();
		$client->request('GET', $path);
	}

    //Tests

    public function testHabitats() {
		$this->getClient('/habitats/');
		$this->assertResponseStatusCodeSame(Response::HTTP_OK, "Le chemin des habitats n'existe pas");
	}
    public function testAfficheHabitats() {
		$this->getClient('/habitats/');
		$this->assertSelectorExists('div.div_titre_filtre', "La page des habitats n'est pas affichée");
	}
    public function testHabitat() {
		$this->getClient('/habitats/1');
		$this->assertResponseStatusCodeSame(Response::HTTP_OK, "Le chemin des habitats n'existe pas");
	}
    public function testAfficheHabitat() {
		$this->getClient('/habitats/1');
		$this->assertSelectorExists('div.page-title', "La page des habitats n'est pas affichée");
	}

}
