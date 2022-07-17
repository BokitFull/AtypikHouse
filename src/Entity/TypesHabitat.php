<?php

namespace App\Entity;

use App\Repository\TypesHabitatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TypesHabitatRepository::class)]
class TypesHabitat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 50)]
    private $nom;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $description;

    #[ORM\Column(type: 'datetime_immutable')]
    private $created_at;

    #[ORM\Column(type: 'datetime_immutable')]
    private $updated_at;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: Habitats::class)]
    private $habitats;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private $deleted_at;

    #[ORM\OneToMany(mappedBy: 'type', targetEntity: CaracteristiquesTypeHabitat::class)]
    private $caracteristiquesTypesHabitat;

    public function __construct()
    {
        $this->habitats = new ArrayCollection();
        $this->caracteristiquesTypesHabitat = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

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

    /**
     * @return Collection<int, Habitats>
     */
    public function getHabitats(): Collection
    {
        return $this->habitats;
    }

    public function addHabitat(Habitats $habitat): self
    {
        if (!$this->habitats->contains($habitat)) {
            $this->habitats[] = $habitat;
            $habitat->setType($this);
        }

        return $this;
    }

    public function removeHabitat(Habitats $habitat): self
    {
        if ($this->habitats->removeElement($habitat)) {
            // set the owning side to null (unless already changed)
            if ($habitat->getType() === $this) {
                $habitat->setType(null);
            }
        }

        return $this;
    }

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(?\DateTimeImmutable $deleted_at): self
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }

    /**
     * @return Collection<int, CaracteristiquesTypeHabitat>
     */
    public function getCaracteristiquesTypesHabitat(): Collection
    {
        return $this->caracteristiquesTypesHabitat;
    }

    public function addCaracteristiquesTypeHabitat(CaracteristiquesTypeHabitat $caracteristiquesTypeHabitat): self
    {
        if (!$this->caracteristiquesTypesHabitat->contains($caracteristiquesTypeHabitat)) {
            $this->caracteristiquesTypesHabitat[] = $caracteristiquesTypeHabitat;
            $caracteristiquesTypeHabitat->setType($this);
        }

        return $this;
    }

    public function removeCaracteristiquesTypeHabitat(CaracteristiquesTypeHabitat $caracteristiquesTypeHabitat): self
    {
        if ($this->caracteristiquesTypesHabitat->removeElement($caracteristiquesTypeHabitat)) {
            // set the owning side to null (unless already changed)
            if ($caracteristiquesTypeHabitat->getType() === $this) {
                $caracteristiquesTypeHabitat->setType(null);
            }
        }

        return $this;
    }
}
