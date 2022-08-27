<?php

namespace App\Tests\Entity;
use App\Entity\Reservations;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ReservationsTest extends KernelTestCase
{
    //Initialisation
    public function getEntity() : Reservations {
		return (new Reservations())
		->setDateDebut(new \DateTimeImmutable())
		->setDateFin(new \DateTimeImmutable())
		->setStatut("0")
		->setMontant(100.00)
		->setCreatedAt(new \DateTimeImmutable());
	}

    public function assertHasErrors(Reservations $reservation, int $numberErrors = 0) {
		self::bootKernel();
		$error = self::getContainer()->get('validator')->validate($reservation);
		$this->assertCount($numberErrors, $error);
	}

    //Tests

    //Entité valide
    public function testValidEntity() {
		$this->assertHasErrors($this->getEntity(), 0);
	}

    //Tests des entrées invalides
    public function testInvalidMontant() {
		$this->assertHasErrors($this->getEntity()->setMontant(0), 1);
	}

    //Tests des entrées vides
    public function testEmptyStatut() {
		$this->assertHasErrors($this->getEntity()->setStatut(""), 1);
	}   

    //Tests des entrées trop volumineuses
    public function testInvalidLenghtStatut() {
		$this->assertHasErrors($this->getEntity()->setStatut("aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaz"), 1);
	}
}
