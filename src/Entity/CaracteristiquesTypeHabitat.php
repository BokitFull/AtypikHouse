<?php

namespace App\Entity;

use App\Repository\CaracteristiquesTypeHabitatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: CaracteristiquesTypeHabitatRepository::class)]
class CaracteristiquesTypeHabitat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 100)]
    private $nom;

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
        $this->typesHabitat = new ArrayCollection();
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

    public function getDeletedAt(): ?\DateTimeImmutable
    {
        return $this->deleted_at;
    }

    public function setDeletedAt(\DateTimeImmutable $deleted_at): self
    {
        $this->deleted_at = $deleted_at;

        return $this;
    }

    public function getTypes(): ?TypesHabitat
    {
        return $this->types;
    }

    public function setTypes(?TypesHabitat $types): self
    {
        $this->types = $types;

        return $this;
    }

    /**
     * @return Collection<int, TypesHabitat>
     */
    public function getTypesHabitat(): Collection
    {
        return $this->typesHabitat;
    }

    public function addTypesHabitat(TypesHabitat $typesHabitat): self
    {
        if (!$this->typesHabitat->contains($typesHabitat)) {
            $this->typesHabitat->add($typesHabitat);
        }

        return $this;
    }

    public function removeTypesHabitat(TypesHabitat $typesHabitat): self
    {
        $this->typesHabitat->removeElement($typesHabitat);

        return $this;
    }

}
