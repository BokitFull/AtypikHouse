<?php

namespace App\Entity;

use App\Repository\CommentairesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentairesRepository::class)]
class Commentaires
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text')]
    private $commentaire;

    #[ORM\OneToOne(targetEntity: utilisateurs::class, cascade: ['persist', 'remove'])]
    private $utilisateur;

    #[ORM\OneToOne(targetEntity: reservations::class, cascade: ['persist', 'remove'])]
    private $reservation;

    #[ORM\OneToOne(targetEntity: commentaires::class, cascade: ['persist', 'remove'])]
    private $commentaire_parent;

    #[ORM\Column(type: 'datetime_immutable')]
    private $created_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

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

    public function getCommentaireParent(): ?commentaires
    {
        return $this->commentaire_parent;
    }

    public function setCommentaireParent(?commentaires $commentaire_parent): self
    {
        $this->commentaire_parent = $commentaire_parent;

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
