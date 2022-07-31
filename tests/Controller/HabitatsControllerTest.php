<?php

namespace App\Test\Controller;

use App\Entity\Habitats;
use App\Repository\HabitatsRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HabitatsControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private HabitatsRepository $repository;
    private string $path = '/habitats/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Habitats::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Habitat index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'habitat[titre]' => 'Testing',
            'habitat[adresse]' => 'Testing',
            'habitat[code_postal]' => 'Testing',
            'habitat[pays]' => 'Testing',
            'habitat[description]' => 'Testing',
            'habitat[nb_personnes]' => 'Testing',
            'habitat[prix]' => 'Testing',
            'habitat[debut_disponibilite]' => 'Testing',
            'habitat[fin_disponibilite]' => 'Testing',
            'habitat[created_at]' => 'Testing',
            'habitat[updated_at]' => 'Testing',
            'habitat[deleted_at]' => 'Testing',
            'habitat[est_valide]' => 'Testing',
            'habitat[est_actif]' => 'Testing',
            'habitat[utilisateur]' => 'Testing',
            'habitat[type]' => 'Testing',
            'habitat[caracteristiques]' => 'Testing',
            'habitat[prestations]' => 'Testing',
            'habitat[ville]' => 'Testing',
        ]);

        self::assertResponseRedirects('/habitats/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Habitats();
        $fixture->setTitre('My Title');
        $fixture->setAdresse('My Title');
        $fixture->setCode_postal('My Title');
        $fixture->setPays('My Title');
        $fixture->setDescription('My Title');
        $fixture->setNb_personnes('My Title');
        $fixture->setPrix('My Title');
        $fixture->setDebut_disponibilite('My Title');
        $fixture->setFin_disponibilite('My Title');
        $fixture->setCreated_at('My Title');
        $fixture->setUpdated_at('My Title');
        $fixture->setDeleted_at('My Title');
        $fixture->setEst_valide('My Title');
        $fixture->setEst_actif('My Title');
        $fixture->setUtilisateur('My Title');
        $fixture->setType('My Title');
        $fixture->setCaracteristiques('My Title');
        $fixture->setPrestations('My Title');
        $fixture->setVille('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Habitat');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Habitats();
        $fixture->setTitre('My Title');
        $fixture->setAdresse('My Title');
        $fixture->setCode_postal('My Title');
        $fixture->setPays('My Title');
        $fixture->setDescription('My Title');
        $fixture->setNb_personnes('My Title');
        $fixture->setPrix('My Title');
        $fixture->setDebut_disponibilite('My Title');
        $fixture->setFin_disponibilite('My Title');
        $fixture->setCreated_at('My Title');
        $fixture->setUpdated_at('My Title');
        $fixture->setDeleted_at('My Title');
        $fixture->setEst_valide('My Title');
        $fixture->setEst_actif('My Title');
        $fixture->setUtilisateur('My Title');
        $fixture->setType('My Title');
        $fixture->setCaracteristiques('My Title');
        $fixture->setPrestations('My Title');
        $fixture->setVille('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'habitat[titre]' => 'Something New',
            'habitat[adresse]' => 'Something New',
            'habitat[code_postal]' => 'Something New',
            'habitat[pays]' => 'Something New',
            'habitat[description]' => 'Something New',
            'habitat[nb_personnes]' => 'Something New',
            'habitat[prix]' => 'Something New',
            'habitat[debut_disponibilite]' => 'Something New',
            'habitat[fin_disponibilite]' => 'Something New',
            'habitat[created_at]' => 'Something New',
            'habitat[updated_at]' => 'Something New',
            'habitat[deleted_at]' => 'Something New',
            'habitat[est_valide]' => 'Something New',
            'habitat[est_actif]' => 'Something New',
            'habitat[utilisateur]' => 'Something New',
            'habitat[type]' => 'Something New',
            'habitat[caracteristiques]' => 'Something New',
            'habitat[prestations]' => 'Something New',
            'habitat[ville]' => 'Something New',
        ]);

        self::assertResponseRedirects('/habitats/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getTitre());
        self::assertSame('Something New', $fixture[0]->getAdresse());
        self::assertSame('Something New', $fixture[0]->getCode_postal());
        self::assertSame('Something New', $fixture[0]->getPays());
        self::assertSame('Something New', $fixture[0]->getDescription());
        self::assertSame('Something New', $fixture[0]->getNb_personnes());
        self::assertSame('Something New', $fixture[0]->getPrix());
        self::assertSame('Something New', $fixture[0]->getDebut_disponibilite());
        self::assertSame('Something New', $fixture[0]->getFin_disponibilite());
        self::assertSame('Something New', $fixture[0]->getCreated_at());
        self::assertSame('Something New', $fixture[0]->getUpdated_at());
        self::assertSame('Something New', $fixture[0]->getDeleted_at());
        self::assertSame('Something New', $fixture[0]->getEst_valide());
        self::assertSame('Something New', $fixture[0]->getEst_actif());
        self::assertSame('Something New', $fixture[0]->getUtilisateur());
        self::assertSame('Something New', $fixture[0]->getType());
        self::assertSame('Something New', $fixture[0]->getCaracteristiques());
        self::assertSame('Something New', $fixture[0]->getPrestations());
        self::assertSame('Something New', $fixture[0]->getVille());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Habitats();
        $fixture->setTitre('My Title');
        $fixture->setAdresse('My Title');
        $fixture->setCode_postal('My Title');
        $fixture->setPays('My Title');
        $fixture->setDescription('My Title');
        $fixture->setNb_personnes('My Title');
        $fixture->setPrix('My Title');
        $fixture->setDebut_disponibilite('My Title');
        $fixture->setFin_disponibilite('My Title');
        $fixture->setCreated_at('My Title');
        $fixture->setUpdated_at('My Title');
        $fixture->setDeleted_at('My Title');
        $fixture->setEst_valide('My Title');
        $fixture->setEst_actif('My Title');
        $fixture->setUtilisateur('My Title');
        $fixture->setType('My Title');
        $fixture->setCaracteristiques('My Title');
        $fixture->setPrestations('My Title');
        $fixture->setVille('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/habitats/');
    }
}
