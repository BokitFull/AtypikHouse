<?php

namespace App\Tests;
use App\Entity\CaracteristiquesHabitat;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CaracteristiquesHabitatTest extends KernelTestCase
{
    //Initialisation
    public function getEntity() : CaracteristiquesHabitat {
		return (new CaracteristiquesHabitat())
		->setValeur("nom")
		->setCreatedAt(new \DateTimeImmutable());
	}

    public function assertHasErrors(CaracteristiquesHabitat $caracteristique, int $numberErrors = 0) {
		self::bootKernel();
		$error = self::getContainer()->get('validator')->validate($caracteristique);
		$this->assertCount($numberErrors, $error);
	}

    //Tests

    //Entité valide
    public function testValidEntity() {
		$this->assertHasErrors($this->getEntity(), 0);
	}

    //Tests des entrées vides
    public function testEmptyValeur() {
		$this->assertHasErrors($this->getEntity()->setValeur(""), 1);
	} 

    //Tests des entrées trop volumineuses
    public function testInvalidLenghtValeur() {
		$this->assertHasErrors($this->getEntity()->setValeur("aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaz"), 1);
	}
}
