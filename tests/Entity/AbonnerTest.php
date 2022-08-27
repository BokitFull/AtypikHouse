<?php

namespace App\Tests;
use App\Entity\Abonner;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class AbonnerTest extends KernelTestCase
{
    //Initialisation
    public function getEntity() : Abonner {
		return (new Abonner())
		->setEmailAbonner("test@test.com")
		->setNomAbonner("nom")
		->setCreatedAt(new \DateTimeImmutable());
	}

    public function assertHasErrors(Abonner $abonnement, int $numberErrors = 0) {
		self::bootKernel();
		$error = self::getContainer()->get('validator')->validate($abonnement);
		$this->assertCount($numberErrors, $error);
	}

    //Tests

    //Entité valide
    public function testValidEntity() {
		$this->assertHasErrors($this->getEntity(), 0);
	}

    //Tests des entrées invalides
    public function testInvalidEmail() {
		$this->assertHasErrors($this->getEntity()->setEmailAbonner("invalid@email"), 1);
	} 

    //Tests des entrées vides
    public function testEmptyEmail() {
		$this->assertHasErrors($this->getEntity()->setEmailAbonner(""), 1);
	}

    //Tests des entrées trop volumineuses
    public function testInvalidLenghtEmail() {
		$this->assertHasErrors($this->getEntity()->setEmailAbonner("aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa@aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaz.com"), 1);
	}
    public function testInvalidLenghtNom() {
		$this->assertHasErrors($this->getEntity()->setNomAbonner("aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaz"), 1);
	}
}
