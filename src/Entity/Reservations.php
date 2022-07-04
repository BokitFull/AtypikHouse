<?php

namespace App\Entity;

use App\Repository\ReservationsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use App\Controller\GetReservationsController;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Annotation\Context;

#[ORM\Entity(repositoryClass: ReservationsRepository::class)]
#[ApiResource(
    collectionOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => 'read:collection'
                ]
            ],
            'list_reservations' => [    
                'pagination_enabled'=>false,
                'method' => 'GET',
                'path' => 'get/reservations',
                'controller' => GetReservationsController::class,
                'filters' => [],
                'openapi_context' => [
                    'summary' => 'Récupère une liste',
                    'parameters' => [
                        [
                            'in' => 'query',
                            'name' => 'id',
                            'schema' => [
                                'type' => 'integer'
                            ]
    
                        ]
                    ]
                ]
            ]
        ], 
    itemOperations: [
        'get' => [
            'normalization_context' => [
                'groups' => 'comment:item'
                ]
            ],
        // 'list_habitats' => [    
        //     'method' => 'GET',
        //     'path' => 'get/habitats/{id_array}',
        //     'controller' => GetHabitatsController::class,
        //     'filters' => [],
        //     'openapi_context' => [
        //         'summary' => 'Récupère une liste',
        //         'parameters' => [
        //             [
        //                 'in' => 'query',
        //                 'name' => 'habitats',
        //                 'schema' => [
        //                     'type' => 'array'
        //                 ]

        //             ]
        //         ]
        //     ]
        ]
    // ],

)]
class Reservations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    #[Groups(['read:collection', 'comment:item', 'list_reservations'])]
    private $id;


    #[ORM\ManyToOne(targetEntity: Utilisateurs::class, inversedBy: 'reservations')]
    private $utilisateur;

    #[ORM\ManyToOne(targetEntity: Habitats::class, inversedBy: 'reservations')]

    private $habitat;
    
    #[ORM\Column(type: 'float')]
    private $montant;

    #[Groups(['comment:list', 'comment:item'])]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
    #[ORM\Column(type: 'datetime')]
    private $date_debut;
    
    #[Groups(['comment:list', 'comment:item'])]
    #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
    #[ORM\Column(type: 'datetime')]
    private $date_fin;

    #[ORM\Column(type: 'datetime_immutable')]
    private $created_at;

    #[ORM\OneToMany(mappedBy: 'reservation', targetEntity: Commentaires::class)]
    private $commentaires;

    #[ORM\Column(type: 'boolean')]
    private $Statut;

    public function __construct()
    {
        $this->commentaires = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
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

    public function getHabitat(): ?Habitats
    {
        return $this->habitat;
    }

    public function setHabitat(?Habitats $habitat): self
    {
        $this->habitat = $habitat;

        return $this;
    }

    public function getMontant(): ?string
    {
        return $this->montant;
    }

    public function setMontant(string $montant): self
    {
        $this->montant = $montant;

        return $this;
    }

    public function getDateDebut(): ?\DateTimeInterface
    {
        return $this->date_debut;
    }

    public function setDateDebut(\DateTimeInterface $date_debut): self
    {
        $this->date_debut = $date_debut;

        return $this;
    }

    public function getDateFin(): ?\DateTimeInterface
    {
        return $this->date_fin;
    }

    public function setDateFin(\DateTimeInterface $date_fin): self
    {
        $this->date_fin = $date_fin;

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
     * @return Collection<int, Commentaires>
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaires $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->setReservation($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaires $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            // set the owning side to null (unless already changed)
            if ($commentaire->getReservation() === $this) {
                $commentaire->setReservation(null);
            }
        }

        return $this;
    }

    public function isStatut(): ?bool
    {
        return $this->Statut;
    }

    public function setStatut(bool $Statut): self
    {
        $this->Statut = $Statut;

        return $this;
    }
}
