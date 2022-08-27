<?php

namespace App\Tests\Entity;
use App\Entity\Habitats;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class HabitatsTest extends KernelTestCase
{
    //Initialisation
    public function getEntity() : Habitats {
		return (new Habitats())
		->setTitre("titre")
		->setAdresse("adresse")
		->setCodePostal("75")
		->setPays("pays")
		->setDescription("description")
		->setNbPersonnes("0")
		->setPrix("0")
		->setDebutDisponibilite(new \DateTimeImmutable())
		->setFinDisponibilite(new \DateTimeImmutable())
		->setEstValide(true)
		->setEstActif(true)
		->setCreatedAt(new \DateTimeImmutable());
	}

    public function assertHasErrors(Habitats $habitat, int $numberErrors = 0) {
		self::bootKernel();
		$error = self::getContainer()->get('validator')->validate($habitat);
		$this->assertCount($numberErrors, $error);
	}

    //Tests

    //Entité valide
    public function testValidEntity() {
		$this->assertHasErrors($this->getEntity(), 0);
	}

    //Tests des entrées invalides
    public function testInvalidCodePostal() {
		$this->assertHasErrors($this->getEntity()->setCodePostal("7a"), 1);
	} 
    public function testInvalidNbPersonnes() {
		$this->assertHasErrors($this->getEntity()->setNbPersonnes(-1), 1);
	} 
    public function testInvalidPrix() {
		$this->assertHasErrors($this->getEntity()->setPrix(-1), 1);
	} 

    //Tests des entrées vides
    public function testEmptyTitre() {
		$this->assertHasErrors($this->getEntity()->setTitre(""), 1);
	}   
    public function testEmptyAdresse() {
		$this->assertHasErrors($this->getEntity()->setAdresse(""), 1);
	}   
    public function testEmptyCodePostal() {
		$this->assertHasErrors($this->getEntity()->setCodePostal(""), 1);
	}   


    //Tests des entrées trop volumineuses
    public function testInvalidLenghtTitre() {
		$this->assertHasErrors($this->getEntity()->setTitre("aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa
        aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaz"), 1);
	}
    public function testInvalidLenghtAdresse() {
		$this->assertHasErrors($this->getEntity()->setAdresse("aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaz"), 1);
	}
    public function testInvalidLenghtCodePostal() {
		$this->assertHasErrors($this->getEntity()->setCodePostal("75001"), 1);
	}

}
