<?php

namespace App\Test\Controller;

use App\Entity\Utilisateurs;
use App\Repository\UtilisateursRepository;
use DateTimeImmutable;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class UtilisateursControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private UtilisateursRepository $repository;
    private string $path = '/utlisateurs/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = (static::getContainer()->get('doctrine'))->getRepository(Utilisateurs::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Utilisateur index');

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
            'utilisateur[email]' => 'test@test.Com',
            'utilisateur[roles]' => ['ROLE_USER'],
            'utilisateur[password]' => 'Testing',
            'utilisateur[nom]' => 'Testing',
            'utilisateur[prenom]' => 'Testing',
            'utilisateur[civilite]' => 'F',
            'utilisateur[telephone]' => '01-02-03-04-05',
            'utilisateur[adresse]' => '32 boulevard grandois',
            'utilisateur[code_postal]' => '75',
            'utilisateur[ville]' => 'Paris',
            'utilisateur[pays]' => 'France',
            // 'utilisateur[created_at]' => 'Testing',
            // 'utilisateur[updated_at]' => new DateTimeImmutable('now'),
            // 'utilisateur[deleted_at]' => null,
            'utilisateur[image]' => 'Testing',
        ]);

        self::assertResponseRedirects('/utlisateurs/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new Utilisateurs();
        $fixture->setEmail('My Title');
        $fixture->setRoles(['ROLE_USER']);
        $fixture->setPassword('My Title');
        $fixture->setNom('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setCivilite('My Title');
        $fixture->setTelephone('My Title');
        $fixture->setAdresse('My Title');
        $fixture->setCodePostal('75');
        $fixture->setVille('Paris');
        $fixture->setPays('France');
        // $fixture->setCreatedAt('My Title');
        // $fixture->setUpdatedAt(new DateTimeImmutable('now'));
        $fixture->setDeletedAt(null);
        $fixture->setImage('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('Utilisateur');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new Utilisateurs();
        $fixture->setEmail('My Title');
        $fixture->setRoles(['ROLE_USER']);
        $fixture->setPassword('My Title');
        $fixture->setNom('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setCivilite('F');
        $fixture->setTelephone('01-02-03-04-05');
        $fixture->setAdresse('My Title');
        $fixture->setCodePostal('75');
        $fixture->setVille('Paris');
        $fixture->setPays('France');
        // $fixture->setCreatedAt(new DateTimeImmutable('now'));
        // $fixture->setUpdatedAt(new DateTimeImmutable('now'));
        $fixture->setDeletedAt(null);
        $fixture->setImage('My Title');

        $this->repository->add($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'utilisateur[email]' => 'test@test.Com',
            'utilisateur[roles]' => ['ROLE_USER'],
            'utilisateur[password]' => 'Something New',
            'utilisateur[nom]' => 'Something New',
            'utilisateur[prenom]' => 'Something New',
            'utilisateur[civilite]' => 'F',
            'utilisateur[telephone]' => '01-02-03-04-05',
            'utilisateur[adresse]' => 'Something New',
            'utilisateur[code_postal]' => '75',
            'utilisateur[ville]' => 'Paris',
            'utilisateur[pays]' => 'France',
            'utilisateur[created_at]' => '2022-08-16',
            // 'utilisateur[updated_at]' => 'Something New',
            // 'utilisateur[deleted_at]' => 'Something New',
            'utilisateur[image]' => 'Something New',
        ]);

        self::assertResponseRedirects('/utlisateurs/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getEmail());
        self::assertSame('Something New', $fixture[0]->getRoles());
        self::assertSame('Something New', $fixture[0]->getPassword());
        self::assertSame('Something New', $fixture[0]->getNom());
        self::assertSame('Something New', $fixture[0]->getPrenom());
        self::assertSame('Something New', $fixture[0]->getCivilite());
        self::assertSame('Something New', $fixture[0]->getTelephone());
        self::assertSame('Something New', $fixture[0]->getAdresse());
        self::assertSame('Something New', $fixture[0]->getCodePostal());
        self::assertSame('Something New', $fixture[0]->getVille());
        self::assertSame('Something New', $fixture[0]->getPays());
        self::assertSame('Something New', $fixture[0]->getCreatedAt());
        self::assertSame('Something New', $fixture[0]->getUpdatedAt());
        self::assertSame('Something New', $fixture[0]->getDeletedAt());
        self::assertSame('Something New', $fixture[0]->getImage());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new Utilisateurs();
        $fixture->setEmail('My Title');
        $fixture->setRoles(['ROLE_USER']);
        $fixture->setPassword('My Title');
        $fixture->setNom('My Title');
        $fixture->setPrenom('My Title');
        $fixture->setCivilite('F');
        $fixture->setTelephone('01-02-03-04-05');
        $fixture->setAdresse('My Title');
        $fixture->setCodePostal('75');
        $fixture->setVille('Paris');
        $fixture->setPays('France');
        // $fixture->setCreatedAt(new DateTimeImmutable('now'));
        // $fixture->setUpdatedAt(new DateTimeImmutable('now'));
        $fixture->setDeletedAt(null);
        $fixture->setImage('My Title');

        $this->repository->add($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/utlisateurs/');
    }
}
