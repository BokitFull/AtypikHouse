<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\Repository\ImagesHabitatRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

#[ORM\Entity(repositoryClass: ImagesHabitatRepository::class)]
#[ApiResource()]
class ImagesHabitat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $chemin;

    #[ORM\ManyToOne(targetEntity: Habitats::class, inversedBy: 'imagesHabitats', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $habitat;

    #[ORM\Column(type: 'integer')]
    private $position;

    #[Gedmo\Timestampable(on: 'create')]
    #[ORM\Column(type: 'datetime_immutable')]
    private $created_at;
    
    #[Gedmo\Timestampable(on: 'update')]
    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private $updated_at;

    #[ORM\Column(type: 'datetime_immutable', nullable: true)]
    private $deleted_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChemin(): ?string
    {
        return $this->chemin;
    }

    public function setChemin(string $chemin): self
    {
        $this->chemin = $chemin;

        return $this;
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

    public function getPosition(): ?int
    {
        return $this->position;
    }

    public function setPosition(int $position): self
    {
        $this->position = $position;

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
