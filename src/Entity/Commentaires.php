<?php

namespace App\Entity;

use App\Repository\CommentairesRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: CommentairesRepository::class)]
class Commentaires
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: Reservations::class, inversedBy: 'commentaires')]
    private $reservation;

    #[ORM\Column(type: 'text', nullable: true)]
    private $reponse;

    #[ORM\Column(type: 'integer')]
    private $note_proprete;

    #[ORM\Column(type: 'integer')]
    private $note_accueil;

    #[ORM\Column(type: 'integer')]
    private $note_qualite_prix;

    #[ORM\Column(type: 'integer')]
    private $note_emplacement;

    #[ORM\Column(type: 'integer')]
    private $note_equipements;

    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column(type: 'datetime_immutable')]
    private $created_at;

    #[Gedmo\Timestampable(on: 'update')]
    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private $updated_at;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private $deleted_at;

    #[ORM\Column(type: 'text')]
    private $contenu;

    #[ORM\ManyToOne(targetEntity: Utilisateurs::class)]
    private $utilisateur;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getReponse(): ?string
    {
        return $this->reponse;
    }

    public function setReponse(?string $reponse): self
    {
        $this->reponse = $reponse;

        return $this;
    }

    public function getNoteProprete(): ?int
    {
        return $this->note_proprete;
    }

    public function setNoteProprete(int $note_proprete): self
    {
        $this->note_proprete = $note_proprete;

        return $this;
    }

    public function getNoteAccueil(): ?int
    {
        return $this->note_accueil;
    }

    public function setNoteAccueil(int $note_accueil): self
    {
        $this->note_accueil = $note_accueil;

        return $this;
    }

    public function getNoteQualitePrix(): ?int
    {
        return $this->note_qualite_prix;
    }

    public function setNoteQualitePrix(int $note_qualite_prix): self
    {
        $this->note_qualite_prix = $note_qualite_prix;

        return $this;
    }

    public function getNoteEmplacement(): ?int
    {
        return $this->note_emplacement;
    }

    public function setNoteEmplacement(int $note_emplacement): self
    {
        $this->note_emplacement = $note_emplacement;

        return $this;
    }

    public function getNoteEquipements(): ?int
    {
        return $this->note_equipements;
    }

    public function setNoteEquipements(int $note_equipements): self
    {
        $this->note_equipements = $note_equipements;

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

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(\DateTimeImmutable $deleted_at): self
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }

    public function getContenu(): ?string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateurs
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateurs $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }
}
