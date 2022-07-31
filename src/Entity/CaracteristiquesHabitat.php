<?php

namespace App\Entity;

use App\Repository\CaracteristiquesHabitatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: CaracteristiquesHabitatRepository::class)]
class CaracteristiquesHabitat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    // #[ORM\ManyToOne(targetEntity: Habitats::class, inversedBy: 'caracteristiquesHabitats')]
    // #[ORM\JoinColumn(nullable: false)]
    // private $habitat;

    #[ORM\ManyToMany(targetEntity: Habitats::class, mappedBy: 'caracteristiquesHabitats')]
    #[ORM\JoinColumn(nullable: false)]
    private $habitats;

    // #[ORM\ManyToOne(targetEntity: CaracteristiquesTypeHabitat::class)]
    // #[ORM\JoinColumn(nullable: false)]
    // private $caracteristique_type;

    #[ORM\Column(type: 'string', length: 50)]
    private $valeur;

    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column(type: 'datetime_immutable')]
    private $created_at;

    #[Gedmo\Timestampable(on: 'update')]
    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private $updated_at;
    
    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private $deleted_at;


    public function __construct()
    {
        $this->habitats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHabitat(): ?Habitats
    {
        return $this->habitat;
    }

    public function setHabitat(?Habitats $habitat): self
    {
        $this->habitat = $habitat;

        return $this;
    }

    // public function getCaracteritiqueType(): ?CaracteristiquesTypeHabitat
    // {
    //     return $this->caracteritique_type;
    // }

    // public function setCaracteritiqueType(?CaracteristiquesTypeHabitat $caracteritique_type): self
    // {
    //     $this->caracteritique_type = $caracteritique_type;

    //     return $this;
    // }

    public function getValeur(): ?string
    {
        return $this->valeur;
    }

    public function setValeur(string $valeur): self
    {
        $this->valeur = $valeur;

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

    public function setUpdatedAt(?\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

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
            // $habitat->addCaracteristiquesHabitat($this);
        }

        return $this;
    }

    public function removeHabitat(Habitats $habitat): self
    {
        if ($this->habitats->removeElement($habitat)) {
            // $habitat->removeCaracteristiquesHabitat($this);
        }

        return $this;
    }
}
