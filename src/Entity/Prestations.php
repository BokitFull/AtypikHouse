<?php

namespace App\Entity;

use App\Repository\PrestationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: PrestationsRepository::class)]
class Prestations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    private $nom;

    #[ORM\Column(type: 'string', length: 255)]
    private $icone;

    #[ORM\ManyToOne(targetEntity: TypesPrestation::class, inversedBy: 'prestations')]
    #[ORM\JoinColumn(nullable: false)]
    private $type;

    #[ORM\ManyToMany(targetEntity: Habitats::class, mappedBy: 'prestations')]
    private $habitats;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $description;

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

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getIcone(): ?string
    {
        return $this->icone;
    }

    public function setIcone(string $icone): self
    {
        $this->icone = $icone;

        return $this;
    }

    public function getType(): ?TypesPrestation
    {
        return $this->type;
    }

    public function setType(?TypesPrestation $type): self
    {
        $this->type = $type;

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
            $habitat->addPrestation($this);
        }

        return $this;
    }

    public function removeHabitat(Habitats $habitat): self
    {
        if ($this->habitats->removeElement($habitat)) {
            $habitat->removePrestation($this);
        }

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
}
