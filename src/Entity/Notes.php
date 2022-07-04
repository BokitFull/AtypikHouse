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

    #[ORM\OneToOne(targetEntity: Reservations::class, cascade: ['persist', 'remove'])]

    private $reservation;



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


    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(string $note): self
    {
        $this->note = $note;

        return $this;
    }



    public function getReservation(): ?Reservations
    {
        return $this->reservation;
    }

    public function setReservation(?Reservations $reservation): self
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
