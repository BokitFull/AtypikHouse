<?php

namespace App\Entity;

use App\Repository\AbonnerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AbonnerRepository::class)]
class Abonner
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $emailAbonner;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $NomAbonner;

    #[ORM\Column(type: 'datetime_immutable')]
    private $CreatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmailAbonner(): ?string
    {
        return $this->emailAbonner;
    }

    public function setEmailAbonner(string $emailAbonner): self
    {
        $this->emailAbonner = $emailAbonner;

        return $this;
    }

    public function getNomAbonner(): ?string
    {
        return $this->NomAbonner;
    }

    public function setNomAbonner(?string $NomAbonner): self
    {
        $this->NomAbonner = $NomAbonner;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeImmutable $CreatedAt): self
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }
}
