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

    #[ORM\OneToOne(targetEntity: reservations::class, cascade: ['persist', 'remove'])]
    private $reservation;

    #[ORM\OneToOne(targetEntity: utilisateurs::class, cascade: ['persist', 'remove'])]
    private $utilisateur;

    #[ORM\Column(type: 'float', scale: 1)]
    private $note_proprete;

    #[ORM\Column(type: 'float', scale: 1)]
    private $note_accueil;

    #[ORM\Column(type: 'float', scale: 1)]
    private $note_emplacement;

    #[ORM\Column(type: 'float', scale: 1)]
    private $note_qualite_prix;

    #[ORM\Column(type: 'float', scale: 1)]
    private $note_equipements;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getNoteProprete(): ?float
    {
        return $this->note_proprete;
    }

    public function setNoteProprete(float $note_proprete): self
    {
        $this->note_proprete = $note_proprete;

        return $this;
    }

    public function getNoteAccueil(): ?float
    {
        return $this->note_accueil;
    }

    public function setNoteAccueil(float $note_accueil): self
    {
        $this->note_accueil = $note_accueil;

        return $this;
    }

    public function getNoteEmplacement(): ?float
    {
        return $this->note_emplacement;
    }

    public function setNoteEmplacement(float $note_emplacement): self
    {
        $this->note_emplacement = $note_emplacement;

        return $this;
    }

    public function getNoteQualitePrix(): ?float
    {
        return $this->note_qualite_prix;
    }

    public function setNoteQualitePrix(float $note_qualite_prix): self
    {
        $this->note_qualite_prix = $note_qualite_prix;

        return $this;
    }

    public function getNoteEquipements(): ?float
    {
        return $this->note_equipements;
    }

    public function setNoteEquipements(float $note_equipements): self
    {
        $this->note_equipements = $note_equipements;

        return $this;
    }
}
