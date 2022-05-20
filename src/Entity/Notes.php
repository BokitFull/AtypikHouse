<?php

namespace App\Entity;

use App\Repository\NotesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NotesRepository::class)]
class Notes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 20)]
    private $note;

    #[ORM\OneToOne(targetEntity: reservations::class, cascade: ['persist', 'remove'])]
    private $reservation;

    #[ORM\OneToOne(targetEntity: utilisateurs::class, cascade: ['persist', 'remove'])]
    private $utilisateur;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;

        return $this;
    }

    public function getUtilisateur(): ?utilisateurs
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?utilisateurs $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }

    public function getReservation(): ?reservations
    {
        return $this->reservation;
    }

    public function setReservation(?reservations $reservation): self
    {
        $this->reservation = $reservation;

        return $this;
    }
}
