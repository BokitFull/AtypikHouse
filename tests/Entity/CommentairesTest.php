<?php

namespace App\Tests\Entity;
use App\Entity\Commentaires;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CommentairesTest extends KernelTestCase
{
    //Initialisation
    public function getEntity() : Commentaires {
		return (new Commentaires())
		->setContenu("commentaire")
		->setReponse("réponse")
		->setNoteProprete(0)
		->setNoteAccueil(0)
		->setNoteQualitePrix(0)
		->setNoteEmplacement(0)
		->setNoteEquipements(0)
		->setCreatedAt(new \DateTimeImmutable());
	}

    public function assertHasErrors(Commentaires $commentaire, int $numberErrors = 0) {
		self::bootKernel();
		$error = self::getContainer()->get('validator')->validate($commentaire);
		$this->assertCount($numberErrors, $error);
	}

    //Tests

    //Entité valide
    public function testValidEntity() {
		$this->assertHasErrors($this->getEntity(), 0);
	}

    //Tests des entrées invalides
    public function testInvalidNoteProprete() {
		$this->assertHasErrors($this->getEntity()->setNoteProprete(6), 1);
	} 
    public function testInvalidNoteAccueil() {
		$this->assertHasErrors($this->getEntity()->setNoteAccueil(6), 1);
	} 
    public function testInvalidNoteQualitePrix() {
		$this->assertHasErrors($this->getEntity()->setNoteQualitePrix(6), 1);
	} 
    public function testInvalidNoteEmplacement() {
		$this->assertHasErrors($this->getEntity()->setNoteEmplacement(6), 1);
	} 
    public function testInvalidNoteEquipements() {
		$this->assertHasErrors($this->getEntity()->setNoteEquipements(6), 1);
	} 

}
