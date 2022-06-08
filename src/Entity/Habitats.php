<?php

namespace App\Entity;

use App\Repository\HabitatsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HabitatsRepository::class)]
class Habitats
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 150)]
    private $libelle;

    #[ORM\Column(type: 'string', length: 100)]
    private $adresse;

    #[ORM\Column(type: 'string', length: 10)]
    private $code_postal;

    #[ORM\Column(type: 'string', length: 80)]
    private $ville;

    #[ORM\Column(type: 'string', length: 80)]
    private $pays;

    #[ORM\ManyToOne(targetEntity: Utilisateurs::class, inversedBy: 'habitats')]
    private $proprietaire;

    #[ORM\Column(type: 'boolean')]
    private $est_disponible;

    #[ORM\Column(type: 'datetime_immutable')]
    private $created_at;

    #[ORM\OneToMany(mappedBy: 'habitat', targetEntity: Reservations::class)]
    private $reservations;

    #[ORM\OneToMany(mappedBy: 'habitats', targetEntity: Activites::class)]
    private $activites;

    #[ORM\Column(type: 'json', nullable: true)]
    private $images = [];

    #[ORM\ManyToMany(targetEntity: Equipements::class, inversedBy: 'habitats')]
    private $equipements;

    #[ORM\Column(type: 'string', length: 255)]
    private $description_title;

    #[ORM\Column(type: 'text', nullable: true)]
    private $description;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
        $this->equipements = new ArrayCollection();
        $this->activites = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLibelle(): ?string
    {
        return $this->libelle;
    }

    public function setLibelle(string $libelle): self
    {
        $this->libelle = $libelle;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->code_postal;
    }

    public function setCodePostal(string $code_postal): self
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    public function getProprietaire(): ?utilisateurs
    {
        return $this->proprietaire;
    }

    public function setProprietaire(?utilisateurs $proprietaire): self
    {
        $this->proprietaire = $proprietaire;

        return $this;
    }

    public function isEstDisponible(): ?bool
    {
        return $this->est_disponible;
    }

    public function setEstDisponible(bool $est_disponible): self
    {
        $this->est_disponible = $est_disponible;

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

    /**
     * @return Collection<int, Reservations>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservations $reservation): self
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations[] = $reservation;
            $reservation->setHabitat($this);
        }

        return $this;
    }

    public function removeReservation(Reservations $reservation): self
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getHabitat() === $this) {
                $reservation->setHabitat(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, equipements>
     */
    public function getEquipements(): Collection
    {
        return $this->equipements;
    }

    public function addEquipement(equipements $equipement): self
    {
        if (!$this->equipements->contains($equipement)) {
            $this->equipements[] = $equipement;
            $equipement->setHabitats($this);
        }

        return $this;
    }

    public function removeEquipement(equipements $equipement): self
    {
        if ($this->equipements->removeElement($equipement)) {
            // set the owning side to null (unless already changed)
            if ($equipement->getHabitats() === $this) {
                $equipement->setHabitats(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, activites>
     */
    public function getActivites(): Collection
    {
        return $this->activites;
    }

    public function addActivite(activites $activite): self
    {
        if (!$this->activites->contains($activite)) {
            $this->activites[] = $activite;
            $activite->setHabitats($this);
        }

        return $this;
    }

    public function removeActivite(activites $activite): self
    {
        if ($this->activites->removeElement($activite)) {
            // set the owning side to null (unless already changed)
            if ($activite->getHabitats() === $this) {
                $activite->setHabitats(null);
            }
        }

        return $this;
    }

    public function getImages(): ?array
    {
        return $this->images;
    }

    public function setImages(?array $images): self
    {
        $this->images = $images;

        return $this;
    }

    public function getDescriptionTitle(): ?string
    {
        return $this->description_title;
    }

    public function setDescriptionTitle(string $description_title): self
    {
        $this->description_title = $description_title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
