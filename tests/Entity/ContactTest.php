<?php

namespace App\Tests\Entity;
use App\Entity\Contact;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ContactTest extends KernelTestCase
{
    //Initialisation
    public function getEntity() : Contact {
		return (new Contact())
		->setNom("nom")
		->setPrenom("prenom")
		->setEmail("test@test.com")
		->setMessage("message")
		->setTelephone("010101010101");
	}

    public function assertHasErrors(Contact $contact, int $numberErrors = 0) {
		self::bootKernel();
		$error = self::getContainer()->get('validator')->validate($contact);
		$this->assertCount($numberErrors, $error);
	}

    //Tests

    //Entité valide
    public function testValidEntity() {
		$this->assertHasErrors($this->getEntity(), 0);
	}

    //Tests des entrées invalides
    public function testInvalidEmail() {
		$this->assertHasErrors($this->getEntity()->setEmail("invalid@email"), 1);
	} 

    //Tests des entrées vides
    public function testEmptyNom() {
		$this->assertHasErrors($this->getEntity()->setNom(""), 1);
	}   
    public function testEmptyPrenom() {
		$this->assertHasErrors($this->getEntity()->setPrenom(""), 1);
	}   
    public function testEmptyEmail() {
		$this->assertHasErrors($this->getEntity()->setEmail(""), 1);
	}
    public function testEmptyMessage() {
		$this->assertHasErrors($this->getEntity()->setMessage(""), 1);
	}   
    public function testEmptyTelephone() {
		$this->assertHasErrors($this->getEntity()->setTelephone(""), 1);
	}

    //Tests des entrées trop volumineuses
    public function testInvalidLenghtNom() {
		$this->assertHasErrors($this->getEntity()->setNom("aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaz"), 1);
	}
    public function testInvalidLenghtPrenom() {
		$this->assertHasErrors($this->getEntity()->setPrenom("aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaz"), 1);
	}
    public function testInvalidLenghtEmail() {
		$this->assertHasErrors($this->getEntity()->setEmail("aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa@aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaz.com"), 1);
	}
    public function testInvalidLenghtTelephone() {
		$this->assertHasErrors($this->getEntity()->setTelephone("aaaaaaaaaaaaaaaaaaaaz"), 1);
	}

}
