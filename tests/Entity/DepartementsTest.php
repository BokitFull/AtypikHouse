<?php

namespace App\Tests\Entity;
use App\Entity\Departements;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class DepartementsTest extends KernelTestCase
{
    //Initialisation
    public function getEntity() : Departements {
		return (new Departements())
		->setNom("nom");
	}

    public function assertHasErrors(Departements $departement, int $numberErrors = 0) {
		self::bootKernel();
		$error = self::getContainer()->get('validator')->validate($departement);
		$this->assertCount($numberErrors, $error);
	}

    //Tests

    //Entité valide
    public function testValidEntity() {
		$this->assertHasErrors($this->getEntity(), 0);
	}

    //Tests des entrées vides
    public function testEmptyNom() {
		$this->assertHasErrors($this->getEntity()->setNom(""), 1);
	}

	//Tests des entrées trop volumineuses
    public function testInvalidLenghtNom() {
		$this->assertHasErrors($this->getEntity()->setNom("aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaz"), 1);
	}
}
