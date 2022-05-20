<?php

namespace App\Entity;

use App\Repository\CodesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CodesRepository::class)]
class Codes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'float')]
    private $montant;

    #[ORM\OneToOne(targetEntity: utilisateurs::class, cascade: ['persist', 'remove'])]
    private $utilisateur_debiteur;

    #[ORM\OneToOne(targetEntity: utilisateurs::class, cascade: ['persist', 'remove'])]
    private $utilisateur_crediteur;

    #[ORM\Column(type: 'datetime_immutable')]
    private $created_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMontant(): ?float
    {
        return $this->montant;
    }

    public function setMontant(float $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getUtilisateurDebiteur(): ?utilisateurs
    {
        return $this->utilisateur_debiteur;
    }

    public function setUtilisateurDebiteur(?utilisateurs $utilisateur_debiteur): self
    {
        $this->utilisateur_debiteur = $utilisateur_debiteur;

        return $this;
    }

    public function getUtilisateurCrediteur(): ?utilisateurs
    {
        return $this->utilisateur_crediteur;
    }

    public function setUtilisateurCrediteur(?utilisateurs $utilisateur_crediteur): self
    {
        $this->utilisateur_crediteur = $utilisateur_crediteur;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }
}
