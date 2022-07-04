<?php

namespace App\Entity;

use App\Repository\CommentairesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    #[ORM\Column(type: 'datetime_immutable')]
    private $created_at;

    #[ORM\ManyToOne(targetEntity: Utilisateurs::class, inversedBy: 'commentaires')]
    private $utilisateur;

    #[ORM\ManyToOne(targetEntity: Reservations::class, inversedBy: 'commentaires')]
    private $reservation;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'commentaires')]
    private $commentaire_parent;

    #[ORM\OneToMany(mappedBy: 'commentaire_parent', targetEntity: self::class)]
    private $commentaires;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
    }

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

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

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

    public function getReservation(): ?Reservations
    {
        return $this->reservation;
    }

    public function setReservation(?Reservations $reservation): self
    {
        $this->reservation = $reservation;

        return $this;
    }

    public function getCommentaireParent(): ?self
    {
        return $this->commentaire_parent;
    }

    public function setCommentaireParent(?self $commentaire_parent): self
    {
        $this->commentaire_parent = $commentaire_parent;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(self $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setCommentaireParent($this);
        }

        return $this;
    }

    public function removeCommentaire(self $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getCommentaireParent() === $this) {
                $commentaire->setCommentaireParent(null);
            }
        }

        return $this;
    }
}
